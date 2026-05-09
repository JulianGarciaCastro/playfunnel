<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;
use App\Models\Library;
use App\Models\Project;
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
                
                $ffmpegOptions = $this->ffmpegOptions();
                $ffprobe = FFProbe::create($ffmpegOptions);
                $duracion = $ffprobe->format($mediaFile) // extracts file informations
                ->get('duration');   // returns the duration property
                
                Log::debug('Duracion del video: ' . $duracion . " - Aleatorio: " . $duracion );
                $duracion = rand ( 2 , $duracion-2 );
                Log::debug('Duracion del video: ' . $duracion . " - Aleatorio: " . $duracion );
                
                $ffmpeg = FFMpeg::create($ffmpegOptions);
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
            else if (Str::startsWith($mediaType, 'image')) {
                $folderThumbNail = $folderPath . '/thumbnails';
                $thumbNailName   = pathinfo($mediaName, PATHINFO_FILENAME) . '.jpg';
                $thumbnailURL    = $folderThumbNail . '/' . $thumbNailName;

                if(!Storage::exists($folderThumbNail)){
                    Storage::makeDirectory($folderThumbNail);
                }

                if ($this->canBuildImageThumbnail($mediaType)) {
                    if ($this->generateImageThumbnail($fileURL, $thumbnailURL)) {
                        $library->thumbnail = $thumbnailURL;
                    } else {
                        Log::warning('LibraryController.addMedia() Unable to generate image thumbnail for: ' . $fileURL);
                    }
                }
            }

            $library->save();

            $previewFile = !empty($library->thumbnail) ? $library->thumbnail : $fileURL;
            return response()->json([
                'success'=>'Y',
                'file'=>Library::publicMediaUrl($previewFile),
                'id'=> $library->id,
                "type"=>$mediaType,
                "media"=>$fileURL,
            ]);
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
            
            $project = $this->findProjectsUsingLibraryInOptions($library);
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

    public function editVideo(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'start' => 'required|numeric|min:0',
            'end' => 'required|numeric|min:0.1',
            'offset' => 'nullable|numeric|min:0',
            'title' => 'nullable|string|max:120',
            'subtitle' => 'nullable|string|max:180',
            'titleStyle' => 'nullable|string|max:30',
            'subtitleStyle' => 'nullable|string|max:30',
            'titleStart' => 'nullable|numeric|min:0',
            'titleEnd' => 'nullable|numeric|min:0',
            'titleVisible' => 'nullable|integer|min:0|max:1',
            'titleFontSize' => 'nullable|integer|min:18|max:96',
            'filter' => 'nullable|string|max:30',
            'brightness' => 'nullable|numeric|min:-1|max:1',
            'contrast' => 'nullable|numeric|min:0|max:3',
            'fadeIn' => 'nullable|numeric|min:0|max:5',
            'fadeOut' => 'nullable|numeric|min:0|max:5',
            'speed' => 'nullable|numeric|min:0.25|max:2',
        ]);

        if ($validator->fails()) {
            return response()->json(['success'=>'N', 'error'=>$validator->errors()->all()]);
        }

        $library = Library::where('createdby', Auth::id())
            ->where('id', $request->input('id'))
            ->first();

        if (!$library || !(Str::startsWith($library->type, 'video') || strtoupper($library->type) === 'VIDEO')) {
            return response()->json(['success'=>'N', 'error'=>__('library.video_editor_not_found')]);
        }

        if (!Storage::exists($library->url)) {
            return response()->json(['success'=>'N', 'error'=>__('library.video_editor_not_found')]);
        }

        try {
            $start = max(0, (float) $request->input('start'));
            $end = max(0.1, (float) $request->input('end'));

            $ffmpegOptions = $this->ffmpegOptions();
            $ffprobe = FFProbe::create($ffmpegOptions);
            $duration = (float) $ffprobe->format(Storage::path($library->url))->get('duration');

            if ($duration <= 0) {
                return response()->json(['success'=>'N', 'error'=>__('library.video_editor_invalid_duration')]);
            }

            $end = min($end, $duration);
            $offset = max(0, (float) $request->input('offset', 0));
            if ($start >= $end) {
                return response()->json(['success'=>'N', 'error'=>__('library.video_editor_invalid_range')]);
            }

            $sourceFolder = dirname($library->url);
            $baseName = pathinfo($library->name, PATHINFO_FILENAME);
            $outputName = $this->editedVideoName($sourceFolder, $baseName);
            $outputUrl = $sourceFolder . '/' . $outputName;

            $ffmpeg = FFMpeg::create($ffmpegOptions);
            $video = $ffmpeg->open(Storage::path($library->url));
            $video->filters()->clip(TimeCode::fromSeconds($start), TimeCode::fromSeconds($end - $start));

            $videoFilter = $this->buildVideoEditorFilter(
                (int) $request->input('titleVisible', 1) === 0 ? '' : trim((string) $request->input('title')),
                trim((string) $request->input('subtitle')),
                (string) $request->input('titleStyle', 'plain'),
                (string) $request->input('subtitleStyle', 'plain'),
                (string) $request->input('filter', 'none'),
                (float) $request->input('brightness', 0),
                (float) $request->input('contrast', 1),
                (float) $request->input('fadeIn', 0),
                (float) $request->input('fadeOut', 0),
                (float) $request->input('speed', 1),
                $end - $start,
                max(0, (float) $request->input('titleStart', 0) - $offset),
                max(0, (float) $request->input('titleEnd', $end) - $offset),
                (int) $request->input('titleFontSize', 36)
            );

            if ($videoFilter !== '') {
                $video->filters()->custom($videoFilter);
            }

            $format = (new X264('aac', 'libx264'))->setKiloBitrate(1800)->setAudioKiloBitrate(128);
            $video->save($format, Storage::path($outputUrl));

            $thumbnailUrl = $this->createVideoThumbnail($ffmpeg, $outputUrl, $sourceFolder, $outputName);

            $edited = new Library();
            $edited->createdby = Auth::id();
            $edited->url = $outputUrl;
            $edited->thumbnail = $thumbnailUrl;
            $edited->name = $outputName;
            $edited->type = 'video/mp4';
            $edited->mediasize = Storage::exists($outputUrl) ? Storage::size($outputUrl)/(1048576*1014) : 0;
            $edited->description = trim((string) $request->input('title'));
            $edited->save();

            return response()->json([
                'success'=>'Y',
                'file'=>$thumbnailUrl ?: $outputUrl,
                'id'=>$edited->id,
                'type'=>$edited->type,
                'media'=>$outputUrl,
                'message'=>__('library.video_editor_saved')
            ]);
        } catch (Exception $e) {
            Log::error('LibraryController.editVideo() Error: ' . $e->getMessage());
            return response()->json(['success'=>'N', 'error'=>__('library.video_editor_error') . ': ' . $e->getMessage()]);
        }
    }





    public function loadMedia(Request $request){

        Log::debug('Leyendo Library para Usuario: ' . Auth::id());
        $library = Library::where('createdby', Auth::id())->get();
        $libMedia = array();

        foreach($library as $lib){
            Log::debug('Leyendo Tabla: ' . $lib->url);

            $thumbnail = $lib->thumbnail;
            $originalFile = $lib->url;

            if ($lib->type === 'FOLDER') {
                continue;
            }

            $previewFile = !empty($thumbnail) ? $thumbnail : $originalFile;
            if (Str::startsWith($lib->type, 'video') || strtoupper($lib->type) === 'VIDEO') {
                $myLib = array("url" => Library::publicMediaUrl($previewFile), "id"=>$lib->id, "type"=>"VIDEO", "media"=>$originalFile);
                array_push($libMedia, $myLib);
                continue;
            }

            if (Str::startsWith($lib->type, 'image') || strtoupper($lib->type) === 'IMAGE') {
                $myLib = array("url" => Library::publicMediaUrl($previewFile),  "id"=>$lib->id, "type"=>"IMAGE", "media"=>$originalFile);
                array_push($libMedia, $myLib);
            }
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

    private function canBuildImageThumbnail(string $mediaType): bool
    {
        $normalizedType = strtolower($mediaType);
        return strpos($normalizedType, 'svg') === false;
    }

    private function buildVideoEditorFilter(
        string $title,
        string $subtitle,
        string $titleStyle,
        string $subtitleStyle,
        string $filter,
        float $brightness,
        float $contrast,
        float $fadeIn,
        float $fadeOut,
        float $speed,
        float $clipDuration,
        float $titleStart,
        float $titleEnd,
        int $titleFontSize
    ): string
    {
        $filters = [];
        $speed = max(0.25, min(2, $speed));

        if ($speed !== 1.0) {
            $filters[] = 'setpts=' . round(1 / $speed, 4) . '*PTS';
        }

        if ($filter === 'grayscale') {
            $filters[] = 'hue=s=0';
        } else if ($filter === 'sepia') {
            $filters[] = 'colorchannelmixer=.393:.769:.189:0:.349:.686:.168:0:.272:.534:.131';
        } else if ($filter === 'vivid') {
            $filters[] = 'eq=saturation=1.35:contrast=1.08';
        }

        if ($brightness != 0 || $contrast != 1) {
            $filters[] = 'eq=brightness=' . round($brightness, 2) . ':contrast=' . round($contrast, 2);
        }

        if ($fadeIn > 0) {
            $filters[] = 'fade=t=in:st=0:d=' . round($fadeIn, 2);
        }

        if ($fadeOut > 0 && $clipDuration > $fadeOut) {
            $filters[] = 'fade=t=out:st=' . round($clipDuration - $fadeOut, 2) . ':d=' . round($fadeOut, 2);
        }

        $fontFile = $this->escapeDrawTextFontPath(public_path('fonts/OpenSans-Bold.ttf'));

        if ($title !== '') {
            $filters[] = $this->drawTextCommand($fontFile, $title, $titleStyle, '(h-text_h)/2', (string) max(18, $titleFontSize), $titleStart, $titleEnd);
        }

        if ($subtitle !== '') {
            $filters[] = $this->drawTextCommand($fontFile, $subtitle, $subtitleStyle, 'h-text_h-h*0.12', 'h/22', 0, $clipDuration);
        }

        return implode(',', $filters);
    }

    private function drawTextCommand(string $fontFile, string $text, string $style, string $y, string $fontSize, float $start = 0, float $end = 0): string
    {
        $fontColor = 'white';
        $box = '';
        $border = 'borderw=3:bordercolor=black@0.75';

        if ($style === 'box') {
            $box = ':box=1:boxcolor=black@0.75:boxborderw=18';
            $border = 'borderw=0';
        } else if ($style === 'creator') {
            $fontColor = 'yellow';
            $border = 'borderw=5:bordercolor=black';
        } else if ($style === 'retro') {
            $fontColor = 'white';
            $border = 'borderw=4:bordercolor=purple@0.95:shadowx=4:shadowy=4:shadowcolor=orange@0.95';
        } else if ($style === 'pride') {
            $border = 'borderw=3:bordercolor=black:shadowx=6:shadowy=6:shadowcolor=blue@0.8';
        } else if ($style === 'button') {
            $fontColor = 'black';
            $box = ':box=1:boxcolor=white@0.95:boxborderw=24';
            $border = 'borderw=0:shadowx=3:shadowy=3:shadowcolor=black@0.35';
        } else if ($style === 'bubble') {
            $fontColor = 'lime';
            $border = 'borderw=4:bordercolor=green@0.9';
        } else if ($style === 'sharp') {
            $box = ':box=1:boxcolor=black@0.35:boxborderw=12';
            $border = 'borderw=2:bordercolor=pink@0.95';
        } else if ($style === 'double') {
            $fontColor = 'white';
            $border = 'borderw=1:bordercolor=black:shadowx=0:shadowy=5:shadowcolor=purple@0.8';
        }

        $enable = $end > $start ? ":enable='between(t," . round($start, 2) . "," . round($end, 2) . ")'" : '';

        return "drawtext=fontfile='{$fontFile}':text='" . $this->escapeDrawText($text) . "':fontcolor={$fontColor}:fontsize={$fontSize}:{$border}{$box}:x=(w-text_w)/2:y={$y}{$enable}";
    }

    private function escapeDrawText(string $value): string
    {
        $value = str_replace(["\r", "\n"], ' ', $value);
        return str_replace(["\\", "'", ":", "%"], ["\\\\", "\\'", "\\:", "\\%"], $value);
    }

    private function escapeDrawTextFontPath(string $path): string
    {
        return str_replace(['\\', ':'], ['/', '\\:'], $path);
    }

    private function createVideoThumbnail(FFMpeg $ffmpeg, string $videoUrl, string $folderPath, string $videoName): string
    {
        $folderThumbNail = $folderPath . '/thumbnails';
        $thumbNailName = pathinfo($videoName, PATHINFO_FILENAME) . '.jpg';
        $thumbnailUrl = $folderThumbNail . '/' . $thumbNailName;

        if(!Storage::exists($folderThumbNail)){
            Storage::makeDirectory($folderThumbNail);
        }

        try {
            $ffmpeg
                ->open(Storage::path($videoUrl))
                ->frame(TimeCode::fromSeconds(0))
                ->save(Storage::path($thumbnailUrl));

            return $thumbnailUrl;
        } catch (Exception $e) {
            Log::warning('LibraryController.createVideoThumbnail() Error: ' . $e->getMessage());
            return '';
        }
    }

    private function ffmpegOptions(): array
    {
        return [
            'ffmpeg.binaries' => $this->resolveFfmpegBinary(env('FFMPEG'), 'ffmpeg'),
            'ffprobe.binaries' => $this->resolveFfmpegBinary(env('FFPROBE'), 'ffprobe'),
        ];
    }

    private function resolveFfmpegBinary(?string $configuredPath, string $binary): string
    {
        $candidates = [];

        if (!empty($configuredPath)) {
            $candidates[] = $configuredPath;
            $candidates[] = public_path($configuredPath);
            $candidates[] = base_path($configuredPath);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $candidates[] = public_path("lib/ffmpeg-4.4-full_build_win/bin/{$binary}.exe");
        }

        $candidates[] = public_path("lib/ffmpeg-4.4.1-i686-static/{$binary}");
        $candidates[] = public_path("lib/ffmpeg-git-20211013-amd64-static/{$binary}");

        foreach ($candidates as $candidate) {
            $candidate = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $candidate);
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return (string) $configuredPath;
    }

    private function editedVideoName(string $folder, string $baseName): string
    {
        $cleanBaseName = Str::slug($baseName, '-');
        $outputName = $cleanBaseName . '_Edit.mp4';
        $counter = 2;

        while (Storage::exists($folder . '/' . $outputName)) {
            $outputName = $cleanBaseName . '_Edit_' . $counter . '.mp4';
            $counter++;
        }

        return $outputName;
    }

    private function findProjectsUsingLibraryInOptions(Library $library)
    {
        if (!Schema::hasTable('type_option_data')) {
            return collect();
        }

        $projectIds = collect();

        if (Schema::hasColumn('type_option_data', 'library_img')) {
            $idsByLibraryImg = DB::table('type_option_data')
                ->where('library_img', $library->id)
                ->pluck('projectid');
            $projectIds = $projectIds->merge($idsByLibraryImg);
        }

        if (Schema::hasColumn('type_option_data', 'image_url')) {
            $idsByImageUrl = DB::table('type_option_data')
                ->where('image_url', $library->url)
                ->pluck('projectid');
            $projectIds = $projectIds->merge($idsByImageUrl);
        }

        if (Schema::hasColumn('type_option_data', 'content')) {
            $idsByContent = DB::table('type_option_data')
                ->where('content', 'like', '%' . $library->url . '%')
                ->pluck('projectid');
            $projectIds = $projectIds->merge($idsByContent);
        }

        $projectIds = $projectIds
            ->filter(function ($id) {
                return !empty($id);
            })
            ->unique()
            ->values();

        if ($projectIds->isEmpty()) {
            return collect();
        }

        return Project::whereIn('id', $projectIds)->get();
    }

    private function generateImageThumbnail(string $sourcePath, string $thumbnailPath, int $maxWidth = 1600, int $jpegQuality = 82): bool
    {
        if (!function_exists('gd_info')) {
            return false;
        }

        $sourceAbsolutePath = Storage::path($sourcePath);
        if (!file_exists($sourceAbsolutePath)) {
            return false;
        }

        $imageInfo = @getimagesize($sourceAbsolutePath);
        if (!$imageInfo || empty($imageInfo[2])) {
            return false;
        }

        $sourceWidth = (int) $imageInfo[0];
        $sourceHeight = (int) $imageInfo[1];
        $sourceType = (int) $imageInfo[2];
        if ($sourceWidth <= 0 || $sourceHeight <= 0) {
            return false;
        }

        switch ($sourceType) {
            case IMAGETYPE_JPEG:
                $sourceImage = @imagecreatefromjpeg($sourceAbsolutePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = @imagecreatefrompng($sourceAbsolutePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = @imagecreatefromgif($sourceAbsolutePath);
                break;
            case IMAGETYPE_WEBP:
                if (!function_exists('imagecreatefromwebp')) {
                    return false;
                }
                $sourceImage = @imagecreatefromwebp($sourceAbsolutePath);
                break;
            default:
                return false;
        }

        if (!$sourceImage) {
            return false;
        }

        $scale = min(1, $maxWidth / $sourceWidth);
        $targetWidth = max(1, (int) round($sourceWidth * $scale));
        $targetHeight = max(1, (int) round($sourceHeight * $scale));

        $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
        if (!$targetImage) {
            imagedestroy($sourceImage);
            return false;
        }

        $backgroundColor = imagecolorallocate($targetImage, 255, 255, 255);
        imagefill($targetImage, 0, 0, $backgroundColor);

        imagecopyresampled(
            $targetImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight
        );

        $thumbnailDirectory = dirname($thumbnailPath);
        if(!Storage::exists($thumbnailDirectory)){
            Storage::makeDirectory($thumbnailDirectory);
        }

        $thumbnailAbsolutePath = Storage::path($thumbnailPath);
        $isSaved = imagejpeg($targetImage, $thumbnailAbsolutePath, $jpegQuality);

        imagedestroy($targetImage);
        imagedestroy($sourceImage);

        return (bool) $isSaved;
    }
}
