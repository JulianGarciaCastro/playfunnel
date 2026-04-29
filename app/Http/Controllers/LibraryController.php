<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Library;
use Carbon\Carbon;

class LibraryController extends Controller{

    public function addMedia(Request $request){

        //'mediaFile' => 'required|mimes:jpeg,png,jpg,gif,svg,x-flv,mp4,quicktime,x-ms-wmv,mov,ogg,qt|max:8192',
        // Max filesize = 500MB

        $user = Auth::user();

        //validar si tiene plan activo
        $activePlan = $user->getPlanSusbcriptionActive;

        if(!$activePlan){
            return response()->json(['success'=>'N', 'error'=>'No hay plan activo.']);
        }

        //Log::debug('_____________________________________V01');
        Log::debug('activePlan: ' . $activePlan);
        $planEndDate = Carbon::createFromFormat('d-m-Y', $activePlan->getPlanSubscriptionEndDate());
        $currentDate = Carbon::createFromFormat('d-m-Y', Carbon::now()->format('d-m-Y'));
        Log::debug('Plan Actual: ' . $planEndDate . " - Fecha Actual: " . $currentDate );

        if($currentDate->gt($planEndDate)){
            return response()->json(['success'=>'N', 'error'=>__('add-video.subscriptionExpired')]);
        }

        //validar y hay espacio disponible
        $folderID  = $request->input('folderID');
        $mediaFile = $request->file('mediaFile');
        $mediaType = $mediaFile->getClientMimeType();
        $mediaName = $mediaFile->getClientOriginalName();
        $mediaSize = $mediaFile->getSize()/(1048576*1014);
        $newSize   = $mediaSize + $user->getLibrarySize();
        $planSize  = $user->getPlanSize();
        $folderPath= 'media' . '/' . Auth::id();
        
        Log::debug('LibraryController.addMedia() FolderID: ' . $folderID);
        if($folderID != 'MAIN'){
            $library = Library::where('createdby', Auth::id())->where('id', $folderID)->first();
            
            if($library === null){
                return response()->json(['success'=>'N', 'error'=>__('add-video.folderNotFound')]);
            }
            
            Log::debug('LibraryController.addMedia() Folder found: ' . $library);
            $folderPath = $library->url;
        }
        
        if($newSize>$planSize){
            return response()->json(['success'=>'N', 'error'=>__('add-video.storageFull')]);
        }

        if(Str::startsWith($mediaType, 'image')){
            $validator = Validator::make($request->all(), [
                //'mediaFile' => 'required|mimes:jpg,jpeg,png,gif,svg|max:512000',
                'mediaFile' => 'required|mimes:jpg,jpeg,png,gif,svg,mp4,flv,m3u8,ts,3gp,avi,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,wmv,x-ms-wmv,mov|max:512000',
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                //'mediaFile' => 'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv'
                'mediaFile' => 'required|mimes:jpg,jpeg,png,gif,svg,mp4,flv,m3u8,ts,3gp,avi,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,wmv,x-ms-wmv,mov'
            ]);
        }

        if ($validator->passes()) {
            //$folderName= 'media' . '/' . Auth::id();
            $fileURL = $folderPath . '/' . $mediaName;

            if(Storage::exists($fileURL)){
                $mediaName = uniqid() . '.' . $mediaFile->getClientOriginalExtension();
                $fileURL = $folderPath . '/' . $mediaName;
            }

            $mediaFile->storeAs($folderPath, $mediaName);

            $library = new Library();
            $library->createdby = Auth::id();
            $library->url       = $fileURL;
            $library->name      = $mediaName;
            $library->type      = $mediaType;
            $library->mediasize = $mediaSize;
            
            $saveThumbnailError="";
            $thumbnailURL      ="";
            
            Log::debug("LibraryController.addMedia() : LibraryCreate: ". $library );
            
            if (Str::startsWith($mediaType, 'video')){
                $folderThumbNail = $folderPath . '/thumbnails';
                $thumbNailName   = pathinfo($mediaName, PATHINFO_FILENAME) . '.jpg';
                $thumbnailURL    = $folderThumbNail . '/' . $thumbNailName;
                
                if(!Storage::exists($folderThumbNail)){
                    Log::debug('LibraryController.addMedia() Creating thumbnail Folder: ' . $folderThumbNail );
                    Storage::makeDirectory($folderThumbNail);
                }
                
                $ffprobe = FFProbe::create([  'ffmpeg.binaries'  => env("FFMPEG"), 'ffprobe.binaries' => env("FFPROBE")]);
                $duracion = $ffprobe->format($mediaFile) // extracts file informations
                ->get('duration');   // returns the duration property
                
                Log::debug('Duracion del video: ' . $duracion . " - Aleatorio: " . $duracion );
                $duracion = rand ( 2 , $duracion-2 );
                Log::debug('Duracion del video: ' . $duracion . " - Aleatorio: " . $duracion );
                
                $ffmpeg = FFMpeg::create([  'ffmpeg.binaries'  => env("FFMPEG"), 'ffprobe.binaries' => env("FFPROBE")]);
                $media = $ffmpeg->open($mediaFile);
                
                Log::debug("thumbnailURL:".$thumbnailURL);
                $library->thumbnail = $thumbnailURL;
                
                try{
                    $media->frame(TimeCode::fromSeconds(0))->save($thumbnailURL);
                }
                catch(Exception  $e){
                    $saveThumbnailError = $e->getMessage();
                    Log::error('Error: ' . $saveThumbnailError);
                    
                    $arrErrors = array();
                    array_push($arrErrors, $saveThumbnailError);
                    return response()->json(['success'=>'N', 'error'=>$arrErrors]);
                }
            }

            $library->save();

            if (Str::startsWith($mediaType, 'video')){
                return response()->json(['success'=>'Y', 'file'=>$thumbnailURL, 'id'=> $library->id, "type"=>$mediaType, "media"=>$fileURL ]);
            }
            else{
                return response()->json(['success'=>'Y', 'file'=>$fileURL, 'id'=> $library->id, "type"=>$mediaType, "media"=>"$fileURL" ]);
            }
        }

        $arrErrors = array();
        array_push($arrErrors, $validator->errors()->all());

        return response()->json(['success'=>'N', 'error'=>$arrErrors]);
    }




