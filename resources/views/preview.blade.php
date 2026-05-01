@php
    $previewFrom = request()->query('from');
    $backUrl = 'actions?project=' . $project->id;
    if ($previewFrom === 'publish') {
        $backUrl = 'publish?project=' . $project->id;
    } elseif ($previewFrom === 'cuePoints') {
        $backUrl = 'cuePoints?project=' . $project->id;
    } elseif ($previewFrom === 'addVideo') {
        $backUrl = 'addVideo?project=' . $project->id;
    }
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/Style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
        <title>	PlayFunnel - The Interactive Video Funnel </title>
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>

    </head>
	<body class="bg-white preview-page">
        <?php session()->put("preview", 1); ?>
		@include('nav_bar_project')
    <!-------------------------------------MAIN------------------------------------------>
    <div class="container-fluid m-0 p-0 vh-100 ">
         <section class="step123 row col-12  mx-0 p-0 w-100">

              <div class="mainContainer col row p-0 m-0">
     <!-----------------------------------------------------Left Menu-->
     	<!--
		<div class="sideNavWork col d-flex align-items-center justify-content-center bg-05" id="navbarNav">

        	<ul id="mediaList" class="navbar-nav p-0 ">
            @foreach ($projectLibs as $projectLib)
        	  <li id="list-{{$projectLib->id}}" name="{{$projectLib->id }}" position="{{$projectLib->position }}" class="nav-item" media-id="{{ $projectLib->libraryid }}" proyectlib-id="{{ $projectLib->id }}"  media-name="{{ $projectLib->name }}">
                <a class=" widgetVideo nav-link c03  text-md-left p-0 m-0" >
                  <img class="p-0 m-0" src="{{$projectLib->library->thumbnail }}" onclick="setMainMedia(this)" libraryid="{{ $projectLib->library->id }}" libraryurl="{{ $projectLib->library->url }}" projectlib="{{ $projectLib->id }}" />
    			  <i class="d-none c07">◄</i>
                </a>
              </li>
            @endforeach
        	</ul>
    	</div>
        -->
      <!---------------------------------------------------------Main-->

            <div class="mainContainer col row p-0 m-0">
            	{{ csrf_field() }}
            	<input type="hidden" name="projectId" id="projectId" value="{{$project->id}}">
            	<input type="hidden" name="libraryId" id="libraryId" value="">

                <div class="mainpreview col mx-4 m-0 mt-2">
                   <div class="w-100 m-0 p-0 mt-0 row justify-content-center">
                    <div class="previewPanel p-0 pt-4 m-0 row">
                      <ul class="devices d-flex m-0 mb-3 p-2 align-items-center">
						<li class="m-0 p-2 desktop  active" data-id="p-desktop"><i class="fas fa-desktop c05"></i></li>
						<li class="m-0 mx-3 p-2 table  " data-id="p-tablet"><i class="fas fa-tablet-alt c05"></i></li>
						<li class="m-0 p-2 mobile  " data-id="p-mobile"><i class="fas fa-mobile-alt c05"></i></li>
                      </ul>
                 	</div>
                </div>
                <div class="contentIframe  p-desktop">
					<?php
						$codigo_proyeecto = $_GET['project'];
						$codigo_proyecto_encriptado = openssl_encrypt($codigo_proyeecto, $ciphering="AES-128-CTR",
														$encryption_key="PlayFunnel", $options=0, $encryption_iv="1234567891011121");

					?>
					<iframe src="/embed?project=<?= $codigo_proyecto_encriptado ?>&projectView=0"  title="Iframe Example" height="100%" width="100%" style="/* padding-bottom: 140%; */border:none;"></iframe>
				</div>
                <!-------------------------->

      <!---------------------------------------------------Right Menu-->

            </div>
         </section>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"                                   integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" 					crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 		integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var backUrl = @json($backUrl);
            var setBackButton = function (elementId) {
                var button = document.getElementById(elementId);
                if (!button) {
                    return;
                }

                button.setAttribute('type', 'button');
                button.innerHTML = '<i class="fas fa-arrow-left mr-2"></i>Volver';
                button.onclick = function (event) {
                    event.preventDefault();
                    window.location.href = backUrl;
                };
            };

            setBackButton('guardarHeader');
            setBackButton('guardarHeaderMobile');
        });


		/*----------------------------------Change of Device*/
		$(".previewPanel .devices li").click(function() {
			$( ".previewPanel .devices li").removeClass("active");
			var dStyle = $(this).data("id");
			console.log(dStyle);
			$(".contentIframe").removeClass("p-desktop p-tablet p-mobile")
			$(".contentIframe").addClass(dStyle);
			$(this).addClass("active");
		});

    </script>
  </body>
</html>
