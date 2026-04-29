<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Library;
use App\Models\ProjectLibrary;
use App\Models\CuePoint;
use App\Models\TypeBrowse;
use App\Models\TypeOption;
use App\Models\TypeOptionData;
use App\Models\TypeForm;
use App\Models\TypeFormData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

use Illuminate\Support\Arr;
use App\Http\Resources\ProjectResource;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

class ProjectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request){
        //
    }

    function index(){
        return View::make('projects');
    }


    public static function getProjects(int $userid ){
        $projects = Project::where('user_id', Auth::id())->get();

        return $projects;
    }

    protected $landing_page = 'landing_page';
    protected $publish_div = 'publish_div';


    public function addProject(Request $request){
        
        $user = Auth::user();
        $activePlan = $user->isPlanSusbcriptionActive();

        Log::debug('addProject()  $request: ' . json_encode($request->all()) );
        
        if(!$activePlan){
            return Redirect::intended('projects')->with(['success'=>'N', 'error'=>'No hay plan activo.']);
        }
        
        $request->request->add(['user_id' => Auth::id()]);
        //$request->request->add(['landing_page' => $this->landing_page]);
        
        $name = $request->input('name');
        $user_id= Auth::id();
        
        /**
          'name.unique' => 'Ya existe un proyecto con el nombre ' . $name ,
            'name.required' => 'Debe especificar un nombre para el proyecto',
            'name.max' => 'El nombre del proyecto debe tener como maximo 30 caracteres.',
         */
        $messages = [
            'name.required' => __('You must specify a name for the project.'),
            'name.unique'   => __('There is already a project with the name') . ' ' . $name,
            'name.max'      => __('The project name must have a maximum of 30 characters.'),
        ];
        
        $validator = Validator::make($request->all(), 
            ['name' => ['required',
                        'max:30',
                        Rule::unique('project')->where(function ($query) use($name,$user_id) {
                            return $query->where('name', $name)->where('user_id', $user_id);
                        })] ]
                        ,
                        $messages
                    );
        
        if ($validator->fails()){
            return Redirect::to('projects')->withErrors($validator);
        }

        $request->input('landing_page', 'landing_page');
        Project::create($request->all());

        return Redirect::intended('projects');
    }


    public function delProject(Request $request){
        $projectsID     = $request->input('project');
        $projectsIDJSON = json_decode($projectsID);

        Log::debug('delProject() los ids: ' . $projectsID);

        foreach($projectsIDJSON as $projectID){
            $project = Project::where('user_id', Auth::id())
            ->where('id', $projectID)
            ->first();

            if($project)
                $project->delete();
        }

        return response()->json(['success'=>'Y']);
    }


    public function addProjectLib(Request $request){
        $projectLib = new ProjectLibrary();
        $projectLib->projectid  = $request->input('projectId');
        $projectLib->libraryid  = $request->input('libraryId');
        $projectLib->position   = $request->input('position');;
        $projectLib->userid     = Auth::id();
        $projectLib->save();

        return response()->json(['success'=>'Y', 'data'=>$projectLib]);
    }
    
    
    public function changeProjectLib(Request $request){
        Log::debug('changeProjectLib()...');
        
        $libraryId    = $request->input('newlib');
        $projectLibID = $request->input('projectlib');
        $message      = "";
        
        Log::debug('changeProjectLib() New Library ID:' .$libraryId . ' ProjectLibraryID:' .$projectLibID );
        
        $projectLibrary = ProjectLibrary::where('userid', Auth::id())
                                        ->where('id', $projectLibID)
                                        ->first();
        
        if($projectLibrary){
            Log::debug('changeProjectLib() projectlibrary found...');
            $projectLibrary->libraryid = $libraryId;
            $projectLibrary->save();
            
            $library = Library::where('createdby', Auth::id())
                                ->where('id', $libraryId)
                                ->first();
            
            Log::debug('changeProjectLib() URL: ' . $library->url . "  PublicPath: " . public_path(  $library->url));
            $ffprobe = FFProbe::create([  'ffmpeg.binaries'  => env("FFMPEG"), 'ffprobe.binaries' => env("FFPROBE")]);
            $duration = $ffprobe->format($library->url)->get('duration');
            Log::debug('changeProjectLib() VideoDuration: ' . $duration );
            
            $cuepointSet = $projectLibrary->cuePoints()->orderBy('time', 'asc')->get();
            $cuepoints   = $cuepointSet->count();
            
            if($cuepointSet  && count($cuepointSet)>0){
                foreach ($cuepointSet as $i => $cuePoint) {
                    Log::debug('changeProjectLib() CuepointTime: ' . $cuePoint->time );
                    
                    if($cuePoint->time > $duration){
                        $message=__('add-video.reviewCuepoint');
                        $newTime = $duration;
                        $cuePoint->time = $newTime;
                        Log::debug('changeProjectLib() New CuepointTime: ' . $newTime );
                    }
                        
                    //$cuePoint->time =  $i+1;
                    $cuePoint->libraryid = $libraryId;
                    $cuePoint->save();
                }
            }
            
            return response()->json(['success'=>'Y', 'data'=>$projectLibrary, 'message' => $message]);
        }
        Log::debug('changeProjectLib() projectlibrary NOT found...');
        return response()->json(['success'=>'N',  'message'=> 'No tiene permisos para actualizar registro']);
    }


    public function updateProjectLib(Request $request){
        $projectid     = $request->input('projectid');
        $projectLibAux = $request->input('projectlib');
        $projectlibs   = json_decode($projectLibAux);

        // Guardar el "ascpect" proporción ancho/alto del proycto
        $project = Project::where('user_id', Auth::id())
        ->where('id', $projectid)
        ->first();
        $project->aspect = $request->input('aspect');
        $project->save();

        foreach($projectlibs as $projectlib) {
            Log::debug('updateProjectLib() tiene el update: ' . $projectlib->action);

            if( $projectlib->action == 'UPDATE' ){
                $projectLibrary = ProjectLibrary::where('userid', Auth::id())
                                ->where('projectid', $projectid)
                                ->where('libraryid', $projectlib->libraryid)
                                ->where('id',        $projectlib->id)
                                ->first();

                if($projectLibrary){
                    $projectLibrary->position    = $projectlib->position;
                    $projectLibrary->name        = isset($projectlib->name) ? $projectlib->name : null;
                    $projectLibrary->description = isset($projectlib->description) ? $projectlib->description : null;
                    $projectLibrary->save();
                }
            }
        }

        return response()->json(['success'=>'Y', 'data'=>$projectlibs]);
    }


    public function delProjectLib(Request $request){
        $id         = $request->input('id');
        $library    = ProjectLibrary::find($id);
        $idUser     = $library->userid;

        if(Auth::id() == $idUser){
            $library->delete();
            return response()->json(['success'=>'Y', 'message'=> 'Eliminado Correctamente']);
        }

        return response()->json(['success'=>'N', 'message'=> 'No tiene permisos para borrar registro']);
    }


    public static function getProjectLib(int $projectid ) {
        $projectLib =  ProjectLibrary::where('userid', Auth::id())
                        ->where('projectid', $projectid)
                        ->orderBy('position', 'ASC')
                        ->get();

        return $projectLib;
    }


    public function addCuepoint(Request $request){
        $cuePoint = new CuePoint();
        $cuePoint->projectid        = $request->input('projectid');
        $cuePoint->libraryid        = $request->input('libraryid');
        $cuePoint->projectlibraryid = $request->input('projectlibid');
        $cuePoint->position         = $request->input('position');
        $cuePoint->time             = $request->input('time');
        $cuePoint->type             = 'BROWSE';
        $cuePoint->userid           = Auth::id();
        $cuePoint->save();

        $cpBrowse = new TypeBrowse();
        $cpBrowse->userid     = $cuePoint->userid;
        $cpBrowse->projectid  = $cuePoint->projectid;
        $cpBrowse->libraryid  = $cuePoint->libraryid;
        $cpBrowse->cuepointid = $cuePoint->id;
        $cpBrowse->type       = 'NONE';
        $cpBrowse->save();

        return response()->json(['success'=>'Y', 'id'=>$cuePoint->id]);
    }


    public function updCuepoint(Request $request){
        $id       = $request->input('id');
        $cuePoint = CuePoint::find($id);

        if($cuePoint){
            if(Auth::id() == $cuePoint->userid){
                $cuePoint->time = $request->input('time');
                $cuePoint->save();
                return response()->json(['success'=>'Y']);
            }
            else{
                return response()->json(['success'=>'N', 'message'=> 'No tiene permisos para actualizar registro']);
            }
        }

        return response()->json(['success'=>'N', 'message'=> 'No existe el cuepoint indicado ' . $id]);
    }
    
    
    public function delCuepoint(Request $request){
        $id       = $request->input('id');
        $cuePoint = CuePoint::find($id);
        
        if($cuePoint){
            $idUser   = $cuePoint->userid;
            
            if(Auth::id() == $idUser){
                $cuePoint->delete();
                return response()->json(['success'=>'Y']);
            }
            else{
                return response()->json(['success'=>'N', 'message'=> 'No tiene permisos para borrar registro']);
            }
        }
        
        
        return response()->json(['success'=>'N', 'message'=> 'No existe el cuepoint indicado ' . $id]);
    }


    public function getCuepointList(Request $request){
        $cuePoints = CuePoint::where('userid',          Auth::id())
                            ->where('projectid',        $request->input('projectid'))
                            ->where('libraryid',        $request->input('libraryid'))
                            ->where('projectlibraryid', $request->input('projectlibid'))
                            ->orderBy('time', 'ASC')
                            ->get();

        return response()->json(['success'=>'Y',  'cuepoints'=>$cuePoints]);
    }


    public function setCuepointData(Request $request){
        //$cuePoint = CuePoint::updateOrCreate([ids],[data]);
        $cuePoints = $request->input('cuepoints');
        $cuePointsJSON = json_decode($cuePoints);

        Log::debug('setCuepointData Entrada: ' . $cuePoints);
        $mensaje = 'No hay Cambios para guardar';
        foreach($cuePointsJSON as $dataCuepoint){
            Log::debug('setCuepointData CuPoint: ' . $dataCuepoint->id . ' ACTION: ' . $dataCuepoint->action);

            if($dataCuepoint->action == 'UPDATE'){
                $cuePoint = CuePoint::where('userid', Auth::id())
                            ->where('projectid', $request->input('projectid'))
                            ->where('libraryid', $request->input('libraryid'))
                            ->where('id',        $dataCuepoint->id)
                            ->first();

                if($cuePoint){
                    $cueName     = $dataCuepoint->cuepointname;
                    $mainType    = $dataCuepoint->type;
                    $oldMainType = $cuePoint->type;

                    if($oldMainType != $mainType){
                        //$this->deleteCuepointData($cuePoint);
                        $cuePoint->deleteCuepointData();
                    }

                    $cuePoint->type         = $mainType;
                    $cuePoint->cuepointname = $cueName;
                    $cuePoint->save();

                    if($mainType == "BROWSE"){
                        $cpBrowse = $cuePoint->typeBrowse;

                        if(!$cpBrowse){
                            $cpBrowse = new TypeBrowse();
                            $cpBrowse->userid     = Auth::id();
                            $cpBrowse->projectid  = $request->input('projectid');
                            $cpBrowse->libraryid  = $request->input('libraryid');
                            $cpBrowse->cuepointid = $dataCuepoint->id;
                        }
                        $dataCuepoint->type_option= null;
                        $dataCuepoint->type_form  = null;

                        $cpBrowse->type    = $dataCuepoint->type_browse->type;
                        $cpBrowse->goto    = isset($dataCuepoint->type_browse->goto) ? $dataCuepoint->type_browse->goto : null;
                        $cpBrowse->options = isset($dataCuepoint->type_browse->options) ? $dataCuepoint->type_browse->options : null;
                        $cpBrowse->save();

                        $mensaje = 'Actualizado correctamente';
                    }
                    else if($mainType == "OPTION" ){
                        $cpOption = $cuePoint->typeOption;

                        if(!$cpOption){
                            $cpOption = new TypeOption();
                            $cpOption->userid     = Auth::id();
                            $cpOption->projectid  = $request->input('projectid');
                            $cpOption->libraryid  = $request->input('libraryid');
                            $cpOption->cuepointid = $dataCuepoint->id;
                        }
                        $dataCuepoint->type_browse= null;
                        $dataCuepoint->type_form  = null;

                        $cpOption->type    = $dataCuepoint->type_option->type;
                        $cpOption->options = $dataCuepoint->type_option->options;
                        $cpOption->content = $dataCuepoint->type_option->content;
                        $cpOption->save();


                        $cpOptionDataSet = $cpOption->typeOptionData;
                        $dataSetToUpdate = isset($dataCuepoint->type_option->type_option_data) ? $dataCuepoint->type_option->type_option_data : [];

                        Log::debug('setCuepointData CuPoint OptionData Enviado por Cliente: ' . count($dataSetToUpdate));
                        Log::debug('setCuepointData CuPoint OptionData Existente enServidor: ' . count($cpOptionDataSet));

                        foreach($dataSetToUpdate as $dataOpcion){
                            if (isset($dataOpcion->id)){
                                Log::debug('setCuepointData CuPoint Already ID: ' . $dataOpcion->id);
                                $cpOptionData = TypeOptionData::find($dataOpcion->id);
                                $cpOptionData->uuid     = $dataOpcion->uuid;
                                $cpOptionData->name     = $dataOpcion->name;
                                $cpOptionData->type     = $dataOpcion->type;
                                $cpOptionData->goto     = $dataOpcion->goto;
                                $cpOptionData->options  = $dataOpcion->options;
                                $cpOptionData->content  = $dataOpcion->content;
                                //$cpOptionData->library_img = $dataOpcion->library_img;
                                
                                if(isset($dataOpcion->library_img)){
                                    $cpOptionData->library_img = $dataOpcion->library_img;
                                }
                                
                                $cpOptionData->save();
                            }
                            else{
                                $cpNewOptionData = new TypeOptionData();
                                $cpNewOptionData->userid            = Auth::id();
                                $cpNewOptionData->projectid         = $request->input('projectid');
                                $cpNewOptionData->libraryid         = $request->input('libraryid');
                                $cpNewOptionData->projectlibraryid  = $cuePoint->projectlibraryid;
                                $cpNewOptionData->cuepointid        = $cpOption->cuepointid;
                                $cpNewOptionData->typeoptionid      = $cpOption->id;
                                $cpNewOptionData->uuid              = $dataOpcion->uuid;
                                $cpNewOptionData->name              = $dataOpcion->name;
                                $cpNewOptionData->type              = $dataOpcion->type;
                                $cpNewOptionData->goto              = $dataOpcion->goto;
                                $cpNewOptionData->options           = $dataOpcion->options;
                                $cpNewOptionData->content           = $dataOpcion->content;
                                //$cpNewOptionData->library_img       = $dataOpcion->library_img;

                                if(isset($dataOpcion->library_img)){
                                    $cpNewOptionData->library_img = $dataOpcion->library_img;
                                }
                                
                                $cpNewOptionData->save();
                            }
                        }

                        $mensaje   = 'Actualizado correctamente';
                    }
                    else if($mainType == "FORM" ){
                        $cpForm = $cuePoint->typeForm;

                        if(!$cpForm){
                            $cpForm = new TypeForm();
                            $cpForm->userid     = Auth::id();
                            $cpForm->projectid  = $request->input('projectid');
                            $cpForm->libraryid  = $request->input('libraryid');
                            $cpForm->cuepointid = $dataCuepoint->id;
                        }
                        $dataCuepoint->type_browse=null;
                        $dataCuepoint->type_option=null;

                        $cpForm->content = $dataCuepoint->type_form->content;
                        $cpForm->name    = $dataCuepoint->type_form->name;
                        $cpForm->sendto  = $dataCuepoint->type_form->sendto;
                        $cpForm->type    = $dataCuepoint->type_form->type;
                        $cpForm->goto    = $dataCuepoint->type_form->goto;
                        $cpForm->options = $dataCuepoint->type_form->options;
                        $cpForm->save();

                        $mensaje = 'Actualizado correctamente';
                    }
                    else{
                        return response()->json(['success'=>'N', 'message'=>'No se encontro cuepoint tipo ' . $mainType ]);
                    }
                }
            }

            $project   = Project::find($request->input('projectid'));
            $cuePoints = $project->cuePoints;
            Log::debug('setCuepointData Salida: ' . $cuePoints);
        }

        return response()->json(['success'=>'Y', 'message'=>$mensaje, 'cuePoints' => $cuePoints]);
    }

    public function setPublishData(Request $request){
        $project   = Project::find($request->input('projectid'));

        $project->publish_library_img = $request->input('publish_library_img');
        $project->landing_library_img = $request->input('landing_library_img');
        $project->publish_div         = $request->input('publish_div');
        $project->landing_page        = $request->input('landing_page');
        $project->project_status_id   = $request->input('project_status')=='true' ? '1' : '0' ;
        $project->save();

        $mensaje   = 'Actualizado correctamente';

        return response()->json(['success'=>'Y', 'message'=>$mensaje]);
    }

    public function all(){

        $projects = Project::where('user_id', Auth::id())->paginate(20);

        if($projects){
            return ProjectResource::collection($projects);
        }

        return response()->json(['data' => 'Not found Projects'], 404);
    }

    public function show($id){

        $project = Project::where('user_id', Auth::id())->where('id', $id)->first();

        if($project){
            return new ProjectResource($project);
        }

        return response()->json(['data' => 'Resource not found'], 404);
    }
}



