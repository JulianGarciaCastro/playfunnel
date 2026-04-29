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
</style>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="{{ url('/translations/library.js') }}"></script>

<script type="text/javascript">
    //var currentTab = "VIDEO";
    var currentFolder = [];
    const folderNames = new Map();


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

        if (type == 'FOLDER') {
            newMedia = $('<span class="material-icons"></span>');
        } else {
            newMedia = $('<img class="img-fluid w-100 h-100" />');
        }

        newMedia.attr('media-src', media);
        newMedia.attr('media-id', id);
        newMedia.attr('media-type', type);

        // Uri de la imagen o video
        let nameSpace = media.split("/");
        newMedia.attr('media-name', nameSpace[nameSpace.length - 1]);

        var playMedia = "";
        
        if (type.startsWith("video/")) {
            newMedia.attr('src', url);
            media = "'" + media + "'";
            playMedia = 'ontouchstart="doubleTouchFunction(\'video\', ' + media + ')" ondblclick="playVideo(' + media + ')"';
        }
        if (type.startsWith("image/")) {
            newMedia.attr('src', media);
            media = "'" + media + "'";
            playMedia = 'ontouchstart="doubleTouchFunction(\'image\', ' + media + ')" ondblclick="playImage(' + media + ')"';
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
        }

        return newDiv;
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


    function playVideo(media) {
        console.log("playVideo() Media: " + media);

        $('source', $('#playVideo')).attr('src', media);
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
                //alert("Error: "+JSON.stringify(error));
                modalMsgShow(JSON.stringify(error));
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
                    	newDiv = makeDiv(item.thumbnail, item.id, item.type, item.url);
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
