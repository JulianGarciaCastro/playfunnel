<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/Style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>{{__('step2.title')}}</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
    </head>
	<body class="bg-white">

		@include('nav_bar_project')
		
        <!-------------------------------------MAIN------------------------------------------>
        <div class="container-fluid m-0 p-0 vh-100 ">
        	{{ csrf_field() }}
        	<input type="hidden" name="projectId" 		id="projectId" 		value="{{$project->id}}">
        	<input type="hidden" name="libraryId" 		id="libraryId" 		value="">
        	<input type="hidden" name="projectlibid" 	id="projectlibid" 	value="">
        	<section class="step123 stepProgress row col-12  mx-0 p-0 w-100">
                <!-----------------------------------------------------------------------------------Left Menu-->
                <div class="sideNavWork col d-flex align-items-center justify-content-center bg-05" id="navbarNavWork" >
                    <div class="openSideNavWork navbar-toggler d-lg-none d-flex mr-2" type="button" data-toggle="collapse" data-target="#navbarNavWork" aria-controls="navbarNavWork" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fas fa-arrow-circle-right mr-2"></i><i class="fas fa-photo-video"></i></div>
                    <ul id="mediaList" class="navbar-nav p-0 ">
                    @foreach ($projectLibs as $projectLib)
        			  <li id="list-{{$projectLib->id}}" name="{{$projectLib->id }}" position="{{$projectLib->position }}" class="nav-item" media-id="{{ $projectLib->libraryid }}" proyectlib-id="{{ $projectLib->id }}">
                        <a class=" widgetVideo nav-link c03  text-md-left p-0 m-0" >
                          <img class="p-0 m-0" src="{{$projectLib->library->thumbnail }}" onclick="setMainMedia(this)" libraryid="{{ $projectLib->library->id }}" libraryurl="{{ $projectLib->library->url }}" projectlib="{{ $projectLib->id }}" />
    					  <i class="d-none c07">â—„</i>
                        </a>
                      </li>
                    @endforeach
                    </ul>
                </div>

            <!-------------------------------------MAIN------------------------------------------>
            <div class="mainContainer col row p-0 m-0">
                <div class="main col m-4">
                    <!--------------------------------------------------------Steps-->
                   	<div class="steps m-0 p-0 row">
                   		<div class="progressbar-wrapper col-md-9 col-12">
                    		<div class="progressbar-wrapper progressbar-wrapper text-center "> {{$project->name}} </div>
                          	<ul class="progressbar p-0 row mt-4 mt-md-1">
                              	<li class="active col-3" onclick="window.location.href='addVideo?project={{ $project->id }}';">{{__('step2.add_video')}}</li>
                              	<li class="active col-3" onclick="window.location.href='cuePoints?project={{ $project->id }}';">{{__('step2.create_cuepoints')}}</li>
                              	<li class=" col-3" onclick="window.location.href='actions?project={{ $project->id }}';">{{__('step2.cuepoint_actions')}}</li>
                              	<li class="col-3" onclick="window.location.href='publish?project={{ $project->id }}';">{{__('step2.publish')}}</li>
                          	</ul>
						</div>
                   </div>
                   <!--------------------------------------------------Main Video-->
                   <div class="row justify-content-center blockAdd">
                     <div class="addVideoMain p-0 m-0 {{ $project->aspect }}">
                        <a class="playVideoEmbed"><img src="images/SVG/Play.svg"></a>
                      <div id="play"  class="play w-100">
                        <div id="videoContainer">
                            <video id="projectVideo" name="projectVideo" poster="" media-id="" lib-id="" class="col-12"  preload="auto">
        			            <source src="" type="video/mp4" media-id="" class="col-12"/>
        					</video>
                            <div id="containerFather">
                                <div id="progressContainer">
                                    <div id="markers-container"></div>
                                    <div id="progress"></div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                   </div>
                </div>
                <!---------------------------------------------------Right Menu-->
                <div class="col-12 col-lg-4 bg-white p-0 m-0 rightMenu  setup2 mt-md-0 mt-5">
                    <div class="titulo py-3 bg-01 px-0">
                        <h5 class="h5 text-center col-12 p-0 cWhite">{{__('step2.cuepoint_time')}}</h5>
                    </div>
                    <div class="p-3 p-lg-4">
                      <h6>{{__('step2.cuepoint_list')}}</h6>
                      <div class="d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 pr-2 py-2">
                        <p id="currentTime" name="currentTime" class="col text-center h5 font-weight-bold cMain m-0 p-0">00:00:00</p>
                        <button class="col-2 btn-round m-0 p-0" onclick="addCuepoint()"><i class="h4 cMain fas fa-plus-square d-flex align-items-center my-0"></i></button>
                      </div>
                      <div id="cuepointList" name="cuepointList" class="arraysCue col-12 p-0 mt-2 m-0">

                      </div>
                    </div>
                    <div class="col-12 next d-flex justify-content-center">
                    	<button class="btn-square bg-Main cWhite px-3" onclick="window.location.href='actions?project={{ $project->id }}';">
                      		<i class="fas fa-caret-square-right mr-2"></i>{{__('step2.continue')}}
                      	</button>
                    </div>
                </div>
            </div>
          </section>
		</div>

		<x-messages/>
		
		<!--- Modal Edit CueTime --->
        <div class="modal fade bd-example-modal-sm" id="EditCueTime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
            	<div class="col-12">
            	  <div class="col-12 row justify-content-end p-0 m-0 pt-3">
            		<button data-dismiss="modal" aria-label="Close"  type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
            		  <span class="material-icons d-flex justify-content-center">clear</span>
            		</button>
            	  </div>
            	  <p class="text-h3 cMain text-center mt-3" id="modalTitle">{{__('step2.edit_cuepoint')}}</p>
            	  <p class="text-center pb-2 c02 mb-4"  id="modalContent">{{__('step2.edit_description')}}</p>
            	  <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
  					<input id="timeSlider" type="range" min="1" max="100" value="1" step="0.1" class="slider w-100" id="myRange">
  					<div class="range-tooltip" id="rangeTooltip">00:00:00</div>
				  </div>
            	  <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
            		  <button type="button" class="btn-square px-3 bg-Main cWhite" id="okBTN" onclick="editCuepointBtn()">{{__('step2.aceptar')}}</button>
            		  <button type="button" class="btn-square px-3 bg-05 cMain ml-5" id="cancelBTN"  data-dismiss="modal" >{{__('step2.cancelar')}}</button>
            	  </div>
            	</div>
              </div>
            </div>
        </div>
 	
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 		integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" 	crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript">

    	$( document ).ready(function() {
    
    		//Funcion para resaltar el video seleccionado en edicion de proyecto pasos 1, 2, 3
        	$("#mediaList").on("click", "li", function (event) {
    			$(this).siblings().find("a").removeClass("active");
    			$(this).find("a").addClass("active");
                document.querySelector(".playVideoEmbed").classList.remove('pp');
                videoPlay= false;
    		});
    
    		$(".addVideoMain").css("opacity","1");

    	  	//if( ($("#mediaList").has("li").length > 0) ) {
        	//	$("#mediaList").find("li").first().click();
    	    //	let img = $("#mediaList").find("li").first().find("img");
    	    //	setMainMedia(img);
    		//	resizeAddmedia();
    	    //}
    	    
    	    console.log( "step2 document ready!" );
     	});


        function resizeAddmedia() {
            $(".addVideoMain").parent().addClass("desktop");
            if ($(".addVideoMain").parent().hasClass("desktop")) {
                //console.log("tiene Desktop");
                var ds = $(".addVideoMain").parent().css("width").slice(0, -2);
                var ds1 = ds / 1.777;
                $(".addVideoMain").parent().css("height", ds1 + "px");
            }

            //16-9
            if ($(".addVideoMain").hasClass("d-main")) {
                if ($(".addVideoMain").parent().hasClass("desktop")) {
                    $(".d-main").css("width", "100%");
                    //console.log("clase d-main-desktop");
                    var qs = $(".d-main").css("width").slice(0, -2);
                    var qs1 = qs / 1.777;
                    $(".d-main").css("height", qs1 + "px");
                    $(".d-main").css("opacity", "1");
                }
            }

            //9-16
            if ($(".addVideoMain").hasClass("d-mobile")) {
                if ($(".addVideoMain").parent().hasClass("desktop")) {
                    $(".d-mobile").css("height", "100%");
                    var ms = $(".d-mobile").css("height").slice(0, -2);
                    var ms1 = ms / 1.777;
                    $(".d-mobile").css("width", ms1 + "px");
                    $(".d-mobile").css("opacity", "1");
                }
            }

            //1-1
            if ($(".addVideoMain").hasClass("d-square")) {
                if ($(".addVideoMain").parent().hasClass("desktop")) {
                    $(".d-square").css("height", "100%");
                    //console.log("clase square-desktop");
                    var qs = $(".d-square").css("height").slice(0, -2);
                    //console.log("w="+qs);
                    var qs1 = qs;
                    $(".d-square").css("width", qs1 + "px");
                    $(".d-square").css("opacity", "1");
                }
            }

        }


        $(window).resize(function() {
            resizeAddmedia();
        });


        //devuelve CurrentTime  en valor .3
        function matchRounded(number) {
            let rounded = Math.floor(number * 10 / 3) * 3 / 10;
            rounded = new Date(rounded * 1000).toISOString().substr(11, 10);
            return rounded;
        }


        // Vars
        let video = '';
        let setMarker = false;
        var mediaId
        var projectlibid

        // Carga media
        function setMainMedia(img) {
        	console.log('setMainMedia() img: ' + $(img).attr("libraryid"));
        	           
            mediaId = $(img).attr("libraryid");
            var mediaSrc = $(img).attr("libraryurl");
            var mediaImg = $(img).attr("src");
            projectlibid = $(img).attr("projectlib");

            var currentLib = $("#projectVideo").attr("lib-id");

            if (currentLib == projectlibid)
                return;

            $("#projectlibid").val(projectlibid);

            var url = '{{ route('stream', ':id') }}';
            url = url.replace(':id', mediaId);

            const videoOn = document.getElementById('projectVideo');
            videoOn.setAttribute('poster', mediaImg);
            videoOn.setAttribute('media-id', mediaId);
            videoOn.setAttribute('lib-id', projectlibid);
            videoOn.src = url;
            $('#currentTime').text("00:00:00:0");
            //console.log('nuevo video');

            // Elimino markers olds
            document.getElementById('markers-container').innerHTML = '';
            const markers = document.querySelectorAll('.marker');
            console.log("Marcas:  %o", markers);

            markers.forEach((marker) => {
                marker.remove();
            });
            console.log('elimino old markers')


            // Escucho el time del video
            videoOn.ontimeupdate = function() {
                let number = videoOn.currentTime;
                let roundedCurrentTime = matchRounded(number);
                //Display
                onTrackedVideoFrame(roundedCurrentTime, this.duration);
            };           
            listCuepoint(mediaId, projectlibid);           
           

        }


        const startMarker = ( duration,response) => {

            //console.log('entro a markers2');
            //console.log(response);
            //console.log(duration);
            const video = document.getElementById("projectVideo");
            const progressContainer = document.getElementById("markers-container");
            const progress = document.getElementById("progress");

            for (const i of response.cuepoints) {

                let id = i.id;
                let time = i.time;
                //console.log(id+'/'+time);

                // Creo div marker
                const marker = document.createElement("div");
                marker.classList.add("marker");
                const position = (time / duration) * 100;
                marker.style.left = position + '%';

                // Creo evento click
                marker.addEventListener("click", function(event) {
                    event
                .stopPropagation(); // Prevenir interferencias al hacer clic en el contenedor de progreso
                    video.currentTime = time;
                    //video.play();
                });
                marker.setAttribute('title', id);
                progressContainer.appendChild(marker);
            }

            setMarker = false;
            //console.log(setMarker);
            // Bloqueo lista de media
            //document.getElementById('mediaList').style.pointerEvents = 'auto';

            /*cuepointList_.forEach((item,index) => {

            })*/
    	}

        // Espero a que cargue los meta del video
        const videoDuration = (response) => {

            
            const video_ = document.getElementById("projectVideo");
            const duration_ = 0;

            duration = new Promise((resolve, reject) => {
                // Comprobamos si los metadatos ya estÃ¡n cargados

                if (video_.readyState >= 1) {
                    resolve(video_.duration);                    

                } else {
                    // Agregamos un event listener para cuando los metadatos estÃ©n cargados
                    video_.addEventListener('loadedmetadata', function() {
                        resolve(video_.duration);
                    });

                    // Agregamos un event listener para manejar errores
                    video_.addEventListener('error', function() {
                        reject('Error al cargar el video.');
                    });
                }
            });
            duration.then(result => {
                //console.log(result); // Esto imprimirÃ¡: 19.886533
                startMarker(result, response)
            });
        }

        function removeMarker(id) {
            const markers = document.querySelectorAll('.marker');
            markers.forEach(marker => {
                if (marker.title == id) {
                    marker.remove();
                }
            });
        }


        let videoPlay = false;

        //Call BD and list cuepoints de media
        function listCuepoint(mediaId, projectlibid) {

            // Bloqueo lista de media
            //document.getElementById('mediaList').style.pointerEvents = 'none';

            $("#libraryId").val(mediaId);
            $("#projectlibid").val(projectlibid);

            var form = new FormData();
            form.append('_token', $("input[name=_token]").val());
            form.append('projectid', $("input[name=projectId]").val());
            form.append('projectlibid', projectlibid);
            form.append('libraryid', mediaId);


            $.ajax({
                url: '/ajax-getCuepointList',
                type: 'POST',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    //console.log("Call-DB");
                    if (response.success == 'Y') {
                        $("#cuepointList").empty();
                        if (!response.cuepoints.length)
                            return;

                        $.each(response.cuepoints, function(i, item) {
                            var cuePoint = '<div onclick="selectCuePointStep2(this)" id="cuepoint-' +
                                item.id + '" name="cuepoint-' + item.id + '" cuepoint-id="' + item.id +
                                '" time="' + item.time +
                                '" class="d-flex array_item col-12 p-0 align-items-center px-0 mt-3 justify-content-between p-0 pr-2">' +
                                '<div class="col-8 p-0">' + matchRounded(item.time) + '</div>' +
                                '<div class="col d-flex justify-content-end p-0 m-0 gap-2">' +
                                	'<button class="btn-round bg-Main cWhite p-0 ms-*" onclick="editCuepoint(' +item.id + ')"> <span class="fs-4">⋯</span></button> '+
                                	'<button class="btn-round bg-Main cWhite p-0 m-0" onclick="delCuepoint(' +item.id + ')"><i class="fas fa-minus"></i></button>' +
                                '</div>' +
                                '</div><hr class="col-10 my-1">';

                            $("#cuepointList").append(cuePoint);
                        });
                        videoDuration(response);
                    }
                },
                error: function(request, error) {
                    console.log(error);
                    console.log(request);                  
                    modalMsgShow(JSON.stringify(request));
                }
            });
            marks_();
        }



        // Play amd Pause
        function playAndPause() {
            video = document.getElementById("projectVideo");
            //console.log('entro a play');
            //console.log(video);
            document.querySelector(".playVideoEmbed").addEventListener("click", () => {
                //console.log('play');
                if (!videoPlay) {
                    video.play();
                    document.querySelector(".playVideoEmbed").classList.add('pp');
                } else {
                    video.pause();
                    document.querySelector(".playVideoEmbed").classList.remove('pp');
                }
                videoPlay = !videoPlay;
            }, false);
        };




        // Adiciona nuevo cue
        function addCuepoint() {
            //Set Video Current
            const vid = document.getElementById("projectVideo");
            let nativeCurrentTime = vid.currentTime; //To copy on DB
            let currentTime = matchRounded(nativeCurrentTime);


            if (!currentTime)
                return;

            //currentTime = parseInt(currentTime);
            //currentTime = currentTime.toFixed(2);


            var addContinue = true;
            $("#cuepointList").children("div").each(function() {
                var $currentElement = $(this);
                var auxTime = $currentElement.attr("time");
                var timeTo = currentTime;

                if (timeTo == matchRounded(auxTime)) {
                    //console.log("ENCONTRADO: " + auxTime);
                    addContinue = false;
                }
            });


            if (!addContinue) {               
                modalMsgShow("Ya existe un cuepoint en: " + currentTime);
                return;
            }

            var form = new FormData();
            form.append('_token', $("input[name=_token]").val());
            form.append('libraryid', $("input[name=libraryId]").val());
            form.append('projectid', $("input[name=projectId]").val());
            form.append('projectlibid', $("input[name=projectlibid]").val());
            form.append('time', nativeCurrentTime);
            form.append('position', 0);

            //console.log("Formulario: "+ $("input[name=projectlibid]").val());

            $.ajax({
                url: '/ajax-addCuepoint',
                type: 'POST',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.success == 'Y') {
                        let img = $("#mediaList").find("li").first().find("img");
                        var mediaId = $("input[name=libraryId]").val();
                        var projectlibid = $("input[name=projectlibid]").val();
                        listCuepoint(mediaId, projectlibid);
                      
                    }
                },
                error: function(request, error) {
                    console.log(error);
                    console.log(request);                   
                    modalMsgShow("Error: " + JSON.stringify(request));
                }

            });
        }

        //Borra
        function delCuepoint(id) {
            removeMarker(id)
            var form = new FormData();
            form.append('_token', $("input[name=_token]").val());
            form.append('id', id);

            $.ajax({
                url: '/ajax-delCuepoint',
                type: 'POST',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success == 'Y') {

                        var name = "#cuepoint-" + id;
                        $(name).next().remove();
                        $(name).remove();

                    } else {
                       
                        modalMsgShow(response.message);
                        var name = "#cuepoint-" + id;
                        $(name).next().remove();
                        $(name).remove();
                    }
                },
                error: function(request, error) {
                    console.log(error);
                    console.log(request);                   
                    modalMsgShow("Error: " + JSON.stringify(request));
                }
            });

        }

        //Actualizador de tiempo
        function onTrackedVideoFrame(roundedCurrentTime, duration) {
            $('#currentTime').text(roundedCurrentTime);
        }

        //Va al tiempo en el video
        function selectCuePointStep2(button) {
            var hms = $(button).attr('time');
            var vid = document.getElementById("projectVideo");
            vid.currentTime = hms;
        };


        function modalMsgClose() {
            $('#msgModal').modal('hide');
        }


        function modalMsgShow(texto) {
            $("#modalMsgContent").text(texto);
            $("#msgOK").attr("onClick", "modalMsgClose()");
            $('#msgModal').modal('show');
        }

        /*------------------new */
        let markers = [];
        const marks_ = () => {
            //console.log('entro a mark');
            const video = document.getElementById("projectVideo");
            const progressContainer = document.getElementById("progressContainer");
            const progress = document.getElementById("progress");

            video.addEventListener('ended', function() {
                video.currentTime = 0;
                video.pause();
                document.querySelector(".playVideoEmbed").classList.remove('pp');
                videoPlay = !videoPlay;
            });    

            video.addEventListener("loadedmetadata", function() {
                markers.forEach(markerData => addMarker(markerData.time, markerData.title));
            });

            video.addEventListener('timeupdate', function() {
                const percentage = (video.currentTime / video.duration) * 100;
                progress.style.width = `${percentage}%`;
            });
 


            let isDragging = false;

            progressContainer.addEventListener('mousedown', function(event) {
                isDragging = true;
                updateProgress(event);
            });

            document.addEventListener('mouseup', function() {
                isDragging = false;
            });

            document.addEventListener('mousemove', function(event) {
                if (isDragging) {
                    updateProgress(event);
                }
            });

            function updateProgress(event) {
                const rect = progressContainer.getBoundingClientRect();
                const offsetX = event.clientX - rect.left;
                const positionPercentage = offsetX / rect.width;
                const newTime = positionPercentage * video.duration;

                video.currentTime = newTime;
            }

        }


        var duration;
        $(document).ready(function() {
            $(".addVideoMain").css("opacity", "1");
            
            /* DELETE THIS PART AFTER TESTING
            if (($("#mediaList").has("li").length > 0)) {
                $("#mediaList").find("li").first().click();
                let img = $("#mediaList").find("li").first().find("img");  
            }
            */
           
            // Definimos cual es el video seleccionado y lo marcamos
            var pos =  1; // Asigno por defecto el primer video
            console.log("defino pos="+pos);

            // Veo si ya esta asignada la variable local de video-set sino asigno el valor 1
            if (localStorage.getItem('video-set') == null || localStorage.getItem('video-set') == 'undefined') {
                console.log("No existe localStorage");
                localStorage.setItem('video-set', '1'); 
                console.log("Asigno local"+localStorage.getItem('video-set'));
            }

            // Asigno el valor de la variable local a la variable pos
            pos =  localStorage.getItem('video-set'); 

            // Busco el video seleccionado y lo marco como activo y lo llamo para que se ejecute
            $('#mediaList li a').removeClass('active');
            $('#mediaList li a').removeClass('active');
            if($('#mediaList li[position="' + pos + '"]')){
                // console.log("Existe pos"+pos);
                $('#mediaList li[position="' + pos + '"] a').addClass('active');
                setMainMedia( $('#mediaList li[position="' + pos + '"] img')); 
            }else{
                // console.log("No existe pos");
                $('#mediaList li[position="' + 1 + '"] a').addClass('active');
                setMainMedia( $('#mediaList li[position="' + 1 + '"] img')); 
            }           
            resizeAddmedia();          

            // Click en la lista de videos y cambio la variable local video-set y lo marco como activo
            $("#mediaList").on("click", "li", function (event) {
                $(this).siblings().find("a").removeClass("active");
                $(this).find("a").addClass("active");
                localStorage.setItem('video-set', $(this).attr("position"));
		    });


            const video = $('#projectVideo').get(0); // Get raw DOM element
    	    video.onloadedmetadata = function() {
    	      duration = video.duration; // Duration in seconds
    	      console.log('Video duration:', duration);
    	      $('#timeSlider').attr('max', duration-0.5);
    	    };
	    
    	    //updateTooltip();
    	    $('#timeSlider').on('input', updateTooltip);
    	    
            console.log("step2 document ready!");

        });


        playAndPause();


        function updateTooltip() {
            const $range = $('#timeSlider');
            const $tooltip = $('#rangeTooltip');
            const val = parseFloat($range.val());
            const min = parseFloat($range.attr('min'));
            const max = parseFloat($range.attr('max'));
            const percent = (val - min) / (max - min);
            const offset = percent * $range.width();
            
            $tooltip.text(matchRounded(val));
            $tooltip.css('left', offset + 'px');

            if ($tooltip.css('display') === 'none') {
        	  $tooltip.show();
        	}
            
          }

        var cuepointID;
        function editCuepoint(id){
        	console.log("editCuepoint() id: " + id);
        	cuepointID=id;
        	
        	var name = "#cuepoint-" + id;
			var time = $(name).attr('time'); 
        	$('#timeSlider').val(time);
        	$('#EditCueTime').modal('show');

        	setTimeout(function() {
    		  updateTooltip();
    		}, 500);
        	
       }

        function editCuepointBtn(){
        	console.log("editCuepointBtn() id: ");

        	var newTime = $('#timeSlider').val();
        	console.log("editCuepointBtn() New Time: " + newTime);

        	var addContinue = true;
            $("#cuepointList").children("div").each(function() {
                var $currentElement = $(this);
                var auxTime = $currentElement.attr("time");
                var timeTo = matchRounded(newTime);

                if (timeTo == matchRounded(auxTime)) {
                    //console.log("ENCONTRADO: " + auxTime);
                    addContinue = false;
                }
            });

            if (!addContinue) {            
                modalMsgShow("Ya existe un cuepoint en: " + matchRounded(newTime));
                $('#EditCueTime').modal('hide');
                return;
            }


            var form = new FormData();
            form.append('_token', $("input[name=_token]").val());
            form.append('id', cuepointID);
            form.append('time', newTime);

            $.ajax({
                url: '/ajax-updCuepoint',
                type: 'POST',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success == 'Y') {

                    	var name = "#cuepoint-" + cuepointID;
            			var cuepoint = $(name);
            			cuepoint.attr("time", newTime);
            			cuepoint.children('div').first().text(matchRounded(newTime));
                    	$('#EditCueTime').modal('hide');

                    	
                        const markers = document.querySelectorAll('.marker');
                        markers.forEach((marker) => {
                            marker.remove();
                        });

                    	
                    	listCuepoint(mediaId, projectlibid);

                    } 
                    else {                   
                    	$('#EditCueTime').modal('hide');
                        modalMsgShow(response.message);
                    }
                },
                error: function(request, error) {
                    console.log(error);
                    console.log(request);                   
                    modalMsgShow("Error: " + JSON.stringify(request));
                }
            });
	
       }
        
    </script>
	<style>

    
      .range-tooltip {
        position: absolute;
        top: -30px;
        background: #333;
        color: #fff;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 14px;
        white-space: nowrap;
        transform: translateX(-50%);
        display: none;
      }
    
    </style>

  </body>

</html>