    public function delMedia(Request $request){

        $id  = $request->input('id');

        $library    = Library::find($id);
        $url        = $library->url;
        $thumbnail  = $library->thumbnail;
        $idUser     = $library->createdby;

        if(Auth::id() == $idUser){
            //Log::debug('Usuario permitido para eliminar ');
            //$projectLib = $library->projectLibrary()->where('userid', Auth::id())->get();
            //Log::debug('ProjectLibrary: ' . count($projectLib));

            if($library->type == 'FOLDER' ){
                $folderPath = $library->url;
                if (empty(Storage::files($folderPath)) && empty(Storage::directories($folderPath))) {
                    Storage::deleteDirectory($folderPath);
                    $library->delete();
                    return response()->json(['success'=>'Y', 'message'=> __('add-video.folderDeleteOK')]);
                } else {
                    return response()->json(['success'=>'N', 'message'=> __('add-video.folderNotEmpty')]);
                }
            }
            
            $project = $library->project;
            Log::debug('LibraryController.delMedia() Count of projects where library is used: ' . count($project));
            
            if(count($project) > 0){
                //$projecta = $projectLib->first()->project;
                Log::debug('LibraryController.delMedia() Usuario permitido para eliminar pero tiene libreria asignada al proyecto: ' . $project[0]->name);
                return response()->json(['success'=>'N', 'message'=> __('add-video.cantDeleteFile', ['name' => $project[0]->name])]);
            }
            
            $project = $library->projectPublish;
            Log::debug('LibraryController.delMedia() Count of projects where library is PublishPage: ' . count($project));
            
            if(count($project) > 0){
                Log::debug('LibraryController.delMedia() Usuario permitido para eliminar pero tiene libreria usada en PublishPage: ' . $project[0]->name);
                return response()->json(['success'=>'N', 'message'=> __('add-video.cantDeleteFilePublish', ['name' => $project[0]->name])]);
            }
            
            $project = $library->projectLanding;
            Log::debug('LibraryController.delMedia() Count of projects where library is LandingPage: ' . count($project));
            
            if(count($project) > 0){
                Log::debug('LibraryController.delMedia() Usuario permitido para eliminar pero tiene libreria usada en LandingPage: ' . $project[0]->name);
                return response()->json(['success'=>'N', 'message'=> __('add-video.cantDeleteFileLanding', ['name' => $project[0]->name])]);
            }
            
            $project = $library->projectOption;
            Log::debug('LibraryController.delMedia() Count of projects where library is in Option: ' . count($project));
            
            if(count($project) > 0){
                Log::debug('LibraryController.delMedia() Usuario permitido para eliminar pero tiene libreria usada en Opciones: ' . $project[0]->name);
                return response()->json(['success'=>'N', 'message'=> __('add-video.cantDeleteFileOption', ['name' => $project[0]->name])]);
            }
            
            $library->delete();
            Storage::delete( $url );

            if(!empty($thumbnail)){
                Storage::delete( $thumbnail );
                
                $dirThumbnail = dirname($thumbnail);
                
                if(empty(Storage::files($dirThumbnail))) {
                    Storage::deleteDirectory($dirThumbnail);
                }
            }

            return response()->json(['success'=>'Y', 'message'=> __('add-video.fileDeleteOK')]);
        }

        return response()->json(['success'=>'N', 'message'=> __('add-video.noPermissionDelete')]);
    }





