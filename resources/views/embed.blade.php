<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="css/StyleEmbed.css">
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <?php
        header('p3p: CP="CAO PSA OUR"');
        session()->put("tko",csrf_token());
        ?>
    </head>
	<body>
	<?php
	 	if($project->aspect=="d-mobile")
		 	$aspect = "f916aspect";
		elseif($project->aspect=="d-square")
			$aspect = "f133aspect";
		else // d-main
			$aspect = "f169aspect";
	  ?>
    <?php
    if(session('preview') === null || session('preview') === 0 )
        session()->put("preview",0);
        //echo ("<script>alert(".session('preview').")</script>");
    ?>

	{{ csrf_field() }}

    <!-------------------------------------MAIN------------------------------------------>

        <div class="mainContainer <?= $aspect ?>">
            <div class="main">
			   <!--------VIDEO------->
               <div class="blockAdd" id="blockAdd">
                 <div class="addVideoMain published  "   >
					<a class="playVideoEmbed"><img src="images/SVG/Play.svg"></a>
					<div class="widgetContainer" id="widgetContainer"></div>
                  <div id="play" name="name" class="play">
                    <video id="projectVideo" playsinline name="projectVideo" poster="" media-id="" lib-id="" class="col-12" preload="auto">
                        <source src="" type="video/mp4" media-id="" class="col-12 ">
                    </video>
                  </div>
                </div>
               </div>
            </div>

        </div>


    <script>
        console.log("TOKEN:"+"{{ csrf_token() }}");
        var sessionPreview = {{ json_encode(session("preview")) }};


        var projectLibs = [];
      	var cuePoints   = [];
		var project;
        const windows = {};
        let tempCuepoint = null;

        // Inicio
        document.addEventListener("DOMContentLoaded", function() {
            console.log("ready!");

            // Miro si estoy en preview
            try {
                if (sessionPreview) {
                    console.log("Preview Start: No interactions register");
                    console.log(sessionPreview);
                } else {
                    console.log('Interactions register active');
                }
            } catch (error) {
                console.log('Error de Session Preview');
            }


            // Cargo variables de projecto
    	    projectLibs = @json($projectLibs);
    		cuePoints = @json($cuePoints);
    		project = @json($project);

    		var projectlib = projectLibs[0];
            let currentLib = 0;
    		if(projectlib){
                console.log(projectlib);
				setMainMedia(projectlib, false, currentLib);
        	}
      	});


		// Devuelve CurrentTime en valor .3
		function matchRounded(number){
			let rounded = Math.floor(number*10/3)*3 / 10;
			rounded = new Date(rounded * 1000).toISOString().substr(11, 10);
			return rounded;
		}

        // Ajusto Video y parametros del libreria
        function setMainMedia(projectlib, autoplay, currentLib){
            console.log('Entro');
			var mediaId      = projectlib.libraryid
			var mediaSrc     = projectlib.library.url;
			var mediaImg 	 = projectlib.library.thumbnail;
			var projectlibid = projectlib.id;
            let videoOn = document.getElementById('projectVideo');
            videoOn.setAttribute('lib-id', projectlibid);

			if(currentLib == projectlibid)
				return;

        	var url = '{{ route("stream", ":id") }}';
    		url = url.replace(':id', mediaId);
            console.log(url);

            videoOn = document.getElementById('projectVideo');
            videoOn.setAttribute('poster', mediaImg);
            videoOn.setAttribute('media-id', mediaId);
            videoOn.setAttribute('lib-id', projectlibid);
            videoOn.src = url;

            // Autoplay si está habilitado
            if (autoplay) {
                console.log("Autoplay: " + autoplay);
                videoOn.play();
            }

            // Añadir eventos al video
            videoOn.addEventListener("timeupdate", timeListen);
            videoOn.addEventListener("ended", endVideoListen);
        }

        // Se escucha el tiempo / Tipo  de Cuepoint
        let timeListen = function(event){
            videoOn = document.getElementById('projectVideo');
    		let absSeconds = matchRounded(this.currentTime);
    		var currentMedia =  videoOn.getAttribute('media-id');
    		var currentLib   = videoOn.getAttribute("lib-id");

            //console.log(currentMedia);
            //console.log(currentLib);
            //console.log(absSeconds);
            //console.log(cuePoints);



            cuePoints.forEach(function(cuePoint, index) {
                let cueTime = matchRounded(cuePoint.time);

                //console.log('cue:'+cueTime);
                //console.log('time:'+absSeconds);


                if( cuePoint.projectlibraryid == currentLib && cueTime == absSeconds){


                    console.log('=:'+cuePoint.id+'/'+tempCuepoint);
                    if(cuePoint.id != tempCuepoint){
                        console.log('interacción');
                        registerInteraction(cuePoint.id,cuePoint.cuepointname,null,cuePoint.cuepointname,0);
                        tempCuepoint = cuePoint.id;
                    }

                    // Reviso tipo de CuePoint
                    if(cuePoint.type == "BROWSE"){
                        console.log('Browse');

                        // Clean WidgetContainer
                        document.getElementById('widgetContainer').innerHTML = '';


                        // Check kind of browser is
                        if(cuePoint.type_browse.type == "NONE"){
                            console.log('NONE');
                        }
                        else if(cuePoint.type_browse.type == "URL"){
                            console.log('URL');
                            goUrl(cuePoint.type_browse.goto, cuePoint.type_browse.options);
                        }
                        else if(cuePoint.type_browse.type == "CUEPOINT"){
                            console.log('CUEPOINT');
                            goCuepoint(cuePoint.type_browse.goto);
							mobileSet();
                        }
                        else if(cuePoint.type_browse.type == "VIDEO"){
                            console.log('VIDEO');
                            goVideo(cuePoint.type_browse.goto);
                        }
                        else{
                    		console.log('NINGUN TIPO');
                    	    //videoOn[0].addEventListener("timeupdate", timeListen);
                    	}
                    }
                    else if(cuePoint.type == "OPTION"){
                        console.log('Option');

                        videoOn.pause();
              		    let contenedor = document.getElementById('widgetContainer');
                        contenedor.innerHTML = '';
      					contenedor.innerHTML = cuePoint.type_option.content;
                        contenedor.classList.add('active');
                        document.getElementById('AB').classList.remove('d-none');


                        // Llamo a las acciones de opciones
                        listenOptionActions(cuePoint,cuePoint.type_option.type_option_data);


						// Aqui quitamos algunas propiedades que no se usan
						// Eliminar todos los elementos con la clase 'edit-tooltip' dentro de los elementos 'li' dentro del elemento con el ID 'AB'
                        document.querySelectorAll("#AB li .edit-tooltip").forEach(element => {element.remove();});
                        // Eliminar el elemento con el ID 'imgGetIn'
                        const imgGetIn = document.getElementById("imgGetIn");if (imgGetIn) {imgGetIn.remove();}
                        // Establecer la opacidad a '0' para todos los elementos con la clase 'disable' dentro del elemento con el ID 'AB'
                        document.querySelectorAll("#AB .disable").forEach(element => {element.style.opacity = "0";});
                        // Establecer 'pointer-events' a 'none' para todos los elementos con la clase 'disable' dentro del elemento con el ID 'AB'
                        document.querySelectorAll("#AB .disable").forEach(element => {element.style.pointerEvents = "none";});
                        // Eliminar todos los elementos con la clase 'ui-resizable-handle' dentro de los elementos 'li' dentro del elemento con el ID 'AB'
                        document.querySelectorAll("#AB li .ui-resizable-handle").forEach(element => {element.remove();});
                        // Establecer 'contenteditable' a 'false' para todos los elementos 'p' dentro de los elementos 'li' dentro del elemento con el ID 'AB'
                        document.querySelectorAll("#AB li p").forEach(element => {element.contentEditable = "false";});

                        mobileSet();
                    }
                    else if(cuePoint.type == "FORM"){
                        console.log('Form');

                        videoOn.pause();
              		    let contenedor = document.getElementById('widgetContainer');
                        contenedor.innerHTML = '';
      					contenedor.innerHTML = cuePoint.type_form.content;
                        contenedor.classList.add('active');
                        document.getElementById('AF').classList.remove('d-none');


						// Aqui quitamos algunas propiedades que no se usan
						// Eliminar el elemento con id 'fields-form'
                        let fieldsForm = document.getElementById('fields-form');
                        if (fieldsForm) {fieldsForm.parentNode.removeChild(fieldsForm);}
                        // Eliminar el atributo 'contenteditable' de los elementos h3 dentro del elemento con id 'form-title'
                        let formTitleH3 = document.querySelectorAll('#form-title h3');
                        formTitleH3.forEach(function(h3) { h3.removeAttribute('contenteditable');});
                        // Eliminar el elemento con id 'colors-form'
                        let colorsForm = document.getElementById('colors-form');
                        if (colorsForm) { colorsForm.parentNode.removeChild(colorsForm);}
                        // funcion update elimino de inputs
                        // Selecciona todos los elementos input en el documento
                        let inputs = document.querySelectorAll('input');
                        // Itera sobre cada input y elimina el atributo onfocusout
                        inputs.forEach(function(input) { input.removeAttribute('onfocusout');});


                        //Ajusto posición de Formulario
                        const AF = document.querySelector('#AF');
                        AF.offsetHeight
                        const inps4 = AF.querySelectorAll('.d-flex');
                        let numeros = inps4, suma = 0;
                            numeros.forEach (function(numero){ ;
                                suma += numero.offsetHeight;
                        });
                        suma = suma+document.querySelector('#form-title').offsetHeight;
                        if(AF.offsetHeight > suma){
                            AF.classList.remove('content-start');
                        }else{
                        AF.classList.add('content-start');
                        }

                        // Llamo a las acciones de formulario
						listenFormActions(cuePoint);


                    }
                }
            });
        }


        // ___ BROWSER WIDGETS ACTIONS
        // Ir a Video
        const goVideo = (projectlibid) => {

            console.log('goVideo:'+projectlibid);
        	projectLibs.forEach(function(element, index) {
				if(element.id == projectlibid){
					setMainMedia(element, true);
				}
			});
        }
        // Ir a Url
        const goUrl = (url, option) => {
            console.log('goUrl:' + url + '/' + option);
            if (windows[url] && !windows[url].closed) {
                windows[url].focus();
            } else {
                windows[url] = window.open(url, option);
            }
            endVideoListen();
        };
        // Ir a Cuepoint
        const goCuepoint = (cuepointid) => {
            console.log('goCuepoint:' + cuepointid);
            cuePoints.forEach(function( cue, index ) {
				if(cue.id == cuepointid){
					console.log('Salto a:'+cue.id)
                    videoOn = document.getElementById('projectVideo');
		        	videoOn.currentTime = cue.time;
					videoOn.play();
					var cuepointname = cue.cuepointname;
				}
			});
		};


        // ___ OPTIONS WIDGETS ACTIONS
        // Opciones
        const listenOptionActions = (cuepoint,optionData) => {
        	console.log('Option Actions:');

            // Opciones al hacer clic en boton
        	const opctionCta = document.querySelectorAll('#widgetContainer > ul > li');
            opctionCta.forEach(function(element, index) {
                element.addEventListener('click', function() {

                    document.getElementById("widgetContainer").classList.remove('active');
                    document.getElementById('AB').classList.add('d-none');
                    let uuid = element.getAttribute('uuid');


                    optionData.forEach(function(item, i) {
                        console.log("Mirando optionData: ", item);
                        let optionUuid = item.uuid;

                        if(item.uuid == uuid){
                            console.log(item);

                            if(item.type == "URL"){
                                console.log('URL');

                                goUrl(item.goto, item.options);
                                registerInteraction(item.cuepointid,cuepoint.cuepointname,item.id,item.name,0);
                            }
                            else if(item.type == "CUEPOINT"){
                                console.log('CUEPOINT');

                                goCuepoint(item.goto);
                                // Limpio el contenedor
                                document.getElementById('widgetContainer').innerHTML = '';
                                registerInteraction(item.cuepointid,cuepoint.cuepointname,item.id,item.name,0);

                            }
                            else if(item.type == "VIDEO"){
                                console.log('VIDEO');

                                goVideo(item.goto);
                                // Limpio el contenedor
                                document.getElementById('widgetContainer').innerHTML = '';
                                registerInteraction(item.cuepointid,cuepoint.cuepointname,item.id,item.name,0);
                            }
                        }
                    });
                });
            });
        }


        // ___ FORM WIDGETS ACTIONS
        // Form CTA
        const listenFormActions = (item) => {
            const cta = document.getElementById('form-cta');
            cta.addEventListener('click', function() {

                const formData = document.getElementById('AF'); // Formulario de acciones
                const inputs = formData.querySelectorAll('.itemForm.d-flex');
                const sendto = item.type_form.sendto;
                const nameForm = item.type_form.name;


                if(document.querySelector('#AF').checkValidity()){
                    document.getElementById("widgetContainer").classList.remove('active');
                    document.getElementById('AF').classList.add('d-none');

                    // Envio de formulario
                    crm = loadCrmField();
                    sendForm(inputs, sendto, nameForm, crm);

                    // Opciones de CTA
                    if(item.type_form.type == "URL"){
                        console.log('URL');
                        goUrl(item.type_form.goto, item.type_form.options);
                    }
                    else if(item.type_form.type == "CUEPOINT"){
                        console.log('Cuepoint');
                        goCuepoint(item.type_form.goto);
                        document.getElementById('widgetContainer').innerHTML = '';
                    }
                    else if(item.type_form.type == "VIDEO"){
                        console.log('Video');
                        goVideo(item.type_form.goto);
                        document.getElementById('widgetContainer').innerHTML = '';
                    }
                }
            });
        }


        // ___ FINAL DEL VIDEO
		const endVideoListen = function(){
            console.log('El video ha finalizado');
			const block_add = document.getElementById('blockAdd');
            block_add.innerHTML = '';
            block_add.innerHTML = project.publish_div;

            registerInteraction(null,'End',null,'End',1);


			//console.log("remove1");
			document.getElementById("imgGetIn_view").remove();
			//console.log("remove2");
            document.querySelector(".edit-poster").remove();

			//console.log("ya remove");
            document.querySelector('#title-end h2').removeAttribute('contenteditable');
            document.querySelector('#subtitle-end p').removeAttribute('contenteditable');
            document.querySelector('.poster-end #again').removeAttribute('contenteditable');

            button = document.querySelector(".poster-end #again");
            button.addEventListener("click", (event) => {
                document.location.href = document.location.href;
            });
		}



        // ___ PLAY VIDEO
        let conterWidgets = document.querySelector('.widgetContainer');
        document.querySelector(".playVideoEmbed").addEventListener("click", startPlay, false);
        let videoPlay = false;

        function startPlay() {
            document.getElementById("projectVideo").play();
            videoPlay = !videoPlay;
            registerInteraction(null, 'Video', null, 'Play', 0);
            document.querySelector(".playVideoEmbed").removeEventListener("click", startPlay, false);
            document.querySelector(".playVideoEmbed").classList.add('pp');
            playAndPause();
        }

        const playAndPause = () => {
            document.querySelector(".playVideoEmbed").addEventListener("click", () => {
                if (!videoPlay) {
                    document.getElementById("projectVideo").play();
                    document.querySelector(".playVideoEmbed").classList.add('pp');
                } else {
                    document.getElementById("projectVideo").pause();
                    document.querySelector(".playVideoEmbed").classList.remove('pp');
                }
                videoPlay = !videoPlay;
            }, false);
        };



        // ___ Registro de Interacciones
        // Registro
		function registerInteraction(cuepointid, cuepointname, cuepointoptionid, cuepointoptionname, interactiontype) {
            if (!{{ session('preview') }}) {
                let form = new FormData();
                form.append('_token', "{{ csrf_token() }}");
                form.append('project', '{{ request()->get('project') }}');

                form.append('cuepointid', cuepointid !== null ? cuepointid : -1);
                if (cuepointname !== null) form.append('cuepointname', cuepointname);
                if (cuepointoptionid !== null) form.append('cuepointoptionid', cuepointoptionid);
                if (cuepointoptionname !== null) form.append('cuepointoptionname', cuepointoptionname);
                form.append('interactiontype', interactiontype !== null ? interactiontype : 0);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'ajax-register-interaction', true);
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        // Request was successful
                        console.log('Interaction registered successfully');
                    } else {
                        // Handle error
                        alert("Error ajax-register-interaction: " + xhr.statusText);
                    }
                };
                xhr.onerror = function () {
                    // Handle network error
                    alert("Error ajax-register-interaction: " + xhr.statusText);
                };
                xhr.send(form);
            }
        }


        // ___ Envio de Formulario
        // Send form
        function sendForm(inputs, sendto, nameForm, crm) {
            if (!{{session('preview')}}) {
                console.log('imprimo');
                const formData = new FormData();
                inputs.forEach(element => {
                    try {
                        let nameF = element.querySelector('input').name;
                        let valF = element.querySelector('input').value;
                        let tagF = element.querySelector('label b').innerHTML;
                        formData.append(nameF, valF);
                        formData.append('tag' + nameF, tagF);
                    } catch (error) {
                        let nameF2 = element.querySelector('textarea').name;
                        let valF2 = element.querySelector('textarea').value;
                        let tagF2 = element.querySelector('label b').innerHTML;
                        formData.append(nameF2, valF2);
                        formData.append('tag' + nameF2, tagF2);
                    }
                });
                formData.append('sendto', sendto);
                formData.append('nameForm', nameForm);
                if (crm) {
                    sendCrm(formData);
                }

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'sendForm', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        // Request was successful
                        console.log('Form sent successfully');
                    } else {
                        // Handle error
                        alert("Error sendForm: " + xhr.statusText);
                    }
                };
                xhr.onerror = function () {
                    // Handle network error
                    alert("Error sendForm: " + xhr.statusText);
                };
                xhr.send(formData);
            }
        }



        // ___ Envio al CRM
        // Cargar Crm
        function  loadCrmField(){
            let form = document.querySelector('#AF');
            let crm;
            if(form.hasAttribute('crm')){
                if(form.getAttribute('crm') == 'true'){
                    console.log('es true');
                    crm = true;
                }else{
                    console.log('es falso');
                    crm = false;
                }
            }else{
                console.log('no esta');
                crm = false;
            }
            return crm;
        }

        // Enviar Crm
        function sendCrm(formData) {
            // Add the project ID
            formData.append('projectid', {{ $project->id }});
            formData.append('_token', "{{ csrf_token() }}");

            console.log("{{ csrf_token() }}");

            // Display the values CRM
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'crm-register', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Request was successful
                    console.log('Crm Enviado');
                } else {
                    // Handle error
                    alert("Error al enviar crm-register: " + xhr.statusText);
                }
            };
            xhr.onerror = function () {
                // Handle network error
                alert("Error al enviar crm-register: " + xhr.statusText);
            };
            xhr.send(formData);
        }


        // ___ Versión Movil
        // Mobileset
		function mobileSet() {
            const AB = document.getElementById('AB');
            let sD = AB.getAttribute("data-desktop");
            AB.style.fontSize = sD + "px";

            let fMobile = AB.getAttribute("data-mobile");

            let css = '@media screen and (max-width: 480px) {#AB {font-size:' + fMobile + 'px !important;}}';
            let head = document.head || document.getElementsByTagName('head')[0];
            let style = document.createElement('style');

            head.appendChild(style);

            style.type = 'text/css';
            if (style.styleSheet) {
                // This is required for IE8 and below.
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(document.createTextNode(css));
            }
        }




    </script>
  </body>
</html>
