<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/Style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>{{__('step4.title')}}</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
    </head>

	<body class="bg-white">
	
    	@include('nav_bar_project')

    	{{ csrf_field() }}

        <?php
            session()->put("preview", 1);

            $codigo_proyeecto = $_GET['project'];
            if ($project->aspect == 'd-main') {
                $aspect = '56.25%';
            } elseif ($project->aspect == 'd-square') {
                $aspect = '100%';
            } elseif ($project->aspect == 'd-mobile') {
                $aspect = '177.8%';
            } else {
                $aspect = '56.25%';
            }

            $codigo_proyecto_encriptado = openssl_encrypt($codigo_proyeecto, $ciphering = 'AES-128-CTR', $encryption_key = 'PlayFunnel', $options = 0, $encryption_iv = '1234567891011121');
        ?>
        <!-------------------------------------MAIN------------------------------------------>
        <div class="container-fluid m-0 p-0 vh-100 ">
            <section class="step123 row col-12  mx-0 p-0 w-100">
                <div class="mainContainer col row p-0 m-0">
                    <!-----------------------------------------------------Left Menu-->
                    <!---------------------------------------------------------Main-->
                    <div class="mainContainer col row p-0 m-0">
                        <div class="main col m-0 p-0">
                            <div class="steps m-0 p-0 row">
                                <div class="progressbar-wrapper col-md-9 col-12">
                                    <div class="progressbar-wrapper progressbar-wrapper text-center "> {{ $project->name }}</div>
                                    <ul class="progressbar p-0 row mt-4 mt-md-1">
                                        <li class="active col-3" onclick="window.location.href='addVideo?project={{ $project->id }}';"> {{ __('step4.add_video') }}</li>
                                        <li class="active col-3" onclick="window.location.href='cuePoints?project={{ $project->id }}';"> {{ __('step4.create_cuepoints') }}</li>
                                        <li class="active col-3" onclick="window.location.href='actions?project={{ $project->id }}';"> {{ __('step4.cuepoint_actions') }}</li>
                                        <li class="active col-3" onclick="window.location.href='publish?project={{ $project->id }}';"> {{ __('step4.publish') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row justify-content-center blockAdd desktop poster d-none" >
                                <div class="addVideoMain contentIframe {{ $project->aspect }} prev" id="endVideoContent">
                                  @if ($project->publish_div)
                                    {!! $project->publish_div !!}
                                  @else
                                    <div class="d-flex poster-end flex-column align-items-center justify-content-center w-100">
                                      <button class="edit-poster"><i class="fas fa-pencil-alt"></i></button>
                                      <div id="resizable" class="resizable ui-widget-content content-image logo p-0 my-3">
                                        <button id='imgGetIn'></button>
                                        <img src="{{ $publish_library_img }}" class="img-fluid logoImg" alt="" id="endVideoimage">
                                        <input type="hidden" id="endVideoimageId" value="{{ $project->publish_library_img }}">
                                      </div>
                                      <div class="content-text p-0 flex-column align-items-center d-flex">
                                        <div class="context wysiwyg-content" id="title-end" >
                                          <h2 id="final_titulo_uno" contenteditable> Lorem, ipsum dolor sit amet consectetur adipisicing elit </h2>
                                        </div>
                                        <div class="context wysiwyg-content" id="subtitle-end" >
                                          <p id="final_titulo_dos" contenteditable> Lorem, ipsum dolor sit amet consectetur adipisicing elit </p>
                                        </div>
                                      </div>
                                      <button id="again" class="btn-square bg-Main cWhite px-3 mt-3">{{__('step4.play_again')}}</button>
                                    </div>
                                  @endif
                                </div>
                            </div>
                            <div id="landing_content">
                                @if ($project->landing_page)
                                    {!! $project->landing_page !!}
                                @else
                                    <div class="landing dark w-100 h-100 py-5" id="landing_page">
                                        <div class="w-50 content-data">
                                            <button class="edit-landing" onclick="edit_color('landing')"><i class="fas fa-pencil-alt"></i></button>
                                            <div id="resizable2" class="content-img ui-widget-content On logo" style="width: 96px; height: 76px;">
                                                <button id='imgGetIn_land'></button>
                                                <img src="{{ $publish_library_img }}" class="resizable logoImg" alt="" id="landImage" >
                                                <input class="img" type="hidden" id="land_imageId" value="{{ $project->publish_library_img }}">
                                            </div>
                                            <h1 class="my-4" id="titulo_uno" contenteditable>Lorem, ipsum dolor sit amet consectetur adipisicing elit</h1>
                                            <div class="embed-container" style=" position: relative; padding-bottom:56.25%; height: 0; overflow: hidden; border:none; border-radius: 24px">
                                                <?php
                                                    echo '<iframe id="embed_iframe" src="https://' . $_SERVER['HTTP_HOST'] . '/embed?project=' . $codigo_proyecto_encriptado . '&projectView=0" allow="camera *; microphone *; autoplay *; encrypted-media *; fullscreen *; display-capture *;" style="  position: absolute; top:0; left: 0; width: 100%;  height: 100%; border: none;"></iframe>';
                                                ?>
                                            </div>
                                            <div class="context wysiwyg-content">
                                                <p id="titulo_dos" contenteditable data-desktop="18" class="justify-content-center my-3" id="subtile-land">Lorem, ipsum dolor sit amet consectetur adipisicing elit</p>
                                            </div>
                                            <a id="cta_landing" class="cta mt-4 btn-square bg-01 cWhite px-5" href="https://www.google.com" contenteditable>click me</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="previewPanel p-0 m-0 row">
                                <ul class="devices d-flex m-0 mr-4 p-2 align-items-center">
                                    <li class="active m-0 p-2 desktop" data-id="desktop"><i class="fas fa-desktop c05"></i></li>
                                    <!--<li class="m-0 mx-3 p-2 table" data-id="table"><i class="fas fa-tablet-alt c05"></i></li>-->
                                    <li class="m-0 ml-3 p-2 mobile" data-id="mobile"><i class="fas fa-mobile-alt c05"></i></li>
                                </ul>
                                <button onclick="window.location.href='preview?project={{ $project->id }}';"class="btn-square bg-01 cWhite px-3 ml-3">{{ __('step4.preview') }}<i class="far fa-eye ml-2 py-0"></i></button>
                            </div>
                        </div>

                        <!---------------------------------------------------Right Menu-->
                        <div class="col-12 col-lg-4 bg-white p-0 m-0 rightMenu setup4 mt-md-0 mt-5">
                            <div class="titulo py-3 bg-01 px-0">
                                <h5 class="h5 text-center col-12 p-0 cWhite">{{ __('step4.publish_and_share') }}</h5>
                            </div>
                            <!--{{ csrf_field() }}
                                <input type="hidden" name="projectId"  id="projectId"  value="{{ $project->id }}">
                                <input type="hidden" name="libraryId"  id="libraryId"  value="">
                                <input type="hidden" name="cuepointId" id="cuepointId" value="">-->
                            <div class="p-3 p-lg-4 mb-5 publishPanel">
                                <h6>{{ __('step4.edit_views') }}</h6>
                                <hr class="my-2">
                                <div class="viewPanel d-flex p-0 bg-05 align-items-center justify-content-between m-0">
                                    <a id="share_page" class="py-3 col text-center active">{{ __('step4.landing_page') }}</a>
                                    <a id="final_view" class="py-3 col text-center">{{ __('step4.end') }}</a>
                                </div>
                                <hr class="my-2">
                                <h6>{{ __('step4.project_status') }}</h6>
                                <hr class="my-2">
                                <div class="activePanel d-flex p-0 bg-05 align-items-center justify-content-between m-0 py-3 px-3">
                                    <p class="m-0 p-0">{{ __('step4.active') }}</p>
                                    <label class="switch m-0 p-0">
                                        <input type="checkbox" id="activateProject" {{($project->project_status_id == 1 ? 'checked' : '')}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <hr class="my-2">
                                <div class="widgets col-12 p-0 m-0 pt-2">
                                    <h6>{{ __('step4.share') }}</h6>
                                    <hr class="my-2">
                                    <div id="accordion">
                                        <div class="card ">
                                            <div class="card-header p-0 py-2 px-3" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link p-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <p class="p-0 m-0">IFRAME</p>
                                                        <i class="fas fa-caret-square-down"></i>
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#accordion">
                                                <div class="card-body py-3 px-2">
                                                    <p class="description p-2 m-0">{{ __('step4.copy_to_share') }}</p>
                                                    <p class="linkBox p-2 m-0" id="iframeLink">
                                                        <?php
                                                        //$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
                                                            echo htmlentities(
                                                                '<div class="embed-container" style=" position: relative; padding-bottom:' . $aspect . '; height: 0; overflow: hidden; border:none; border-radius: 24px">
                                                                    <iframe src="https://' . $_SERVER['HTTP_HOST'] . '/embed?project=' . $codigo_proyecto_encriptado . '" allow="camera *; microphone *; autoplay *; encrypted-media *; fullscreen *; display-capture *;" style="  position: absolute; top:0; left: 0; width: 100%;  height: 100%; border: none;"></iframe>
                                                                 </div>'
                                                            );
                                                        ?>
                                                    </p>
                                                    <div class="cta pt-3">
                                                        <button id="copyIframe"class="btn-square bg-Main cWhite px-3">{{ __('step4.copy') }}</button></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="card">
                                            <div class="card-header p-0 py-2 px-3" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed p-0" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        <p class="p-0 m-0">{{ __('step4.direct_url') }}</p>
                                                        <i class="fas fa-caret-square-down"></i>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body py-3 px-2">
                                                    <p class="description p-2 m-0">{{ __('step4.copy_to_your_url') }}</p>
                                                    <p class="linkBox p-2 m-0" id="UrlLink">
                                                        <?php
                                                            echo 'https://' . $_SERVER['HTTP_HOST'] . '/embed?project=' . $codigo_proyecto_encriptado;
                                                        ?>
                                                    </p>
                                                    <div class="cta pt-3"><button id="copyUrl" class="btn-square bg-Main cWhite px-3">{{ __('step4.copy') }} </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="card">
                                            <div class="card-header p-0 py-2 px-3" id="headingThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed p-0" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        <p class="p-0 m-0">{{ __('step4.landing') }}</p>
                                                        <i class="fas fa-caret-square-down"></i>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="card-body py-3 px-2">
                                                    <p class="description p-2 m-0">{{ __('step4.copy_to_your_site') }}</p>
                                                    <p class="linkBox p-2 m-0" id="UrlLanding">
                                                        <?php
                                                        echo 'https://' . $_SERVER['HTTP_HOST'] . '/landing?project=' . $codigo_proyecto_encriptado;
                                                        ?>
                                                    </p>
                                                    <div class="cta pt-3"><button id="copyLanding" class="btn-square bg-Main cWhite px-3">{{ __('step4.copy') }} </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                    </div>
                                </div>
                                <div class="col-12 next d-flex justify-content-center">
                                    <button class="btn-square bg-Main cWhite px-3"> <i class="fas fa-caret-square-right mr-2"></i>{{ __('step4.publish') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!----------------------------------EDIT OPTION TOOL SIDE PANEL --------------------->
        <div class="toolOptionEdit d-none" draggable="true" id="toolOptionEdit">
            <div class="toolOptionEditClose"></div>
            <div class="OptionsEdit">
                <a class="closeM cWhite" href="#">
                    <i class="fas fa-times"></i>
                </a>
                <p class="p-0 m-0 mr-2">{{ __('step4.button') }}:</p>
                <div class="name d-flex  justify-content-betwee align-items-center w-100">
                    <input class="px-2 col text-left" type="text" id="cta-poster" placeholder="Nombre de la opciÃ³n">
                </div>
                <div class="href d-flex  justify-content-betwee align-items-center w-100">
                    <span>Destino:</span>
                    <input class="ml-3 px-2 col text-left" type="text" id="cta-href" placeholder="https://www.myhomepage.com">
                </div>
                <div class="colores d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span>Fondo:</span>
                        <input class="mx-2" type="color" id="colorpicker-cta-poster" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55">
                        <input class="" type="text" class="p-2" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-cta-poster">
                    </div>
                    <div class="d-flex align-items-center">
                        <span>Texto:</span>
                        <input class="mx-2" type="color" id="colorpickerFont-cta-poster" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55">
                        <input class="" type="text" class="p-2" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-cta-poster">
                    </div>
                </div>
                <!--END ACCION-->

                <hr class="my-2">
                <div class="d-flex color align-items-center justify-content-between p-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="m-0 p-0">{{ __('step4.background') }}:</p>
                        <input class="mx-2" type="color" id="colorpickerBG-poster" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55">
                        <input class="" type="text" class="p-2" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorBG-poster">
                    </div>
                </div>
                <hr class="my-2">
                <div class="d-flex color align-items-center justify-content-between">
                    <p class="m-0 p-0">{{ __('step4.title1') }}:</p>
                    <div class="d-flex color align-items-center justify-content-between">
                        <input class="mx-2" type="color" id="colorpickerFont-title-poster" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55">
                        <input class="" type="text" class="p-2" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-title-poster">
                        <div class="d-flex align-items-center justify-content-end ml-5">
                            <i class="fas fa-text-height"></i><input class="ml-1" id="fontNumber-title-poster" type="number" value="32">
                        </div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="d-flex color align-items-center justify-content-between">
                    <p class="m-0 p-0">{{ __('step4.title2') }}:</p>
                    <div class="d-flex color align-items-center justify-content-between">
                        <input class="mx-2" type="color" id="colorpickerFont-des-poster" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55">
                        <input class="" type="text" class="p-2" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-des-poster">
                        <div class="d-flex align-items-center justify-content-end ml-5">
                            <i class="fas fa-text-height"></i><input class="ml-1" id="fontNumber-des-poster" type="number" value="16">
                        </div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="activePanel d-flex p-0 m-0 align-items-center justify-content-between">
                    <p class="m-0 p-0 mr-3">{{ __('step4.image') }}:</p>
                    <label class="switch m-0 p-0 switch-poster-image">
                        <input type="checkbox" id="toolbox_img" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
                <hr class="my-2">

                <div class="activePanel d-flex p-0 m-0 align-items-center justify-content-between">
                    <p class="m-0 p-0 mr-3">{{ __('step4.title1') }}:</p>
                    <label class="switch m-0 p-0 switch-poster-title">
                        <input type="checkbox" id="toolbox_titulo_uno" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
                <hr class="my-2">

                <div class="activePanel d-flex p-0 m-0 align-items-center justify-content-between">
                    <p class="m-0 p-0 mr-3">{{ __('step4.title2') }}:</p>
                    <label class="switch m-0 p-0 switch-poster-title2">
                        <input type="checkbox" id="toolbox_titulo_dos" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
                <hr class="my-2">

                <div class="activePanel d-flex p-0 m-0 align-items-center justify-content-between">
                    <p class="m-0 p-0 mr-3">{{ __('step4.button') }}:</p>
                    <label class="switch m-0 p-0 switch-poster-cta">
                        <input type="checkbox"  id="toolbox_boton" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        
        <x-manage-library :library="$library" :user="$user" />
        <x-messages/>


        <!--END CONTAINER-->

        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script src="js/Sortable.js"></script>
    
        <script>
            window.onload = function() {
    
            	window.addEventListener("beforeunload", function(e) {
                    if (!existsChanges()) {
                        return undefined;
                    }
    
                    var confirmationMessage = 'It looks like you have been editing something. If you leave before saving, your changes will be lost.';
    
                    (e || window.event).returnValue = confirmationMessage; //Gecko + IE
                    return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
                });
    
                    
            	// Obtener los elementos por ID
                const sharePage = document.getElementById('share_page');
                const finalView = document.getElementById('final_view');
                const landing = document.querySelector('#landing_content');
                const poster = document.querySelector('.poster');
    
                // FunciÃ³n para manejar el clic en share_page
                sharePage.addEventListener('click', function() {
                    sharePage.classList.add('active');
                    finalView.classList.remove('active');
                    landing.classList.remove('d-none');
                    poster.classList.add('d-none');
                });
    
                // FunciÃ³n para manejar el clic en final_view
                finalView.addEventListener('click', function() {
                    finalView.classList.add('active');
                    sharePage.classList.remove('active');
                    poster.classList.remove('d-none');
                    landing.classList.add('d-none');
                    resizeAddmedia();
                });
    
                
    
                //remove desktop in mobile version
                var x = window.matchMedia("(max-width: 700px)")
                myFunction(x) // Call listener function at run time
                x.addListener(myFunction) // Attach listener function on state changes
    
                $("#copyIframe").click(function() {
                    copyToClipBoard("iframe");
                });
    
                $("#copyUrl").click(function() {
                    copyToClipBoard("url");
                });
    
                $("#copyLanding").click(function() {
                    copyToClipBoard("landing");
                });

                $("#imgGetIn_view").on("click", function() {
                	targetImg('view');
                });
                $("#imgGetIn_land").on("click", function() {
                	targetImg('land');
                });
    
              	//INICIO TOOLBOX
        		//Boton
        		monitorClick($('#toolbox_boton'));
        		monitorChange($('#cta-poster'));
        		monitorInput($('#cta_landing'));
        		monitorChange($('#cta-href'));
        		monitorChange($('#colorpicker-cta-poster'));
        		monitorChange($('#hexcolor-cta-poster'));
        		monitorChange($('#colorpickerFont-cta-poster'));
        		monitorChange($('#hexcolorFont-cta-poster'));
    
        		//Color BackGround
        		monitorChange($('#colorpickerBG-poster'));
        		monitorChange($('#hexcolorBG-poster'));
    
        		//Color-Tamaño Titulo Uno
        		monitorClick($('#toolbox_titulo_uno'));
        		monitorChange($('#colorpickerFont-title-poster'));
        		monitorChange($('#hexcolorFont-title-poster'));
        		monitorChange($('#fontNumber-title-poster'));
    
              	//Color-Tamaño Titulo Dos
              	monitorClick($('#toolbox_titulo_dos'));
        		monitorChange($('#colorpickerFont-des-poster'));
        		monitorChange($('#hexcolorFont-des-poster'));
        		monitorChange($('#fontNumber-des-poster'));
    
        		//Imagen
        		monitorClick($('#toolbox_img'));
    
              	//FIN TOOLBOX
    
              	//Landing Page
                monitorInput($('#titulo_uno'));
                monitorInput($('#titulo_dos'));
    
                //Final View
                monitorInput($('#final_titulo_uno'));
                monitorInput($('#final_titulo_dos'));
    
                monitorClick($('#activateProject'));
    
                $( "#final_view" ).on("click", function() {
                    console.log('click on : final_view');
                	//setProjectChanged();
                });
    
                $( "#share_page" ).on("click", function() {
                	console.log('click on : share_page');
                	//setProjectChanged();
                });
    
                $("#guardarHeader").click(boton_guardar);
                $("#guardarHeaderMobile").click(boton_guardar);
            };
    
            var projectChanged = false;
    
            function setProjectChanged(){
            	projectChanged = true;
            	console.log("setProjectChanged(): " + projectChanged);
            }
    
            function existsChanges() {
                console.log("existsChanges(): " + projectChanged);
                return projectChanged;
            }
    
            function monitorClick(objeto) {
    			objeto.on('click', function() {
    				console.log('monitorClick() : ' + objeto.attr('id'));
                	setProjectChanged();
                });
        	}
    
    		function monitorChange(objeto) {
    			objeto.on('change', function() {
    				console.log('monitorChange() : ' + objeto.attr('id'));
                	setProjectChanged();
                });
        	}
    
    		function monitorInput(objeto) {
    			objeto.on('input', function() {
    				console.log('monitorInput(): ' + objeto.attr('id'));
                	setProjectChanged();
                });
        	}
    
            function copyToClipBoard(type) {
                if (type == "iframe") {
                    $("#iframeLink").text();
                    navigator.clipboard.writeText($("#iframeLink").text());
                    modalMsgShow("iframe copiado en portapapeles");
    
                } else if (type == "url") {
                    $("#UrlLink").text();
                    navigator.clipboard.writeText($("#UrlLink").text());
                    modalMsgShow("URL copiada en portapapeles");
                }else if (type == "landing") {
                    $("#UrlLink").text();
                    navigator.clipboard.writeText($("#UrlLanding").text());
                    modalMsgShow("URL copiada en portapapeles");
                }
            }
    

    
            let target_img = "";
    
            function targetImg(target) {
            	console.log("targetImg() target: " + target);
                $('#libraryModal').modal('show');
                
                target_img = '#imgGetIn_' + target;
            }
            
    
            
            function selectImageMedia() {
                console.log("selectImageMedia()");
                var blnSelected = false;
    
                $('#libraryModal input[type=checkbox]').each(function() {
                    console.log("this");
                    if (this.checked) {
                        var name = $(this).attr("name");
                        console.log("Seleccionado: " + name)
    
                        var mediaId = $(this).parent().next().attr("media-id");
                        var mediaSrc = $(this).parent().next().attr("media-src");
                        var mediaImg = $(this).parent().next().attr("src");
    
                        blnSelected = true;
                        $(this).prop("checked", false);
                        $(this).parent().removeClass('selected');
    
                        console.log("mediaSrc: " + mediaSrc);
                        console.log('*****TARGET ES:' + target_img);
                        let target_path = $(target_img).parent().find('img');
                        let target_input = $(target_img).parent().find('input');
                        console.log(target_path);
                        console.log(target_input);
                        target_path.attr("src", mediaSrc);
                        target_input.val(name);
                        $('#endVideoimageId').val(name);
                        setProjectChanged();
                    }
                });
    
                if (blnSelected) {
                    $('#libraryModal').modal('hide');
                }
            }
    
    
    
            function boton_guardar() {
                console.log("boton_guardar(): linea <?= __LINE__ - 1 ?>");
    
                if (!existsChanges()) {
                    console.log("boton_guardar(): no hay cambios");
                    ProjectModalSave(false);
                    return;
                }
    
                var form = new FormData();
                form.append('_token', 	 	  $("input[name=_token]").val());
                form.append('projectid',      <?= $_REQUEST['project'] ?>);
                form.append('landing_page',   $('#landing_content').html());
                form.append('publish_div',    $('#endVideoContent').html());
                form.append('project_status', $('#activateProject').is(':checked'));
                form.append('publish_library_img', $('#endVideoimageId').val());
                form.append('landing_library_img', $('#land_imageId').val());
    
                $.ajax({
                    url: '/ajax-setPublishData',
                    type: 'POST',
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == 'Y') {
                            ProjectModalSave(true);
                            projectChanged =false;
                            console.log('ajax-setPublishData() OK');
                            $( '#embed_iframe' ).attr( 'src', function ( i, val ) { return val; });
                        }
                        if (response.success == 'N') {
                            console.log("Error: " + response.message)
                            modalMsgShow("Error: " + response.message);
                        }
                    },
                    error: function(request, error) {
                        console.log(error);
                        console.log(request);
                        modalMsgShow("Error: " + JSON.stringify(error));
                    }
            	});
    		}
    
    
    
            function resizeAddmedia() {
    
                //POSTER
                if ($(".addVideoMain").parent().hasClass("desktop")) {
                    console.log("tiene Desktop)");
                    var ds = $(".addVideoMain").parent().css("width").slice(0, -2);
                    var ds1 = ds / 1.777;
                    $(".addVideoMain").parent().css("height", ds1 + "px");
                } else if ($(".addVideoMain").parent().hasClass("mobile")) {
                    console.log("tiene Mobile)");
                    var ds = $(".addVideoMain").parent().css("width").slice(0, -2);
                    var ds1 = ds * 1.777;
                    $(".addVideoMain").parent().css("height", ds1 + "px");
                }
    
                if ($(".addVideoMain").hasClass("d-main")) {
                    if ($(".addVideoMain").parent().hasClass("desktop")) {
                        console.log("clase main");
                        //$(".d-main").css("max-width","80%")
                        var cs = $(".d-main").css("width").slice(0, -2);
                        console.log("w=" + cs);
                        var cs1 = cs / 1.777;
                        console.log("cs1=" + cs1);
                        $(".d-main").css("height", cs1 + "px");
                        console.log("h=" + cs1);
                    } else if ($(".addVideoMain").parent().hasClass("mobile")) {
                        console.log("clase main");
                        //$(".d-main").css("max-width","80%")
                        var cs = $(".d-main").css("width").slice(0, -2);
                        console.log("w=" + cs);
                        var cs1 = cs / 1.777;
                        //console.log("cs1="+cs1);
                        $(".d-main").css("height", cs1 + "px");
                        //console.log("h="+cs1);
                        $(".mobile").css("height", "fit-content");
                    }
                    /*
                    console.log("clase main");
                    //$(".d-main").css("max-width","80%")
                    var cs = $(".d-main").css("width").slice(0,-2);
                    console.log("w="+cs);
                    var cs1 = cs/1.777;
                    console.log("cs1="+cs1);
                    $(".d-main").css("height",cs1+"px");
                    console.log("h="+cs1);
                    */
                }
    
                if ($(".addVideoMain").hasClass("d-mobile")) {
                    if ($(".addVideoMain").parent().hasClass("desktop")) {
                        $(".d-mobile").css("height", "100%");
                        var ms = $(".d-mobile").css("height").slice(0, -2);
                        var ms1 = ms / 1.777;
                        $(".d-mobile").css("width", ms1 + "px");
                    } else if ($(".addVideoMain").parent().hasClass("mobile")) {
                        $(".d-mobile").css("width", "100%");
                        var ms = $(".d-mobile").css("width").slice(0, -2);
                        var ms1 = ms * 1.777;
                        $(".d-mobile").css("height", ms1 + "px");
                        $(".mobile").css("height", "fit-content");
                    }
                }
                if ($(".addVideoMain").hasClass("d-square")) {
                    if ($(".addVideoMain").parent().hasClass("desktop")) {
                        $(".d-square").css("height", "100%");
                        console.log("clase square-desktop");
                        var qs = $(".d-square").css("height").slice(0, -2);
                        console.log("w=" + qs);
                        var qs1 = qs;
                        $(".d-square").css("width", qs1 + "px");
                        console.log("h=" + qs1);
                    } else if ($(".addVideoMain").parent().hasClass("mobile")) {
                        $(".d-square").css("width", "100%");
                        console.log("clase square-mobile");
                        var qs = $(".d-square").css("width").slice(0, -2);
                        console.log("h=" + qs);
                        var qs1 = qs;
                        $(".d-square").css("height", qs1 + "px");
                        $(".mobile").css("height", "fit-content");
                        console.log("w=" + qs1);
                    }
                }
            }
    
    
            $(window).resize(function() {
                resizeAddmedia();
            });
    
            // Declaro vista que se esta editando.
            let current_view = 'landing';
    
            // LLamo a la ventana de ediciÃ³n
            const edit_color = (view) => {
                $("body").css("overflow", "hidden");
                if (view == 'view') {
                    getViewEdit();
                    current_view = 'view';
                }
                if (view == 'landing') {
                    getLandingEdit();
                    current_view = 'landing';
                }
    
                $("#toolOptionEdit").removeClass("d-none");
                $("#toolOptionEdit").show(500);
            }
    
    
            $(".closeM").on("click", function() {
                $("body").css("overflow", "initial");
                $("#toolOptionEdit").hide(500);
                $("body").css("overflow", "initial");
            });
    
            $("#toolOptionEdit .toolOptionEditClose").on("click", function() {
                $("#toolOptionEdit").hide(500);
                $("body").css("overflow", "initial");
            });
    
            /*-----------------------------------------------------------------------------EDIT POSTER SET*/
    
            // #CTA
            $(".switch-poster-cta").find("input").change(function() {
                //console.log("cambio");
                if ($(".switch-poster-cta input").is(':checked')) {
                    //console.log("on");
                    if (current_view == 'view') {
                        $("#again").addClass("On");
                        $("#again").removeClass("Off");
                    }
                    if (current_view == 'landing') {
                        $("#cta_landing").addClass("On");
                        $("#cta_landing").removeClass("Off");
                    }
                } else {
                    if (current_view == 'view') {
                        $("#again").removeClass("On");
                        $("#again").addClass("Off");
                    }
                    if (current_view == 'landing') {
                        $("#cta_landing").removeClass("On");
                        $("#cta_landing").addClass("Off");
                    }
                }
    
            });
    
            // #Text
            $("#toolOptionEdit #cta-poster").on('input', function() {
                console.log(current_view);
                if (current_view == 'view') {
                    $("#again").text($("#cta-poster").val());
                }
                if (current_view == 'landing') {
                    $("#cta_landing").text($("#cta-poster").val());
                }
            });
    
            // href
            $("#toolOptionEdit #cta-href").on('input', function() {
    
                if (current_view == 'landing') {
                    $("#cta_landing").attr("href", $("#toolOptionEdit #cta-href").val());
                }
            });
    
            // #Color BG CTA
            // picker
            $("#toolOptionEdit #colorpicker-cta-poster").on('input', function() {
                //console.log(current_view);
                if (current_view == 'view') {
                    var hex = $("#toolOptionEdit #colorpicker-cta-poster").val();
                    $(".poster-end #again").css('background-color', hex);
                }
                if (current_view == 'landing') {
                    var hex = $("#toolOptionEdit #colorpicker-cta-poster").val();
                    $("#cta_landing").css('background-color', hex);
                }
            });
    
            // hexa
            $("#toolOptionEdit #hexcolor-cta-poster").on('input', function() {
                if (current_view == 'view') {
                    var color = $("#toolOptionEdit #hexcolor-cta-poster").val();
                    $(".poster-end #again").css('background-color', color);
                }
                if (current_view == 'landing') {
                    var color = $("#toolOptionEdit #hexcolor-cta-poster").val();
                    $("#cta_landing").css('background-color', color);
                }
            });
    
            // sincro hexa-picker
            $('#colorpicker-cta-poster').on('input', function() {
                $('#hexcolor-cta-poster').val(this.value);
            });
            $('#hexcolor-cta-poster').on('input', function() {
                $('#colorpicker-cta-poster').val(this.value);
            });
    
    
    
    
            // #Color Fuente
            // picker
            $("#toolOptionEdit #colorpickerFont-cta-poster").change(function() {
                if (current_view == 'view') {
                    var picker2 = $("#toolOptionEdit #colorpickerFont-cta-poster").val();
                    $(".poster-end #again").css('color', picker2);
                }
                if (current_view == 'landing') {
                    var picker2 = $("#toolOptionEdit #colorpickerFont-cta-poster").val();
                    $("#cta_landing").css('color', picker2);
                }
            });
    
            // hexa
            $("#toolOptionEdit #hexcolorFont-cta-poster").change(function() {
                if (current_view == 'view') {
                    var hex2 = $("#toolOptionEdit #hexcolorFont-cta-poster").val();
                    $(".poster-end #again").css('color', hex2);
                }
                if (current_view == 'landing') {
                    var hex2 = $("#toolOptionEdit #hexcolorFont-cta-poster").val();
                    $("#cta_landing").css('color', hex2);
                }
            });
    
            // sincro hexa-picker
            $('#colorpickerFont-cta-poster').on('input', function() {
                $('#hexcolorFont-cta-poster').val(this.value);
            });
            $('#hexcolorFont-cta-poster').on('input', function() {
                $('#colorpickerFont-cta-poster').val(this.value);
            });
    
    
    
            // #Image / logo
            $(".switch-poster-image").find("input").change(function() {
                //console.log("cambio");
                if ($(".switch-poster-image input").is(':checked')) {
                    //console.log("on");
                    if (current_view == 'view') {
                        $(".poster .logo").addClass("On");
                        $(".poster .logo").removeClass("Off");
                    }
                    if (current_view == 'landing') {
                        $(".landing .logo").addClass("On");
                        $(".landing .logo").removeClass("Off");
                    }
                } else {
                    if (current_view == 'view') {
                        $(".poster .logo").removeClass("On");
                        $(".poster .logo").addClass("Off");
                    }
                    if (current_view == 'landing') {
                        $(".landing .logo").removeClass("On");
                        $(".landing .logo").addClass("Off");
                    }
                }
    
            });
    
    
    
            // #Backgroud
            // hexa
            $("#toolOptionEdit #hexcolorBG-poster").change(function() {
                if (current_view == 'view') {
                    var hex = $("#toolOptionEdit #hexcolorBG-poster").val();
                    $(".poster-end").css('background-color', hex);
                }
                if (current_view == 'landing') {
                    var hex = $("#toolOptionEdit #hexcolorBG-poster").val();
                    $(".landing").css('background-color', hex)
                }
            });
            // picker
            $("#toolOptionEdit #colorpickerBG-poster").change(function() {
                if (current_view == 'view') {
                    var color = $("#toolOptionEdit #colorpickerBG-poster").val();
                    $(".poster-end").css('background-color', color);
                }
                if (current_view == 'landing') {
                    var color = $("#toolOptionEdit #colorpickerBG-poster").val();
                    $(".landing").css('background-color', color);
                }
            });
            // sincro hexa-picker
            $('#colorpickerBG-poster').on('input', function() {
                $('#hexcolorBG-poster').val(this.value);
            });
            $('#hexcolorBG-poster').on('input', function() {
                $('#colorpickerBG-poster').val(this.value);
            });
    
    
    
            // #Title
            $(".switch-poster-title").find("input").change(function() {
                //console.log("cambio");
                if ($(".switch-poster-title input").is(':checked')) {
                    //console.log("on");
                    if (current_view == 'view') {
                        $(".poster h2").addClass("On");
                        $(".poster h2").removeClass("Off");
                    }
                    if (current_view == 'landing') {
                        $(".landing h1").addClass("On");
                        $(".landing h1").removeClass("Off");
                    }
                } else {
                    if (current_view == 'view') {
                        $(".poster h2").removeClass("On");
                        $(".poster h2").addClass("Off");
                    }
                    if (current_view == 'landing') {
                        $(".landing h1").removeClass("On");
                        $(".landing h1").addClass("Off");
                    }
                }
    
            });
            // picker
            $("#toolOptionEdit #colorpickerFont-title-poster").change(function() {
                if (current_view == 'view') {
                    var picker = $("#toolOptionEdit #colorpickerFont-title-poster").val();
                    $(".poster-end #title-end").css('color', picker);
                }
                if (current_view == 'landing') {
                    var picker = $("#toolOptionEdit #colorpickerFont-title-poster").val();
                    $(".landing h1").css('color', picker);
                }
            });
            // hexa
            $("#toolOptionEdit #hexcolorFont-title-poster").change(function() {
                if (current_view == 'view') {
                    var hex = $("#toolOptionEdit #hexcolorFont-title-poster").val();
                    $(".poster-end #title-end").css('color', hex);
                }
                if (current_view == 'landing') {
                    var hex = $("#toolOptionEdit #hexcolorFont-title-poster").val();
                    $(".landing h1").css('color', hex);
                }
            });
    
            $('#colorpickerFont-title-poster').on('input', function() {
                $('#hexcolorFont-title-poster').val(this.value);
            });
            $('#hexcolorFont-title-poster').on('input', function() {
                $('#colorpickerFont-title-poster').val(this.value);
            });
    
    
            // #Title size
            $("#fontNumber-title-poster").change(function() {
    
                if (current_view == 'view') {
                    var fontN = $("#fontNumber-title-poster").val();
                    $("#title-end h2").attr("data-desktop", fontN);
                    var sD = $("#title-end h2").attr("data-desktop");
                    $("#title-end h2").css("font-size", sD + "px");
                }
                if (current_view == 'landing') {
                    var fontN = $("#fontNumber-title-poster").val();
                    $(".landing h1").attr("data-desktop", fontN);
                    var sD = $(".landing h1").attr("data-desktop");
                    $(".landing h1").css("font-size", sD + "px");
                }
            });
    
            // #description
            $(".switch-poster-title2").find("input").change(function() {
                //console.log("cambio");
                if ($(".switch-poster-title2 input").is(':checked')) {
                    //console.log("on");
                    if (current_view == 'view') {
                        $(".poster p").addClass("On");
                        $(".poster p").removeClass("Off");
                    }
                    if (current_view == 'landing') {
                        $(".landing p").addClass("On");
                        $(".landing p").removeClass("Off");
                    }
                } else {
                    if (current_view == 'view') {
                        $(".poster p").removeClass("On");
                        $(".poster p").addClass("Off");
                    }
                    if (current_view == 'landing') {
                        $(".landing p").removeClass("On");
                        $(".landing p").addClass("Off");
                    }
                }
    
            });
            //color
            $("#toolOptionEdit #colorpickerFont-des-poster").change(function() {
                if (current_view == 'view') {
                    var hex = $("#toolOptionEdit #colorpickerFont-des-poster").val();
                    $(".poster-end #subtitle-end").css('color', hex);
                }
                if (current_view == 'landing') {
                    var hex = $("#toolOptionEdit #colorpickerFont-des-poster").val();
                    $(".landing p").css('color', hex);
                }
            });
    
            $("#toolOptionEdit #hexcolorFont-des-poster").change(function() {
                if (current_view == 'view') {
                    var color = $("#toolOptionEdit #hexcolorFont-des-poster").val();
                    $(".poster-end #subtitle-end").css('color', color);
                }
                if (current_view == 'landing') {
                    var color = $("#toolOptionEdit #hexcolorFont-des-poster").val();
                    $(".landing p").css('color', color);
                }
            });
    
            $('#colorpickerFont-des-poster').on('input', function() {
                $('#hexcolorFont-des-poster').val(this.value);
            });
    
            $('#hexcolorFont-des-poster').on('input', function() {
                $('#colorpickerFont-des-poster').val(this.value);
            });
    
            //font
            $("#fontNumber-des-poster").change(function() {
                if (current_view == 'view') {
                    var fontN = $("#fontNumber-des-poster").val();
                    //console.log("la fuente es: "+fontN);
                    $("#subtitle-end p").attr("data-desktop", fontN);
                    var sD = $("#subtitle-end p").attr("data-desktop");
                    $("#subtitle-end p").css("font-size", sD + "px");
                }
                if (current_view == 'landing') {
                    var fontN = $("#fontNumber-des-poster").val();
                    //console.log("la fuente es: "+fontN);
                    $(".landing p").attr("data-desktop", fontN);
                    var sD = $(".landing p").attr("data-desktop");
                    $(".landing p").css("font-size", sD + "px");
                }
            });
    

            /*media query*/
            function myFunction(x) {
                if (x.matches) { // If media query matches
                    $(".previewPanel .devices li.mobile").click();
                    $(".previewPanel .devices li.desktop").hide();
                } else {
                    $(".previewPanel .devices li.desktop").show();
                    $(".previewPanel .devices li.desktop").click();
                }
            }
            
    
    
    
            /*-----------------------------------------------------------------------------EDIT POSTER GET*/
            function getViewEdit() {
                //cta
                if ($(".poster #again").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-cta input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-cta input").prop("checked", false);
                }

                //href
                $("#cta-href").attr('disabled', true);

                //color-bg
                var bgCta = $('#again').css('backgroundColor');
                $("#hexcolor-cta-poster").val(RgbaTohex(bgCta));
                var ctaHex = $("#hexcolor-cta-poster").val();
                $('#toolOptionEdit #colorpicker-cta-poster').val(ctaHex.toString());

                //color-font
                var fontCta = $('#again').css('color');
                $("#hexcolorFont-cta-poster").val(RgbaTohex(fontCta));
                var ctaFontHex = $("#hexcolorFont-cta-poster").val();
                $('#toolOptionEdit #colorpickerFont-cta-poster').val(ctaFontHex.toString());
                //text
                $("#cta-poster").val($("#again").text());

                //image
                if ($(".poster .logo").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-image input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-image input").prop("checked", false);
                }

                //background
                var bgPoster = $('.poster-end').css('backgroundColor');
                $("#toolOptionEdit #hexcolorBG-poster").val(RgbaTohex(bgPoster));
                var bgPosterHex = $("#toolOptionEdit #hexcolorBG-poster").val();

                //console.log(bgPosterHex);
                $('#colorpickerBG-poster').val(bgPosterHex.toString());

                //title
                if ($(".poster h2").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-title input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-title input").prop("checked", false);
                }
                //load
                $(".content-text h2").css("font-size", $(".content-text h2").css("font-size"));

                //color
                var bgPoster = $('.poster-end #title-end').css('color');
                $("#hexcolorFont-title-poster").val(RgbaTohex(bgPoster));
                var titleHex = $("#hexcolorFont-title-poster").val();
                //console.log(titleHex+"titl2");
                $('#toolOptionEdit #colorpickerFont-title-poster').val(titleHex.toString());
                //font-size
                $("#fontNumber-title-poster").val($('.poster-end #title-end h2').css("font-size").slice(0, -2));


                //des
                //load
                //subtitle
                if ($(".poster p").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-title2 input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-title2 input").prop("checked", false);
                }

                $(".content-text p").css("font-size", $(".content-text p").css("font-size"));
                //color
                var bgPoster = $('.poster-end #subtitle-end').css('color');
                $("#hexcolorFont-des-poster").val(RgbaTohex(bgPoster));
                var titleHex = $("#hexcolorFont-des-poster").val();
                //console.log(titleHex+"titl2");
                $('#toolOptionEdit #colorpickerFont-des-poster').val(titleHex.toString());
                //font-size
                $("#fontNumber-des-poster").val($('.poster-end #subtitle-end p').css("font-size").slice(0, -2));

            }
            
            /*
            function getViewEdit() {
                //cta
                if ($(".poster #again").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-cta input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-cta input").prop("checked", false);
                }
    
                //href
                $("#cta-href").attr('disabled', true);
    
                //color-bg
                var bgCta = $('#again').css('backgroundColor');
                $("#hexcolor-cta-poster").val(RgbaTohex(bgCta));
                var ctaHex = $("#hexcolor-cta-poster").val();
                $('#toolOptionEdit #colorpicker-cta-poster').val(ctaHex.toString());
    
                //color-font
                var fontCta = $('#again').css('color');
                $("#hexcolorFont-cta-poster").val(RgbaTohex(fontCta));
                var ctaFontHex = $("#hexcolorFont-cta-poster").val();
                $('#toolOptionEdit #colorpickerFont-cta-poster').val(ctaFontHex.toString());
                //text
                $("#cta-poster").val($("#again").text());
    
                //image
                if ($(".poster .logo").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-image input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-image input").prop("checked", false);
                }
    
                //background
                var bgPoster = $('.poster-end').css('backgroundColor');
                $("#toolOptionEdit #hexcolorBG-poster").val(RgbaTohex(bgPoster));
                var bgPosterHex = $("#toolOptionEdit #hexcolorBG-poster").val();
    
                //console.log(bgPosterHex);
                $('#colorpickerBG-poster').val(bgPosterHex.toString());
    
                //title
                if ($(".poster h2").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-title input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-title input").prop("checked", false);
                }
                //load
                $(".content-text h2").css("font-size", $(".content-text h2").css("font-size"));
    
                //color
                var bgPoster = $('.poster-end #title-end').css('color');
                $("#hexcolorFont-title-poster").val(RgbaTohex(bgPoster));
                var titleHex = $("#hexcolorFont-title-poster").val();
                //console.log(titleHex+"titl2");
                $('#toolOptionEdit #colorpickerFont-title-poster').val(titleHex.toString());
                //font-size
                $("#fontNumber-title-poster").val($('.poster-end #title-end h2').css("font-size").slice(0, -2));
    
    
                //des
                //load
                //subtitle
                if ($(".poster p").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-title2 input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-title2 input").prop("checked", false);
                }
    
                $(".content-text p").css("font-size", $(".content-text p").css("font-size"));
                //color
                var bgPoster = $('.poster-end #subtitle-end').css('color');
                $("#hexcolorFont-des-poster").val(RgbaTohex(bgPoster));
                var titleHex = $("#hexcolorFont-des-poster").val();
                //console.log(titleHex+"titl2");
                $('#toolOptionEdit #colorpickerFont-des-poster').val(titleHex.toString());
                //font-size
                $("#fontNumber-des-poster").val($('.poster-end #subtitle-end p').css("font-size").slice(0, -2));
    
            }
            */
    
            function getLandingEdit() {
                //cta
                if ($("#cta_landing").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-cta input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-cta input").prop("checked", false);
                }
                //href
                $("#cta-href").attr('disabled', false);
                
                //color-bg
                var bgCta = $('#cta_landing').css('backgroundColor');
                $("#hexcolor-cta-poster").val(RgbaTohex(bgCta));
                var ctaHex = $("#hexcolor-cta-poster").val();
                $('#toolOptionEdit #colorpicker-cta-poster').val(ctaHex.toString());
    
                //color-font
                var fontCta = $('#cta_landing').css('color');
                $("#hexcolorFont-cta-poster").val(RgbaTohex(fontCta));
                var ctaFontHex = $("#hexcolorFont-cta-poster").val();
                $('#toolOptionEdit #colorpickerFont-cta-poster').val(ctaFontHex.toString());
                //text
                $("#cta-poster").val($("#cta_landing").text());
                $("#cta-href").val($("#cta_landing").attr('href'));
    
                //image
                if ($(".landing .logo").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-image input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-image input").prop("checked", false);
                }
    
                //background
                var bgLand = $('.landing').css('backgroundColor');
                $("#toolOptionEdit #hexcolorBG-poster").val(RgbaTohex(bgLand));
                var bgPosterHex = $("#toolOptionEdit #hexcolorBG-poster").val();
    
                //console.log(bgPosterHex);
                $('#colorpickerBG-poster').val(bgPosterHex.toString());
    
                //title
                if ($(".landing h1").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-title input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-title input").prop("checked", false);
                }
    
    
                //title  
                //color
                var bgLand_h1 = $('.landing h1').css('color');
                $("#hexcolorFont-title-poster").val(RgbaTohex(bgLand_h1));
                var titleHex = $("#hexcolorFont-title-poster").val();
                //console.log(titleHex+"titl2");
                $('#toolOptionEdit #colorpickerFont-title-poster').val(titleHex.toString());
                //font-size
                $("#fontNumber-title-poster").val($('.landing h1').css("font-size").slice(0, -2));
    
    
                //des
                //subtitle
                if ($(".landing p").is(":visible")) {
                    //console.log("no esta oculta");
                    $(".switch-poster-title2 input").prop("checked", true)
                    //$("#toolOptionEdit .switch input").prop( "checked", true );
                } else {
                    //console.log("si esta oculta");
                    $(".switch-poster-title2 input").prop("checked", false);
                }
    
                var pColor = $('.landing p').css('color');
                console.log("El color es:" + pColor + ' hex ' + RgbaTohex(pColor));
                $("#hexcolorFont-des-poster").val(RgbaTohex(pColor));
    
                var pHex = $("#hexcolorFont-des-poster").val();
                $('#toolOptionEdit #colorpickerFont-des-poster').val(pHex.toString());
    
                //font-size
                $("#fontNumber-des-poster").val($('.landing p').css("font-size").slice(0, -2));
    
    
            }
    
            function serLogoSize() {
                var porWidth = $(".content-image").width() * 100 / $(".poster-end").width();
                porWidth = porWidth + "%";
                $(".content-image").width(porWidth);
                var porHeight = $(".content-image").height() * 100 / $(".poster-end").height();
                porHeight = porHeight + "%";
                console.log(porHeight);
                $(".content-image").height(porHeight);
            }
            //-----------------------------------------CONVERT TO HEX-----------------------------------------//
            function RgbaTohex(rgba) {
                console.log("RgbaTohex()");
                console.log("color viejo es:" + $('.poster-end').css('backgroundColor'));
                rgba = rgba.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
    
                return rgba && rgba.length === 4 ?
                    "#" + ("0" + parseInt(rgba[1], 10).toString(16)).slice(-2) +
                    ("0" + parseInt(rgba[2], 10).toString(16)).slice(-2) +
                    ("0" + parseInt(rgba[3], 10).toString(16)).slice(-2) :
                    "";
            }
    
            //-----------------------------------------CONVERT TO RGBA-----------------------------------------//
            function hexToRgbA(hex) {
                console.log(hex);
                var c;
                if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                    c = hex.substring(1).split('');
    
                    if (c.length == 3) {
                        c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                    }
    
                    c = '0x' + c.join('');
                    return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',1)';
                }
    
                throw new Error('Bad Hex');
            }
    
            /*----------------------------------Change of Device*/
            $(".previewPanel .devices li").click(function() {
                $(".previewPanel .devices li").removeClass("active");
                var dStyle = $(this).data("id");
                console.log(dStyle);
                $(".blockAdd").removeClass("desktop tablet mobile")
                $(".blockAdd").addClass(dStyle);
                $(this).addClass("active");
                resizeAddmedia();
            });
    
            $(function() {
                //remove desktop in mobile version
                var x = window.matchMedia("(max-width: 700px)")
                myFunction(x) // Call listener function at run time
                x.addListener(myFunction) // Attach listener function on state changes
                serLogoSize();
                resizeAddmedia();
                getViewEdit();
    
                $("#resizable").resizable({
                    containment: ".poster-end",
                    stop: function(event, ui) {
                        serLogoSize();
                        setProjectChanged();
                    }
                });
                $("#resizable2").resizable({
                    containment: ".landing",
                    stop: function(event, ui) {
                        serLogoSize();
                        setProjectChanged();
                    }
                });
            });
    
    

            function selectMedia() {
                console.log("selectMedia()");
                var blnSelected = false;
    			var imgSelected = false;
    			var fldSelected = false;
    
                $('#libraryModal input[type=checkbox]').each(function() {
    
                    $(this).change(function(){
                        if ($(this).prop('checked')) {
                            $('input[type=checkbox]').prop("checked", false);
                            $('input[type=checkbox]').parent().removeClass('selected');
                            $(this).parent().addClass('selected');
                            $(this).prop("checked", true);
                        } else {
                            $(this).parent().removeClass('selected');
                        }
    				});	
                    
                    if (this.checked) {
    				
                        var name = $(this).attr("name");
                        console.log("Seleccionado: " + name)
    
                        var mediaType = $(this).parent().next().attr("media-type");
    
        				if(mediaType.startsWith("video/")){
    						console.log("Ha seleccionado VIDEO, no se admite.");
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
                        
                        var mediaId = $(this).parent().next().attr("media-id");
                        var mediaSrc = $(this).parent().next().attr("media-src");
                        var mediaImg = $(this).parent().next().attr("src");
    
                        blnSelected = true;
                        $(this).prop("checked", false);
                        $(this).parent().removeClass('selected');
    
                        console.log("mediaSrc: " + mediaSrc);
                        console.log('*****TARGET ES:' + target_img);
                        let target_path = $(target_img).parent().find('img');
                        let target_input = $(target_img).parent().find('input');
                        console.log(target_path);
                        console.log(target_input);
                        target_path.attr("src", mediaSrc);
                        target_input.val(name);

                        if(target_img =='#imgGetIn_view'){
                        	$('#endVideoimageId').val(name);
                        }
                        else if(target_img =='#imgGetIn_land'){
                        	$('#land_imageId').val(name);
                        }
                        $("#deleteMediaFileBtn").hide();
                        setProjectChanged();  
                    }
                });
    
                if (blnSelected) {
                    $('#libraryModal').modal('hide');
                }
    
                if(imgSelected)
    				modalMsgShow("No se permite seleccionar Videos");
    			if(fldSelected)
    				modalMsgShow("No se permite seleccionar Carpetas");
    
    			imgSelected = false;
    			fldSelected = false;
    			blnSelected = false;
            }
    
    
    
            /* UPDATE NEW TOOLS v.1.1 /**/
            //Elements
            const cta_view = document.querySelector('.poster-end #again'); //cta from final view
            const btn_edit_post = document.querySelector('.poster-end .edit-poster'); //cta from final view
            const cta_land = document.querySelector('.landing .cta'); //cta from final view
            const btn_img_view = document.querySelector('#imgGetIn'); //cta from final view
    
            //function
            const updateTools = () => {
    
                //editable cta text
                if (cta_view.isContentEditable) {
                    console.log('true editable');
                } else {
                    console.log('false editable');
                    cta_view.setAttribute('contenteditable', 'true');
                }
                //cambio id en botÃ³n add img
                if (btn_img_view) {
                    btn_img_view.setAttribute('id', 'imgGetIn_view');
                }
    
                //edit poster set onclick
                if (!btn_edit_post.hasAttribute(
                    'onclick="edit_color(\'view\')"')) { // Si no tiene el atributo onclick, aÃ±Ã¡delo `
                    btn_edit_post.setAttribute('onclick', 'edit_color(\'view\')');
                }
    
            }
            updateTools();
                
    
            //Space in button -> allow press space bar in editable text on cta
            cta_view.addEventListener('keydown', function(event) {
                if (event.key === ' ') {
                    event.preventDefault();
                    document.execCommand('insertHTML', false, '&nbsp;');
                }
            });
            cta_land.addEventListener('keydown', function(event) {
                if (event.key === ' ') {
                    event.preventDefault();
                    document.execCommand('insertHTML', false, '&nbsp;');
                }
            });
        </script>
	</body>
</html>