    public function loadMedia(Request $request){

        Log::debug('Leyendo Library para Usuario: ' . Auth::id());
        $library = Library::where('createdby', Auth::id())->get();
        $libMedia = array();

        foreach($library as $lib){
            Log::debug('Leyendo Tabla: ' . $lib->url);

            $thumbnail = $lib->thumbnail;
            $originalFile = $lib->url;

            if(!empty($thumbnail)){
                $myLib = array("url" => $thumbnail, "id"=>$lib->id, "type"=>"VIDEO", "media"=>$originalFile);
            }
            else{
                $myLib = array("url" => $lib->url,  "id"=>$lib->id, "type"=>"IMAGE", "media"=>$lib->url);
            }

            array_push($libMedia, $myLib);
        }
        
        $directories = Storage::directories('media' . '/' . Auth::id() );
        $filteredDirectories = array_diff($directories, ['.', '..','thumbnails']);
        Log::debug('loadMedia() Directorios: ' . $directories);
        Log::debug('loadMedia() Directorios Filtrados: ' . $filteredDirectories);
        
        foreach($filteredDirectories as $dir){
            $myLib = array("name" => basename($dir), "type"=>"FOLDER");
            Log::debug('loadMedia() Añadiendo Folder: ' . $myLib);
            array_push($libMedia, $myLib);
        }

        return response()->json(['success'=>'Y',  'file'=>json_encode($libMedia)]);
    }


    public function getMediaInfo(Request $request){

        Log::debug('getMediaInfo: ' . Auth::id());

        $library = Library::where('createdby', Auth::id())
                    ->where('id', $request->input('id'))
                    ->first();

        if($library){
            return response()->json(['success'=>'Y',  'name' =>$library->name , 'description'=>$library->description]);
        }
        else{
            return response()->json(['success'=>'N',  'info'=>__('add-video.notFileFound')]);
        }
    }


    public function setMediaInfo(Request $request){

        Log::debug('setMediaInfo: ' . Auth::id());

        $library = Library::where('userid', Auth::id())
        ->where('id',        $request->input('id'))
        ->first();

        if($library){
            $library->name        = $request->input('id');
            $library->description = $request->input('description');
            $library->save();
        }

        return response()->json(['success'=>'Y']);
    }


