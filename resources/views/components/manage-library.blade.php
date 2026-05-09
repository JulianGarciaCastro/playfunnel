<!--- Modal Library --->

<div class="modal fade bd-example-modal-lg m-0 p-0" id="libraryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document"></div>
    <div class="my-0 librery m-0 row w-100 justify-content-center align-items-center">
        <div class="container bg-06 p-0 m-0">
            <div class="headerMenu col-12 pt-3 d-flex pb-md-3">
                <button data-dismiss="modal" aria-label="Close" type="submit" class="closeM align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
                    <span class="material-icons d-flex justify-content-center"> clear </span>
                </button>
                <p class="text-center m-lg-0 col-lg-6">{{ __('add-video.file_library') }}</p>
                <div class="row justify-content-center m-0 p-0 deleteContainer pb-3 pb-lg-0">
                   
                </div>
                <div class="action-folder row justify-content-center m-0 p-0 pb- pb-lg-0"> 
                    <button type="submit" id="newFolder" class="align-items-center justify-content-center btn-cMain bg-Main px-3  cWhite mr-lg-4 mb-3 mb-lg-0">
                    	<i class="fas fa-folder-plus mr-2"></i>{{ __('add-video.add_folder') }}
                    </button>
                    <div class="upload d-flex align-items-center">
                        @if ($user->isPlanSusbcriptionActive())
                            <!-- <button type="submit" class=" align-items-center justify-content-center btn btn-cMain bg-02 "><i class="fas fa-cloud-upload-alt"></i> Subir Archivo</button> -->
                            <label for="mediaFile" class="d-flex align-items-center justify-content-center btn btn-cMain bg-02 m-0">
                            	<i class="fas fa-cloud-upload-alt mr-2"></i> {{ __('add-video.upload_file') }}
                            </label>
                            <!--<i>(video/mp4, video/mpeg, video/x-msvideo, mvideo/x-ms-wmv)</i>-->
                            <input style="visibility:hidden;" type="file" id="mediaFile" name="mediaFile" value="images/SVG/user-solid.svg" />
                        @endif
                	</div>
                        
                    <button type="submit" id="deleteMediaFileBtn" class="align-items-center justify-content-center bg-Wrong btn-basic cWhite px-3 px-lg-4 mb-4 mb-lg-0" data-toggle="modal" data-target="#deleteAllMediaModal">
                    	<span class="material-icons mr-2">delete</span> {{ __('library.delete') }}
                    </button>
                </div>
            </div>
           
			<div class="mainMenu">
				<div class="sideMenu row col-12 col-md-3 bg-white p-0 m-0">
					<div class="breadcrumb-container col-12 d-flex justify-content-between align-items-center">
						<ul class="breadcrumb w-100"></ul>
						
						<!-- TODO borrar
						<div id="filter" class=" d-flex w-100">
							<div class="col-6 folder p-0 active" id="tabVideos" name="tabVideos">
								<a class="nav-link text-md-left ml-0 ml-md-2 justify-content-center justify-content-md-start d-flex align-items-center" id="viewVideos" name="viewVideos">
									<span class="material-icons"> radio_button_checked </span><span>{{ __('add-video.videos') }}</span>
								</a>
							</div>
							<div class="col-6 folder p-0 active" id="tabVideos" name="tabVideos">
								<a class="nav-link text-md-left ml-0 ml-md-2 justify-content-center justify-content-md-start d-flex align-items-center" id="viewImages" name="viewImages">
									<span class="material-icons"> radio_button_unchecked </span><span>{{ __('add-video.images') }}</span>
								</a>
							</div>
						</div>
						 -->
					</div>
					<div class="w-100 h-100 py-md-0 py-3">
						<div class="h-100">
							<div class="main-folder pt-3 row w-100 m-0">
								{{ csrf_field() }}
								<input type="hidden" name="projectlibid" id="projectlibid" value="">	
								<div id="content-folder" class="folder p-0"></div>
							</div>
						</div>						
					</div>
				</div>
				<!-----CARDS---->
				<div class="content row p-0 m-0 col-12 col-md "> 
					<div id="myMedia" name="myMedia" class="row tables p-0 m-0 col-12 p-3 align-items-star justify-content-around">
					</div>
				</div>
			</div>
            
            <div class="downMenu row col-12 m-0 py-3 bg-05 align-items-center" style="justify-content: right">
                
                <div class="selectPanel">
                    <button data-dismiss="modal" onclick="closeModalLibrary()"aria-label="Close" class="d-none d-md-inline align-items-center justify-content-center btn-basic bg-Close cWhite px-3 px-lg-4">{{ __('add-video.close') }}</button>
                    <button type="submit" onclick="selectMedia()" name="btnSelect" class=" align-items-center justify-content-center btn-basic bg-02 px-3 px-lg-4 cWhite ">{{ __('add-video.select') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--- Modal Video Editor --->
<div class="modal fade" id="videoEditorModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl video-editor-dialog">
        <div class="modal-content video-editor-modal">
            <div class="video-editor-topbar">
                <button type="button" class="video-editor-icon" data-dismiss="modal" aria-label="Close" onclick="closeVideoEditor()">
                    <span class="material-icons">clear</span>
                </button>
                <p class="video-editor-title">{{ __('library.video_editor') }}</p>
                <button type="button" id="videoEditorSave" class="video-editor-export" onclick="saveVideoEdit()">
                    <span class="material-icons">file_upload</span>{{ __('library.export') }}
                </button>
            </div>
            <div class="video-editor-layout">
                <aside class="video-editor-left-panel">
                    <h3>{{ __('library.text_panel') }}</h3>
                    <div class="video-text-card active" data-style="plain" data-target="title">
                            <span>{{ __('library.plain_text') }}</span>
                    </div>
                    <p class="video-editor-subhead">{{ __('library.text_styles') }}</p>
                    <div class="video-editor-style-grid">
                        <button type="button" data-style="creator" data-target="title">{{ __('library.style_creator') }}</button>
                        <button type="button" data-style="box" data-target="title">{{ __('library.style_box') }}</button>
                        <button type="button" data-style="pride" data-target="title">Pride</button>
                        <button type="button" data-style="button" data-target="title">Button</button>
                        <button type="button" data-style="bubble" data-target="title">Bubble</button>
                        <button type="button" data-style="retro" data-target="title">{{ __('library.style_retro') }}</button>
                        <button type="button" data-style="machine" data-target="title">Maquina</button>
                        <button type="button" data-style="circular" data-target="title">Circular</button>
                        <button type="button" data-style="sharp" data-target="title">Nitido titulo</button>
                        <button type="button" data-style="double" data-target="title">Lineas dobles</button>
                    </div>
                </aside>
                <div class="video-editor-stage">
                <div class="video-editor-preview-wrap">
                    <video id="videoEditorPreview" class="video-editor-preview" controls playsinline>
                        <source src="" type="video/mp4" />
                    </video>
                    <div class="video-editor-text-preview">
                        <div id="videoEditorTitleBox" class="video-editor-title-box selected">
                            <div class="video-editor-floating-toolbar">
                                <span class="material-icons">edit</span>
                                <button type="button" data-color="#ffffff"></button>
                                <select id="videoEditorFont">
                                    <option value="Open Sans">Open Sans</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Arial">Arial</option>
                                </select>
                                <select id="videoEditorFontSize">
                                    <option value="28">28</option>
                                    <option value="36" selected>36</option>
                                    <option value="48">48</option>
                                    <option value="64">64</option>
                                </select>
                            </div>
                            <p id="videoEditorTitlePreview" contenteditable="true"></p>
                            <span class="video-editor-box-dot dot-tl"></span>
                            <span class="video-editor-box-dot dot-tr"></span>
                            <span class="video-editor-box-dot dot-bl"></span>
                            <span class="video-editor-box-dot dot-br"></span>
                            <span class="video-editor-box-dot dot-l"></span>
                            <span class="video-editor-box-dot dot-r"></span>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="video-editor-controls">
                <div class="video-editor-playback">
                    <button type="button" class="video-editor-play" onclick="toggleVideoEditorPlay()">
                        <span id="videoEditorPlayIcon" class="material-icons">play_arrow</span>
                    </button>
                    <span id="videoEditorCurrent">0:00</span>
                    <span>/</span>
                    <span id="videoEditorDuration">0:00</span>
                </div>
                <input type="hidden" id="videoEditorStart" value="0">
                <input type="hidden" id="videoEditorEnd" value="0">
                <input type="hidden" id="videoEditorOffset" value="0">
                <input type="hidden" id="videoEditorTextStart" value="0">
                <input type="hidden" id="videoEditorTextEnd" value="0">
                <input type="hidden" id="videoEditorTextVisible" value="1">
                <input type="hidden" id="videoEditorSubtitleInput" value="">
                <div class="video-editor-timeline">
                    <div class="video-editor-ruler" id="videoEditorRuler"></div>
                    <span class="video-editor-playhead" id="videoEditorPlayhead"></span>
                    <div class="video-editor-row video-editor-text-row">
                        <button type="button" id="videoEditorAddText" class="video-editor-add-text" onclick="showVideoEditorText()">
                            <span class="material-icons">title</span>
                            <span>+ Añadir texto</span>
                        </button>
                        <div id="videoEditorTextClip" class="video-editor-text-clip">
                            <span class="video-editor-handle video-editor-text-handle-left"></span>
                            <span class="material-icons">title</span>
                            <input type="text" id="videoEditorTitleInput" maxlength="120" value="Agrega tu texto aqui">
                            <button type="button" class="video-editor-text-hide" onclick="hideVideoEditorText(event)" title="Ocultar texto">
                                <span class="material-icons">visibility_off</span>
                            </button>
                            <span class="video-editor-handle video-editor-text-handle-right"></span>
                        </div>
                    </div>
                    <div class="video-editor-row">
                        <div id="videoEditorClip" class="video-editor-clip">
                            <span class="video-editor-handle video-editor-handle-left"></span>
                            <div class="video-editor-strip">
                                <span class="material-icons">volume_up</span>
                            </div>
                            <span class="video-editor-handle video-editor-handle-right"></span>
                        </div>
                    </div>
                </div>
                <p id="videoEditorStatus" class="video-editor-status"></p>
            </div>
        </div>
    </div>
</div>


<!--- Modal PlayVideo --->
<div class="modal fade bd-example-modal-sm" id="playMediaModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="col-12">
                <div class="col-12 row justify-content-end p-0 m-0 pt-3">
                    <button data-dismiss="modal" onclick="stopVideo()" aria-label="Close" type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
                        <span class="material-icons d-flex justify-content-center">clear</span>
                    </button>
                </div>
                <p class="text-h3 cMain text-center mt-3">{{ __('add-video.video') }}</p>
                <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                    <video id="playVideo" controls class="col-12">
                        <source src="" type="video/mp4" class="col-12" />
                        <p>{{ __('add-video.error_playing_video') }}</p>
                        <!-- type='video/ogg; codecs="theora, vorbis"'   width=640 height=360-->
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>


<!--- Modal PlayImage --->
<div class="modal fade bd-example-modal-sm" id="playImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="col-12">
                <div class="col-12 row justify-content-end p-0 m-0 pt-3">
                    <button data-dismiss="modal" aria-label="Close" type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
                        <span class="material-icons d-flex justify-content-center">clear</span>
                    </button>
                </div>
                <p class="text-h3 cMain text-center mt-3">{{ __('add-video.image') }}</p>
                <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                    <img id="playImage" src="" class="col-12 img-fluid" />
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Upload Media Progress-->
<div class="modal fade bd-example-modal-sm" id="uploadMediaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="col-12">
                <div class="col-12 row justify-content-end p-0 m-0 pt-3">
                    <button data-dismiss="modal" aria-label="Close" type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
                        <span class="material-icons d-flex justify-content-center">clear</span>
                    </button>
                </div>
                <p class="text-h3 cMain text-center mt-3">{{ __('add-video.uploading') }}</p>
                <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                    <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
                </div>
            </div>
        </div>
    </div>
</div>


<!--- Modal Eliminar Unico Fichero --->
<div class="modal fade bd-example-modal-sm" id="deleteMediaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="col-12">
                <div class="col-12 row justify-content-end p-0 m-0 pt-3">
                    <button data-dismiss="modal" aria-label="Close" type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
                        <span class="material-icons d-flex justify-content-center">clear</span>
                    </button>
                </div>
                <p class="text-h3 cMain text-center mt-3">{{ __('add-video.delete_multimedia') }}</p>
                <p class="text-center pb-2 c02">{{ __('add-video.are_you_sure_del_multimedia') }}</p>
                <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                    <button type="button" class="btn-square px-3 bg-Main cWhite" onclick="deleteMediaModalBtn()">{{ __('add-video.confirm') }}</button>
                    <button type="button" class="btn-square px-3 bg-05 cMain ml-5" data-dismiss="modal">{{ __('add-video.discard') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Eliminar Varios Ficheros-->
<div class="modal fade bd-example-modal-sm" id="deleteAllMediaModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="col-12">
                <div class="col-12 row justify-content-end p-0 m-0 pt-3">
                    <button data-dismiss="modal" aria-label="Close" type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
                        <span class="material-icons d-flex justify-content-center">clear</span>
                    </button>
                </div>
                <p class="text-h3 cMain text-center mt-3">{{ __('library.delete_multimedia') }}</p>
                <p class="text-center pb-2 c02">{{ __('library.are_you_sure_delete') }}</p>
                <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                    <button type="button" class="btn-square px-3 bg-Main cWhite" onclick="deleteAllMediaBtn()">{{ __('library.confirm') }}</button>
                    <button type="button" class="btn-square px-3 bg-05 cMain ml-5" data-dismiss="modal">{{ __('library.discard') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal New Folder-->
<div class="modal fade bd-example-modal-sm" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="col-12">
                <button type="button" class="btn-WhiteText cMain justify-self-end" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                <p class="text-h3 cMain text-center mt-3">{{ __('add-video.new_folder') }}</p>
                <div class="row justify-content-center bg-white px-3 px-md-4 ">
                    <div class="col-12 p-0 m-0 mb-4 row justify-content-center">
                        <label for="folderName" class="text-left pr-3 cMain mb-0"> {{ __('add-video.folder_name') }} </label>
                        <input type="text" class="col-6 inputForm p-0 c02" id="folderName"name="folderName" maxlength="20">
                    </div>
                    <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                        <button type="button" id="newFolderModalOK" class="btn-square px-3 bg-Main cWhite" onclick="createNewFolder()">{{ __('projects.ok') }}</button>
                        <button type="button" class="btn-square px-3 bg-05 cMain ml-5" data-dismiss="modal">{{ __('projects.cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .watermark {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;

    }

    .playVideo {
        border: 3px solid #000;
    }

    .cards {
        position: relative;
    }

    .video-editor-dialog {
        max-width: min(1180px, 96vw);
    }

    .video-editor-modal {
        border: 0;
        border-radius: 8px;
        overflow: hidden;
        background: #f7f7fb;
    }

    .video-editor-topbar {
        min-height: 72px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 14px 18px;
        background: #ffffff;
        border-bottom: 1px solid #e8e8f2;
    }

    .video-editor-title {
        margin: 0;
        color: #27263b;
        font-weight: 700;
        font-size: 20px;
    }

    .video-editor-icon,
    .video-editor-play {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 50%;
        background: #ffffff;
        color: #2b293d;
        box-shadow: 0 2px 10px rgba(23, 22, 34, 0.12);
    }

    .video-editor-export {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 0;
        border-radius: 6px;
        padding: 0 18px;
        background: #8d2df8;
        color: #ffffff;
        font-weight: 700;
    }

    .video-editor-layout {
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        min-height: 520px;
    }

    .video-editor-left-panel {
        background: #f7f7fb;
        border-right: 1px solid #e1e1ec;
        padding: 20px;
        overflow-y: auto;
        max-height: 64vh;
    }

    .video-editor-left-panel h3 {
        margin: 0 0 18px;
        color: #242235;
        font-size: 20px;
        font-weight: 800;
    }

    .video-text-card {
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid transparent;
        border-radius: 6px;
        background: #000000;
        color: #ffffff;
        font-size: 24px;
        font-weight: 800;
        cursor: pointer;
    }

    .video-text-card.active {
        border-color: #8d2df8;
    }

    .video-editor-subhead {
        margin-top: 20px !important;
        padding-top: 18px;
        border-top: 1px solid #e1e1ec;
        color: #242235 !important;
        font-size: 16px;
    }

    .video-editor-style-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .video-editor-style-grid button,
    .video-editor-pill {
        min-height: 74px;
        border: 1px solid #d9d7e8;
        border-radius: 6px;
        background: #ffffff;
        color: #242235;
        font-weight: 800;
    }

    .video-editor-style-grid button[data-style="creator"] {
        color: #ffffff;
        -webkit-text-stroke: 1px #111111;
        text-shadow: 2px 2px 0 #111111;
    }

    .video-editor-style-grid button[data-style="box"] {
        background: #111111;
        color: #ffffff;
    }

    .video-editor-style-grid button[data-style="pride"] {
        color: #ffffff;
        text-shadow: 3px 3px 0 #ff5757, 6px 6px 0 #48a7ff;
    }

    .video-editor-style-grid button[data-style="button"] {
        border-radius: 999px;
        box-shadow: 0 8px 18px rgba(23, 22, 34, 0.18);
    }

    .video-editor-style-grid button[data-style="bubble"] {
        color: #8cff2f;
        -webkit-text-stroke: 1px #2f7f16;
    }

    .video-editor-style-grid button[data-style="retro"] {
        color: #221d1d;
        text-shadow: 3px 3px 0 #ff9a21, 6px 6px 0 #2a6bff;
    }

    .video-editor-style-grid button.active,
    .video-editor-pill.active {
        border-color: #8d2df8;
        color: #8d2df8;
        box-shadow: 0 0 0 2px rgba(141, 45, 248, 0.14);
    }

    .video-editor-stage {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        min-height: 520px;
        background: #ffffff;
    }

    .video-editor-preview-wrap {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: #fdfdfd;
    }

    .video-editor-preview {
        width: 100%;
        max-height: 58vh;
        background: #000000;
        border: 3px solid #9b34ff;
    }

    .video-editor-preview.is-outside-clip {
        opacity: 0;
    }

    .video-editor-text-preview {
        position: absolute;
        inset: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 44px 24px;
        text-align: center;
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.85);
    }

    .video-editor-title-box {
        position: relative;
        min-width: 340px;
        max-width: 82%;
        padding: 18px 26px;
        border: 3px solid transparent;
    }

    .video-editor-title-box.selected {
        border-color: #8d2df8;
    }

    .video-editor-title-box p {
        margin: 0;
        font-size: 36px;
        font-weight: 800;
        overflow-wrap: anywhere;
        outline: 0;
        cursor: text;
    }

    .video-editor-floating-toolbar {
        position: absolute;
        left: 50%;
        top: -58px;
        transform: translateX(-50%);
        min-height: 40px;
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 6px 8px;
        border-radius: 6px;
        background: #ffffff;
        color: #2a293b;
        box-shadow: 0 4px 16px rgba(22, 20, 34, 0.18);
        text-shadow: none;
    }

    .video-editor-floating-toolbar button {
        width: 26px;
        height: 26px;
        border: 1px solid #c9c7d8;
        border-radius: 50%;
        background: #ffffff;
    }

    .video-editor-floating-toolbar select {
        height: 30px;
        border: 1px solid #d9d7e8;
        border-radius: 4px;
        color: #2a293b;
        background: #ffffff;
    }

    .video-editor-box-dot {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #8d2df8;
    }

    .dot-tl { left: -7px; top: -7px; }
    .dot-tr { right: -7px; top: -7px; }
    .dot-bl { left: -7px; bottom: -7px; }
    .dot-br { right: -7px; bottom: -7px; }
    .dot-l { left: -7px; top: calc(50% - 5px); }
    .dot-r { right: -7px; top: calc(50% - 5px); }

    .video-editor-title-box .text-box {
        padding: 10px 18px;
        background: rgba(0, 0, 0, 0.76);
        border-radius: 4px;
        text-shadow: none;
    }

    .video-editor-title-box .text-creator {
        color: #fff36b;
        -webkit-text-stroke: 1px #111111;
    }

    .video-editor-title-box .text-retro {
        color: #ffffff;
        text-shadow: 3px 3px 0 #ff8b2b, -3px -3px 0 #8d2df8;
    }

    .video-editor-title-box .text-pride {
        color: #ffffff;
        text-shadow: 3px 3px 0 #ff5757, 6px 6px 0 #48a7ff, 9px 9px 0 #ffd84d;
    }

    .video-editor-title-box .text-button {
        padding: 12px 28px;
        border-radius: 999px;
        background: #ffffff;
        color: #242235;
        text-shadow: none;
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.28);
    }

    .video-editor-title-box .text-bubble {
        color: #8cff2f;
        -webkit-text-stroke: 2px #2f7f16;
    }

    .video-editor-title-box .text-machine {
        font-family: Georgia, serif;
        letter-spacing: 0;
    }

    .video-editor-title-box .text-circular {
        padding: 28px;
        border-radius: 50%;
        background: #4b91e8;
        color: #ffffff;
        text-shadow: none;
    }

    .video-editor-title-box .text-sharp {
        padding: 10px 16px;
        border: 3px solid #ff9da1;
        color: #ffffff;
    }

    .video-editor-title-box .text-double {
        border-top: 4px solid #c15be8;
        border-bottom: 4px solid #c15be8;
        padding: 8px 0;
    }

    .video-editor-controls {
        padding: 16px 22px 20px;
        background: #ffffff;
        border-top: 1px solid #e8e8f2;
    }

    .video-editor-playback,
    .video-editor-trim,
    .video-editor-text {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .video-editor-trim label,
    .video-editor-text label {
        margin: 0;
        color: #6f6b85;
        font-weight: 700;
        white-space: nowrap;
    }

    .video-editor-trim input[type="range"] {
        min-width: 120px;
        flex: 1;
        accent-color: #8d2df8;
    }

    .video-editor-timeline {
        width: 100%;
        position: relative;
        padding-top: 6px;
    }

    .video-editor-ruler {
        position: relative;
        height: 38px;
        margin-bottom: 8px;
        border-radius: 8px;
        background: #f1e7ff;
        overflow: hidden;
    }

    .video-editor-ruler span {
        position: absolute;
        top: 11px;
        transform: translateX(-50%);
        color: #6f6b85;
        font-weight: 700;
        font-size: 13px;
    }

    .video-editor-row {
        position: relative;
        height: 62px;
        margin-bottom: 10px;
        background: #f4f4fa;
        overflow: hidden;
    }

    .video-editor-playhead {
        position: absolute;
        top: 6px;
        left: 0;
        width: 4px;
        height: calc(100% - 6px);
        background: #242235;
        border-radius: 4px;
        z-index: 20;
        pointer-events: none;
    }

    .video-editor-playhead:before {
        content: "";
        position: absolute;
        top: -8px;
        left: -11px;
        width: 26px;
        height: 28px;
        border-radius: 8px 8px 14px 14px;
        background: #242235;
    }

    .video-editor-playhead:after {
        content: attr(data-time);
        position: absolute;
        top: -42px;
        left: 50%;
        transform: translateX(-50%);
        min-width: 46px;
        padding: 5px 8px;
        border-radius: 7px;
        background: #242235;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        opacity: 0;
    }

    .video-editor-playhead.is-dragging:after,
    .video-editor-playhead:hover:after {
        opacity: 1;
    }

    .video-editor-text-row {
        height: 42px;
    }

    .video-editor-text-clip,
    .video-editor-clip {
        position: absolute;
        top: 5px;
        left: 0;
        width: 100%;
        height: calc(100% - 10px);
        border: 3px solid #8d2df8;
        border-radius: 8px;
        background: #efa0f6;
        overflow: hidden;
    }

    .video-editor-text-clip {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 28px;
        color: #7a176f;
        font-weight: 800;
        cursor: grab;
    }

    .video-editor-text-clip.is-dragging {
        cursor: grabbing;
    }

    .video-editor-add-text {
        position: absolute;
        inset: 8px 0;
        display: none;
        align-items: center;
        gap: 10px;
        padding: 0 20px;
        border: 2px dashed #dedce8;
        border-radius: 8px;
        background: #ffffff;
        color: #74718a;
        font-size: 18px;
        font-weight: 700;
        text-align: left;
    }

    .video-editor-text-clip input {
        width: 100%;
        border: 0;
        background: transparent;
        color: #7a176f;
        font-weight: 800;
        outline: 0;
        cursor: text;
    }

    .video-editor-text-clip .material-icons {
        flex: 0 0 auto;
    }

    .video-editor-text-hide {
        flex: 0 0 auto;
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.45);
        color: #7a176f;
        cursor: pointer;
    }

    .video-editor-text-hide .material-icons {
        font-size: 18px;
    }

    .video-editor-clip {
        background: #111111;
        cursor: grab;
    }

    .video-editor-clip.is-dragging {
        cursor: grabbing;
    }

    .video-editor-strip {
        height: 100%;
        margin: 0 18px;
        display: flex;
        align-items: center;
        background: linear-gradient(90deg, #f7fbff 0 12%, #dceefd 12% 26%, #ffffff 26% 42%, #cfe8ff 42% 58%, #ffffff 58% 76%, #ddefff 76% 100%);
        background-position: center;
        background-size: cover;
    }

    .video-editor-clip:before,
    .video-editor-clip:after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        width: 24px;
        background: repeating-linear-gradient(-45deg, rgba(36, 34, 53, 0.12), rgba(36, 34, 53, 0.12) 6px, rgba(255,255,255,0.7) 6px, rgba(255,255,255,0.7) 12px);
        z-index: 1;
        pointer-events: none;
    }

    .video-editor-clip:before {
        left: 18px;
    }

    .video-editor-clip:after {
        right: 18px;
    }

    .video-editor-strip .material-icons {
        margin-left: 10px;
        padding: 5px;
        border-radius: 4px;
        background: #ffffff;
        color: #242235;
    }

    .video-editor-handle {
        position: absolute;
        top: 0;
        width: 18px;
        height: 100%;
        background: #8d2df8;
        cursor: ew-resize;
        z-index: 2;
    }

    .video-editor-handle:after {
        content: "";
        position: absolute;
        top: 12px;
        bottom: 12px;
        left: 7px;
        width: 4px;
        border-radius: 4px;
        background: #ffffff;
    }

    .video-editor-handle-left {
        left: 0;
    }

    .video-editor-handle-right {
        right: 0;
    }

    .video-editor-text-handle-left {
        left: 0;
    }

    .video-editor-text-handle-right {
        right: 0;
    }

    .video-editor-text input {
        width: 100%;
        min-height: 40px;
        border: 1px solid #d9d7e8;
        border-radius: 6px;
        padding: 0 12px;
        color: #27263b;
    }

    .video-editor-text label {
        flex: 1;
    }

    .video-editor-status {
        min-height: 22px;
        margin: 0;
        color: #8d2df8;
        font-weight: 700;
    }

    .video-card-edit {
        position: absolute;
        right: 8px;
        bottom: 8px;
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: #ffffff;
        color: #8d2df8;
        box-shadow: 0 2px 10px rgba(23, 22, 34, 0.22);
        opacity: 0.95;
        z-index: 3;
    }

    .video-card-edit .material-icons {
        font-size: 19px;
        line-height: 34px;
    }

    @media screen and (max-width: 768px) {
        .video-editor-layout {
            grid-template-columns: 1fr;
        }

        .video-editor-left-panel {
            max-height: 260px;
            border-right: 0;
            border-bottom: 1px solid #e1e1ec;
        }

        .video-editor-stage {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .video-editor-playback,
        .video-editor-trim,
        .video-editor-text {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="{{ url('/translations/library.js') }}"></script>

<script type="text/javascript">
    //var currentTab = "VIDEO";
    const streamUrlTemplate = @json(route('stream', ':id'));
    var currentFolder = [];
    const folderNames = new Map();
    var videoEditorMedia = null;
    var videoEditorProjectTime = 0;
    var syncingVideoEditorTime = false;


    $(document).ready(function() {
        console.log("document.ready()");

        const relativeURL = window.location.pathname;
        console.log('URL relativa: ' + relativeURL);

        if (relativeURL == '/library') {
            $('.libreryContainer').append($('#libraryModal .container'));
            //$('.action-folder').append($('.upload'));
            //$('.action-folder').append($('#deleteMediaFileBtn'));
            $('.downMenu').remove();
        }

        
        $("#newFolder").click(function() {
            newFolder();
        });

        $("#mediaFile").change(function() {
            uploadMedia(this);
        });

        $("#deleteMediaFileBtn").hide();

        openFolder('MAIN');
        updateModalEvent();
        selectInputsMedia();
        bindVideoEditorTrimHandles();
        bindVideoEditorTextHandles();
        bindVideoEditorPlayhead();
        bindVideoEditorStageText();
        //updateViewDivs();


        $(document).on("keydown", function(event) {
			if (event.key === "Enter" && $("#newFolderModal").is(":visible")) {
    	    	$("#newFolderModalOK").trigger("click");
    	  	}
    	});
    });

    // Actualizo el contenido de la carpeta seleccionada
    function updateModalEvent() {
        console.log("updateModalEvent() ");
        
		$('#myMedia input[type=checkbox]').click(function() {
			var one_checked = false
            $('#myMedia input[type=checkbox]').each(function() {
                if (this.checked) {
                    one_checked = true;
                    return;
                }
            });

			if (one_checked) {
                $("#deleteMediaFileBtn").show();
                $("#deleteMediaFileBtn").addClass('active');
            } else {
                $("#deleteMediaFileBtn").hide();
                $("#deleteMediaFileBtn").removeClass('active');
            }
        });

		$('#content-folder input[type=checkbox]').click(function() {
			var one_checked = false
			
            $('#content-folder input[type=checkbox]').each(function() {
                if (this.checked) {
                    one_checked = true;
                    return;
                }
            });
            if (one_checked) {
                $("#deleteMediaFileBtn").show();
                $("#deleteMediaFileBtn").addClass('active');
            } else {
                $("#deleteMediaFileBtn").hide();
                $("#deleteMediaFileBtn").removeClass('active');
            }
        });
    }


    const selectInputsMedia = (element) => {
        console.log('selectInputsMedia()  ');

        let inputsMedia = document.querySelectorAll('.checkMedia');
        inputsMedia.forEach((element) => {
            selectMedias(element);
        })
    }


    const selectMedias = (element) => {
        console.log('selectMedias() element: ' + element.parentNode.parentNode.getAttribute('id'));
        element.addEventListener("change", (event) => {
            if (element.checked) {
                element.parentNode.classList.add('selected');
                element.parentNode.parentNode.classList.add('selected');
            } else {
                element.parentNode.classList.remove('selected');
                element.parentNode.parentNode.classList.remove('selected');
            }
        });
    }

    // ***** Crea un div para cada media que se encuentra en la carpeta seleccionada o las carpetas
    function makeDiv(url, id, type, media) {
        console.log("makeDiv() URL: " + url + " - ID: " + id + " - TYPE: " + type + " - MEDIA: " + media);

        // Creo el elemento vacio
        var newMedia = '';
        var originalMedia = media;
        var originalPreview = url || media;

        if (type == 'FOLDER') {
            newMedia = $('<span class="material-icons"></span>');
        } else {
            newMedia = $('<img class="img-fluid w-100 h-100" />');
        }

        newMedia.attr('media-src', media);
        newMedia.attr('media-id', id);
        newMedia.attr('media-type', type);
        if (url) {
            newMedia.attr('media-preview', url);
        }

        // Uri de la imagen o video
        let nameSpace = media.split("/");
        newMedia.attr('media-name', nameSpace[nameSpace.length - 1]);

        var playMedia = "";
        
        if (type.startsWith("video/")) {
            newMedia.attr('src', url || media);
            playMedia = 'ontouchstart="doubleTouchFunction(\'video\', ' + id + ')" ondblclick="playVideo(' + id + ')"';
        }
        if (type.startsWith("image/")) {
            newMedia.attr('src', url || media);
            var imagePreview = "'" + (url || media) + "'";
            playMedia = 'ontouchstart="doubleTouchFunction(\'image\', ' + imagePreview + ')" ondblclick="playImage(' + imagePreview + ')"';
        }
        if (type == "FOLDER") {
            if (url == id) {
                newMedia.html('reply');
            } else {
                newMedia.html('folder');
                folderNames.set(id, nameSpace[nameSpace.length - 1]);
            }

            playMedia = 'ontouchstart="doubleTouchFunction(\'folder\', ' + id + ')" ondblclick="openFolder(' + id + ')"';
        }

        var innerDiv = '';

        if (type == 'FOLDER') {
            innerDiv = '<div id="newDiv-' + id + '" name="newDiv-' + id + '" media-type="' + type + '" class="cards mt-0 mx-2 p-0">';
            innerDiv += '<div> ' + nameSpace[nameSpace.length - 1] + ' </div>';
        } else {
            innerDiv = '<div id="newDiv-' + id + '" name="newDiv-' + id + '" media-type="' + type + '" class="cards col-3 mt-2 mx-2 p-0">';
        }

        innerDiv += '<div class=" options d-flex justify-content-end p-0"' + playMedia + '>';

        //Para el caso de divs que no son folder return
        if (url != id && type != 'FOLDER') {
            innerDiv += '<input type="checkbox" class="selecter mt-2 mr-2 checkMedia" id="checkMedia" name="' + id + '">' +
                        '<button class="deleter ml-2 mb-2" id="' + id + '" name="' + id + '" onclick="deleteMedia(' + id + ')" >' +
                        	'<span class="trash material-icons mr-2">delete</span>' +
                        '</button>';
        }
        if (url != id && type == 'FOLDER') {
            innerDiv += '<input type="checkbox" class="selecter mt-0 mr-2 checkMedia" id="checkMedia" name="' + id + '">'
        }

        innerDiv += '</div> </div>';

        var newDiv = $(innerDiv);
        newMedia.appendTo(newDiv);

        // Agregamos icono
        if (type.includes('image')) {
            newDiv.prepend('<span class="tagImage material-icons">image</span>');
        }
        if (type.includes('video')) {
            newDiv.prepend('<span class="tagVideo material-icons">play_circle_filled</span>');
            newDiv.append('<button type="button" class="video-card-edit" title="' + libraryMsg.edit_video + '" onclick="openVideoEditor(event, ' + id + ', \'' + escapeJsAttribute(originalMedia) + '\', \'' + escapeJsAttribute(originalPreview) + '\')"><span class="material-icons">edit</span></button>');
        }

        return newDiv;
    }

    function escapeJsAttribute(value) {
        return String(value || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");
    }

    function formatEditorTime(seconds) {
        seconds = Math.max(0, Number(seconds) || 0);
        var minutes = Math.floor(seconds / 60);
        var rest = Math.floor(seconds % 60);
        return minutes + ':' + String(rest).padStart(2, '0');
    }

    function openVideoEditor(event, id, media, preview) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        videoEditorMedia = {
            id: id,
            media: media,
            preview: preview
        };

        var video = $('#videoEditorPreview').get(0);
        $('#videoEditorPreview source').attr('src', media);
        $('.video-editor-strip').css('background-image', preview ? 'url("' + preview + '")' : '');
        $('#videoEditorTitleInput').val('Agrega tu texto aqui');
        $('#videoEditorSubtitleInput').val('');
        $('.video-editor-style-grid button, .video-text-card').removeClass('active');
        $('.video-text-card[data-style="plain"]').addClass('active');
        $('#videoEditorTitleInput').attr('data-style', 'plain');
        $('#videoEditorSubtitleInput').attr('data-style', 'plain');
        $('#videoEditorTitlePreview').text('Agrega tu texto aqui');
        $('#videoEditorTextVisible').val(1);
        videoEditorProjectTime = 0;
        $('#videoEditorTextClip').show();
        $('#videoEditorAddText').hide();
        $('#videoEditorTitleBox').show().addClass('selected');
        updateVideoEditorTextStyles();
        $('#videoEditorStatus').text('');
        $('#videoEditorPlayIcon').text('play_arrow');
        video.load();

        $('#videoEditorModal').modal('show');
    }

    $('#videoEditorPreview').on('loadedmetadata', function() {
        var duration = this.duration || 0;
        $('#videoEditorStart').val(0);
        $('#videoEditorEnd').val(duration);
        $('#videoEditorOffset').val(0);
        $('#videoEditorTextStart').val(0);
        $('#videoEditorTextEnd').val(duration);
        $('#videoEditorDuration').text(formatEditorTime(duration));
        setVideoEditorProjectTime(0);
        updateVideoEditorLabels();
        updateVideoEditorTimeline();
    });

    $('#videoEditorPreview').on('timeupdate', function() {
        if (!syncingVideoEditorTime && !this.paused) {
            var start = Number($('#videoEditorStart').val()) || 0;
            var offset = Number($('#videoEditorOffset').val()) || 0;
            videoEditorProjectTime = Math.max(0, offset + ((this.currentTime || start) - start));
        }
        updateVideoEditorClock();
        updateVideoEditorPlayhead();
        updateVideoEditorTextVisibility();
        updateVideoEditorClipVisibility();
        var end = Number($('#videoEditorEnd').val()) || this.duration || 0;
        if (this.currentTime >= end) {
            this.pause();
            $('#videoEditorPlayIcon').text('play_arrow');
        }
    });

    $('#videoEditorPreview').on('play', function() {
        syncVideoEditorSourceToProjectTime();
    });

    $('#videoEditorTitleInput, #videoEditorSubtitleInput').on('input', function() {
        $('#videoEditorTitlePreview').text($('#videoEditorTitleInput').val());
        $('#videoEditorTitleBox').show().addClass('selected');
    });

    $('#videoEditorTitlePreview').on('input', function() {
        $('#videoEditorTitleInput').val($(this).text().trim());
    });

    $('#videoEditorTitleInput').on('mousedown touchstart click', function(event) {
        event.stopPropagation();
    });

    $('#videoEditorFont').on('change', function() {
        $('#videoEditorTitlePreview').css('font-family', $(this).val());
    });

    $('#videoEditorFontSize').on('change', function() {
        $('#videoEditorTitlePreview').css('font-size', $(this).val() + 'px');
    });

    $('.video-editor-style-grid button, .video-text-card').on('click', function() {
        var target = $(this).data('target') || 'title';
        var style = $(this).data('style') || 'plain';
        $('[data-target="' + target + '"]').removeClass('active');
        $(this).addClass('active');

        if (target == 'subtitle') {
            $('#videoEditorSubtitleInput').attr('data-style', style);
        } else {
            $('#videoEditorTitleInput').attr('data-style', style);
        }

        updateVideoEditorTextStyles();
    });

    function updateVideoEditorTextStyles() {
        applyVideoEditorTextStyle($('#videoEditorTitlePreview'), $('#videoEditorTitleInput').attr('data-style'));
    }

    function applyVideoEditorTextStyle($element, style) {
        $element.removeClass('text-box text-creator text-retro text-pride text-button text-bubble text-machine text-circular text-sharp text-double');
        if (style == 'box') {
            $element.addClass('text-box');
        } else if (style == 'creator') {
            $element.addClass('text-creator');
        } else if (style == 'retro') {
            $element.addClass('text-retro');
        } else if (style == 'pride') {
            $element.addClass('text-pride');
        } else if (style == 'button') {
            $element.addClass('text-button');
        } else if (style == 'bubble') {
            $element.addClass('text-bubble');
        } else if (style == 'machine') {
            $element.addClass('text-machine');
        } else if (style == 'circular') {
            $element.addClass('text-circular');
        } else if (style == 'sharp') {
            $element.addClass('text-sharp');
        } else if (style == 'double') {
            $element.addClass('text-double');
        }
    }

    function updateVideoEditorLabels() {
        var duration = $('#videoEditorPreview').get(0).duration || 0;
        var start = Number($('#videoEditorStart').val()) || 0;
        var end = Number($('#videoEditorEnd').val()) || duration;
        $('#videoEditorStartLabel').text(formatEditorTime(start));
        $('#videoEditorEndLabel').text(formatEditorTime(end));
        $('#videoEditorStartPanel').text(formatEditorTime(start));
        $('#videoEditorEndPanel').text(formatEditorTime(end));
        $('#videoEditorDuration').text(formatEditorTime(duration));
        updateVideoEditorClock();
    }

    function updateVideoEditorClock() {
        var video = $('#videoEditorPreview').get(0);
        var duration = video.duration || 0;
        var current = Math.max(0, Math.min(videoEditorProjectTime || 0, duration));
        $('#videoEditorCurrent').text(formatEditorTime(current));
    }

    function setVideoEditorProjectTime(projectTime) {
        var video = $('#videoEditorPreview').get(0);
        var duration = video.duration || 0;

        videoEditorProjectTime = Math.max(0, Math.min(Number(projectTime) || 0, duration));

        if (duration) {
            syncVideoEditorSourceToProjectTime();
        }

        updateVideoEditorClock();
        updateVideoEditorPlayhead();
        updateVideoEditorTextVisibility();
        updateVideoEditorClipVisibility();
    }

    function videoEditorSourceTimeFromProject(projectTime) {
        var video = $('#videoEditorPreview').get(0);
        var duration = video.duration || 0;
        var start = Number($('#videoEditorStart').val()) || 0;
        var end = Number($('#videoEditorEnd').val()) || duration;
        var offset = Number($('#videoEditorOffset').val()) || 0;
        var clipDuration = Math.max(0.5, end - start);
        var insideClip = projectTime >= offset && projectTime <= offset + clipDuration;
        var sourceTime = insideClip ? start + (projectTime - offset) : start;

        return Math.max(start, Math.min(sourceTime, end));
    }

    function syncVideoEditorSourceToProjectTime() {
        var video = $('#videoEditorPreview').get(0);
        var sourceTime = videoEditorSourceTimeFromProject(videoEditorProjectTime || 0);

        if (Math.abs((video.currentTime || 0) - sourceTime) > 0.05) {
            syncingVideoEditorTime = true;
            video.currentTime = sourceTime;
            setTimeout(function() {
                syncingVideoEditorTime = false;
            }, 0);
        }
    }

    function buildVideoEditorRuler(duration) {
        var $ruler = $('#videoEditorRuler');
        $ruler.empty();
        duration = Math.max(0.5, duration || 0.5);
        var step = duration <= 90 ? 15 : 30;
        for (var second = 0; second <= duration + 0.1; second += step) {
            $ruler.append('<span style="left:' + ((second / duration) * 100) + '%">' + formatEditorTime(second) + '</span>');
        }
    }

    function updateVideoEditorTimeline() {
        var duration = $('#videoEditorPreview').get(0).duration || 0;
        var start = Number($('#videoEditorStart').val()) || 0;
        var end = Number($('#videoEditorEnd').val()) || duration;
        var offset = Number($('#videoEditorOffset').val()) || 0;
        var rawTextStart = Number($('#videoEditorTextStart').val());
        var rawTextEnd = Number($('#videoEditorTextEnd').val());
        var textStart = isNaN(rawTextStart) ? 0 : rawTextStart;
        var textEnd = isNaN(rawTextEnd) ? duration : rawTextEnd;
        if (!duration) {
            return;
        }

        var editedDuration = Math.max(0.5, end - start);
        offset = Math.max(0, Math.min(offset, duration - editedDuration));
        textStart = Math.max(0, Math.min(textStart, duration - 0.5));
        textEnd = Math.max(textStart + 0.5, Math.min(textEnd, duration));

        var videoLeft = (offset / duration) * 100;
        var videoWidth = (editedDuration / duration) * 100;
        var textLeft = (textStart / duration) * 100;
        var textWidth = ((textEnd - textStart) / duration) * 100;

        $('#videoEditorOffset').val(offset);
        $('#videoEditorTextStart').val(textStart);
        $('#videoEditorTextEnd').val(textEnd);
        $('#videoEditorClip').css({ left: videoLeft + '%', width: videoWidth + '%' });
        $('#videoEditorTextClip').css({ left: textLeft + '%', width: textWidth + '%' });
        buildVideoEditorRuler(duration);
        updateVideoEditorPlayhead();
        updateVideoEditorClipVisibility();
    }

    function updateVideoEditorPlayhead() {
        var duration = $('#videoEditorPreview').get(0).duration || 0;
        if (!duration) {
            return;
        }
        var current = $('#videoEditorPreview').get(0).currentTime || 0;
        var left = Math.max(0, Math.min(100, ((videoEditorProjectTime || 0) / duration) * 100));
        $('#videoEditorPlayhead').css('left', left + '%').attr('data-time', formatEditorTime(videoEditorProjectTime || 0));
    }

    function projectTimeFromTimelinePointer(event) {
        var pointer = event.originalEvent && event.originalEvent.touches ? event.originalEvent.touches[0] : event;
        var $timeline = $('#videoEditorRuler');
        var duration = $('#videoEditorPreview').get(0).duration || 0;
        var left = Math.max(0, Math.min(pointer.pageX - $timeline.offset().left, $timeline.width()));

        return duration ? (left / $timeline.width()) * duration : 0;
    }

    function bindVideoEditorPlayhead() {
        var dragging = false;

        $('#videoEditorPlayhead').on('mousedown touchstart', function(event) {
            dragging = true;
            $(this).addClass('is-dragging');
            event.preventDefault();
            event.stopPropagation();
        });

        $('#videoEditorRuler').on('mousedown touchstart', function(event) {
            dragging = true;
            $('#videoEditorPlayhead').addClass('is-dragging');
            setVideoEditorProjectTime(projectTimeFromTimelinePointer(event));
            event.preventDefault();
        });

        $(document).on('mousemove.videoEditorPlayhead touchmove.videoEditorPlayhead', function(event) {
            if (!dragging) {
                return;
            }

            setVideoEditorProjectTime(projectTimeFromTimelinePointer(event));
            event.preventDefault();
        });

        $(document).on('mouseup.videoEditorPlayhead touchend.videoEditorPlayhead', function() {
            dragging = false;
            $('#videoEditorPlayhead').removeClass('is-dragging');
        });
    }

    function bindVideoEditorTrimHandles() {
        var dragSide = null;
        var dragStartX = 0;
        var dragStartValue = 0;
        var dragEndValue = 0;
        var dragOffsetValue = 0;
        var dragHasMoved = false;

        $('#videoEditorClip').on('mousedown touchstart', function(event) {
            if ($(event.target).hasClass('video-editor-handle')) {
                return;
            }

            var pointer = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
            dragSide = 'move';
            dragStartX = pointer.pageX;
            dragStartValue = Number($('#videoEditorStart').val()) || 0;
            dragEndValue = Number($('#videoEditorEnd').val()) || ($('#videoEditorPreview').get(0).duration || 0);
            dragOffsetValue = Number($('#videoEditorOffset').val()) || 0;
            dragHasMoved = false;
            $('#videoEditorClip').addClass('is-dragging');
            event.preventDefault();
        });

        $('#videoEditorClip .video-editor-handle').on('mousedown touchstart', function(event) {
            var pointer = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
            dragSide = $(this).hasClass('video-editor-handle-left') ? 'left' : 'right';
            dragStartX = pointer.pageX;
            dragStartValue = Number($('#videoEditorStart').val()) || 0;
            dragEndValue = Number($('#videoEditorEnd').val()) || ($('#videoEditorPreview').get(0).duration || 0);
            dragOffsetValue = Number($('#videoEditorOffset').val()) || 0;
            dragHasMoved = true;
            event.preventDefault();
            event.stopPropagation();
        });

        $(document).on('mousemove.videoEditorTrim touchmove.videoEditorTrim', function(event) {
            if (!dragSide) {
                return;
            }

            var pointer = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
            var $row = $('#videoEditorClip').parent();
            var width = $row.width();
            var duration = $('#videoEditorPreview').get(0).duration || 0;
            var deltaSeconds = ((pointer.pageX - dragStartX) / width) * duration;
            var start = dragStartValue;
            var end = dragEndValue;
            var offset = dragOffsetValue;
            var clipDuration = Math.max(0.5, end - start);

            if (dragSide == 'move' && !dragHasMoved && Math.abs(pointer.pageX - dragStartX) < 4) {
                return;
            }
            dragHasMoved = true;

            if (dragSide == 'left') {
                start = Math.max(0, Math.min(dragStartValue + deltaSeconds, end - 0.5));
                $('#videoEditorStart').val(Math.max(0, start));
                offset = Math.max(0, Math.min(dragOffsetValue + (start - dragStartValue), duration - (end - start)));
                $('#videoEditorOffset').val(offset);
                setVideoEditorProjectTime(offset);
            } else {
                if (dragSide == 'move') {
                    offset = Math.max(0, Math.min(dragOffsetValue + deltaSeconds, duration - clipDuration));
                    $('#videoEditorOffset').val(offset);
                    setVideoEditorProjectTime(offset);
                } else {
                end = Math.min(duration, Math.max(dragEndValue + deltaSeconds, start + 0.5));
                $('#videoEditorEnd').val(Math.min(duration, end));
                    setVideoEditorProjectTime((Number($('#videoEditorOffset').val()) || 0) + (end - start));
                }
            }

            updateVideoEditorLabels();
            updateVideoEditorTimeline();
        });

        $(document).on('mouseup.videoEditorTrim touchend.videoEditorTrim', function() {
            dragSide = null;
            $('#videoEditorClip').removeClass('is-dragging');
        });
    }

    function bindVideoEditorTextHandles() {
        var dragSide = null;
        var dragStartX = 0;
        var dragTextStartValue = 0;
        var dragTextEndValue = 0;
        var dragHasMoved = false;

        $('#videoEditorTextClip').on('mousedown touchstart', function(event) {
            if ($(event.target).hasClass('video-editor-handle')) {
                return;
            }

            if ($(event.target).is('input, select, button, textarea')) {
                return;
            }

            var pointer = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
            dragSide = 'move';
            dragStartX = pointer.pageX;
            dragTextStartValue = Number($('#videoEditorTextStart').val()) || 0;
            dragTextEndValue = Number($('#videoEditorTextEnd').val()) || ($('#videoEditorPreview').get(0).duration || 0);
            dragHasMoved = false;
            $('#videoEditorTextClip').addClass('is-dragging');
        });

        $('#videoEditorTextClip .video-editor-handle').on('mousedown touchstart', function(event) {
            var pointer = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
            dragSide = $(this).hasClass('video-editor-text-handle-left') ? 'left' : 'right';
            dragStartX = pointer.pageX;
            dragTextStartValue = Number($('#videoEditorTextStart').val()) || 0;
            dragTextEndValue = Number($('#videoEditorTextEnd').val()) || ($('#videoEditorPreview').get(0).duration || 0);
            dragHasMoved = true;
            event.preventDefault();
            event.stopPropagation();
        });

        $(document).on('mousemove.videoEditorTextTrim touchmove.videoEditorTextTrim', function(event) {
            if (!dragSide) {
                return;
            }

            var pointer = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
            var $row = $('#videoEditorTextClip').parent();
            var width = $row.width();
            var duration = $('#videoEditorPreview').get(0).duration || 0;
            var projectStart = 0;
            var projectEnd = duration;
            if (dragSide == 'move' && !dragHasMoved && Math.abs(pointer.pageX - dragStartX) < 4) {
                return;
            }
            dragHasMoved = true;
            var deltaSeconds = ((pointer.pageX - dragStartX) / width) * Math.max(0.5, projectEnd - projectStart);
            var textStart = dragTextStartValue;
            var textEnd = dragTextEndValue;

            if (dragSide == 'left') {
                textStart = Math.min(dragTextStartValue + deltaSeconds, textEnd - 0.5);
                textStart = Math.max(projectStart, textStart);
                $('#videoEditorTextStart').val(textStart);
                $('#videoEditorPreview').get(0).currentTime = textStart;
            } else if (dragSide == 'right') {
                textEnd = Math.max(dragTextEndValue + deltaSeconds, textStart + 0.5);
                textEnd = Math.min(projectEnd, textEnd);
                $('#videoEditorTextEnd').val(textEnd);
                $('#videoEditorPreview').get(0).currentTime = textEnd;
            } else {
                var textDuration = Math.max(0.5, dragTextEndValue - dragTextStartValue);
                textStart = dragTextStartValue + deltaSeconds;
                textStart = Math.max(projectStart, Math.min(textStart, projectEnd - textDuration));
                textEnd = textStart + textDuration;
                $('#videoEditorTextStart').val(textStart);
                $('#videoEditorTextEnd').val(textEnd);
                $('#videoEditorPreview').get(0).currentTime = textStart;
            }

            event.preventDefault();
            updateVideoEditorTimeline();
            updateVideoEditorTextVisibility();
        });

        $(document).on('mouseup.videoEditorTextTrim touchend.videoEditorTextTrim', function() {
            dragSide = null;
            $('#videoEditorTextClip').removeClass('is-dragging');
        });
    }

    function bindVideoEditorStageText() {
        $('#videoEditorTitleBox').on('click', function() {
            $(this).addClass('selected');
            $('#videoEditorTitlePreview').focus();
        });
    }

    function hideVideoEditorText(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        $('#videoEditorTextVisible').val(0);
        $('#videoEditorTextClip').hide();
        $('#videoEditorAddText').css('display', 'flex');
        $('#videoEditorTitleBox').hide();
    }

    function showVideoEditorText() {
        $('#videoEditorTextVisible').val(1);
        $('#videoEditorTextClip').show();
        $('#videoEditorAddText').hide();
        $('#videoEditorTitleBox').show().addClass('selected');
        updateVideoEditorTimeline();
        updateVideoEditorTextVisibility();
    }

    function updateVideoEditorTextVisibility() {
        if ($('#videoEditorTextVisible').val() == '0') {
            $('#videoEditorTitleBox').hide();
            return;
        }

        var current = videoEditorProjectTime || 0;
        var textStart = Number($('#videoEditorTextStart').val()) || 0;
        var textEnd = Number($('#videoEditorTextEnd').val()) || ($('#videoEditorPreview').get(0).duration || 0);
        $('#videoEditorTitleBox').toggle(current >= textStart && current <= textEnd);
    }

    function updateVideoEditorClipVisibility() {
        var video = $('#videoEditorPreview').get(0);
        var current = videoEditorProjectTime || 0;
        var duration = video.duration || 0;
        var start = Number($('#videoEditorStart').val()) || 0;
        var end = Number($('#videoEditorEnd').val()) || duration;
        var offset = Number($('#videoEditorOffset').val()) || 0;
        var clipDuration = Math.max(0.5, end - start);
        $('#videoEditorPreview').toggleClass('is-outside-clip', current < offset || current > offset + clipDuration);
    }

    function toggleVideoEditorPlay() {
        var video = $('#videoEditorPreview').get(0);
        var start = Number($('#videoEditorStart').val()) || 0;
        var end = Number($('#videoEditorEnd').val()) || video.duration || 0;

        if (video.paused) {
            if (video.currentTime >= video.duration) {
                video.currentTime = 0;
            }
            syncVideoEditorSourceToProjectTime();
            video.play();
            $('#videoEditorPlayIcon').text('pause');
        } else {
            video.pause();
            $('#videoEditorPlayIcon').text('play_arrow');
        }
    }

    function closeVideoEditor() {
        var video = $('#videoEditorPreview').get(0);
        video.pause();
        $('#videoEditorPlayIcon').text('play_arrow');
    }

    function saveVideoEdit() {
        if (!videoEditorMedia) {
            return;
        }

        var form = new FormData();
        form.append('_token', $("input[name=_token]").val());
        form.append('id', videoEditorMedia.id);
        form.append('start', $('#videoEditorStart').val());
        form.append('end', $('#videoEditorEnd').val());
        form.append('offset', $('#videoEditorOffset').val());
        form.append('title', $('#videoEditorTextVisible').val() == '0' ? '' : $('#videoEditorTitleInput').val());
        form.append('subtitle', $('#videoEditorSubtitleInput').val());
        form.append('titleStyle', $('#videoEditorTitleInput').attr('data-style') || 'plain');
        form.append('subtitleStyle', $('#videoEditorSubtitleInput').attr('data-style') || 'plain');
        form.append('titleStart', $('#videoEditorTextStart').val());
        form.append('titleEnd', $('#videoEditorTextEnd').val());
        form.append('titleVisible', $('#videoEditorTextVisible').val());
        form.append('titleFontSize', $('#videoEditorFontSize').val());

        $('#videoEditorSave').prop('disabled', true);
        $('#videoEditorStatus').text(libraryMsg.saving_video);

        $.ajax({
            url: '/ajax-editVideo',
            type: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success == 'Y') {
                    var newDiv = makeDiv(response.file, response.id, response.type, response.media);
                    $('#myMedia').append(newDiv);
                    updateModalEvent();
                    selectInputsMedia();
                    $('#videoEditorStatus').text(response.message || libraryMsg.video_editor_saved);
                    setTimeout(function() {
                        $('#videoEditorModal').modal('hide');
                        closeVideoEditor();
                    }, 700);
                } else {
                    $('#videoEditorStatus').text(response.error || libraryMsg.video_editor_error);
                }
            },
            error: function(request, error) {
                var backendMessage = request && request.responseJSON
                    ? (request.responseJSON.message || request.responseJSON.error || '')
                    : '';
                $('#videoEditorStatus').text(backendMessage || error || libraryMsg.video_editor_error);
            },
            complete: function() {
                $('#videoEditorSave').prop('disabled', false);
            }
        });
    }

	//TODO
    //function updateViewDivs() {
    //    console.log("updateViewDivs() currentTab: " + currentTab);

    //    selectInputsMedia();
    //    if (currentTab == "IMAGE") {
    //        $('div[media-type^="video"]').each(function() {
    //            $(this).hide();
    //        });
    //        $('div[media-type^="image"]').each(function() {
    //            $(this).show();
    //        });
    //    } else {
    //        $('div[media-type^="video"]').each(function() {
    //            $(this).show();
    //        });
    //        $('div[media-type^="image"]').each(function() {
    //            $(this).hide();
    //        });
    //    }
    //}


    function playVideo(mediaId) {
        console.log("playVideo() Media ID: " + mediaId);

        $('source', $('#playVideo')).attr('src', streamUrlTemplate.replace(':id', mediaId));
        $('#playMediaModal').modal('show');
        $('#playVideo').get(0).load();
        //$('#playVideo').get(0).play();
    }

    let touchCount = 0; // Varibale necesaria ara el contador de toques
    let touchTimeout; // Variable para el timeout del contador de toques	
    // Contador de toques para detectar doble toque y abrir carpeta o video/imagen
    function doubleTouchFunction(origen, id) {
        touchCount++;
        if (touchCount === 2) {
            //openFolder();
            //alert('doble'+id+' - '+origen);
            if (origen == 'folder') {
                openFolder(id);
            } else if (origen == 'video') {
                playVideo(id);
            } else if (origen == 'image') {
                playImage(id);
            }

            touchCount = 0; // Reiniciar contador
        }
        clearTimeout(touchTimeout);
        touchTimeout = setTimeout(() => {
            touchCount = 0; // Reiniciar si pasa mucho tiempo entre toques
        }, 300); // Ajustar el tiempo según lo necesario
    }


    function stopVideo() {
        console.log("playVideo()");

        $('#playVideo').get(0).pause();
    }


    function playImage(media) {
        console.log("playImage() Media: " + media);

        $('#playImage').attr('src', media);
        $('#playImageModal').modal('show');
    }

    // Cierra el modal de la libreria
    function closeModalLibrary() {
        $('#libraryModal').modal('hide');
    }


    function uploadMedia(input) {
        console.log("uploadMedia() Current Folder: " + currentFolder[currentFolder.length - 1]);

        if (input.files && input.files[0]) {

            if (!input.files[0].type.match('image/*') && !input.files[0].type.match('video/*')) {
                modalMsgShow(libraryMsg.notvalidType);
                $("#mediaFile")[0].value = '';
                return null;
            }

            var reader = new FileReader();

            reader.onload = function(e) {
                var form = new FormData();
                form.append('_token', $("input[name=_token]").val());
                form.append('mediaFile', input.files[0]);
                form.append('folderID', currentFolder[currentFolder.length - 1]);

                $("#uploadMediaModal").modal("show");
                //cache: false,

                $.ajax({
                    url: '/ajax-addMedia',
                    type: 'POST',
                    data: form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    async: true,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                console.log(percentComplete + "%");
                                $('#progressBar').val(Math.round(percentComplete));

                                if (percentComplete >= 100) {
                                    $("#uploadMediaModal").modal("hide");
                                    setTimeout(
                                        function() {
                                            console.log(
                                                "voy a cerrar modal despues de 3 sec");
                                            $("#uploadMediaModal").modal("hide");
                                        }, 1500);
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        if (response.success == 'Y') {
                            newDiv = makeDiv(response.file, response.id, response.type, response.media);
                       
                           
                       
                            $('#myMedia').append(newDiv);

                            if (response.type.startsWith("image/"))
                                $("#viewImages").click();
                            else
                                $("#viewVideos").click();

                            updateModalEvent();
                            //updateViewDivs();
                            selectInputsMedia();
                            //selectedImage();
                            console.log("voy a cerrar modal");
                            $("#uploadMediaModal").modal("hide");

                            setTimeout(
                                function() {
                                    console.log("voy a cerrar modal despues de 3 sec");
                                    $("#uploadMediaModal").modal("hide");
                                }, 1500);

                            $("#mediaFile")[0].value = '';
                        } else {
                            console.log('Errores : ' + response.error);
                            modalMsgShow(JSON.stringify(response.error));

                            $("#uploadMediaModal").modal("hide");
                            $("#mediaFile")[0].value = '';

                            setTimeout(
                                function() {
                                    console.log("voy a cerrar modal despues de 3 sec");
                                    $("#uploadMediaModal").modal("hide");
                                }, 1500);

                        }
                        $("#uploadMediaModal").modal("hide");
                    },
                    error: function(request, error) {
                        console.log(error);
                        console.log(request);
                        //alert(JSON.stringify(error));
                        modalMsgShow(JSON.stringify(error));

                        $("#uploadMediaModal").modal("hide");
                        $("#mediaFile")[0].value = '';

                        setTimeout(
                            function() {
                                console.log("voy a cerrar modal despues de 3 sec");
                                $("#uploadMediaModal").modal("hide");
                            }, 1500);
                    }
                });
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    //Esta funcion es para desmarcar hermanos cuando selecciono una imagen/video
    function selectedImage() {
        console.log('selectedImage()');

        $('#myMedia input[type=checkbox]').each(function() {
            $(this).change(function() {
                if ($(this).prop('checked')) {
                    //console.log('selectedImage() selected name: ' + $(this).prop('name'));

                    $('#myMedia input[type=checkbox]').prop("checked", false);
                    $('#myMedia input[type=checkbox]').parent().removeClass('selected');
                    $(this).parent().addClass('selected');
                    $(this).prop("checked", true);
                } else {
                    //console.log('selectedImage() unselected name: ' + $(this).prop('name'));
                    $(this).parent().removeClass('selected');
                }
            });
        });
    }


    function deleteMedia(id) {
        console.log("deleteMedia() MediaID: " + id);

        $('#deleteMediaModal').modal('show');
        currentID = id;
    }


    function deleteMediaModalBtn() {
        console.log("deleteMediaModalBtn()");
        
        deleteMediaAux(currentID);
        $('#deleteMediaModal').modal('hide');
        currentID = null;

    }

    function deleteAllMediaBtn() {
        console.log("deleteAllMediaBtn()");

        $('#myMedia input[type=checkbox]').each(function() {
            if (this.checked) {
                var name = "#newDiv-" + $(this).attr("name");
                console.log("Borrando: " + name)
                deleteMediaAux($(this).attr("name"));
            }
        });

        $('#content-folder input[type=checkbox]').each(function() {
            if (this.checked) {
                var name = "#newDiv-" + $(this).attr("name");
                console.log("Borrando: " + name)
                deleteMediaAux($(this).attr("name"));
            }
        });

        //$("#deleteMediaFileBtn").hide();
        $('#deleteAllMediaModal').modal('hide');
    }


    function deleteMediaAux(id) {
        console.log("deleteMediaAux() ID: " + id);

        var form = new FormData();
        form.append('_token', $("input[name=_token]").val());
        form.append('id', id);

        $.ajax({
            url: '/ajax-delMedia',
            type: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success == 'Y') {
                    var name = "#newDiv-" + id;
                    $(name).remove();
                    updateModalEvent();

                    var one_checked = false
                    $('#myMedia input[type=checkbox]').each(function() {
                        if (this.checked) {
                            one_checked = true;
                            return;
                        }
                    });
                    $('#content-folder input[type=checkbox]').each(function() {
                        if (this.checked) {
                            one_checked = true;
                            return;
                        }
                    });

        			if (one_checked) {
                        $("#deleteMediaFileBtn").show();
                        $("#deleteMediaFileBtn").addClass('active');
                    } else {
                        $("#deleteMediaFileBtn").hide();
                        $("#deleteMediaFileBtn").removeClass('active');
                    }
                    
                } else if (response.success == 'N') {
                    //alert(response.message);
                    modalMsgShow(response.message);
                } else {
                    console.log('Respuesta: %o', response);
                }
            },
            error: function(request, error) {
                console.log(error);
                console.log(request);
                var fallback = 'Error eliminando archivo';
                var backendMessage = request && request.responseJSON
                    ? (request.responseJSON.message || request.responseJSON.error || '')
                    : '';

                if (Array.isArray(backendMessage)) {
                    backendMessage = backendMessage.join(' | ');
                } else if (typeof backendMessage === 'object' && backendMessage !== null) {
                    backendMessage = JSON.stringify(backendMessage);
                }

                modalMsgShow(backendMessage || fallback);
            }
        });
    }




    // Delete Folder
    function deleteFolders(array) {

    }

    function newFolder() {
        console.log("newFolder()");

        $('#newFolderModal').modal('show');
    }

    // Crear una nueva carpeta
    // Se llama desde el modal de crear carpeta
    function createNewFolder() {
        console.log("crfeateNewFolder()");

        if (!$("#folderName").val()) {
            modalMsgShow(libraryMsg.missingFolderName);
            return;
        }

        var regex = new RegExp("^[a-zA-Z0-9. ]*$");
        if (!regex.test($("#folderName").val())) {
            modalMsgShow(libraryMsg.invalidFolderName);

            return;
        }

        var form = new FormData();
        form.append('_token', $("input[name=_token]").val());
        form.append('folderName', $("#folderName").val());
        form.append('currentFolder', currentFolder[currentFolder.length - 1]);

        $('#newFolderModal').modal('hide');

        $.ajax({
            url: '/ajax-newFolder',
            type: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success == 'Y') {
                    //modalMsgShow(response.message);
                    newDiv = makeDiv(response.file, response.id, response.type, response.media);
                    // Se añade la nueva carpeta al contenedor de de carpetas
                    $('#content-folder').prepend(newDiv);
                    updateModalEvent();
                    selectInputsMedia();
                    //updateViewDivs();
                    $("#folderName").val("");
                } else if (response.success == 'N') {
                    //alert(response.message);
                    modalMsgShow(response.error);
                } else {
                    console.log('Respuesta: %o', response);
                }
            },
            error: function(request, error) {
                console.log(error);
                console.log(request);
                modalMsgShow(JSON.stringify(error));
            }
        });
    }


    function openFolder(id) {
        console.log("openFolder() ID: " + id);
        var form = new FormData();
        form.append('_token', $("input[name=_token]").val());
        form.append('folderID', id);

        $.ajax({
            url: '/ajax-openFolder',
            type: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success == 'Y') {
                    // console.log("openFolder() Folders to display: %o", response.folders);
					
					currentFolder.push(id);
					index = currentFolder.indexOf(id);

					if(index == 1)
						previousFolder = "'MAIN'";
					else
						previousFolder = currentFolder[index-1];

					currentFolder  = currentFolder.slice(0, index + 1);

					console.log("openFolder() Folders Index: "+ index + " - Previous: " + previousFolder + "- Miga: " + currentFolder);

					
                    // Limpio el contenido de la carpeta
                    $('#myMedia').empty();
                    $('#content-folder').empty();

                    if(id != 'MAIN'){
						newDiv = makeDiv(previousFolder, previousFolder, 'FOLDER', libraryMsg.back+"/"+libraryMsg.back);
						$('#content-folder').prepend(newDiv);   
					}

                    $.each(response.folders, function(i, item) {
                    	newDiv = makeDiv(item.thumbnail_public_url || item.public_url || item.thumbnail, item.id, item.type, item.url);
                    	if (item.type == 'FOLDER') {
                            $('#content-folder').append(newDiv);
                        } else {
                            $('#myMedia').append(newDiv);
                        }
					});

            		updateModalEvent();
                    selectInputsMedia();
                    $("#deleteMediaFileBtn").hide();
            		//updateViewDivs();
                } 
                else if (response.success == 'N') {
                    modalMsgShow(response.error);
                } 
                else {
                    console.log('Respuesta: %o', response);
                }

                // Si solo se quiere permitir un elemento seleccionado.
        		//selectedImage();

                // Generate the breadcrumb
                const $breadcrumb = $('.breadcrumb');
                $breadcrumb.empty();
                currentFolder.forEach(function(item, index) {
                    if (index === currentFolder.length - 1) {
                        if (item == 'MAIN') {
                            $breadcrumb.append('<li> '+libraryMsg.home+' </li>');
                        } else {
                            $breadcrumb.append('<li> ' + folderNames.get(item) + ' </li>');
                        }
                    } else {
                        if (item == 'MAIN') {
                            $breadcrumb.append('<li> <a onclick="openFolder('+"'MAIN'"+'); return false;" href="#"> Inicio </a> </li>');
                        } else {
                            $breadcrumb.append("<li> <a onclick='openFolder(" + item + "); return false;' href='#'> " + folderNames.get(item) + "</a> </li>");
                        }
                    }
                });
            },
            error: function(request, error) {
                console.log(error);
                console.log(request);
                modalMsgShow(JSON.stringify(error));
            }
        });
    }
</script>
