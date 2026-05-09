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
        <title>{{__('add-video.title')}}</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
	</head>
	<body class="bg-white">	
		
		@include('nav_bar_project')

		<x-manage-library :library="$library" :user="$user"/>
		<x-messages/>
      

        <!--- Modal Desvincular Media de Proyecto --->
        <div class="modal fade bd-example-modal-sm" id="deleteProjectLibModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="col-12">
                <div class="col-12 row justify-content-end p-0 m-0 pt-3">
                  <button data-dismiss="modal" aria-label="Close"  type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
                    <span class="material-icons d-flex justify-content-center">clear</span>
                  </button>
                </div>
                <p class="text-h3 cMain text-center mt-3">{{__('add-video.delete_media')}}</p>
                <p class="text-center pb-2 c02">{{__('add-video.are_you_sure_unlink_media_from_project')}}</p>
                <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                	<button type="button" class="btn-square px-3 bg-Main cWhite" onclick="deleteProjectLibModalBtn()">{{__('add-video.confirm')}}</button>
                	<button type="button" class="btn-square px-3 bg-05 cMain ml-5"  data-dismiss="modal" >{{__('add-video.discard')}}</button>
                </div>
              </div>
            </div>
          </div>
        </div>

    	
              
       
    <!-------------------------------------MAIN------------------------------------------>
    <div class="container-fluid m-0 p-0 vh-100 ">

         <section class="step123 row col-12  mx-0 p-0 w-100">
            <div class="sideNavWork col d-flex align-items-center justify-content-center bg-05" id="navbarNavWork" >
                    <div class="openSideNavWork navbar-toggler d-lg-none d-flex mr-2" type="button" data-toggle="collapse" data-target="#navbarNavWork" aria-controls="navbarNavWork" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fas fa-arrow-circle-right mr-2"></i><i class="fas fa-photo-video"></i></div>
                    <ul class="navbar-nav p-0 ">
                    	<li class="nav-item">
                        	<a class=" widgetVideo nav-link c03  text-md-left p-0 m-0" href="#" data-toggle="modal" data-target=".bd-example-modal-lg">
                        		<img class="p-0 m-0" src="images/SVG/Btn-Add-Video.svg"/>
                        		<i class="fas fa-plus-circle"></i>
                        	</a>
                      	</li>
                    </ul>
                    <ul id="mediaList" name="mediaList" class="navbar-nav p-0 ">
                    @foreach ($projectLibs as $projectLib)
        			  <li id="list-{{$projectLib->id}}" name="{{$projectLib->id }}" position="{{$projectLib->position }}" class="nav-item" media-id="{{ $projectLib->libraryid }}" proyectlib-id="{{ $projectLib->id }}">

						<a class=" widgetVideo nav-link c03  text-md-left p-0 m-0" >
                          <img class="p-0 m-0" src="{{ $projectLib->library->thumbnail_public_url }}" onclick="setMainMedia(this)" libraryid="{{ $projectLib->library->id }}" libraryurl="{{ $projectLib->library->url }}" projectlib="{{ $projectLib->id }}" />
						  <i class="d-none c07">◄</i>
                        </a>
                        <button class="deleter" id="{{$projectLib->id}}" name="{{ $projectLib->id}}" onclick="deleteProjectLib('{{ $projectLib->id }}')" ><i class="fas fa-trash"></i></button>
                        <button class="deleter" id="{{$projectLib->id}}" name="{{ $projectLib->id}}" onclick="changeProjectLib('{{ $projectLib->id }}')" ><i class="fas fa-sync-alt"></i></button>
                      </li>
                    @endforeach
                    </ul>
            </div>
            <div class="mainContainer col row p-0 m-0">
                <div class="main w-100 m-4">
                    <div class="steps m-0 p-0 row">
    				  <div class="progressbar-wrapper col-md-9 col-12">
    				  <div class="progressbar-wrapper progressbar-wrapper text-center "> {{$project->name}} </div>
    				    <ul class="progressbar p-0 row mt-4 mt-md-1">
    					  <li class="active col-3" onclick="window.location.href='addVideo?project={{ $project->id }}';">{{__('add-video.add_video')}}</li>
    					  <li class=" col-3" onclick="window.location.href='cuePoints?project={{ $project->id }}';">{{__('add-video.create_cuepoints')}} </li>
    					  <li class=" col-3" onclick="window.location.href='actions?project={{ $project->id }}';">{{__('add-video.cuepoint_actions')}} </li>
    					  <li class="col-3" onclick="window.location.href='publish?project={{ $project->id }}';">{{__('add-video.publish')}}</li>
    				    </ul>
    			      </div>
    				</div>
					<div class="aspect mt-3">
						<ul>
							<li data-id="d-main"><div class="device1 <?php if($project->aspect=="d-main")echo "active" ?>"></div>{{__('add-video.horizontal')}}</li>
							<li data-id="d-square"><div class="device2 <?php if($project->aspect=="d-square")echo "active" ?>"></div>{{__('add-video.square')}}</li>
							<li data-id="d-mobile"><div class="device3 <?php if($project->aspect=="d-mobile")echo "active" ?>"></div>{{__('add-video.vertical')}}</li>
						</ul>
						<input id="aspect" type="hidden" name="aspect" value="{{ $project->aspect ?: 'd-main' }}" >
						<input type="hidden" name="projectId" 	 id="projectId" value="{{$project->id}}">
                    </div>
                    <div class="row justify-content-center blockAdd">
                      <div class="addVideoMain {{ $project->aspect }} p-0 m-0">
                        <a class="playVideoEmbed" ><img src="images/SVG/Play.svg"></a>
                        <div id="play" name="play" class="play w-100">
                          <i class="fas fa-play-circle"></i>
                          {{__('add-video.add_video')}}
                        </div>
                      </div>
                    </div>

                </div>
            </div>
			 <!---------------------------------------------------Right Menu-->
			 <div class="col-12 col-lg-4 bg-white p-0 m-0 rightMenu rightMenu setup2 mt-md-0 mt-5">
                    <div class="titulo py-3 bg-01 px-0">
                        <h5 class="h5 text-center col-12 p-0 cWhite">{{__('add-video.add_video')}}</h5>
                    </div>
					<div class="p-3 p-lg-4 mb-4">
						<h6 class="mb-0">{{__('add-video.video_info')}}</h6>
						<hr class="m-0 my-2">
						<div class="pt-3 px-0 fieldDes">
							<label for="videoName"  class="w-100 p-0 m-0" >{{__('add-video.name')}}</label>
							<input id="mediaName" name ="mediaName" class="w-100 py-2 px-3 m-0" placeholder="{{__('add-video.video_name')}}" type="text" name="videoName" onfocusout="updateData()" maxlength="45">
						</div>
						<div class="pt-3 px-0 fieldDes">
							<label for="videoDescription"  class="w-100 p-0 m-0" >{{__('add-video.description')}}</label>
							<input id="mediaDesc" name ="mediaDesc" class="w-100 py-2 px-3 m-0" placeholder="{{__('add-video.video_description')}}" type="text" name="videoDescription" onfocusout="updateData()" maxlength="250">
						</div>

					  </div>

                    <div class="col-12 next d-flex justify-content-center">
                    	<button class="btn-square bg-Main cWhite px-3" onclick="window.location.href='cuePoints?project={{ $project->id }}';">
                      		<i class="fas fa-caret-square-right mr-2"></i>{{__('add-video.continue')}}
                      	</button>
                    </div>
                </div>
         </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 		integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
	<script src="js/Sortable.js"></script>

    <style>
        .nav-item.over {
            border: 3px dotted #666;
        }
        
        .playVideoEmbed{
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

    <script type="text/javascript">

    	var projectLibrary = [];
    	let videoPlay = false;
    	var video
      	$(document).ready(function(){

      		//Funcion para resaltar el video seleccionado en edicion de proyecto pasos 1, 2, 3
        	$("#mediaList").on("click", "li", function (event) {
    			$(this).siblings().find("a").removeClass("active");
    			$(this).find("a").addClass("active");

    			document.querySelector(".playVideoEmbed").classList.remove('pp');
                videoPlay= false;
    		});

        	projectLibrary = @json($projectLibs);

        	$.each(projectLibrary, function(i, item) {
        		item.action = "READY";
            });

// conflito HEAD
			hold_video();

        	console.log("TODOS LOS PROJECT LIBS: %o",  projectLibrary);  
			console.log("step1 document ready!");  

			$('.closeM').on('click', function () {
	        	$('#libraryModal').modal('hide');
	            changeLibrary = false;
	        });
      	
      	});

		// Mantener el video seleccionado
		const hold_video = (sorting = false)=>{
			// Definimos cual es el video seleccionado y lo marcamos
			var pos =  1; // Asigno por defecto el primer video

			if(localStorage.getItem('video-set') == null){
				localStorage.setItem('video-set', '1');
			}		


			if(!sorting){
				//console.log("No es un ordenamiento de la lista de videos");
				// Veo si ya esta asignada la variable local de video-set sino asigno el valor 1
				if (localStorage.getItem('video-set') == null) {
					localStorage.setItem('video-set', '1'); 
				}

				// Asigno el valor de la variable local a la variable pos
				pos =  localStorage.getItem('video-set'); 

				// Busco el video seleccionado y lo marco como activo y lo llamo para que se ejecute
				$('#mediaList li a').removeClass('active');
				$('#mediaList li[position="' + pos + '"] a').addClass('active');
				setMainMedia( $('#mediaList li[position="' + pos + '"] img'));

				// Click en la lista de videos y cambio la variable local video-set y lo marco como activo
				$("#mediaList").on("click", "li", function (event) {
					$(this).siblings().find("a").removeClass("active");
					$(this).find("a").addClass("active");
					localStorage.setItem('video-set', $(this).attr("position"));
				});
			}else{
				// Si es un ordenamiento de la lista de videos
				// Busco el video seleccionado y lo marco como activo y lo llamo para que se ejecute				
				var newpos = $('#mediaList li a.active');				
				localStorage.setItem('video-set', newpos.parent().attr("position"));
				
				
			}
			
		}

/* DEV-BBLTC-02 =conflito=
        	if( ($("#mediaList").has("li").length > 0) ) {
        		$("#mediaList").find("li").first().click();
    	    	var img = $("#mediaList").find("li").first().find("img");
    	    	setMainMedia(img);
    	    }
conflito DEV-BBLTC-02

        	console.log( "step1 document ready!" );
      	});
*/

      	function existsChanges(){
			var continuar = false;
			$.each(projectLibrary, function(i, item) {
				if(item.action == 'UPDATE'){
					continuar= true;
					return;
				}
  			});

  			return continuar;
		}


        var changeLibrary=false;
        var projectLibID;
        
        function changeProjectLib(id) {
        	console.log("changeProjectLib() id to Change: "+ id);
        	$('#libraryModal').modal('show');
        	projectLibID = id;
        	changeLibrary=true;
        }

        function acceptChangeLibrary(mediaId, mediaSrc, mediaImg){
        	console.log('acceptChangeLibrary() new MediaID: ' + mediaId);

        	var listName = "list-" + projectLibID;
        	var oldMediaID =$('#'+listName).attr('media-id');

        	console.log('acceptChangeLibrary() old MediaID: ' + oldMediaID);
        	
        	if(oldMediaID == mediaId){
        		console.log('Mismo ID');
                modalMsgShow("Debe seleccionar un video diferente.");
				return true;
            }
        	
            var form = new FormData();
        	form.append('_token', $("input[name=_token]").val());
        	form.append('newlib', mediaId);
        	form.append('projectlib', projectLibID);
        
          	$.ajax({
        		url:  '/ajax-changeProjectLib',
            	type: 'POST',
            	data: form,
            	cache: false,
        		contentType: false,
        		processData: false,
        		dataType: 'json',
            	success: function(response){
              		if(response.success == 'Y') {
        
        				var projectLib = response.data;
              			var listName = "list-" + projectLib.id;
              			var position = $('#'+listName).attr('position');
        
        				var imagen = '<img class="p-0 m-0" src="'+mediaImg+'" onclick="setMainMedia( this )" libraryid="'+mediaId+'" libraryurl="'+mediaSrc+'" projectlib="'+projectLib.id+'" />';
                		var item = '<li id="'+listName+'" name="'+projectLib.id+'" position="'+position+'" class="nav-item" media-id="'+mediaId+'" projectlib-id="'+projectLib.id+'">'
                                 +   '<a class=" widgetVideo nav-link c03 text-md-left p-0 m-0 " >'
                                 + 	  imagen
                                 +	  '<i class="d-none c07">◄</i>'
                                 +   '</a>'
                                 +   '<button class="deleter" id="'+projectLib.id+'" projectlibid="'+projectLib.id+'" onclick="deleteProjectLib('+ projectLib.id +')" ><i class="fas fa-trash"></i></button>'
                                 +   '<button class="deleter" id="'+projectLib.id+'" projectlibid="'+projectLib.id+'" onclick="changeProjectLib('+ projectLib.id +')" ><i class="fas fa-sync-alt"></i></button>'
                                 + '</li>';
        
          				//$('#mediaList').append(item);
          				//$('li#itemA').replaceWith('<li id="itemA"><i class="fas fa-trash"></i> Nuevo contenido</li>');
          				$('#'+listName).replaceWith(item);
          				
        				// Pregunto si es el primer video si lo es lo cargo en el centro y lo selecciono
        				const vidosList = document.querySelectorAll('#mediaList li');
        				if(vidosList.length == 1){
        					setMainMedia(imagen);
        					vidosList[0].classList.add('active');
        					vidosList[0].querySelector('a').classList.add('active');
        					localStorage.setItem('video-set',vidosList[0].getAttribute('position'));							
        				}						
        
          				setMainMedia(imagen);
        				
          				console.log("Antes de actualizar ID: %o",  projectLibrary);
        				$.each(projectLibrary, function(i, item) {
							if(item.id == projectLibID){
								console.log("Encontrado: %o",  item);
								item.action = "UPDATE";
                    			item.libraryid=mediaId;
                    			return false;
							}
                        });
        				console.log("Despues de actualizar ID: %o",  projectLibrary);
        				
          				dragList();
          				updatePositions();
          				changeLibrary = false;
          				console.log('acceptChangeLibrary() ended OK  message: ' +response.message );
						
          				if(response.message != "")
	          				modalMsgShow(JSON.stringify(response.message));
          				//$('.modal-backdrop').remove();
          				//$("#libraryModal").hide();
          				console.log('acceptChangeLibrary() clickingOn: ' + '#'+listName+' img' );
          				//$('#'+listName+' img').trigger('click');
          				//$('#list-372 img').trigger('click');
              		}
              		else{
              			console.log('Errores : ' + response.message);
                        modalMsgShow(JSON.stringify(response.message));
                  	}
            	},
            	error: function(request, error){
        			console.log(error);
        			console.log(request);
        			//alert("Error: "+JSON.stringify(error));
        			console.log('acceptChangeLibrary() ended KO');
        			modalMsgShow(JSON.stringify(error));
        		}
        	});
        }

     // Cierra el modal de la libreria
        function closeModalLibrary() {
            $('#libraryModal').modal('hide');
            changeLibrary = false;
        }


      	function selectMedia(){
      		console.log("selectMedia()");
			var blnSelected = false;
			var imgSelected = false;
			var fldSelected = false;

			$('#libraryModal input[type=checkbox]').each(function () {
				
    			if(this.checked){
    				var name = $(this).attr("name");
    				console.log("Seleccionado: " + name)

    				var mediaType = $(this).parent().next().attr("media-type");

    				if(mediaType.startsWith("image/")){
						console.log("Ha seleccionado IMAGE, no se admite.");
						$(this).prop("checked", false);
						$(this).parent().removeClass("selected", false);
						imgSelected = true;
        				return true;
        			}

    				if(mediaType == "FOLDER"){
						console.log("Ha seleccionado FOLDER, no se admite.");
						$(this).prop("checked", false);
						$(this).parent().removeClass("selected", false);
						fldSelected = true;
        				return true;
        			}

    				var mediaId  = $(this).parent().next().attr("media-id");
    				var mediaSrc  = $(this).parent().next().attr("media-src");
    				var mediaImg  = $(this).parent().next().attr("src");
    				var mediaType = $(this).parent().next().attr("media-type");
    				console.log(" Id: " + mediaId + ", Media:" + mediaSrc + ", Img:" + mediaImg);

    				if(changeLibrary){
    					console.log("selectMedia() changeLibrary==true");
    					acceptChangeLibrary(mediaId, mediaSrc, mediaImg)
    				}
    				else{
    					console.log("selectMedia() changeLibrary==false");
    					createListMedia(mediaId, mediaSrc, mediaImg);
            		}
    				
    				
    				//setMainMedia(mediaId, mediaSrc, mediaImg)
    				blnSelected = true;
    				$(this).prop("checked", false);
    				$(this).parent().removeClass('selected');
    			}
    		});

    		if(blnSelected)
				$('#libraryModal').modal('hide');

			if(imgSelected)
				modalMsgShow("No se permite seleccionar Imagenes");
			if(fldSelected)
				modalMsgShow("No se permite seleccionar Carpetas");

			imgSelected = false;
			fldSelected = false;
			blnSelected = false;
			changeLibrary=false;
		}


		function setMainMedia(img){
			console.log("setMainMedia()... %o",  img);
			var mediaId  	 = $(img).attr("libraryid");
			var mediaSrc 	 = $(img).attr("libraryurl");
			var mediaImg 	 = $(img).attr("src");
			var projectlibid = $(img).attr("projectlib");

			var currentLib 	 = $("#projectVideo").attr("lib-id");

			//if(currentLib == projectlibid){
			//	console.log('setMainMedia() currentLib ' + currentLib);	
			//	console.log('setMainMedia() projectlibID ' + projectlibid);
			//	return;
			//	}
			
			if(!mediaId){
				document.querySelector(".playVideoEmbed").classList.add('pp');
				return;
			}
			else{
				document.querySelector(".playVideoEmbed").classList.remove('pp');
			}

			$("#projectlibid").val($(img).attr("projectlib"));

			var url = '{{ route("stream", ":id") }}';
			url = url.replace(':id', mediaId);

			var videoContent = '<video id="projectVideo" name="projectVideo" poster="'+mediaImg+'?t='+Date.now()+'" media-id='+mediaId+' lib-id="'+projectlibid+'" class="col-12" controls preload="auto">'
        					+	'<source src="'+ url +'?t='+Date.now()+'" type="video/mp4" media-id="'+mediaId+'" class="col-12"/>'
        					+	'<p>Video is not visible, most likely your browser does not support HTML5 video</p>'
        					+'</video>';

			$('#play').html(videoContent)
			//$(videoContent).find('video')[0].load();

			//let video = $('#projectVideo');
			//let poster = video.attr('poster');
			//video.attr('poster', poster + '?t=' + Date.now());

			
			$.each(projectLibrary, function(i, item) {
				if(item.id == projectlibid){
					console.log('El nombre: ' + item.name);
					if(item.name)
						$("#mediaName").val(item.name.substring(0,19));
					else
						$("#mediaName").val('');
					if(item.description)
        				$("#mediaDesc").val(item.description);
					else
						$("#mediaDesc").val('')
        			return false;
				}
            });

			$("#projectVideo").on('ended', function() {
				this.currentTime = 0;
				this.pause();
	            document.querySelector(".playVideoEmbed").classList.remove('pp');
	            videoPlay = !videoPlay;
	        });  


	        $("#projectVideo").on("play", function() {
            	console.log("Video started playing!");

            	document.querySelector(".playVideoEmbed").classList.add('pp');                
                videoPlay = !videoPlay;
            });

	        $("#projectVideo").on("pause", function() {
            	console.log("Video paused playing!");

            	document.querySelector(".playVideoEmbed").classList.remove('pp');
                videoPlay = !videoPlay;
            });
	        playAndPause();
		}




		//---------------------------------------- CHANGE ASPECT PROJECT
		$(".aspect li").click(function(){
			$(".addVideoMain").removeClass("d-main d-square d-mobile");
			$(".addVideoMain").addClass($(this).data("id"));
			$(".aspect li div").removeClass("active");
			$(this).find("div").addClass("active");

			$("#aspect").attr("value",$(this).data("id"));

			$.each(projectLibrary, function(i, item) {
				item.action = "UPDATE";
			});
			resizeAddmedia();
		});



		function updateData(){
			var projectlib = $("#projectlibid").val();
			$.each(projectLibrary, function(i, item) {
				if(item.id == projectlib){
					var updated= false;
					if(item.name != $("#mediaName").val()){
						item.name = $("#mediaName").val();
						updated= true;
					}

					if(item.description != $("#mediaDesc").val()){
						item.description= $("#mediaDesc").val();
						updated= true;
					}

					if(updated)
						item.action = "UPDATE";

        			return false;
				}
            });
		}

		function boton_guardar(){

			if(!existsChanges()){
				//alert("No hay modificaciones");
				//modalMsgShow("No hay modificaciones");
				ProjectModalSave(false);
				return;
				}

			var form = new FormData();
			form.append('_token',     $("input[name=_token]").val());
			form.append('projectid',  $("input[name=projectId]").val());
			form.append('projectlib', JSON.stringify(projectLibrary));
			form.append('aspect',  $("#aspect").val());

			$.ajax({
				url:  '/ajax-updateProjectLib',
				type: 'POST',
				data: form,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'json',
				success: function(response){
					if(response.success == 'Y') {
                        ProjectModalSave(true);
						$.each(projectLibrary, function(i, item) {
							item.action = "READY";
						});


					}
				},
				error: function(request, error){
					console.log(error);
					console.log(request);
					//alert("Error: "+JSON.stringify(error));
					modalMsgShow(JSON.stringify(error));
				}
			});
		}

		$("#guardarHeader").click(boton_guardar);
		$("#guardarHeaderMobile").click(boton_guardar);


		function createListMedia(mediaId, mediaSrc, mediaImg){
            var position = $("#mediaList").find("li").length+1;

            var form = new FormData();
			form.append('_token', $("input[name=_token]").val());
			form.append('projectId', $("input[name=projectId]").val());
			form.append('libraryId', mediaId);
			form.append('position', position);

          	$.ajax({
        		url:  '/ajax-addProjectLib',
            	type: 'POST',
            	data: form,
            	cache: false,
    			contentType: false,
    			processData: false,
    			dataType: 'json',
            	success: function(response){
              		if(response.success == 'Y') {

						var projectLib = response.data;
              			var listName = "list-" + projectLib.id;

    					var imagen = '<img class="p-0 m-0" src="'+mediaImg+'" onclick="setMainMedia( this )" libraryid="'+mediaId+'" libraryurl="'+mediaSrc+'" projectlib="'+projectLib.id+'" />';
                		var item = '<li id="'+listName+'" name="'+projectLib.id+'" position="'+position+'" class="nav-item" media-id="'+mediaId+'" projectlib-id="'+projectLib.id+'">'
                                 +   '<a class=" widgetVideo nav-link c03 text-md-left p-0 m-0 " >'
                                 + 	  imagen
                                 +	  '<i class="d-none c07">◄</i>'
                                 +   '</a>'
                                 +   '<button class="deleter" id="'+projectLib.id+'" projectlibid="'+projectLib.id+'" onclick="deleteProjectLib('+ projectLib.id +')" ><i class="fas fa-trash"></i></button>'
                                 +   '<button class="deleter" id="'+projectLib.id+'" projectlibid="'+projectLib.id+'" onclick="changeProjectLib('+ projectLib.id +')" ><i class="fas fa-sync-alt"></i></button>'
                                 + '</li>';


                        //$('#'+listName).on('click', function() {
                		//	setMainMedia(mediaId, mediaSrc);
            			//});
						
          				var name = $("img[media-id="+mediaId+"]").attr("media-name");
          				console.log('Nombre del Medio ' + name);
          				$("#mediaName").val(name.substring(0,19));
          				$('#mediaList').append(item);
          				$("#deleteMediaFileBtn").hide();
						
						// Pregunto si es el primer video si lo es lo cargo en el centro y lo selecciono
						const vidosList = document.querySelectorAll('#mediaList li');
						if(vidosList.length == 1){
							setMainMedia(imagen);
							vidosList[0].classList.add('active');
							vidosList[0].querySelector('a').classList.add('active');
							localStorage.setItem('video-set',vidosList[0].getAttribute('position'));							
						}						



          				//setMainMedia(imagen);
						projectLib.action = "UPDATE";
						projectLib.name   = name.substring(0,19);
          				projectLibrary.push(projectLib);
          				console.log("TODOS LOS PROJECT LIBS: %o",  projectLibrary);
          				dragList();
          				updatePositions();
          				console.log('Paso por createListMedia() ' + name);
          				//$('.modal-backdrop').remove();
              		}
            	},
            	error: function(request, error){
    				console.log(error);
    				console.log(request);
    				//alert("Error: "+JSON.stringify(error));
    				modalMsgShow(JSON.stringify(error));
    			}
        	});
    	}



    	function deleteProjectLibModalBtn(){
    		var form = new FormData();
			form.append('_token', $("input[name=_token]").val());
			form.append('id', projectLibID);

			$.ajax({
        		url:  '/ajax-delProjectLib',
            	type: 'POST',
            	data: form,
            	cache: false,
    			contentType: false,
    			processData: false,
    			dataType: 'json',
            	success: function(response){
              		if(response.success == 'Y') {
              			var name = "#list-"+projectLibID;
              			$(name).remove();

              			var content = '<i class="fas fa-play-circle"></i>'
                        				+ 'AÑADIR VIDEO';
                        $('#play').html(content);
                        $("#mediaName").val('');
						$("#mediaDesc").val('');

                        $('#deleteProjectLibModal').modal('hide');
                        document.querySelector(".playVideoEmbed").classList.add('pp');

                        console.log("Antes de eliminar: %o",  projectLibrary);
              			$.each(projectLibrary, function(i, item) {
							if(item.id == projectLibID){
                    			index= i;
                    			projectLibrary.splice(i, 1);
                    			console.log("Despues de eliminar: %o",  projectLibrary);
                    			return false;
							}
                        });

                        projectLibID=null;
                        updatePositions();
              		}
            	},
            	error: function(request, error){
    				console.log(error);
    				console.log(request);
    				//alert("Error: "+JSON.stringify(request));
    				modalMsgShow(JSON.stringify(request));
    			}
           	});

    	}


    	
    	function deleteProjectLib(id) {
			$('#deleteProjectLibModal').modal('show');
			projectLibID = id;
    	}


    	function updatePositions(){
    		lista = Array.from(document.getElementById("mediaList").getElementsByTagName("li"));
            for(let i = 0; i < lista.length; i += 1) {
                lista[i].setAttribute("position", (i+1));
            }

            for(let i = 0; i < lista.length; i += 1) {
            	var lstid = lista[i].getAttribute("name");
            	var lstpos= lista[i].getAttribute("position");

                $.each(projectLibrary, function(j, item) {
                	console.log("Lista id:  " + lstid + " pos: " + lstpos  + " - Item id: " + item.id + " pos: " + item.position);

            		if(item.id == lstid){
                		if(item.position != lstpos){
                			console.log("Item new pos: " + lstpos );
    						item.position = lstpos;
    						item.action = "UPDATE";
                    	}
                		else{
                			console.log("Item same pos: " + item.position + " lstpos: " + lstpos );
                        }
                    }
                });
            }
			hold_video(true);
      	}

		new Sortable(document.getElementById('mediaList'), {
			animation: 150,
			onSort: function(evt) {
				updatePositions();
			}
		});


    	function dragList(){
    		function handleDragStart(e) {

            	this.style.opacity = '0.4';
            	dragSrcEl = this;
            	e.dataTransfer.effectAllowed = 'move';

            	lista =  Array.from(document.getElementById("mediaList").getElementsByTagName("li"));

                for(let i = 0; i < lista.length; i += 1) {
                    if(lista[i] === this){
                    	index = i;
                    	console.log ("Moviendo desde indice: " + index);
                    }
                }
            }


            function handleDrop(e) {
            	e.stopPropagation();

            	if (dragSrcEl !== this) {
            		dragSrcEl.remove( dragSrcEl );

                    for(let i = 0; i < lista.length; i += 1) {
                        if(lista[i] === this){
                            indexDrop = i;
                            console.log ("Moviendo hasta indice: " + indexDrop);
                        }
                    }

                    if(index > indexDrop) {
                    	this.before( dragSrcEl );
                    }
                    else {
                    	this.after( dragSrcEl );
                    }


                    updatePositions();
                }

            	return false;
            }


            function handleDragEnd(e) {
            	this.style.opacity = '1';

                lista.forEach(function (item) {
                	item.classList.remove('over');
                });
            }

            function handleDragOver(e) {
            	if (e.preventDefault) {
            		e.preventDefault();
            	}

            	return false;
            }

            function handleDragEnter(e) {
            	this.classList.add('over');
            }

            function handleDragLeave(e) {
            	this.classList.remove('over');
            }


        	let lista =  Array.from(document.getElementById("mediaList").getElementsByTagName("li"));
        	lista.forEach( function(item) {
        		item.addEventListener('dragstart', handleDragStart, false);
        		item.addEventListener('dragover',  handleDragOver,  false);
        		item.addEventListener('dragenter', handleDragEnter, false);
        		item.addEventListener('dragleave', handleDragLeave, false);
        		item.addEventListener('dragend',   handleDragEnd,   false);
        		item.addEventListener('drop',      handleDrop,      false);
        	});

        }

    	let index;
		let indexDrop;

    	document.addEventListener('DOMContentLoaded', (event) => {
			dragList();
		});


		function resizeAddmedia(){
			$(".addVideoMain").parent().addClass("desktop");
			if($(".addVideoMain").parent().hasClass("desktop")){
				//console.log("tiene Desktop");
				var ds = $(".addVideoMain").parent().css("width").slice(0,-2);
				var ds1 = ds/1.777;
				$(".addVideoMain").parent().css("height",ds1+"px");
			}

			//16-9
			if($(".addVideoMain").hasClass("d-main")){
				if($(".addVideoMain").parent().hasClass("desktop")){
					$(".d-main").css("width","100%");
					//console.log("clase d-main-desktop");
					var qs = $(".d-main").css("width").slice(0,-2);
					var qs1 = qs/1.777;
					$(".d-main").css("height",qs1+"px");
					$(".d-main").css("opacity","1");
				}
			}

			//9-16
			if($(".addVideoMain").hasClass("d-mobile")){
				if($(".addVideoMain").parent().hasClass("desktop")){
					$(".d-mobile").css("height","100%");
					var ms = $(".d-mobile").css("height").slice(0,-2);
					var ms1 = ms/1.777;
					$(".d-mobile").css("width",ms1+"px");
					$(".d-mobile").css("opacity","1");
				}
			}

			//1-1
			if($(".addVideoMain").hasClass("d-square")){
				if($(".addVideoMain").parent().hasClass("desktop")){
					$(".d-square").css("height","100%");
					//console.log("clase square-desktop");
					var qs = $(".d-square").css("height").slice(0,-2);
					console.log("w="+qs);
					var qs1 = qs;
					$(".d-square").css("width",qs1+"px");
					$(".d-square").css("opacity","1");
				}
			}

		}



		$(window).resize(function() {
				resizeAddmedia();
		});


		// Play amd Pause
        function playAndPause() {
        	console.log('playAndPause() init...');
            video = document.getElementById("projectVideo");
            
            //console.log(video);
            document.querySelector(".playVideoEmbed").addEventListener("click", () => {
                console.log('playVideoEmbed.cllick() ' + videoPlay);
                if (!videoPlay) {
                    video.play();
                    document.querySelector(".playVideoEmbed").classList.add('pp');
                } else {
                    video.pause();
                    document.querySelector(".playVideoEmbed").classList.remove('pp');
                }
                //videoPlay = !videoPlay;
                console.log('playVideoEmbed.cllick() ' + videoPlay);
            }, false);

            console.log('playAndPause() end...');
        };

		window.onload = function() { //Selected Media
            
		    window.addEventListener("beforeunload", function (e) {
		        if (!existsChanges()) {
		            return undefined;
		        }

		        var confirmationMessage = 'It looks like you have been editing something. If you leave before saving, your changes will be lost.';

		        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
		        return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
		    });
			resizeAddmedia();
		};

    </script>
    @if(isset($errors))
         @foreach ($errors->all() as $error)
          <!-- <div class="alert alert-danger" role="alert">{{ $error }}</div> -->
          <script>
          	modalMsgShow("{{ $error }}");
          </script>
        @endforeach
	@endif
	</body>
</html>