    public function newFolder(Request $request){
        Log::debug('LibraryController.newFolder()');
        
        $user = Auth::user();
        
        //validar si tiene plan activo
        $activePlan = $user->getPlanSusbcriptionActive;
        
        if(!$activePlan){
            return response()->json(['success'=>'N', 'error'=>__('add-video.noSubscription')]);
        }
        
        Log::debug('LibraryController.newFolder() activePlan: ' . $activePlan);
        $planEndDate = Carbon::createFromFormat('d-m-Y', $activePlan->getPlanSubscriptionEndDate());
        $currentDate = Carbon::createFromFormat('d-m-Y', Carbon::now()->format('d-m-Y'));
        Log::debug('LibraryController.newFolder() Plan Actual: ' . $planEndDate . " - Fecha Actual: " . $currentDate );
        
        if($currentDate->gt($planEndDate)){
            return response()->json(['success'=>'N', 'error'=>__('add-video.subscriptionExpired')]);
        }
        
        $folderName    = trim($request->input('folderName'));
        $currentFolder = $request->input('currentFolder');
        
        $rules = array('folderName' => 'required|max:20|regex:/^[a-zA-Z0-9 ]+$/',);
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()){
            return response()->json(['success'=>'N', 'error'=>__('add-video.wrongFolderName')]);
        }
        
        $newFolder  ="";
        $folderRoot ="";
            
        if($currentFolder == 'MAIN'){
            $folderRoot = 'media' . '/' . Auth::id();
            $newFolder  = 'media' . '/' . Auth::id() . "/" . $folderName;
        }
        else{
            $library   = Library::where('createdby', Auth::id())->where('id', $currentFolder)->first();
            
            if($library === null){
                Log::debug('LibraryController.newFolder() Folder Padre no existe ID' . $currentFolder);
                return response()->json(['success'=>'N', 'error'=>__('add-video.noParentFolder')]);
            }
            
            $folderRoot = $library->url;
            $newFolder  = $library->url . "/" . $folderName;
        }
        
        Log::debug('LibraryController.newFolder() ParentID: ' . $currentFolder . ' - Folder to Search: ' . $folderRoot . ' - Folder to Create: ' . $folderName . ' - Child URL: ' . $newFolder);
        $folders = Storage::directories($folderRoot);
        
        foreach ($folders as $folder) {
            Log::debug('LibraryController.newFolder() Folder Found: ' . $folder);
            if (strcasecmp($folder, $newFolder) === 0) {
                Log::debug('LibraryController.newFolder() Folder already exists: ' . $newFolder);
                return response()->json(['success'=>'N', 'error'=>__('add-video.folderAreadyExists',['name'=>$folderName])]);
            }
        }
        
        mkdir($newFolder, 0755, true);
        
        $library = new Library();
        $library->createdby = Auth::id();
        $library->url       = $newFolder;
        $library->thumbnail = 'images/SVG/folder.svg';
        $library->name      = $folderName;
        $library->type      = 'FOLDER';
        $library->mediasize = 0;
        $library->save();
            
        return response()->json(['success'=>'Y', 'file'=>$folderName, 'id'=>$library->id, "type"=>"FOLDER", "media"=>"$newFolder",  "message"=>__('add-video.folderCreatedOK',['name'=>$folderName])]);
    }
    
    
    public function openFolder(Request $request){
        Log::debug('LibraryController.openFolder() FolderID: ' . $request->input('folderID'));
        
        $folderID   = $request->input('folderID');
        $mainFolder = 'media' . '/' . Auth::id();
        
        if($folderID != 'MAIN'){
            $folder = Library::where('createdby', Auth::id())->where('id', $folderID)->first();
            
            if($folder === null){
                return response()->json(['success'=>'N', 'error' => __('add-video.folderNotFound')]);
            }
            
            $mainFolder =  $folder->url ;
        }
        
        Log::debug('LibraryController.openFolder() MainFolder: ' . $mainFolder );
        
        $library = Library::where('createdby', Auth::id())->orderBy('type', 'ASC')->orderBy('name', 'ASC')->get();
        
        $filteredCollection = $library->reject(function ($item) use ($mainFolder, $folderID) {
            $filedir = dirname($item->url);
            Log::debug('LibraryController.openFolder() Lib: ID: ' . $item->id . ' - Type: ' . $item->type . ' - URL: ' . $item->url . ' - filedir: ' . $filedir);
            
            return $filedir != $mainFolder || $item->id == $folderID; // Define la condición para eliminar
        });
        
        return response()->json(['success'=>'Y', 'folders' => $filteredCollection]);
    }
}
