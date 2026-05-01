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

    <div class="mainContainer <?= $aspect ?>">
            <div class="main">
                <div class="blockAdd" id="blockAdd">
                 <div class="addVideoMain published  "   >
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
        var cuePoints   = [];
        var project;
        const windows = {};
        let tempCuepoint = null;
        let currentProjectLibIndex = 0; // Variable para controlar el índice del video actual
        let preloadedVideo = null; // Para almacenar el elemento de video precargado
        let thumbnailChangedForCurrentVideo = false; // Nueva bandera para controlar el cambio de thumbnail al inicio de la reproducción
        const OPTION_WIDGET_TITLE_SIZE_DEFAULT = 42;
        const OPTION_WIDGET_FONT_DEFAULT = "Open Sans";

        function normalizeOptionWidgetFontFamily(fontFamily) {
            const candidate = String(fontFamily || "")
                .replace(/["']/g, "")
                .replace(/\s+/g, " ")
                .trim();
            return candidate.length ? candidate : OPTION_WIDGET_FONT_DEFAULT;
        }

        function getOptionWidgetGoogleFontUrl(fontFamily) {
            const normalized = normalizeOptionWidgetFontFamily(fontFamily);
            const familyQuery = normalized.split(/\s+/).join("+");
            return "https://fonts.googleapis.com/css2?family=" + familyQuery + ":wght@400;500;700&display=swap";
        }

        function getOptionWidgetFontCssValue(fontFamily) {
            const normalized = normalizeOptionWidgetFontFamily(fontFamily);
            return '"' + normalized.replace(/"/g, '\\"') + '", sans-serif';
        }

        function ensureOptionWidgetGoogleFontLoaded(fontFamily) {
            const normalized = normalizeOptionWidgetFontFamily(fontFamily);
            const fontKey = normalized.toLowerCase().replace(/[^a-z0-9]+/g, "-");
            const linkId = "option-widget-google-font-runtime-" + fontKey;

            if (document.getElementById(linkId)) {
                return;
            }

            const link = document.createElement("link");
            link.id = linkId;
            link.rel = "stylesheet";
            link.href = getOptionWidgetGoogleFontUrl(normalized);
            document.head.appendChild(link);
        }

        function hydrateOptionWidgetTypography() {
            const ab = document.getElementById("AB");
            if (!ab) {
                return;
            }

            const titlePreview = document.getElementById("optionWidgetTitlePreview");

            let fontFamily = (ab.getAttribute("data-widget-font-family") || "").trim();
            if (!fontFamily && titlePreview) {
                fontFamily = (titlePreview.getAttribute("data-widget-font-family") || "").trim();
            }
            if (!fontFamily && ab.style.fontFamily) {
                fontFamily = ab.style.fontFamily.split(",")[0].replace(/["']/g, "").trim();
            }

            const normalizedFont = normalizeOptionWidgetFontFamily(fontFamily);
            const fontCssValue = getOptionWidgetFontCssValue(normalizedFont);
            ensureOptionWidgetGoogleFontLoaded(normalizedFont);

            ab.setAttribute("data-widget-font-family", normalizedFont);
            ab.style.fontFamily = fontCssValue;

            if (titlePreview) {
                titlePreview.setAttribute("data-widget-font-family", normalizedFont);
                titlePreview.style.fontFamily = fontCssValue;

                let titleSize = parseInt(titlePreview.getAttribute("data-title-font-size"), 10);
                if (!Number.isFinite(titleSize)) {
                    titleSize = parseInt(titlePreview.style.fontSize, 10);
                }
                if (!Number.isFinite(titleSize)) {
                    titleSize = OPTION_WIDGET_TITLE_SIZE_DEFAULT;
                }
                if (titleSize < 14) {
                    titleSize = 14;
                }
                if (titleSize > 120) {
                    titleSize = 120;
                }

                titlePreview.setAttribute("data-title-font-size", String(titleSize));
                titlePreview.style.fontSize = titleSize + "px";
            }
        }

        const optionWidgetBackgroundPreloadCache = new Set();
        const optionWidgetBackgroundPreloadRefs = [];

        function normalizeOptionWidgetBackgroundUrl(url) {
            const cleanUrl = String(url || "").trim().replace(/^["']|["']$/g, "");
            if (!cleanUrl.length || cleanUrl === "none") {
                return "";
            }
            return cleanUrl;
        }

        function extractOptionWidgetBackgroundFromCssValue(cssValue) {
            const match = String(cssValue || "").match(/url\((['"]?)(.*?)\1\)/i);
            return match && match[2] ? normalizeOptionWidgetBackgroundUrl(match[2]) : "";
        }

        function preloadOptionWidgetBackground(url) {
            const cleanUrl = normalizeOptionWidgetBackgroundUrl(url);
            if (!cleanUrl.length || cleanUrl.startsWith("data:")) {
                return;
            }
            if (optionWidgetBackgroundPreloadCache.has(cleanUrl)) {
                return;
            }

            optionWidgetBackgroundPreloadCache.add(cleanUrl);
            const img = new Image();
            img.decoding = "async";
            img.loading = "eager";
            img.src = cleanUrl;
            optionWidgetBackgroundPreloadRefs.push(img);
        }

        function preloadOptionWidgetBackgroundsFromCuePoints(cuePointList) {
            if (!Array.isArray(cuePointList)) {
                return;
            }

            cuePointList.forEach(function(cuePoint) {
                if (!cuePoint || cuePoint.type !== "OPTION" || !cuePoint.type_option || !cuePoint.type_option.content) {
                    return;
                }

                const optionHtml = String(cuePoint.type_option.content || "");
                if (!optionHtml.length) {
                    return;
                }

                const parser = new DOMParser();
                const doc = parser.parseFromString("<div id='__pf_option_bg_probe'>" + optionHtml + "</div>", "text/html");
                const abNode = doc.querySelector("#AB");
                if (!abNode) {
                    return;
                }

                preloadOptionWidgetBackground(abNode.getAttribute("data-bg-image-url"));
                preloadOptionWidgetBackground(extractOptionWidgetBackgroundFromCssValue(abNode.style.backgroundImage));
            });
        }

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
            preloadOptionWidgetBackgroundsFromCuePoints(cuePoints);

            // Inicializa el primer video si existe
            if(projectLibs.length > 0){
                setMainMedia(projectLibs[currentProjectLibIndex], false);
            }
        });


        // Devuelve CurrentTime en valor .3
        function matchRounded(number){
            let rounded = Math.floor(number*10/3)*3 / 10;
            rounded = new Date(rounded * 1000).toISOString().substr(11, 10);
            return rounded;
        }

        // Ajusto Video y parametros del libreria
        function setMainMedia(projectlib, autoplay){
            console.log('Entro a setMainMedia para video:', projectlib.name, ' (ID:', projectlib.id, ')');
            var mediaId      = projectlib.libraryid
            var mediaImg     = projectlib.library.thumbnail; // Accede al thumbnail desde la relación 'library'
            var projectlibid = projectlib.id; // El ID de projectlib, no el ID de la librería del video
            let videoOn = document.getElementById('projectVideo');

            // Reiniciar la bandera para el nuevo video
            thumbnailChangedForCurrentVideo = false;

            // Si el video que intentamos cargar ya es el actual, salimos.
            // Esto evita recargas innecesarias si goVideo apunta al mismo video que ya se está reproduciendo.
            if(videoOn.getAttribute('lib-id') == projectlibid && videoOn.src !== "" && videoOn.src.includes(mediaId)){
                console.log("El video ya está cargado o es el mismo. No hay cambios de SRC.");
                // Aseguramos que el poster sea el del video actual si ya está cargado
                if (videoOn.getAttribute('poster') !== mediaImg) { // Solo si es diferente, para evitar parpadeos
                     videoOn.setAttribute('poster', mediaImg);
                     console.log("Poster actualizado al del video actual (en setMainMedia).");
                }
                preloadNextVideo(); // Todavía queremos precargar el siguiente
                return;
            }

            videoOn.setAttribute('lib-id', projectlibid); // Establece el ID de projectlib
            videoOn.setAttribute('media-id', mediaId); // Establece el ID de la librería del video

            var url = '{{ route("stream", ":id") }}';
            url = url.replace(':id', mediaId);
            console.log("Cargando URL del video: " + url);

            videoOn.setAttribute('poster', mediaImg); // Siempre establece el poster INICIAL del video que se va a reproducir
            videoOn.src = url;
            videoOn.load(); // Carga el nuevo recurso

            // Autoplay si está habilitado
            if (autoplay) {
                console.log("Autoplay: " + autoplay);
                videoOn.play().catch(error => {
                    console.error("Autoplay falló:", error);
                    // Puedes añadir aquí un mensaje al usuario o un botón de "Play"
                });
            }

            // Eliminar escuchadores existentes para evitar duplicados
            videoOn.removeEventListener("timeupdate", timeListen);
            videoOn.removeEventListener("ended", endVideoListen);
            videoOn.removeEventListener("play", handleVideoPlayForThumbnail); // Remover el listener de 'play' anterior

            // Añadir eventos al video
            videoOn.addEventListener("timeupdate", timeListen);
            videoOn.addEventListener("ended", endVideoListen);
            videoOn.addEventListener("play", handleVideoPlayForThumbnail); // Añadir el nuevo listener de 'play'

            // *** LLAMADA A LA PRECARGA DEL SIGUIENTE VIDEO ***
            preloadNextVideo();
        }

        // --- Nueva función para precargar el siguiente video ---
        function preloadNextVideo() {
            // Eliminar el video precargado anterior si existe
            if (preloadedVideo) {
                preloadedVideo.removeAttribute('src'); // Detener descarga
                preloadedVideo.load(); // Descargar vacía para liberar recursos
                preloadedVideo.remove(); // Eliminar el elemento del DOM
                preloadedVideo = null;
                console.log('Video precargado anterior limpiado.');
            }

            const nextIndex = currentProjectLibIndex + 1;
            if (nextIndex < projectLibs.length) {
                const nextLibToPreload = projectLibs[nextIndex];
                const mediaIdToPreload = nextLibToPreload.libraryid;
                var urlToPreload = '{{ route("stream", ":id") }}';
                urlToPreload = urlToPreload.replace(':id', mediaIdToPreload);

                preloadedVideo = document.createElement('video');
                preloadedVideo.style.display = 'none'; // Hazlo invisible
                preloadedVideo.setAttribute('preload', 'auto'); // ¡Esto es clave para que se precargue!
                preloadedVideo.src = urlToPreload;
                document.body.appendChild(preloadedVideo); // Añádelo al DOM (invisible)

                preloadedVideo.load(); // Inicia la carga del video

                preloadedVideo.addEventListener('loadeddata', () => {
                    console.log(`Video ID ${mediaIdToPreload} (siguiente) ha cargado suficientes datos para reproducir los primeros frames.`);
                });
                preloadedVideo.addEventListener('canplaythrough', () => {
                    console.log(`Video ID ${mediaIdToPreload} (siguiente) puede reproducirse hasta el final sin interrupciones.`);
                });
                preloadedVideo.addEventListener('error', (e) => {
                    console.error(`Error precargando video ID ${mediaIdToPreload}:`, e);
                });

                console.log(`Iniciando precarga del siguiente video: ID ${mediaIdToPreload}`);
            } else {
                console.log('No hay más videos para precargar.');
            }
        }

        // *** Nueva función para manejar el cambio de thumbnail al iniciar la reproducción ***
        const handleVideoPlayForThumbnail = function() {
            const videoOn = document.getElementById('projectVideo');
            // Asegurarse de que esto solo se ejecute una vez por la reproducción inicial del video
            if (thumbnailChangedForCurrentVideo) {
                return;
            }

            const nextIndexForThumbnail = currentProjectLibIndex + 1;
            if (nextIndexForThumbnail < projectLibs.length) {
                const nextProjectLibForThumbnail = projectLibs[nextIndexForThumbnail];
                if (nextProjectLibForThumbnail && nextProjectLibForThumbnail.library && nextProjectLibForThumbnail.library.thumbnail) {
                    // *** Aplicar un retraso de 2 segundos antes de cambiar el thumbnail ***
                    setTimeout(() => {
                        videoOn.setAttribute('poster', nextProjectLibForThumbnail.library.thumbnail);
                        console.log(`Poster del video actual cambiado al thumbnail del siguiente video (ID: ${nextProjectLibForThumbnail.id}) después de 2 segundos de iniciar la reproducción.`);
                        thumbnailChangedForCurrentVideo = true; // Marcar como cambiado
                    }, 2000); // 2000 milisegundos = 2 segundos
                }
            }
        };


        // Se escucha el tiempo / Tipo  de Cuepoint
        const getInteractionTagFromCuepoint = (cuePoint) => {
            if (!cuePoint || cuePoint.type !== 'BROWSE' || !cuePoint.type_browse) {
                return null;
            }

            const tag = cuePoint.type_browse.tag;
            if (tag === null || tag === undefined || tag === '') {
                return null;
            }

            return tag;
        };

        const getInteractionTagFromOption = (selectedOption) => {
            if (!selectedOption) {
                return null;
            }

            const tag = selectedOption.tag;
            if (tag === null || tag === undefined || tag === '') {
                return null;
            }

            return tag;
        };

        let timeListen = function(event){
            videoOn = document.getElementById('projectVideo');
            let absSeconds = matchRounded(this.currentTime);
            var currentLibId = videoOn.getAttribute("lib-id"); // El ID de projectlib del video actual

            cuePoints.forEach(function(cuePoint, index) {
                let cueTime = matchRounded(cuePoint.time);

                // Asegúrate de que solo se dispare el cuePoint para el video actualmente en reproducción
                if( cuePoint.projectlibraryid == currentLibId && cueTime == absSeconds){

                    if(cuePoint.id != tempCuepoint){ // Evita que se dispare múltiples veces en el mismo segundo
                        console.log('Interacción detectada en cuePoint:', cuePoint.id);
                        registerInteraction(
                            cuePoint.id,
                            cuePoint.cuepointname,
                            null,
                            cuePoint.cuepointname,
                            0,
                            getInteractionTagFromCuepoint(cuePoint)
                        );
                        tempCuepoint = cuePoint.id; // Almacena el ID del cuePoint para evitar duplicados inmediatos
                    } else {
                        return; // Ya hemos procesado este cuePoint en este segundo
                    }

                    // Reviso tipo de CuePoint
                    if(cuePoint.type == "BROWSE"){
                        console.log('Browse CuePoint');

                        // Clean WidgetContainer
                        document.getElementById('widgetContainer').innerHTML = '';


                        // Check kind of browser is
                        if(cuePoint.type_browse.type == "NONE"){
                            console.log('NONE (no acción de navegación)');
                        }
                        else if(cuePoint.type_browse.type == "URL"){
                            console.log('URL (navegación)');
                            goUrl(cuePoint.type_browse.goto, cuePoint.type_browse.options);
                        }
                        else if(cuePoint.type_browse.type == "CUEPOINT"){
                            console.log('CUEPOINT (navegación)');
                            goCuepoint(cuePoint.type_browse.goto);
                            mobileSet(); // Asegura ajustes para móvil
                        }
                        else if(cuePoint.type_browse.type == "VIDEO"){
                            console.log('BROWSE -> VIDEO (navegación), intentando saltar a projectlib ID:', cuePoint.type_browse.goto);
                            goVideo(cuePoint.type_browse.goto); // <<--- ESTA ES LA LLAMADA CLAVE
                        }
                        else{
                            console.log('Tipo de navegación desconocido');
                        }
                    }
                    else if(cuePoint.type == "OPTION"){
                        console.log('Option CuePoint');

                        videoOn.pause();
                        let contenedor = document.getElementById('widgetContainer');
                        contenedor.innerHTML = '';
                        contenedor.innerHTML = cuePoint.type_option.content;
                        contenedor.classList.add('active');
                        hydrateOptionWidgetTypography();
                        // Asegurarse de que el elemento AB exista antes de manipularlo
                        const abElement = document.getElementById('AB');
                        if (abElement) {
                            const bgUrlFromData = (abElement.getAttribute("data-bg-image-url") || "").trim();
                            const bgUrlFromStyle = extractOptionWidgetBackgroundFromCssValue(abElement.style.backgroundImage);
                            preloadOptionWidgetBackground(bgUrlFromData);
                            preloadOptionWidgetBackground(bgUrlFromStyle);
                            const hasOptionWidgetBg = bgUrlFromData.length > 0 || bgUrlFromStyle.length > 0;
                            if (hasOptionWidgetBg) {
                                abElement.style.backgroundSize = "cover";
                                abElement.style.backgroundPosition = "center";
                                abElement.style.backgroundRepeat = "no-repeat";
                            }
                            abElement.classList.remove('d-none');
                        }


                        // Llamo a las acciones de opciones
                        listenOptionActions(cuePoint,cuePoint.type_option.type_option_data);


                        // Aqui quitamos algunas propiedades que no se usan
                        document.querySelectorAll("#AB li .edit-tooltip").forEach(element => {element.remove();});
                        const imgGetIn = document.getElementById("imgGetIn");if (imgGetIn) {imgGetIn.remove();}
                        document.querySelectorAll("#AB .disable").forEach(element => {element.style.opacity = "0";});
                        document.querySelectorAll("#AB .disable").forEach(element => {element.style.pointerEvents = "none";});
                        document.querySelectorAll("#AB li .ui-resizable-handle").forEach(element => {element.remove();});
                        document.querySelectorAll("#AB li p").forEach(element => {element.contentEditable = "false";});
                        document.querySelectorAll("#optionWidgetTitlePreview").forEach(element => {
                            element.contentEditable = "false";
                            element.removeAttribute("onblur");
                        });

                        mobileSet();
                    }
                    else if(cuePoint.type == "FORM"){
                        console.log('Form CuePoint');

                        videoOn.pause();
                        let contenedor = document.getElementById('widgetContainer');
                        contenedor.innerHTML = '';
                        contenedor.innerHTML = cuePoint.type_form.content;
                        contenedor.classList.add('active');
                        // Asegurarse de que el elemento AF exista antes de manipularlo
                        const afElement = document.getElementById('AF');
                        if (afElement) {
                            afElement.classList.remove('d-none');
                        }


                        // Aqui quitamos algunas propiedades que no se usan
                        let fieldsForm = document.getElementById('fields-form');
                        if (fieldsForm) {fieldsForm.parentNode.removeChild(fieldsForm);}
                        let formTitleH3 = document.querySelectorAll('#form-title h3');
                        formTitleH3.forEach(function(h3) { h3.removeAttribute('contenteditable');});
                        let colorsForm = document.getElementById('colors-form');
                        if (colorsForm) { colorsForm.parentNode.removeChild(colorsForm);}
                        let inputs = document.querySelectorAll('#AF input, #AF textarea'); // Selecciona inputs y textareas dentro del formulario
                        inputs.forEach(function(input) { input.removeAttribute('onfocusout');});


                        //Ajusto posición de Formulario
                        if (afElement) { // Solo si AF existe
                            afElement.offsetHeight
                            const inps4 = afElement.querySelectorAll('.d-flex');
                            let suma = 0;
                            inps4.forEach (function(numero){
                                suma += numero.offsetHeight;
                            });
                            const formTitle = afElement.querySelector('#form-title');
                            if (formTitle) {
                                suma += formTitle.offsetHeight;
                            }

                            if(afElement.offsetHeight > suma){
                                afElement.classList.remove('content-start');
                            }else{
                                afElement.classList.add('content-start');
                            }
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
            console.log('goVideo: Intentando saltar a video con projectlib ID ' + projectlibid);
            const foundIndex = projectLibs.findIndex(element => element.id == projectlibid);
            if (foundIndex !== -1) {
                console.log('goVideo: Video encontrado en projectLibs en índice ' + foundIndex + '. Saltando...');
                // Si el video que se pide ya es el que se está reproduciendo, `setMainMedia` lo maneja
                currentProjectLibIndex = foundIndex; // Actualiza el índice del video actual
                setMainMedia(projectLibs[currentProjectLibIndex], true); // Carga y reproduce automáticamente
            } else {
                console.warn('goVideo: Video con projectlib ID ' + projectlibid + ' no encontrado en projectLibs. No se puede saltar.');
            }
        }

        // Ir a Url
        const goUrl = (url, option) => {
            console.log('goUrl: Abriendo URL externa ' + url + ' con opción ' + option);
            if (windows[url] && !windows[url].closed) {
                windows[url].focus();
            } else {
                windows[url] = window.open(url, option);
            }
            // Cuando un usuario es redirigido a una URL externa, consideramos el funnel terminado.
            showFinalScreen(); // Muestra la pantalla final
        };

        // Ir a Cuepoint
        const goCuepoint = (cuepointid) => {
            console.log('goCuepoint: Saltando a cuepoint con ID ' + cuepointid);
            const cue = cuePoints.find(c => c.id == cuepointid);
            if (cue) {
                console.log('Saltando a tiempo:'+cue.time)
                videoOn = document.getElementById('projectVideo');
                videoOn.currentTime = cue.time;
                videoOn.play();
                // Opcional: limpiar el contenedor de widgets si se salta a un cuepoint que no debería mostrarlo.
                // document.getElementById('widgetContainer').innerHTML = '';
            } else {
                console.warn('Cuepoint con ID ' + cuepointid + ' no encontrado.');
            }
        };


        // ___ OPTIONS WIDGETS ACTIONS
        // Opciones
        const listenOptionActions = (cuepoint,optionData) => {
            console.log('Option Actions: Escuchando clics en opciones');

            const optionCta = document.querySelectorAll('#widgetContainer > ul > li');
            optionCta.forEach(function(element) {
                element.addEventListener('click', function() {
                    console.log("Opción clicada.");
                    document.getElementById("widgetContainer").classList.remove('active');
                    const abElement = document.getElementById('AB');
                    if (abElement) {
                        abElement.classList.add('d-none');
                    }

                    let uuid = element.getAttribute('uuid');

                    const selectedOption = optionData.find(item => item.uuid == uuid);

                    if (selectedOption) {
                        console.log("Acción de opción seleccionada:", selectedOption);
                        if(selectedOption.type == "URL"){
                            console.log('Acción: URL');
                            goUrl(selectedOption.goto, selectedOption.options);
                            registerInteraction(
                                selectedOption.cuepointid,
                                cuepoint.cuepointname,
                                selectedOption.id,
                                selectedOption.name,
                                0,
                                getInteractionTagFromOption(selectedOption)
                            );
                        }
                        else if(selectedOption.type == "CUEPOINT"){
                            console.log('Acción: CUEPOINT');
                            goCuepoint(selectedOption.goto);
                            document.getElementById('widgetContainer').innerHTML = ''; // Limpia el contenedor después de la acción
                            registerInteraction(
                                selectedOption.cuepointid,
                                cuepoint.cuepointname,
                                selectedOption.id,
                                selectedOption.name,
                                0,
                                getInteractionTagFromOption(selectedOption)
                            );
                        }
                        else if(selectedOption.type == "VIDEO"){
                            console.log('Acción: VIDEO, intentando saltar a projectlib ID:', selectedOption.goto);
                            goVideo(selectedOption.goto);
                            document.getElementById('widgetContainer').innerHTML = ''; // Limpia el contenedor después de la acción
                            registerInteraction(
                                selectedOption.cuepointid,
                                cuepoint.cuepointname,
                                selectedOption.id,
                                selectedOption.name,
                                0,
                                getInteractionTagFromOption(selectedOption)
                            );
                        }
                    } else {
                        console.warn("No se encontró la opción con UUID:", uuid);
                    }
                });
            });
        }


        // ___ FORM WIDGETS ACTIONS
        // Form CTA
        const listenFormActions = (item) => {
            if (window.playFunnelDynamicListenFormActions) {
                return window.playFunnelDynamicListenFormActions(item);
            }

            const cta = document.getElementById('form-cta');
            if (!cta) {
                console.warn("Botón de CTA del formulario no encontrado.");
                return;
            }

            cta.addEventListener('click', function() {
                console.log("Botón de formulario clicado.");
                const formDataElement = document.getElementById('AF');
                if (!formDataElement) {
                    console.error("Elemento de formulario 'AF' no encontrado.");
                    return;
                }

                if(formDataElement.checkValidity()){
                    document.getElementById("widgetContainer").classList.remove('active');
                    formDataElement.classList.add('d-none');

                    // Envio de formulario
                    const inputs = formDataElement.querySelectorAll('.itemForm.d-flex');
                    const sendto = item.type_form.sendto;
                    const nameForm = item.type_form.name;
                    let crm = loadCrmField();
                    sendForm(inputs, sendto, nameForm, crm);

                    // Opciones de CTA del formulario
                    if(item.type_form.type == "URL"){
                        console.log('Formulario Acción: URL');
                        goUrl(item.type_form.goto, item.type_form.options);
                    }
                    else if(item.type_form.type == "CUEPOINT"){
                        console.log('Formulario Acción: Cuepoint');
                        goCuepoint(item.type_form.goto);
                        document.getElementById('widgetContainer').innerHTML = '';
                    }
                    else if(item.type_form.type == "VIDEO"){
                        console.log('Formulario Acción: Video');
                        goVideo(item.type_form.goto);
                        document.getElementById('widgetContainer').innerHTML = '';
                    }
                } else {
                    console.log("Formulario inválido. Por favor, revisa los campos.");
                    formDataElement.reportValidity(); // Muestra los mensajes de validación del navegador
                }
            });
        }


        // ___ FINAL DEL VIDEO (Lógica mejorada)
        const endVideoListen = function(){
            console.log('El video ha finalizado');
            const videoOn = document.getElementById('projectVideo');

            // Pausar para que el video se quede en el último frame
            if (videoOn) {
                videoOn.pause();
            }

            // Si hay un siguiente video en el array projectLibs
            if (currentProjectLibIndex < projectLibs.length - 1) {
                const nextProjectLib = projectLibs[currentProjectLibIndex + 1]; // Obtiene el siguiente SIN avanzar el índice aún

                // Nota: El cambio de poster temprano ya se realizó al inicio de la reproducción en handleVideoPlayForThumbnail.
                // Aquí solo necesitamos dar un pequeño retardo por si acaso y cargar el nuevo video.
                setTimeout(() => {
                    currentProjectLibIndex++; // Ahora sí, avanza al índice del siguiente video
                    setMainMedia(projectLibs[currentProjectLibIndex], true); // Carga y reproduce automáticamente el siguiente video
                    console.log('Reproduciendo siguiente video automáticamente:', projectLibs[currentProjectLibIndex].id);
                    registerInteraction(null, 'Video', null, projectLibs[currentProjectLibIndex].name, 0);
                }, 50); // Retardo de 50 milisegundos (ajustable si es necesario)

            } else {
                // Si es el último video, muestra la pantalla final del proyecto
                console.log('Es el último video del proyecto. Mostrando pantalla final.');
                showFinalScreen();
            }
        }

        // ___ FUNCIÓN DEDICADA: Mostrar Pantalla Final del Proyecto
        const showFinalScreen = () => {
            console.log('Mostrando pantalla final del proyecto.');
            const block_add = document.getElementById('blockAdd');
            if (block_add) {
                block_add.innerHTML = '';
                block_add.innerHTML = project.publish_div; // Asume que project.publish_div contiene el HTML de la pantalla final

                registerInteraction(null,'End',null,'End',1); // Registra que el proyecto ha finalizado

                // Limpieza de elementos que pueden ser de la vista de edición o preview
                const imgGetInView = document.getElementById("imgGetIn_view");
                if (imgGetInView) {
                    imgGetInView.remove();
                    console.log('Elemento #imgGetIn_view eliminado.');
                }
                const editPoster = document.querySelector(".edit-poster");
                if (editPoster) {
                    editPoster.remove();
                    console.log('Elemento .edit-poster eliminado.');
                }

                const titleEnd = document.querySelector('#title-end h2');
                if (titleEnd) {
                    titleEnd.removeAttribute('contenteditable');
                    console.log('Atributo contenteditable de #title-end h2 eliminado.');
                }
                const subtitleEnd = document.querySelector('#subtitle-end p');
                if (subtitleEnd) {
                    subtitleEnd.removeAttribute('contenteditable');
                    console.log('Atributo contenteditable de #subtitle-end p eliminado.');
                }
                const againButton = document.querySelector('.poster-end #again');
                if (againButton) {
                    againButton.removeAttribute('contenteditable');
                    console.log('Atributo contenteditable de .poster-end #again eliminado.');
                }

                // Event listener para el botón "Otra vez"
                const button = document.querySelector(".poster-end #again");
                if (button) {
                    button.addEventListener("click", (event) => {
                        console.log('Botón "Otra vez" clicado. Recargando página.');
                        document.location.href = document.location.href; // Recarga la página para reiniciar el proyecto
                    });
                }
            } else {
                console.error("Elemento #blockAdd no encontrado. No se puede mostrar la pantalla final.");
            }
        }


        // ___ PLAY VIDEO
        let conterWidgets = document.querySelector('.widgetContainer');
        document.querySelector(".playVideoEmbed").addEventListener("click", startPlay, false);
        let videoPlay = false;

        function startPlay() {
            const projectVideo = document.getElementById("projectVideo");
            if (projectVideo) {
                projectVideo.play().catch(error => {
                    console.error("Error al intentar reproducir el video al inicio:", error);
                    // Aquí podrías mostrar un mensaje al usuario para que haga clic si el autoplay fue bloqueado.
                });
                videoPlay = !videoPlay;
                registerInteraction(null, 'Video', null, 'Play', 0);
                const playVideoEmbed = document.querySelector(".playVideoEmbed");
                if (playVideoEmbed) {
                    playVideoEmbed.removeEventListener("click", startPlay, false);
                    playVideoEmbed.classList.add('pp');
                }
                playAndPause();
            } else {
                console.error("Elemento de video #projectVideo no encontrado.");
            }
        }

        const playAndPause = () => {
            const playVideoEmbed = document.querySelector(".playVideoEmbed");
            if (!playVideoEmbed) return;

            playVideoEmbed.addEventListener("click", () => {
                const projectVideo = document.getElementById("projectVideo");
                if (!projectVideo) return;

                if (!videoPlay) {
                    projectVideo.play().catch(error => {
                        console.error("Error al intentar reproducir el video:", error);
                    });
                    playVideoEmbed.classList.add('pp');
                } else {
                    projectVideo.pause();
                    playVideoEmbed.classList.remove('pp');
                }
                videoPlay = !videoPlay;
            }, false);
        };



        // ___ Registro de Interacciones
        // Registro
        function registerInteraction(cuepointid, cuepointname, cuepointoptionid, cuepointoptionname, interactiontype, cuepointtag) {
            // Solo registra la interacción si no estamos en modo preview
            if (!{{ session('preview') }}) {
                let form = new FormData();
                form.append('_token', "{{ csrf_token() }}");
                form.append('project', '{{ request()->get('project') }}'); // Asegúrate de que 'project' se pase correctamente

                form.append('cuepointid', cuepointid !== null ? cuepointid : -1);
                if (cuepointname !== null) form.append('cuepointname', cuepointname);
                if (cuepointoptionid !== null) form.append('cuepointoptionid', cuepointoptionid);
                if (cuepointoptionname !== null) form.append('cuepointoptionname', cuepointoptionname);
                if (cuepointtag !== null && cuepointtag !== undefined && cuepointtag !== '') form.append('cuepointtag', cuepointtag);
                form.append('interactiontype', interactiontype !== null ? interactiontype : 0);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'ajax-register-interaction', true);
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        console.log('Interacción registrada exitosamente.');
                    } else {
                        console.error("Error al registrar interacción (status): " + xhr.status + " - " + xhr.statusText);
                        // alert("Error ajax-register-interaction: " + xhr.statusText); // Comentado para evitar alerts en producción
                    }
                };
                xhr.onerror = function () {
                    console.error("Error de red al registrar interacción: " + xhr.statusText);
                    // alert("Error ajax-register-interaction: " + xhr.statusText); // Comentado para evitar alerts en producción
                };
                xhr.send(form);
            } else {
                console.log('Modo preview: No se registran interacciones.');
            }
        }


        // ___ Envio de Formulario
        // Send form
        function sendForm(inputs, sendto, nameForm, crm) {
            // Solo envía el formulario si no estamos en modo preview
            if (!{{session('preview')}}) {
                console.log('Enviando formulario...');
                const formData = new FormData();

                inputs.forEach(element => {
                    const inputElement = element.querySelector('input, textarea');
                    if (inputElement) {
                        let nameF = inputElement.name;
                        let valF = inputElement.value;
                        let labelElement = element.querySelector('label b');
                        let tagF = labelElement ? labelElement.innerHTML : nameF; // Usa el name si no hay etiqueta

                        formData.append(nameF, valF);
                        formData.append('tag' + nameF, tagF);
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
                        console.log('Formulario enviado exitosamente.');
                    } else {
                        console.error("Error al enviar formulario (status): " + xhr.status + " - " + xhr.statusText);
                        // alert("Error sendForm: " + xhr.statusText);
                    }
                };
                xhr.onerror = function () {
                    console.error("Error de red al enviar formulario: " + xhr.statusText);
                    // alert("Error sendForm: " + xhr.statusText);
                };
                xhr.send(formData);
            } else {
                console.log('Modo preview: Formulario no enviado.');
            }
        }


        // ___ Envio al CRM
        // Cargar Crm
        function  loadCrmField(){
            let form = document.querySelector('#AF');
            let crm = false; // Valor predeterminado
            if(form && form.hasAttribute('crm')){
                if(form.getAttribute('crm') == 'true'){
                    console.log('CRM habilitado para el formulario.');
                    crm = true;
                } else {
                    console.log('CRM deshabilitado para el formulario.');
                }
            } else {
                console.log('Atributo "crm" no encontrado en el formulario AF. CRM deshabilitado.');
            }
            return crm;
        }

        // Enviar Crm
        function sendCrm(formData) {
            console.log('Enviando datos al CRM...');
            // Asegúrate de que el ID del proyecto se añade
            formData.append('projectid', {{ $project->id }});
            // El token CSRF ya debería estar en formData si `sendForm` lo pasa,
            // pero si no, este es el lugar para agregarlo también.
            // formData.append('_token', "{{ csrf_token() }}"); // Ya se setea en sendFormRequestHeader

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'crm-register', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log('CRM: Datos enviados exitosamente.');
                } else {
                    console.error("Error al enviar al CRM (status): " + xhr.status + " - " + xhr.statusText);
                    // alert("Error al enviar crm-register: " + xhr.statusText);
                }
            };
            xhr.onerror = function () {
                    console.error("Error de red al enviar al CRM: " + xhr.statusText);
                    // alert("Error al enviar crm-register: " + xhr.statusText);
                };
                xhr.send(formData);
            }


            // ___ Versión Móvil
            // Mobileset
            function mobileSet() {
                const AB = document.getElementById('AB');
                if (!AB) {
                    console.warn("Elemento #AB no encontrado para mobileSet.");
                    return;
                }

                let sD = AB.getAttribute("data-desktop");
                if (sD) { // Asegurarse de que sD no sea null
                    AB.style.fontSize = sD + "px";
                }

                let fMobile = AB.getAttribute("data-mobile");

                let css = '@media screen and (max-width: 480px) {#AB {font-size:' + fMobile + 'px !important;}}';
                let head = document.head || document.getElementsByTagName('head')[0];
                let style = document.createElement('style');

                head.appendChild(style);

                style.type = 'text/css';
                if (style.styleSheet) {
                    // Esto es necesario para IE8 y anteriores.
                    style.styleSheet.cssText = css;
                } else {
                    style.appendChild(document.createTextNode(css));
                }
                console.log('Ajustes de estilo móvil aplicados.');
            }
        </script>
        <script src="js/form-builder-runtime.js"></script>
    </body>
</html>
