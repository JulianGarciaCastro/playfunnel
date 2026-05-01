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
        <title>{{__('step3.title')}}</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
        <style>
            .step3-page .modal {
                z-index: 2500;
            }

            .step3-page .modal-backdrop {
                z-index: 2400;
            }
        </style>
    </head>
	<body class="bg-white step3-page">

    	@include('nav_bar_project')

        <!-------------------------------------MAIN------------------------------------------>
    	<div class="container-fluid m-0 p-0 vh-100 ">
        	<section class="step123 row col-12  mx-0 p-0 w-100">

              <div class="mainContainer col row p-0 m-0">
                 <!-----------------------------------------------------Left Menu-->
                 <div class="sideNavWork col d-flex align-items-center justify-content-center bg-05" id="navbarNavWork" >
              		<div class="openSideNavWork navbar-toggler d-lg-none d-flex mr-2" type="button" data-toggle="collapse" data-target="#navbarNavWork" aria-controls="navbarNavWork" aria-expanded="false" aria-label="Toggle navigation">
                		<i class="fas fa-arrow-circle-right mr-2"></i><i class="fas fa-photo-video"></i>
              		</div>
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

                <!---------------------------------------------------------Main-->
                <div class="mainContainer col row p-0 m-0">
                    <div class="main col m-4 p-0">
                    	<div class="steps m-0 p-0 row">
                        	<div class="progressbar-wrapper col-md-9 col-12">
                            	<div class="progressbar-wrapper progressbar-wrapper text-center "> {{$project->name}} </div>
                            	<ul class="progressbar p-0 row mt-4 mt-md-1">
                                    <li class="active col-3" onclick="window.location.href='addVideo?project={{ $project->id }}';">{{__('step3.add_video')}}</li>
                                    <li class="active col-3" onclick="window.location.href='cuePoints?project={{ $project->id }}';">{{__('step3.create_cuepoints')}}</li>
                                    <li class="active col-3" onclick="window.location.href='actions?project={{ $project->id }}';">{{__('step3.cuepoint_actions')}}</li>
                                    <li class="col-3"        onclick="window.location.href='publish?project={{ $project->id }}';">{{__('step3.publish')}}</li>
                                </ul>
                        	</div>
                   		</div>
                   <div class="row justify-content-center m-0 blockAdd desktop">
                     <div class="addVideoMain {{ $project->aspect }} p-0 m-0">
                       <div class="widgetContainer d-none" id="widgetContainer">
                        <div class="option-widget-title d-none" id="optionWidgetTitleBox">
                          <p id="optionWidgetTitlePreview" contenteditable="true" onblur="onOptionWidgetTitlePreviewBlur()"></p>
                        </div>
                        <ul id="AB" class="ui-sortable d-none ActionBox optionsRows rows-3">
                          <li class="enable Option s-50 aCenter ui-state-default ui-sortable-handle" data-id="1"  draggable="true" uuid="{{uniqid()}}">

                            <div class="content resizable p-0">
                              <img src="images/SVG/imageEmpty.svg" class="img-fluid" alt="">
                            </div>
                            <div class="content p-0">
                              <div class="context wysiwyg-content" >
                                <p contenteditable>
								{{__('step3.title1')}}
                                </p>
                              </div>
                            </div>
                            <span class="option-item-icon d-none" data-icon-class="">
                              <i class="far fa-circle"></i>
                            </span>
                          </li>
                          <li class="enable Option s-50 aCenter ui-state-default ui-sortable-handle" data-id="2"  draggable="true" uuid="{{uniqid()}}">

                            <div class="content resizable p-0">
                              <img src="images/SVG/imageEmpty.svg" class="img-fluid" alt="">
                            </div>
                            <div class="content p-0">
                              <div class="context wysiwyg-content" >
                                <p contenteditable>
								{{__('step3.title2')}}
                                </p>
                              </div>
                            </div>
                            <span class="option-item-icon d-none" data-icon-class="">
                              <i class="far fa-circle"></i>
                            </span>
                          </li>
                          <li class="enable Option s-50 aCenter ui-state-default ui-sortable-handle" data-id="3"  draggable="true" uuid="{{uniqid()}}">

                            <div class="content resizable p-0">
                              <img src="images/SVG/imageEmpty.svg" class="img-fluid" alt="">
                            </div>
                            <div class="content p-0">
                              <div class="context wysiwyg-content" >
                                <p contenteditable>
								{{__('step3.title3')}}
                                </p>
                              </div>
                            </div>
                            <span class="option-item-icon d-none" data-icon-class="">
                              <i class="far fa-circle"></i>
                            </span>
                          </li>
                          <li class="enable Option s-50 aCenter ui-state-default ui-sortable-handle" data-id="4"  draggable="true" uuid="{{uniqid()}}">

                            <div class="content resizable p-0">
                              <img src="images/SVG/imageEmpty.svg" class="img-fluid" alt="">
                            </div>
                            <div class="content p-0">
                              <div class="context wysiwyg-content" >
                                <p contenteditable>
								{{__('step3.title4')}}
                                </p>
                              </div>
                            </div>
                            <span class="option-item-icon d-none" data-icon-class="">
                              <i class="far fa-circle"></i>
                            </span>
                          </li>
                          <li class="enable Option s-50 aCenter ui-state-default ui-sortable-handle" data-id="5"  draggable="true" uuid="{{uniqid()}}">

                            <div class="content resizable p-0">
                              <img src="images/SVG/imageEmpty.svg" class="img-fluid" alt="">
                            </div>
                            <div class="content p-0">
                              <div class="context wysiwyg-content" >
                                <p contenteditable>
								{{__('step3.title5')}}
                                </p>
                              </div>
                            </div>
                            <span class="option-item-icon d-none" data-icon-class="">
                              <i class="far fa-circle"></i>
                            </span>
                          </li>
                          <li class="enable Option s-50 aCenter ui-state-default ui-sortable-handle" data-id="6"  draggable="true" uuid="{{uniqid()}}">

                            <div class="content resizable p-0">
                              <img src="images/SVG/imageEmpty.svg" class="img-fluid" alt="">
                            </div>
                            <div class="content p-0">
                              <div class="context wysiwyg-content" >
                                <p contenteditable>
								{{__('step3.title6')}}
                                </p>
                              </div>
                            </div>
                            <span class="option-item-icon d-none" data-icon-class="">
                              <i class="far fa-circle"></i>
                            </span>
                          </li>
                        </ul>
                       </div>
					   <div class="widgetContainer d-none" id="widgetContainerForm">
						<button class="fileds-form" id="fields-form"><i class="fa fa-server"></i></button>
						<button class="colors-form" id="colors-form"><i class="fas fa-pencil-alt"></i></button>
						<form id="AF" class="ActionBox ui-sortable d-none" style="padding:0;">
							<div class="itemForm" id="form-title">
								<h3 contenteditable >Title</h3>
							</div>
							<div class="d-flex itemForm" id="form-name">
								<label for="fname"><i class="fa fa-user m-0 p-0 mr-2 mt-1" aria-hidden="true"></i><b>First name:</b></label>
								<input type="text" id="f-name" name="f-name"  placeholder="Jhon Doe" required="required" onfocusout="updateTypeForm()">
							</div>
							<div  class="d-flex itemForm" id="form-email">
								<label for="lname"><i class="fa fa-envelope m-0 p-0 mr-2 mt-1" aria-hidden="true"></i><b>Email:</b></label>
								<input type="email" id="f-email" name="f-email" placeholder="Doe@email.com" required="required" onfocusout="updateTypeForm()">
							</div>
							<div class="d-none itemForm" id="form-tel">
								<label for="f-tel"><i class="fa fa-phone m-0 p-0 mr-2 mt-1" aria-hidden="true"></i><b>Telephone:</b></label>
								<input type="tel" id="f-tel" name="f-tel" placeholder="123-45-678"  onfocusout="updateTypeForm()">
							</div>
							<div class="d-none itemForm" id="form-text">
								<label for="f-text"> <i class="fa fa-font m-0 p-0 mr-2 mt-1" aria-hidden="true"></i><b>Text:</b></label>
								<input type="text" id="f-text" name="f-text" placeholder="LoremIpsum..." onfocusout="updateTypeForm()">
							</div>
							<div class="d-none itemForm" id="form-textArea">
								<label for="f-textArea"> <i class="fa fa-commenting m-0 p-0 mr-2 mt-1" aria-hidden="true"></i><b>Comment:</b></label>
								<textarea id="f-textArea" name="f-textArea" rows="3" cols="50" placeholder="At w3schools.com you will learn how to make a website. They offer free tutorials in all web development technologies." onfocusout="updateTypeForm()"></textarea>
							</div>
							<div class="d-none itemForm" id="form-birthday">
								<label for="f-birthday"><i class="fa fa-birthday-cake m-0 p-0 mr-2 mt-1" aria-hidden="true"></i><b>Birthday:</b></label>
								<input type="date" id="f-birthday" name="f-birthday" step="1" min="2013-01-01" max="2013-12-31" placeholder="2013-01-01" onfocusout="updateTypeForm()">
							</div>
							<div class="d-none itemForm" id="form-cp">
								<label for="f-cp"><i class="fa fa-map-marker m-0 p-0 mr-2 mt-1" aria-hidden="true"></i><b>Postal Code:</b></label>
  								<input type="text" data-type="text"  id="f-cp" name="f-cp" placeholder="28040" onfocusout="updateTypeForm()">
							</div>
							<div class="d-flex itemForm row" id="form-terms">
								<label for="f-terms"><b>Accept Terms and Conditions:</b></label>
								<input class="ml-3" type="checkbox" id="f-terms" name="f-terms" placeholder="yes" data-score="" data-skip="" data-name="f-terms" aria-label="Aceptar las condiciones" required="required" onfocusout="updateTypeForm()">
							</div>
							<div  class="d-flex">
								<button type="submit" id="form-cta">
									<span >My Button Example</span>
							  	</button>
							</div>
                            @csrf
						</form>
                       </div>
                       <div id="play" name="name" class="play w-100">
                        <i class="fas fa-play-circle"></i>
                        {{__('step3.add_video')}}
                       </div>
                     </div>
                   </div>
                   <div class="previewPanel p-0 m-0 mt-3 row">
                    <ul class="devices d-flex m-0 mr-4 p-2 align-items-center">
                      <li class="active m-0 p-2 desktop" data-id="desktop"><i class="fas fa-desktop c05"></i></li>
                      <!--<li class="m-0 mx-3 p-2 table" data-id="table"><i class="fas fa-tablet-alt c05"></i></li>-->
                      <li class="m-0 ml-3 p-2 mobile" data-id="mobile"><i class="fas fa-mobile-alt c05"></i></li>
                    </ul>
                    <button onclick="window.location.href='preview?project={{ $project->id }}&from=actions';" class="btn-square bg-01 cWhite px-3 ml-3">{{__('step3.preview')}} <i class="far fa-eye ml-2 py-0"></i></button>
               </div>
            </div>
                <!---------------------------------------------------Right Menu-->
                <div class="col-12 col-lg-4 bg-white p-0 m-0 rightMenu setup3 mt-md-0 mt-3">
                    <div class="titulo py-3 bg-01 px-0">
                        <h5 class="h5 text-center col-12 p-0 cWhite">{{__('step3.cuepoint_actions')}}</h5>
                    </div>
                    {{ csrf_field() }}
                    <input type="hidden" name="projectId"	id="projectId"	value="{{$project->id}}">
        			<input type="hidden" name="libraryId"	id="libraryId"	value="">
        			<input type="hidden" name="cuepointId"	id="cuepointId"	value="">
        			<input type="hidden" name="cpType"		id="cpType" 	value="">
        			<input type="hidden" name="cpOption"	id="cpOption"	value="">
        			<input type="hidden" name="optionUuid"  id="optionUuid" value="">

                    <div class="p-3 p-lg-4 pb-5 CueList mb-4 ">
                      <h6>{{__('step3.cuepoint_list')}}</h6>
                      <div class="d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 py-2">
                        <div class="col-12 d-flex justify-content-between align-items-center text-center" id="dropdownMenu2" data-toggle="dropdown" >
                          <p class="m-0 c02"   id="dropdownId">--</p>
                          <p class="m-0 cMain" id="dropdownName">{{__('step3.select_cuepoint')}}</p>
                          <p class="m-0 c02"   id="dropdownTime">00:00:00:00</p>
                          <i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>
                        </div>
                        <div id="cuepointList" name="cuepointList" class="dropdown-menu col-12 " aria-labelledby="dropdownMenu2">
                        </div>
                      </div>
                      <p id="tipSelectVideo" class="p-0 pt-2 m-0">
					  {{__('step3.you_must_select_video')}}
                      </p>
                      <div id="widgetOptions" class="widgets col-12 p-0 m-0" style="display: none;">
                        <div class="pt-3 px-0 fieldDes">
                          <label for="cueName"  class="w-100 p-0 m-0" >Cuepoint Tag</label>
                          <input id="cueName" name ="cueName" class="w-100 py-2 px-3 m-0" placeholder="Etiqueta del Cue" type="text" maxlength="45" onfocusout="updateCueName()">
                        </div>
                        <hr class="my-4">
                        <h6>{{__('step3.select_widget')}}</h6>
                        <ul class="widgetSelect col-12 justify-content-between p-0 m-0 nav nav-pills mb-3" id="pills-tab" role="tablist">
                          <li class="nav-item mb-2" role="presentation">
                            <a class="nav-link p-0 w-100 h-100 active " id="pills-nav-tab" name="cpType" value="BROWSE" data-toggle="pill" href="#pills-nav" role="tab" aria-controls="pills-contact" aria-selected="true" onclick="selectTypeBrowse()">
                              <div class="pb-2"><i class="h4 fas fa-external-link-alt m-0"></i>{{__('step3.navegation')}}</div>
                            </a>
                          </li>
                          <li class="nav-item mb-2" role="presentation">
                            <a class="nav-link p-0 w-100 h-100" id="pills-options-tab" name="cpType" value="OPTION" data-toggle="pill" href="#pills-options" role="tab" aria-controls="pills-home" aria-selected="false" onclick="selectTypeOption()">
                              <div class="pb-2"><i class="h4 fas fa-ellipsis-h m-0"></i>{{__('step3.options')}}</div>
                            </a>
                          </li>
                          <li class="nav-item mb-2" role="presentation">
                            <a class="nav-link p-0 w-100 h-100" id="pills-forms-tab" name="cpType" value="FORM" data-toggle="pill" href="#pills-forms" role="tab" aria-controls="pills-profile" aria-selected="false" onclick="selectTypeForm()">
                              <div class="pb-2"><i class="h3 far fa-list-alt m-0"></i>{{__('step3.form')}}</div>
                            </a>
                          </li>
                        </ul>

                        <hr class="my-4">
                        <div class="Optwidget tab-content col-12 p-0 m-0" id="pills-tabContent">
                          <div class="W-Nav tab-pane fade show active" id="pills-nav" role="tabpanel" aria-labelledby="pills-nav-tab">
                            <h6 class="h6 mt-4">{{__('step3.widget_options')}}</h6>
                            <div class="form-group row col-12 px-0 m-0 my-2">
                              <label for="browseTag" class="col col-form-label p-0">Etiqueta CRM:</label>
                              <div class="col-sm-8 p-0">
                                <select class="form-control" id="browseTag" onchange="setBrowseTag()">
                                  <option value="">Sin etiqueta</option>
                                </select>
                              </div>
                            </div>
                            <ul class="col-12 justify-content-between p-0 m-0 nav nav-pills bg-Main px-3 py-2" id="pills-tab-1" role="tablist">
                              <li class="nav-item py-2" role="presentation">
                                <a class="nav-link p-0 py-2 px-2 bg-06 active" id="subtypeNone" name="cpBrowseSubType" value="NONE" data-toggle="pill" href="#nav-none" role="tab" aria-selected="true" onclick="selectBrowseNone()">
                                  <i class="fas fa-bullseye"></i>
                                  <p class="m-0 p-0">{{__('step3.none')}}</p>
                                </a>
                              </li>
                              <li class="nav-item py-2" role="presentation">
                                <a class="nav-link p-0 py-2 px-2 bg-06" id="subtypeURL" name="cpBrowseSubType" value="URL" data-toggle="pill" href="#nav-url" role="tab" aria-selected="false">
                                  <i class="fas fa-external-link-alt"></i>
                                  <p class="m-0 p-0">URL</p>
                                </a>
                              </li>
                              <li class="nav-item py-2" role="presentation">
                                <a class="nav-link  p-0 py-2 px-2 bg-06" id="subtypeCuepoint" name="cpBrowseSubType" value="CUEPOINT" data-toggle="pill" href="#nav-cue" role="tab" aria-selected="false" onclick="copyCuepointList()">
                                  <i class="fas fa-route"></i>
                                  <p class="m-0 p-0">CUEPOINT</p>
                                </a>
                              </li>
                              <li class="nav-item py-2" role="presentation">
                                <a class="nav-link  p-0 py-2 px-2 bg-06" id="subtypeVideo" name="cpBrowseSubType" value="VIDEO" data-toggle="pill" href="#nav-video" role="tab" aria-selected="false" onclick="copyVideoList()">
                                  <i class="fas fa-film"></i>
                                  <p class="m-0 p-0">VIDEO</p>
                                </a>
                              </li>
                            </ul>

                            <!-- BROWSE OPTIONS-->
                            <div class="Opts tab-content col-12 p-0 m-0" id="pills-tabContent-1">
                              <!-- GO URL-->
                              <div class="tab-pane fade mt-4" id="nav-url"  role="tabpanel" aria-labelledby="pills-nav-tab">
                                <div class="pt-3 px-0 fieldDes">
                                  <label for="videoName"  class="w-100 p-0 m-0" >{{__('step3.go_to_url')}}</label>
                                  <input id="gotourl" name ="gotourl" class="w-100 py-2 px-3 m-0 col-12" placeholder="Direccion..." type="text" onfocusout="selectBrowseURL()" maxlength="250">
                                </div>
                                <div class="pt-3 px-0 fieldDes">
                                  <label for="urlOption"  class="w-100 p-0 m-0" >{{__('step3.open_in')}}</label>
                                  <ul class="openRadio p-0 m-0" id="urlOption">
                                    <li class="form-check form-check-inline py-2 px-4 m-0">
                                      <input class="form-check-input" type="radio" name="goto_opt" id="inlineRadio1" value="_blank" checked="checked" onclick="selectBrowseURL()">
                                      <label class="form-check-label" for="inlineRadio1">_Blank</label>
                                    </li>
                                    <li class="form-check form-check-inline py-2 px-4 m-0">
                                      <input class="form-check-input" type="radio" name="goto_opt" id="inlineRadio2" value="_self" onclick="selectBrowseURL()">
                                      <label class="form-check-label" for="inlineRadio2">_Self</label>
                                    </li>
                                  </ul>
                                </div>
                              </div>

                              <!-- GO TO CUEPOINT-->
                              <div class="tab-pane fade mt-4" id="nav-cue" role="tabpanel" aria-labelledby="pills-nav-tab">
                                <h6>{{__('step3.cuepoint_list')}}</h6>
                                <div class="d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 py-2">
                                  <div class="col-12 d-flex justify-content-between align-items-center text-center" id="dropdownMenu3" data-toggle="dropdown" >
                                    <p class="m-0 c02"   id="dropdownId-Nav">--</p>
                                    <p class="m-0 cMain" id="dropdownName-Nav">{{__('step3.select_cuepoint')}}</p>
                                    <p class="m-0 c02"   id="dropdownTime-Nav">00:00:00:00</p>
                                    <i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>
                                  </div>
                                  <div id="cuepointList-Nav" name="cuepointList-Nav" class="dropdown-menu col-12 " aria-labelledby="dropdownMenu3">
                                  </div>
                                </div>
                              </div>

                              <!-- GO TO VIDEO-->
                              <div class="tab-pane fade mt-4" id="nav-video" role="tabpanel" aria-labelledby="pills-nav-tab">
                                <h6>{{__('step3.videos_list')}}</h6>
                                <div class="d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 py-2">
                                  <div class="col-12 d-flex justify-content-between align-items-center text-center" id="dropdownMenu4" data-toggle="dropdown" >
                                    <p class="m-0 c02"   id="dropdownId-Nav3">--</p>
                                    <p class="m-0 cMain" id="dropdownName-Nav3">{{__('step3.select_video')}}</p>
                                    <i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>
                                  </div>
                                  <div id="cuepointList-Nav3" name="cuepointList-Nav3" class="dropdown-menu col-12 " aria-labelledby="dropdownMenu4">
                                  </div>
                                </div>
                              </div>

                              <!-- GO TO NONE-->
                              <div class="tab-pane fade mt-4" id="nav-none" role="tabpanel" aria-labelledby="pills-nav-tab">
                              </div>
                            </div>
                          </div>

                         <!-- OPTION OPTIONS-->
                          <div class="W-Options tab-pane fade" id="pills-options" role="tabpanel" aria-labelledby="pills-options-tab">
                            <h6 class="h6 mt-4">{{__('step3.widget_options')}}</h6>
                            <ul class="col-12 justify-content-between p-0 m-0 nav nav-pills mb-3 " id="pills-tab-2" role="tablist">
                              <li class="nav-item" role="presentation">
                                <a class="nav-link active p-0 py-2 w-100 bg-06" id="cpOptSubTypeRow" name="cpOptSubType" value="ROW"  data-toggle="pill" href="#" role="tab" aria-selected="true" ">
                                  <div  class="opt-img"><img src="images/SVG/cols.svg"></div>
                                </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                <a class="nav-link p-0 py-2 w-100 bg-06" id="cpOptSubTypeCol" name="cpOptSubType" value="COL"  data-toggle="pill" href="#" role="tab" aria-selected="false" ">
                                  <div class="opt-img"><img src="images/SVG/rows.svg"></div>
                                </a>
                              </li>
                              <li class="nav-item row p-0 m-0 mb-2 mb-lg-0q" role="presentation">
                                  <h6 class="m-0 c03">{{__('step3.options')}}</h6>
                                  <select class="custom-select py-0 c02" id="numberOfColRow" onchange="setTypeOptionValues()">

                                    <option value="2" >2</option>
                                    <option value="3" selected >3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                  </select>
                              </li>
                            </ul>
                             <hr class="my-2">
                            <div class="form-group row col-12 px-0 m-0 my-2">
                              <label for="widgetOptionTitle" class="col col-form-label p-0">Título:</label>
                              <div class="col-sm-8 p-0">
                                <input type="text" class="form-control" id="widgetOptionTitle" maxlength="120" placeholder="Título del bloque" oninput="setOptionWidgetTitle()">
                              </div>
                            </div>
                            <div class="d-flex color align-items-center justify-content-between">
                              <div class="d-flex align-items-center justify-content-between">
                                <p class="m-0 p-0">Tamaño título</p>
                              </div>
                              <div class="d-flex align-items-center justify-content-end">
                                <i class="fas fa-text-height"></i>
                                <input class="ml-1" id="widgetOptionTitleSize" type="number" min="14" max="120" step="1" value="42" oninput="setOptionWidgetTitleSize()">
                              </div>
                            </div>
                            <div class="d-flex color align-items-center justify-content-between mt-2" id="widgetOptionTitleWeightRow">
                              <div class="d-flex align-items-center justify-content-between">
                                <p class="m-0 p-0">Peso título</p>
                              </div>
                              <div class="d-flex align-items-center justify-content-end" id="widgetOptionTitleWeightButtons">
                                <button type="button" class="title-weight-btn" data-weight="700" onclick="setOptionWidgetTitleWeight('700')">B</button>
                                <button type="button" class="title-weight-btn" data-weight="400" onclick="setOptionWidgetTitleWeight('400')">N</button>
                                <button type="button" class="title-weight-btn" data-weight="300" onclick="setOptionWidgetTitleWeight('300')">L</button>
                              </div>
                            </div>
                            <div class="form-group row col-12 px-0 m-0 my-2">
                              <label for="widgetOptionFontFamily" class="col col-form-label p-0">Fuente:</label>
                              <div class="col-sm-8 p-0">
                                <select class="custom-select py-0 c02" id="widgetOptionFontFamily" onchange="setOptionWidgetFontFamily()"></select>
                              </div>
                            </div>

                            <div class="mt-2" id="globalOptionStyleInline">
                              <p class="m-0 p-0">Estilo general de opciones</p>
                              <div class="activePanel d-flex p-0 m-0 mt-2 align-items-center justify-content-between">
                                <p class="m-0 p-0 mr-3">Imagen</p>
                                <label class="switch m-0 p-0">
                                  <input type="checkbox" id="globalOptionImageEnabled" checked>
                                  <span class="slider round"></span>
                                </label>
                              </div>
                              <hr class="my-2">
                              <div class="aline d-flex aling m-0 p-0 justify-content-between align-items-center">
                                <p class="m-0 p-0">Alineación</p>
                                <ul class="d-flex justify-content-between m-0 p-0" id="globalOptionAlign">
                                  <li class="mx-2" data-id="aStart"><img src="images/SVG/aStart.svg"></li>
                                  <li class="mx-2 active" data-id="aCenter"><img src="images/SVG/aCenter.svg"></li>
                                  <li class="mx-2" data-id="aEnd"><img src="images/SVG/aEnd.svg"></li>
                                </ul>
                              </div>
                              <hr class="my-2">
                              <div class="d-flex sizes m-0 p-0 justify-content-between align-items-center">
                                <p class="m-0 p-0">Tamaño</p>
                                <input class="slider-alpha" id="globalOptionSizeRange" type="range" min="10" max="100" step="5" value="50">
                              </div>
                              <hr class="my-2">
                              <div class="d-flex color align-items-center justify-content-between">
                                <div class="d-flex align-items-center justify-content-between">
                                  <p class="m-0 p-0">Fondo</p>
                                  <input class="mx-2" type="color" id="globalOptionBgColor" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#e8eff7">
                                  <input type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#e8eff7" id="globalOptionBgHex">
                                </div>
                              </div>
                              <hr class="my-2">
                              <div class="d-flex color align-items-center justify-content-between">
                                <div class="d-flex align-items-center justify-content-between">
                                  <p class="m-0 p-0">Borde</p>
                                  <input class="mx-2" type="color" id="globalOptionBorderColor" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#212529">
                                  <input type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#212529" id="globalOptionBorderHex">
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                  <img class="ml-3" src="images/SVG/border.svg">
                                  <input class="ml-2" id="globalOptionBorderWidth" type="number" min="0" max="30" value="0">
                                </div>
                              </div>
                              <hr class="my-2">
                              <div class="d-flex color align-items-center justify-content-between">
                                <div class="d-flex align-items-center justify-content-between">
                                  <p class="m-0 p-0">Texto</p>
                                  <input class="mx-2" type="color" id="globalOptionTextColor" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#1192ee">
                                  <input type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#1192ee" id="globalOptionTextHex">
                                </div>
                              </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                              <p class="m-0 p-0">Imagen fondo</p>
                              <div class="d-flex align-items-center">
                                <button type="button" class="btn-square bg-02 cWhite mr-2 py-1 px-2" id="widgetBgPickBtn" onclick="openWidgetBgPicker()">Elegir</button>
                                <button type="button" class="btn-square bg-Close cWhite py-1 px-2" id="widgetBgClearBtn" onclick="clearOptionWidgetBackground()">Quitar</button>
                              </div>
                              <img class="m-0 mt-1" id="widgetOptionFontPreview" width="50" height="50" alt="Miniatura" src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'%3E%3Crect width='50' height='50' fill='%23e8eff7'/%3E%3Cpath d='M6 34l10-10 8 8 7-7 13 13H6z' fill='%239db4cc'/%3E%3Ccircle cx='17' cy='16' r='4' fill='%239db4cc'/%3E%3C/svg%3E">
                            </div>
                            <p class="m-0 mt-1 c02" id="widgetBgImageLabel">Sin imagen</p>
                            <hr/>
                            <div class="d-flex align-items-center justify-content-between mt-4" id="color-AB">
                              <div class="d-flex align-items-center justify-content-between">
                               <p class="m-0 p-0">{{__('step3.background')}}</p>
                               <input class="mx-1" type="color" id="bg-AB" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55">
                               <input class="" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexBg-AB">
                              </div>
                              <div class="d-flex c03 align-items-center justify-content-end ml-2">
                                <i class="fas fa-adjust"></i>
                                <input class="slider-alpha c03 ml-1" id="opacity-AB" type="range" min="0" max="100" value="50">
                              </div>
                            </div>
                            <hr/>
                            <div class="d-flex color align-items-center justify-content-between">
                              <div class="d-flex align-items-center justify-content-between">
                             	<p class="m-0 p-0">{{__('step3.font')}}</p>
                              </div>
                              <div class="d-flex align-items-center justify-content-end">
                                <i class="fas fa-text-height"></i>
                              	<input class="ml-1" id="fontNumber" type="number" value="20">
                              </div>
                            </div>
							<div class="d-flex color align-items-center justify-content-between mt-2">
								<div class="d-flex align-items-center justify-content-between">
								   <p class="m-0 p-0">{{__('step3.fontM')}}</p>
								</div>
								<div class="d-flex color align-items-center justify-content-end">
								  <i class="fas fa-text-height"></i>
									<input class="ml-1" id="fontNumberM" type="number" value="12">
								</div>
							  </div>
                          </div>

                          <!-- FORM OPTIONS-->
                          <div class="W-Form tab-pane fade" id="pills-forms" role="tabpanel" aria-labelledby="pills-forms-tab">
                            <div class="W-Opt tab-pane fade show " id="pills-options" role="tabpanel" aria-labelledby="pills-options-tab">
                              <h6 class="h6 mt-4 mb-0">{{__('step3.widget_options')}}</h6>

                              <div class="form-group row col-12 px-0 m-0 my-2">
                                  <label for="inputPassword3" class="col col-form-label p-0">{{__('step3.name')}}:</label>
                                  <div class="col-sm-8 p-0">
                                    <input type="text" class="form-control" id="inputName" onfocusout="updateTypeForm()" maxlength="95">
                                  </div>
                              </div>
                              <div class="form-group row col-12 px-0 m-0 my-2">
                                  <label for="inputEmail3" class="col col-form-label p-0">{{__('step3.send_to')}}:</label>
                                  <div class="col-sm-8 p-0">
                                    <input type="email" class="form-control" id="inputSendTo" onfocusout="updateTypeForm()" maxlength="95">
                                  </div>
                              </div>
                              <hr class="my-2">
                              <div id="map-crm-field" class="activePanel d-flex m-0 align-items-center justify-content-between mt-3">
                                  <div class="d-flex justify-content-between aling-items-center">
                                      <p class="m-0 p-0 ">CRM</p>
                                  </div>
                                  <label class="switch m-0 p-0">
                                      <input type="checkbox" id="map-crm-form-edit" checked>
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                              <hr class="my-2">
                              <div class="">
                                <label for="inputEmail3" class="col col-form-label p-0 ">{{__('step3.action_go_to')}}:</label>
								<!-- INICIA OPCIONES FORM -->

								<div class="OptionsEdit">
    								<div class=" accion p-0 m-0">
                            			<ul class="nav nav-tabs" id="myTab" role="tablist">
                            				<li class="nav-item">
                            				<a class="nav-link active" id="goto-url-form" data-toggle="tab" href="#url-form" role="tab" aria-controls="url-form"
                            					aria-selected="true" onclick="copyUrlOption()"> <i class="fas fa-external-link-alt mx-1"></i>URL</a>
                            				</li>
                            				<li class="nav-item">
                            				<a class="nav-link" id="goto-cue-form" data-toggle="tab" href="#cue-form" role="tab" aria-controls="cue-form"
                            					aria-selected="false" onclick="copyCuepointListForm()"><i class="fas fa-route mx-1"></i> Cue</a>
                            				</li>
                            				<li class="nav-item">
                            				<a class="nav-link" id="goto-video-form" data-toggle="tab" href="#video-form" role="tab" aria-controls="video-form"
                            					aria-selected="false" onclick="copyVideoListForm()"> <i class="fas fa-film mx-1"></i>Video</a>
                            				</li>
                            			</ul>
                                		<div class="tab-content" id="goto-content">
                                			<div class="tab-pane fade show active" id="url-form" role="tabpanel" aria-labelledby="url-form-tab">
                                				<div class="pt-1 px-0 fieldDes">
                                					<label for="gotourlOption-form" class="w-100 p-0 m-0" >Dirección:</label>
                                					<input id="gotourlOption-form" name ="gotourlOption-form" class="w-100 py-1 px-2 m-0 col-12 text-left" placeholder="Direccion..." type="text" onfocusout="selectFormBrowseURL()" maxlength="250">
                                				</div>
                                				<div class="pt-1 px-0 fieldDes">
                                					<label for="urlOption-form"  class="w-100 p-0 m-0" >Abrir en</label>
                                					<ul class="openRadio p-0 m-0" id="urlOption-form" name="urlOption-form">
                                					<li class="form-check form-check-inline py-1 px-4 m-0">
                                						<input class="form-check-input" type="radio" name="goto_opt_opt_form" id="inlineRadioOpt1-form" value="_blank" checked="checked" onclick="selectFormBrowseURL()">
                                						<label class="form-check-label" for="inlineRadio1">_Blank</label>
                                					</li>
                                					<li class="form-check form-check-inline py-1 px-4 m-0">
                                						<input class="form-check-input" type="radio" name="goto_opt_opt_form" id="inlineRadioOpt2-form" value="_self" onclick="selectFormBrowseURL()">
                                						<label class="form-check-label" for="inlineRadio2">_Self</label>
                                					</li>
                                					</ul>
                                				</div>
                                			</div>
                                			<div class="tab-pane fade" id="cue-form" role="tabpanel" aria-labelledby="cue-form-tab">
                                				<p class="p-0 m-0 pt-2">Lista de Cuepoints</p>
                                				<div class="row d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 py-1">
                                    				<div class="col-12 d-flex justify-content-between align-items-center text-center px-2" id="dropdownMenu33-form" data-toggle="dropdown" >
                                    					<p class="m-0 c02"   id="dropdownId-Nav11-form">--</p>
                                    					<p class="m-0 cMain" id="dropdownName-Nav11-form">Seleccione Cuepoint</p>
                                    					<p class="m-0 c02"   id="dropdownTime-Nav11-form">00:00:00</p>
                                    					<i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>
                                    				</div>
                                    				<div  id="cuepointList-Nav22-form" name="cuepointList-Nav22-form" class="dropdown-menu col-12 " aria-labelledby="dropdownMenu33-form">
                                    				</div>
                                				</div>
                                			</div>
                                			<div class="tab-pane fade" id="video-form" role="tabpanel" aria-labelledby="video-form-tab">
                                				<p class="p-0 m-0 pt-2">Lista de Video</p>
                                    			<div class="row d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 py-1">
                                    				<div class="col-12 d-flex justify-content-between align-items-center text-center px-2" id="dropdownMenu44-form" data-toggle="dropdown" >
                                    				<p class="m-0 c02"   id="dropdownId-Nav33-form">--</p>
                                    				<p class="m-0 cMain" id="dropdownName-Nav33-form">Seleccione Video</p>
                                    				<i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>
                                    				</div>
                                    				<div  id="cuepointList-Nav33-form" name="cuepointList-Nav33-form" class="dropdown-menu col-12 " aria-labelledby="dropdownMenu44-form">
                                    				</div>
                                    			</div>
                                			</div>
                                		</div>
									</div>

                           		<!-- FINALIZA OPCIONES FORM -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 next d-flex justify-content-center">
                      <button class="btn-square bg-Main cWhite px-3" onclick="window.location.href='publish?project={{ $project->id }}';">
                      	<i class="fas fa-caret-square-right mr-2"></i>{{__('step3.continue')}}
                      </button>
                    </div>
                </div>
            </div>
         </section>

    	<x-tool-option-edit />
		<x-edit-form-tool />
		<x-edit-form-colors />
		<x-manage-library :library="$library" :user="$user"/>
		<x-messages/>

        <!--END CONTAINER-->
	</div>

    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 		integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" 	crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
	<script src="js/Sortable.js"></script>

    <script type="text/javascript">
        var defaultOption;
        var defaultForm;
        window.crmCustomFields = @json($crmCustomFields ?? []);
        window.crmTags = @json($crmTags ?? []);
        var OPTION_WIDGET_TITLE_SIZE_DEFAULT = 42;
        var OPTION_WIDGET_TITLE_WEIGHT_DEFAULT = "700";
        var OPTION_WIDGET_FONT_DEFAULT = "Open Sans";
        var OPTION_WIDGET_GOOGLE_FONTS = [
            "Open Sans",
            "Montserrat",
            "Poppins",
            "Lato",
            "Roboto",
            "Nunito",
            "Merriweather",
            "Playfair Display",
            "Bebas Neue",
            "Oswald",
            "Raleway",
            "Inter",
            "Work Sans",
            "Quicksand",
            "Manrope",
            "DM Sans",
            "Archivo",
            "Anton",
            "Barlow",
            "Karla",
            "Rubik"
        ];

        function getCrmTagChoices() {
            var tags = Array.isArray(window.crmTags) ? window.crmTags : [];
            return tags
                .map(function(tag) {
                    return tag && tag.name ? String(tag.name).trim() : '';
                })
                .filter(function(name, index, arr) {
                    return !!name && arr.indexOf(name) === index;
                });
        }

        function populateTagSelect(selectId, selectedValue, placeholderText) {
            var select = document.getElementById(selectId);
            if (!select) {
                return;
            }

            var currentValue = (selectedValue !== undefined && selectedValue !== null) ? String(selectedValue) : '';
            var tagChoices = getCrmTagChoices();

            select.innerHTML = '';

            var emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = placeholderText || 'Sin etiqueta';
            select.appendChild(emptyOption);

            tagChoices.forEach(function(tagName) {
                var option = document.createElement('option');
                option.value = tagName;
                option.textContent = tagName;
                select.appendChild(option);
            });

            if (currentValue && tagChoices.indexOf(currentValue) === -1) {
                var legacyOption = document.createElement('option');
                legacyOption.value = currentValue;
                legacyOption.textContent = currentValue + ' (no disponible en CRM)';
                select.appendChild(legacyOption);
            }

            select.value = currentValue;
        }

        function populateBrowseTagSelect(selectedValue) {
            populateTagSelect('browseTag', selectedValue, 'Sin etiqueta');
        }

        function setBrowseTag() {
            var selectedTag = $('#browseTag').val() || null;

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {
                    if (item.type_browse == null) {
                        item.type_browse = {};
                    }

                    if (item.type_browse.type == null) {
                        item.type_browse.type = 'NONE';
                    }

                    item.type = 'BROWSE';
                    item.type_browse.tag = selectedTag;
                    item.action = 'UPDATE';
                    return false;
                }
            });
        }

        var optionMediaTarget = "option-image";
        var optionEditorMode = "single";

        function makeOptionRuntimeUuid(index) {
            return "opt-" + Date.now().toString(36) + "-" + index + "-" + Math.random().toString(36).slice(2, 8);
        }

        function normalizeOptionWidgetFontFamily(fontFamily) {
            var candidate = String(fontFamily || "")
                .replace(/["']/g, "")
                .replace(/\s+/g, " ")
                .trim();

            if (!candidate.length) {
                return OPTION_WIDGET_FONT_DEFAULT;
            }

            var lowerCandidate = candidate.toLowerCase();
            for (var i = 0; i < OPTION_WIDGET_GOOGLE_FONTS.length; i++) {
                if (OPTION_WIDGET_GOOGLE_FONTS[i].toLowerCase() === lowerCandidate) {
                    return OPTION_WIDGET_GOOGLE_FONTS[i];
                }
            }

            return candidate;
        }

        function getOptionWidgetGoogleFontUrl(fontFamily) {
            var normalized = normalizeOptionWidgetFontFamily(fontFamily);
            var familyQuery = normalized.split(/\s+/).join("+");
            return "https://fonts.googleapis.com/css2?family=" + familyQuery + ":wght@400;500;700&display=swap";
        }

        function getOptionWidgetFontCssValue(fontFamily) {
            var normalized = normalizeOptionWidgetFontFamily(fontFamily);
            return '"' + normalized.replace(/"/g, '\\"') + '", sans-serif';
        }

        function ensureOptionWidgetGoogleFontLoaded(fontFamily) {
            var normalized = normalizeOptionWidgetFontFamily(fontFamily);
            if (!normalized.length) {
                return;
            }

            var fontKey = normalized.toLowerCase().replace(/[^a-z0-9]+/g, "-");
            var linkId = "option-widget-google-font-" + fontKey;
            if (document.getElementById(linkId)) {
                return;
            }

            var link = document.createElement("link");
            link.id = linkId;
            link.rel = "stylesheet";
            link.href = getOptionWidgetGoogleFontUrl(normalized);
            document.head.appendChild(link);
        }

        function populateOptionWidgetFontSelect(selectedFont) {
            var select = document.getElementById("widgetOptionFontFamily");
            if (!select) {
                return;
            }

            var normalized = normalizeOptionWidgetFontFamily(selectedFont);
            select.innerHTML = "";

            OPTION_WIDGET_GOOGLE_FONTS.forEach(function(fontName) {
                var option = document.createElement("option");
                option.value = fontName;
                option.textContent = fontName;
                option.style.fontFamily = getOptionWidgetFontCssValue(fontName);
                select.appendChild(option);
            });

            var exists = OPTION_WIDGET_GOOGLE_FONTS.some(function(fontName) {
                return fontName.toLowerCase() === normalized.toLowerCase();
            });

            if (!exists) {
                var legacy = document.createElement("option");
                legacy.value = normalized;
                legacy.textContent = normalized + " (custom)";
                legacy.style.fontFamily = getOptionWidgetFontCssValue(normalized);
                select.appendChild(legacy);
            }

            select.value = normalized;
        }

        function updateOptionWidgetFontPreview(fontFamily) {
            var normalized = normalizeOptionWidgetFontFamily(fontFamily);
            $("#widgetOptionFontPreview").attr("data-font-family", normalized);
        }

        function sanitizeOptionWidgetTitleSize(sizeValue) {
            var parsed = parseInt(sizeValue, 10);
            if (isNaN(parsed)) {
                parsed = OPTION_WIDGET_TITLE_SIZE_DEFAULT;
            }

            if (parsed < 14) {
                parsed = 14;
            }
            if (parsed > 120) {
                parsed = 120;
            }

            return parsed;
        }

        function readOptionWidgetTitleSizeFromDom() {
            var preview = $("#optionWidgetTitlePreview");
            if (!preview.length) {
                return OPTION_WIDGET_TITLE_SIZE_DEFAULT;
            }

            var stored = preview.attr("data-title-font-size");
            if (stored !== undefined && stored !== null && String(stored).trim().length) {
                return sanitizeOptionWidgetTitleSize(stored);
            }

            var inline = preview.css("font-size");
            if (inline && String(inline).trim().length) {
                return sanitizeOptionWidgetTitleSize(inline);
            }

            return OPTION_WIDGET_TITLE_SIZE_DEFAULT;
        }

        function applyOptionWidgetTitleSize(sizeValue) {
            var preview = $("#optionWidgetTitlePreview");
            if (!preview.length) {
                return;
            }

            var normalized = sanitizeOptionWidgetTitleSize(sizeValue);
            preview.attr("data-title-font-size", normalized);
            preview.css("font-size", normalized + "px");
            $("#widgetOptionTitleSize").val(normalized);
        }

        function setOptionWidgetTitleSize() {
            applyOptionWidgetTitleSize($("#widgetOptionTitleSize").val());
            setTypeOptionValues();
        }

        function normalizeOptionWidgetTitleWeight(weightValue) {
            var raw = String(weightValue || "").trim().toLowerCase();
            if (!raw.length) {
                return OPTION_WIDGET_TITLE_WEIGHT_DEFAULT;
            }

            if (raw === "light" || raw === "300" || raw === "200" || raw === "100") {
                return "300";
            }
            if (raw === "normal" || raw === "regular" || raw === "400" || raw === "500") {
                return "400";
            }
            if (raw === "bold" || raw === "bolder" || raw === "700" || raw === "600" || raw === "800" || raw === "900") {
                return "700";
            }

            var parsed = parseInt(raw, 10);
            if (!isNaN(parsed)) {
                if (parsed <= 350) {
                    return "300";
                }
                if (parsed >= 600) {
                    return "700";
                }
                return "400";
            }

            return OPTION_WIDGET_TITLE_WEIGHT_DEFAULT;
        }

        function readOptionWidgetTitleWeightFromDom() {
            var preview = $("#optionWidgetTitlePreview");
            if (!preview.length) {
                return OPTION_WIDGET_TITLE_WEIGHT_DEFAULT;
            }

            var stored = preview.attr("data-title-font-weight");
            if (stored !== undefined && stored !== null && String(stored).trim().length) {
                return normalizeOptionWidgetTitleWeight(stored);
            }

            var inline = preview.css("font-weight");
            if (inline && String(inline).trim().length) {
                return normalizeOptionWidgetTitleWeight(inline);
            }

            return OPTION_WIDGET_TITLE_WEIGHT_DEFAULT;
        }

        function updateOptionWidgetTitleWeightButtons(weightValue) {
            var normalized = normalizeOptionWidgetTitleWeight(weightValue);
            $("#widgetOptionTitleWeightButtons .title-weight-btn").removeClass("is-selected");
            $("#widgetOptionTitleWeightButtons .title-weight-btn[data-weight='" + normalized + "']").addClass("is-selected");
        }

        function applyOptionWidgetTitleWeight(weightValue) {
            var preview = $("#optionWidgetTitlePreview");
            var normalized = normalizeOptionWidgetTitleWeight(weightValue);

            if (preview.length) {
                preview.attr("data-title-font-weight", normalized);
                preview.css("font-weight", normalized);
            }

            updateOptionWidgetTitleWeightButtons(normalized);
        }

        function setOptionWidgetTitleWeight(weightValue) {
            applyOptionWidgetTitleWeight(weightValue);
            setTypeOptionValues();
        }

        function readOptionWidgetFontFamilyFromDom() {
            var ab = $("#AB");
            var preview = $("#optionWidgetTitlePreview");

            var stored = (ab.attr("data-widget-font-family") || preview.attr("data-widget-font-family") || "").trim();
            if (stored.length) {
                return normalizeOptionWidgetFontFamily(stored);
            }

            var computed = (ab.css("font-family") || preview.css("font-family") || "")
                .split(",")[0]
                .replace(/["']/g, "")
                .trim();
            if (computed.length) {
                return normalizeOptionWidgetFontFamily(computed);
            }

            return OPTION_WIDGET_FONT_DEFAULT;
        }

        function applyOptionWidgetFontFamily(fontFamily) {
            var normalized = normalizeOptionWidgetFontFamily(fontFamily);
            var cssValue = getOptionWidgetFontCssValue(normalized);

            ensureOptionWidgetGoogleFontLoaded(normalized);
            populateOptionWidgetFontSelect(normalized);
            updateOptionWidgetFontPreview(normalized);

            var ab = $("#AB");
            if (ab.length) {
                ab.attr("data-widget-font-family", normalized);
                ab.css("font-family", cssValue);
                ab.find("li .context, li .context p, li .content p").css("font-family", cssValue);
            }

            var preview = $("#optionWidgetTitlePreview");
            if (preview.length) {
                preview.attr("data-widget-font-family", normalized);
                preview.css("font-family", cssValue);
            }
        }

        function setOptionWidgetFontFamily() {
            applyOptionWidgetFontFamily($("#widgetOptionFontFamily").val());
            setTypeOptionValues();
        }

        function sanitizeOptionBorderWidth(value) {
            var parsed = parseInt(value, 10);
            if (isNaN(parsed) || parsed < 0) {
                parsed = 0;
            }
            if (parsed > 30) {
                parsed = 30;
            }
            return parsed;
        }

        function rgbaToHexSafe(rgba, fallback) {
            var safeFallback = fallback || "#000000";
            if (!rgba) {
                return safeFallback;
            }

            var match = String(rgba).match(/^rgba?\(\s*(\d+),\s*(\d+),\s*(\d+)/i);
            if (!match) {
                return safeFallback;
            }

            function toHex(x) {
                return ("0" + parseInt(x, 10).toString(16)).slice(-2);
            }

            return "#" + toHex(match[1]) + toHex(match[2]) + toHex(match[3]);
        }

        function ensureOptionUseGlobalFlag(optionLi) {
            var option = $(optionLi);
            if (!option.length) {
                return;
            }

            if (option.attr("data-use-global-style") !== "0" && option.attr("data-use-global-style") !== "1") {
                option.attr("data-use-global-style", "1");
            }
        }

        function getOptionUseGlobalStyle(optionLi) {
            var option = $(optionLi);
            if (!option.length) {
                return true;
            }

            ensureOptionUseGlobalFlag(option);
            return option.attr("data-use-global-style") !== "0";
        }

        function setOptionUseGlobalStyleFlag(optionLi, useGlobal) {
            var option = $(optionLi);
            if (!option.length) {
                return;
            }
            option.attr("data-use-global-style", useGlobal ? "1" : "0");
        }

        function getOptionSizeClass(optionLi) {
            var className = ($(optionLi).attr("class") || "");
            var match = className.match(/\bs-(10|20|25|30|40|50|60|70|75|80|90|100)\b/);
            return match ? ("s-" + match[1]) : "s-50";
        }

        function getOptionAlignClass(optionLi) {
            var option = $(optionLi);
            if (option.hasClass("aStart")) {
                return "aStart";
            }
            if (option.hasClass("aEnd")) {
                return "aEnd";
            }
            return "aCenter";
        }

        function getDefaultGlobalOptionStyle() {
            return {
                backgroundColor: "#e8eff7",
                borderColor: "#212529",
                borderWidth: 0,
                fontColor: "#1192ee",
                sizeClass: "s-50",
                alignClass: "aCenter",
                imageEnabled: true
            };
        }

        function readGlobalStyleFromOption(optionLi) {
            var option = $(optionLi);
            var defaults = getDefaultGlobalOptionStyle();
            if (!option.length) {
                return defaults;
            }

            return {
                backgroundColor: rgbaToHexSafe(option.css("background-color"), defaults.backgroundColor),
                borderColor: rgbaToHexSafe(option.css("border-color"), defaults.borderColor),
                borderWidth: sanitizeOptionBorderWidth(option.css("border-width")),
                fontColor: rgbaToHexSafe(option.find(".context p").first().css("color"), defaults.fontColor),
                sizeClass: getOptionSizeClass(option),
                alignClass: getOptionAlignClass(option),
                imageEnabled: !option.hasClass("imgOff")
            };
        }

        function normalizeGlobalOptionStyle(style) {
            var defaults = getDefaultGlobalOptionStyle();
            var normalized = style || {};
            var sizeClass = String(normalized.sizeClass || defaults.sizeClass);
            if (!/^s-(10|20|25|30|40|50|60|70|75|80|90|100)$/.test(sizeClass)) {
                sizeClass = defaults.sizeClass;
            }

            var alignClass = String(normalized.alignClass || defaults.alignClass);
            if (["aStart", "aCenter", "aEnd"].indexOf(alignClass) === -1) {
                alignClass = defaults.alignClass;
            }

            return {
                backgroundColor: String(normalized.backgroundColor || defaults.backgroundColor),
                borderColor: String(normalized.borderColor || defaults.borderColor),
                borderWidth: sanitizeOptionBorderWidth(normalized.borderWidth),
                fontColor: String(normalized.fontColor || defaults.fontColor),
                sizeClass: sizeClass,
                alignClass: alignClass,
                imageEnabled: normalized.imageEnabled !== false
            };
        }

        function getNearestAllowedOptionSize(rawValue) {
            var allowedSizes = [10, 20, 25, 30, 40, 50, 60, 70, 75, 80, 90, 100];
            var parsed = parseInt(rawValue, 10);
            if (isNaN(parsed)) {
                return 50;
            }

            var nearest = allowedSizes[0];
            for (var i = 1; i < allowedSizes.length; i++) {
                if (Math.abs(allowedSizes[i] - parsed) < Math.abs(nearest - parsed)) {
                    nearest = allowedSizes[i];
                }
            }

            return nearest;
        }

        function getWidgetOptionThumbPlaceholder() {
            return "data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'%3E%3Crect width='50' height='50' fill='%23e8eff7'/%3E%3Cpath d='M6 34l10-10 8 8 7-7 13 13H6z' fill='%239db4cc'/%3E%3Ccircle cx='17' cy='16' r='4' fill='%239db4cc'/%3E%3C/svg%3E";
        }

        function writeGlobalOptionStyle(style) {
            var ab = $("#AB");
            if (!ab.length) {
                return;
            }

            var normalized = normalizeGlobalOptionStyle(style);
            ab.attr("data-global-bg-color", normalized.backgroundColor);
            ab.attr("data-global-border-color", normalized.borderColor);
            ab.attr("data-global-border-width", normalized.borderWidth);
            ab.attr("data-global-font-color", normalized.fontColor);
            ab.attr("data-global-size-class", normalized.sizeClass);
            ab.attr("data-global-align-class", normalized.alignClass);
            ab.attr("data-global-image-enabled", normalized.imageEnabled ? "1" : "0");
        }

        function ensureGlobalOptionStyleState() {
            var ab = $("#AB");
            if (!ab.length) {
                return;
            }

            if (ab.attr("data-global-size-class")) {
                return;
            }

            var firstOption = ab.find("li").first();
            var fromOption = readGlobalStyleFromOption(firstOption);
            writeGlobalOptionStyle(fromOption);
        }

        function readGlobalOptionStyle() {
            ensureGlobalOptionStyleState();

            var ab = $("#AB");
            if (!ab.length) {
                return getDefaultGlobalOptionStyle();
            }

            return normalizeGlobalOptionStyle({
                backgroundColor: ab.attr("data-global-bg-color"),
                borderColor: ab.attr("data-global-border-color"),
                borderWidth: ab.attr("data-global-border-width"),
                fontColor: ab.attr("data-global-font-color"),
                sizeClass: ab.attr("data-global-size-class"),
                alignClass: ab.attr("data-global-align-class"),
                imageEnabled: ab.attr("data-global-image-enabled") !== "0"
            });
        }

        function applyOptionImageState(optionLi, imageEnabled) {
            var option = $(optionLi);
            if (!option.length) {
                return;
            }

            var imgContent = option.find("img").parent();
            var textContent = option.find(".context").closest(".content");

            if (imageEnabled) {
                option.addClass("imgOn").removeClass("imgOff");

                if ($("#AB").hasClass("optionsCols")) {
                    imgContent.css({
                        width: "100%",
                        height: "50%"
                    });
                    textContent.css({
                        width: "100%",
                        height: "50%"
                    });
                } else {
                    imgContent.css({
                        width: "50%",
                        height: "100%"
                    });
                    textContent.css({
                        width: "50%",
                        height: "100%"
                    });
                }
            } else {
                option.removeClass("imgOn").addClass("imgOff");
                imgContent.css({
                    width: "0",
                    height: "0"
                });
                textContent.css({
                    width: "100%",
                    height: "100%"
                });
            }
        }

        function applyGlobalStyleToOption(optionLi) {
            var option = $(optionLi);
            if (!option.length) {
                return;
            }

            var style = readGlobalOptionStyle();
            option.removeClass("s-10 s-20 s-25 s-30 s-40 s-50 s-60 s-70 s-75 s-80 s-90 s-100");
            option.removeClass("aStart aCenter aEnd");
            option.addClass(style.sizeClass);
            option.addClass(style.alignClass);
            option.css("background-color", style.backgroundColor);
            option.css("border", style.borderColor + " solid " + style.borderWidth + "px");
            option.find(".context p, .content p").css("color", style.fontColor);
            applyOptionImageState(option, style.imageEnabled);
        }

        function applyGlobalStyleToInheritedOptions() {
            $("#AB li").each(function() {
                var option = $(this);
                ensureOptionUseGlobalFlag(option);
                if (getOptionUseGlobalStyle(option)) {
                    applyGlobalStyleToOption(option);
                }
            });
        }

        function getCurrentOptionEditorTargets() {
            if (optionEditorMode === "global") {
                return $("#AB li").filter(function() {
                    return getOptionUseGlobalStyle(this);
                });
            }

            if (_option && _option.length) {
                return _option;
            }

            return $();
        }

        function toggleOptionStyleControls(enabled) {
            var locked = !enabled;
            $("#toolOptionEdit .sizes .slider-alpha, #toolOptionEdit #colorpickerBG, #toolOptionEdit #hexcolorBG, #toolOptionEdit #colorpicker, #toolOptionEdit #hexcolor, #toolOptionEdit #borderNumber, #toolOptionEdit #colorpickerFont, #toolOptionEdit #hexcolorFont")
                .prop("disabled", locked);
            $("#toolOptionEdit #optionImageEnabled").prop("disabled", locked);
            $("#toolOptionEdit .aline ul").css("pointer-events", locked ? "none" : "auto").css("opacity", locked ? "0.45" : "1");
            $("#toolOptionEdit #optionImagePanel").css("opacity", locked ? "0.55" : "1");
            $("#toolOptionEdit .sizes").css("opacity", locked ? "0.55" : "1");
            $("#toolOptionEdit .color").css("opacity", locked ? "0.55" : "1");
        }

        function updateOptionEditorModeUI() {
            var isGlobalMode = optionEditorMode === "global";
            var usingGlobal = !isGlobalMode && $("#optionUseGlobalStyle").is(":checked");

            $("#optionUseGlobalStyleRow").toggleClass("d-none", isGlobalMode);
            $("#toolOptionEdit .accion").toggleClass("d-none", isGlobalMode);
            $("#toolOptionEdit #optionName").prop("disabled", isGlobalMode);
            $("#toolOptionEdit #optionTag").prop("disabled", isGlobalMode);
            $("#toolOptionEdit #optionIconClass").prop("disabled", isGlobalMode);

            if (isGlobalMode) {
                $("#optionEditorModeHint").text("Modo general: cambios aplicados a todas las opciones que usan estilo general.");
            } else if (usingGlobal) {
                $("#optionEditorModeHint").text("Esta opción está heredando el estilo general.");
            } else {
                $("#optionEditorModeHint").text("Modo individual: esta opción usa estilo propio.");
            }

            toggleOptionStyleControls(isGlobalMode || !usingGlobal);
        }

        function syncGlobalStyleFromControls() {
            var style = {
                backgroundColor: $("#toolOptionEdit #hexcolorBG").val() || $("#toolOptionEdit #colorpickerBG").val() || "#e8eff7",
                borderColor: $("#toolOptionEdit #hexcolor").val() || $("#toolOptionEdit #colorpicker").val() || "#212529",
                borderWidth: sanitizeOptionBorderWidth($("#toolOptionEdit #borderNumber").val()),
                fontColor: $("#toolOptionEdit #hexcolorFont").val() || $("#toolOptionEdit #colorpickerFont").val() || "#1192ee",
                sizeClass: "s-" + ($("#toolOptionEdit .sizes .slider-alpha").val() || "50"),
                alignClass: $("#toolOptionEdit .aline li.active").attr("data-id") || "aCenter",
                imageEnabled: $("#toolOptionEdit #optionImageEnabled").is(":checked")
            };

            writeGlobalOptionStyle(style);
        }

        function loadGlobalOptionInlineControls() {
            var panel = $("#globalOptionStyleInline");
            if (!panel.length) {
                return;
            }

            var style = readGlobalOptionStyle();
            var sizeValue = getNearestAllowedOptionSize(String(style.sizeClass || "s-50").replace("s-", ""));

            $("#globalOptionImageEnabled").prop("checked", style.imageEnabled !== false);
            $("#globalOptionAlign li").removeClass("active");
            var align = $("#globalOptionAlign li[data-id='" + (style.alignClass || "aCenter") + "']");
            if (align.length) {
                align.addClass("active");
            } else {
                $("#globalOptionAlign li[data-id='aCenter']").addClass("active");
            }

            $("#globalOptionSizeRange").val(sizeValue);
            $("#globalOptionBgColor").val(style.backgroundColor);
            $("#globalOptionBgHex").val(style.backgroundColor);
            $("#globalOptionBorderColor").val(style.borderColor);
            $("#globalOptionBorderHex").val(style.borderColor);
            $("#globalOptionBorderWidth").val(sanitizeOptionBorderWidth(style.borderWidth));
            $("#globalOptionTextColor").val(style.fontColor);
            $("#globalOptionTextHex").val(style.fontColor);
        }

        function applyGlobalOptionInlineStyle() {
            var panel = $("#globalOptionStyleInline");
            if (!panel.length) {
                return;
            }

            var sizeValue = getNearestAllowedOptionSize($("#globalOptionSizeRange").val());
            $("#globalOptionSizeRange").val(sizeValue);

            var style = normalizeGlobalOptionStyle({
                backgroundColor: ($("#globalOptionBgHex").val() || $("#globalOptionBgColor").val() || "#e8eff7").trim(),
                borderColor: ($("#globalOptionBorderHex").val() || $("#globalOptionBorderColor").val() || "#212529").trim(),
                borderWidth: sanitizeOptionBorderWidth($("#globalOptionBorderWidth").val()),
                fontColor: ($("#globalOptionTextHex").val() || $("#globalOptionTextColor").val() || "#1192ee").trim(),
                sizeClass: "s-" + sizeValue,
                alignClass: $("#globalOptionAlign li.active").attr("data-id") || "aCenter",
                imageEnabled: $("#globalOptionImageEnabled").is(":checked")
            });

            writeGlobalOptionStyle(style);
            applyGlobalStyleToInheritedOptions();

            if (!$("#toolOptionEdit").hasClass("d-none") && optionEditorMode === "global") {
                setOption($("#AB li").first());
            }

            setTypeOptionValues();
        }

        function bindGlobalOptionInlineControls() {
            var panel = $("#globalOptionStyleInline");
            if (!panel.length) {
                return;
            }

            function isHex6(value) {
                return /^#([0-9a-fA-F]{6})$/.test(String(value || "").trim());
            }

            $("#globalOptionImageEnabled")
                .off("change.globalOptionInline")
                .on("change.globalOptionInline", function() {
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionAlign li")
                .off("click.globalOptionInline")
                .on("click.globalOptionInline", function() {
                    $("#globalOptionAlign li").removeClass("active");
                    $(this).addClass("active");
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionSizeRange")
                .off("input.globalOptionInline change.globalOptionInline")
                .on("input.globalOptionInline change.globalOptionInline", function() {
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionBgColor")
                .off("input.globalOptionInline change.globalOptionInline")
                .on("input.globalOptionInline change.globalOptionInline", function() {
                    $("#globalOptionBgHex").val($(this).val());
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionBorderColor")
                .off("input.globalOptionInline change.globalOptionInline")
                .on("input.globalOptionInline change.globalOptionInline", function() {
                    $("#globalOptionBorderHex").val($(this).val());
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionTextColor")
                .off("input.globalOptionInline change.globalOptionInline")
                .on("input.globalOptionInline change.globalOptionInline", function() {
                    $("#globalOptionTextHex").val($(this).val());
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionBgHex")
                .off("change.globalOptionInline")
                .on("change.globalOptionInline", function() {
                    var value = ($(this).val() || "").trim();
                    if (isHex6(value)) {
                        $("#globalOptionBgColor").val(value);
                    }
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionBorderHex")
                .off("change.globalOptionInline")
                .on("change.globalOptionInline", function() {
                    var value = ($(this).val() || "").trim();
                    if (isHex6(value)) {
                        $("#globalOptionBorderColor").val(value);
                    }
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionTextHex")
                .off("change.globalOptionInline")
                .on("change.globalOptionInline", function() {
                    var value = ($(this).val() || "").trim();
                    if (isHex6(value)) {
                        $("#globalOptionTextColor").val(value);
                    }
                    applyGlobalOptionInlineStyle();
                });

            $("#globalOptionBorderWidth")
                .off("input.globalOptionInline change.globalOptionInline")
                .on("input.globalOptionInline change.globalOptionInline", function() {
                    var width = sanitizeOptionBorderWidth($(this).val());
                    $(this).val(width);
                    applyGlobalOptionInlineStyle();
                });
        }

        function openGeneralOptionEditor() {
            ensureOptionWidgetStructure();
            bindGlobalOptionInlineControls();
            loadGlobalOptionInlineControls();

            var panel = $("#globalOptionStyleInline");
            if (panel.length && panel[0] && typeof panel[0].scrollIntoView === "function") {
                panel[0].scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        }

        function ensureOptionIconElement(optionLi) {
            var option = $(optionLi);
            if (!option.length) {
                return $();
            }

            var icon = option.children(".option-item-icon");
            if (!icon.length) {
                icon = $('<span class="option-item-icon d-none" data-icon-class=""><i class=""></i></span>');
                option.append(icon);
            } else if (!icon.find("i").length) {
                icon.append('<i class=""></i>');
            }

            return icon;
        }

        function readOptionIconClass(optionLi) {
            var option = $(optionLi);
            if (!option.length) {
                return "";
            }

            var icon = ensureOptionIconElement(option);
            var iconClass = (icon.attr("data-icon-class") || "").trim();
            if (!iconClass.length) {
                iconClass = (icon.find("i").attr("class") || "").trim();
            }
            return iconClass;
        }

        function applyOptionIconClass(optionLi, iconClass) {
            var option = $(optionLi);
            if (!option.length) {
                return;
            }

            var normalized = (iconClass || "").trim();
            var icon = ensureOptionIconElement(option);

            if (!normalized.length) {
                icon.addClass("d-none");
                icon.attr("data-icon-class", "");
                icon.find("i").attr("class", "");
                option.removeClass("has-option-icon");
                return;
            }

            icon.removeClass("d-none");
            icon.attr("data-icon-class", normalized);
            icon.find("i").attr("class", normalized);
            option.addClass("has-option-icon");
        }

        function ensureOptionWidgetStructure() {
            var container = $("#widgetContainer");
            if (!container.length) {
                return;
            }

            if (!container.find("#optionWidgetTitleBox").length) {
                container.prepend('<div class="option-widget-title d-none" id="optionWidgetTitleBox"><p id="optionWidgetTitlePreview" contenteditable="true" onblur="onOptionWidgetTitlePreviewBlur()"></p></div>');
            }

            applyOptionWidgetTitleSize(readOptionWidgetTitleSizeFromDom());
            applyOptionWidgetTitleWeight(readOptionWidgetTitleWeightFromDom());
            applyOptionWidgetFontFamily(readOptionWidgetFontFamilyFromDom());

            var ab = container.find("#AB");
            if (!ab.length) {
                return;
            }

            var titleText = (container.find("#optionWidgetTitlePreview").text() || "").trim();
            if (titleText.length) {
                container.find("#optionWidgetTitleBox").removeClass("d-none");
                ab.addClass("with-widget-title");
            } else {
                ab.removeClass("with-widget-title");
            }

            ab.find("li").each(function() {
                var option = $(this);
                ensureOptionIconElement(option);
                applyOptionIconClass(option, readOptionIconClass(option));
                ensureOptionUseGlobalFlag(option);
            });

            ensureGlobalOptionStyleState();
            applyGlobalStyleToInheritedOptions();
            bindGlobalOptionInlineControls();
            loadGlobalOptionInlineControls();
        }

        function buildFreshDefaultOptionHtml() {
            var wrapper = $("<div>").html(defaultOption || "");

            if (!wrapper.find("#optionWidgetTitleBox").length) {
                wrapper.prepend('<div class="option-widget-title d-none" id="optionWidgetTitleBox"><p id="optionWidgetTitlePreview" contenteditable="true" onblur="onOptionWidgetTitlePreviewBlur()"></p></div>');
            }

            wrapper.find("#optionWidgetTitleBox").addClass("d-none");
            var titlePreview = wrapper.find("#optionWidgetTitlePreview");
            titlePreview.text("");
            titlePreview.attr("data-title-font-size", OPTION_WIDGET_TITLE_SIZE_DEFAULT);
            titlePreview.attr("data-title-font-weight", OPTION_WIDGET_TITLE_WEIGHT_DEFAULT);
            titlePreview.attr("data-widget-font-family", OPTION_WIDGET_FONT_DEFAULT);
            titlePreview.css("font-size", OPTION_WIDGET_TITLE_SIZE_DEFAULT + "px");
            titlePreview.css("font-weight", OPTION_WIDGET_TITLE_WEIGHT_DEFAULT);
            titlePreview.css("font-family", getOptionWidgetFontCssValue(OPTION_WIDGET_FONT_DEFAULT));

            var ab = wrapper.find("#AB");
            ab.removeClass("with-widget-title has-widget-bg");
            ab.removeAttr("data-bg-image-id data-bg-image-url data-widget-font-family");
            ab.css("background-image", "");
            ab.attr("data-widget-font-family", OPTION_WIDGET_FONT_DEFAULT);
            ab.css("font-family", getOptionWidgetFontCssValue(OPTION_WIDGET_FONT_DEFAULT));

            var defaults = getDefaultGlobalOptionStyle();
            ab.attr("data-global-bg-color", defaults.backgroundColor);
            ab.attr("data-global-border-color", defaults.borderColor);
            ab.attr("data-global-border-width", defaults.borderWidth);
            ab.attr("data-global-font-color", defaults.fontColor);
            ab.attr("data-global-size-class", defaults.sizeClass);
            ab.attr("data-global-align-class", defaults.alignClass);
            ab.attr("data-global-image-enabled", defaults.imageEnabled ? "1" : "0");

            ab.find("li").each(function(index) {
                var option = $(this);
                option.attr("uuid", makeOptionRuntimeUuid(index + 1));
                option.removeClass("selected has-option-icon");
                option.attr("data-use-global-style", "1");
                var icon = ensureOptionIconElement(option);
                icon.addClass("d-none");
                icon.attr("data-icon-class", "");
                icon.find("i").attr("class", "");
            });

            return wrapper.html();
        }

        function resolveCurrentOptionSubtype(item) {
            var cpSubType = $('a[name="cpOptSubType"][aria-selected="true"]').attr("value");
            if (!cpSubType && item && item.type_option && item.type_option.type) {
                cpSubType = item.type_option.type;
            }
            if (cpSubType !== "COL" && cpSubType !== "ROW") {
                cpSubType = $("#AB").hasClass("optionsCols") ? "COL" : "ROW";
            }
            if (cpSubType !== "COL" && cpSubType !== "ROW") {
                cpSubType = "ROW";
            }

            return cpSubType;
        }

        function extractBackgroundImageUrl(backgroundImage) {
            if (!backgroundImage || backgroundImage === "none") {
                return "";
            }

            var match = backgroundImage.match(/url\((['"]?)(.*?)\1\)/);
            return match && match[2] ? match[2] : "";
        }

        function updateWidgetBgImageLabel(imageUrl) {
            var cleanUrl = (imageUrl || "").trim();
            var previewThumb = $("#widgetOptionFontPreview");
            if (previewThumb.length) {
                previewThumb.attr("src", cleanUrl.length ? cleanUrl : getWidgetOptionThumbPlaceholder());
            }
            $("#widgetBgImageLabel").text("");
        }

        function applyOptionWidgetBackground(imageUrl, imageId) {
            var ab = $("#AB");
            if (!ab.length) {
                return;
            }

            var cleanUrl = (imageUrl || "").trim();
            if (!cleanUrl.length) {
                ab.removeClass("has-widget-bg");
                ab.removeAttr("data-bg-image-url data-bg-image-id");
                ab.css({
                    "background-image": "",
                    "background-size": "",
                    "background-position": "",
                    "background-repeat": ""
                });
                updateWidgetBgImageLabel("");
                return;
            }

            var escapedUrl = cleanUrl.replace(/(["\\])/g, "\\$1");
            ab.addClass("has-widget-bg");
            ab.attr("data-bg-image-url", cleanUrl);
            if (imageId) {
                ab.attr("data-bg-image-id", imageId);
            } else {
                ab.removeAttr("data-bg-image-id");
            }
            ab.css({
                "background-image": 'linear-gradient(rgba(0,0,0,0.30), rgba(0,0,0,0.30)), url("' + escapedUrl + '")',
                "background-size": "cover",
                "background-position": "center",
                "background-repeat": "no-repeat"
            });
            updateWidgetBgImageLabel(cleanUrl);
        }

        function clearOptionWidgetBackground() {
            applyOptionWidgetBackground("", null);
            setTypeOptionValues();
        }

        function openWidgetBgPicker() {
            optionMediaTarget = "widget-bg";
            openDialogImg("widget-bg");
        }

        function applyOptionWidgetTitle(titleText) {
            var container = $("#widgetContainer");
            var titleBox = container.find("#optionWidgetTitleBox");
            var preview = container.find("#optionWidgetTitlePreview");
            var ab = container.find("#AB");
            if (!titleBox.length || !preview.length || !ab.length) {
                return;
            }

            var normalized = (titleText || "").trim();
            if (normalized.length) {
                titleBox.removeClass("d-none");
                preview.text(normalized);
                ab.addClass("with-widget-title");
            } else {
                preview.text("");
                titleBox.addClass("d-none");
                ab.removeClass("with-widget-title");
            }
        }

        function setOptionWidgetTitle() {
            applyOptionWidgetTitle($("#widgetOptionTitle").val());
            setTypeOptionValues();
        }

        function onOptionWidgetTitlePreviewBlur() {
            var normalized = ($("#optionWidgetTitlePreview").text() || "").trim();
            $("#widgetOptionTitle").val(normalized);
            applyOptionWidgetTitle(normalized);
            setTypeOptionValues();
        }

        function loadOptionWidgetPanelValues() {
            ensureOptionWidgetStructure();

            var title = ($("#optionWidgetTitlePreview").text() || "").trim();
            $("#widgetOptionTitle").val(title);
            applyOptionWidgetTitle(title);
            applyOptionWidgetTitleSize(readOptionWidgetTitleSizeFromDom());
            applyOptionWidgetTitleWeight(readOptionWidgetTitleWeightFromDom());
            applyOptionWidgetFontFamily(readOptionWidgetFontFamilyFromDom());

            var ab = $("#AB");
            if (!ab.length) {
                updateWidgetBgImageLabel("");
                return;
            }

            var bgUrl = (ab.attr("data-bg-image-url") || "").trim();
            if (!bgUrl.length) {
                bgUrl = extractBackgroundImageUrl(ab.css("background-image"));
            }

            if (bgUrl.length) {
                ab.addClass("has-widget-bg");
                ab.attr("data-bg-image-url", bgUrl);
                ab.css({
                    "background-size": "cover",
                    "background-position": "center",
                    "background-repeat": "no-repeat"
                });
            } else {
                ab.removeClass("has-widget-bg");
                ab.removeAttr("data-bg-image-url data-bg-image-id");
                ab.css({
                    "background-size": "",
                    "background-position": "",
                    "background-repeat": ""
                });
            }

            updateWidgetBgImageLabel(bgUrl);
        }

        function bindRightMenuScrollContainment() {
            var scrollContainer = $(".rightMenu.setup3 .CueList");
            if (!scrollContainer.length) {
                scrollContainer = $(".rightMenu.setup3");
            }
            if (!scrollContainer.length) {
                return;
            }

            scrollContainer.off("wheel.scrollContain");
            scrollContainer.on("wheel.scrollContain", function(event) {
                if (window.matchMedia("(max-width: 991px)").matches) {
                    return;
                }

                var nativeEvent = event.originalEvent || event;
                var deltaY = nativeEvent.deltaY || 0;
                var element = this;
                var atTop = element.scrollTop <= 0;
                var atBottom = Math.ceil(element.scrollTop + element.clientHeight) >= element.scrollHeight;

                if ((deltaY < 0 && atTop) || (deltaY > 0 && atBottom)) {
                    event.preventDefault();
                }

                event.stopPropagation();
            });
        }


        $(document).ready(function() {
            console.log("step3 document ready!");

            //console.log( "Los cuepoints before: %o", @json($cuePoints) );

            //Funcion para resaltar el video seleccionado en edicion de proyecto pasos 1, 2, 3
        	$("#mediaList").on("click", "li", function (event) {
    			$(this).siblings().find("a").removeClass("active");
    			$(this).find("a").addClass("active");

          		//Cierro el edit si esta abierto
          		$("#AB").addClass("d-none");
                $("#AF").addClass("d-none");

    		});


            cuePoints = @json($cuePoints);
            $.each(cuePoints, function(i, item) {
                item.action = "READY";
            });

            populateBrowseTagSelect(null);

            //console.log("Los cuepoints after: %o", cuePoints);
            defaultOption = $("#widgetContainer").html();
            defaultForm = $("#widgetContainerForm").html();

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


            //Cierro el edit si esta abierto
            $("#AB").addClass("d-none");
            $("#AF").addClass("d-none");

			//loadCuepoints();
			Start();


			$("#guardarHeader").click(boton_guardar);
    		$("#guardarHeaderMobile").click(boton_guardar);

    		$('a[name="cpOptSubType"]').on('shown.bs.tab', setTypeOptionValues);
			console.log("step3 document ready!");

        });


		//devuelve CurrentTime  en valor .3
		function matchRounded(number){
			let rounded = Math.floor(number*10/3)*3 / 10;
			rounded = new Date(rounded * 1000).toISOString().substr(11, 10);
			return rounded;
		}


		function existsChanges(){
			var continuar = false;
			$.each(cuePoints, function(i, item) {
				if(item.action == 'UPDATE'){
					continuar= true;
					return;
				}
  			});

  			return continuar;
		}



        function boton_guardar() {
            if (!existsChanges()) {
                ProjectModalSave(false);
                return;
            }

            var form = new FormData();
            form.append('_token', "{{ csrf_token() }}");
            form.append('projectid', $("#projectId").val());
            form.append('libraryid', $('#projectVideo').attr("media-id"));
            form.append('cuepoints', JSON.stringify(cuePoints));

            $.ajax({
                url: '/ajax-setCuepointData',
                type: 'POST',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success == 'Y') {
                        //loadCuepoints();
                        //alert(response.message +"success");
                        ProjectModalSave(true);
                        cuePoints = response.cuePoints;
                        console.log("boton_guardar() Los CuePoints Guardados: %o", response.cuePoints);

                        $.each(cuePoints, function(i, item) {
                            item.action = "READY";
                        });
                    }
                    if (response.success == 'N') {
                        //alert("Error: " + response.message + "Linea 954" );
                        modalMsgShow("Error: " + response.message);

                    }
                },
                error: function(request, error) {
                    console.log(error);
                    console.log(request);
                    //alert("Error: "+JSON.stringify(error) + "Linea 961");
                    modalMsgShow("Error: " + JSON.stringify(error));
                }
            });
        }




        function setMainMedia(img) {
            var mediaId = $(img).attr("libraryid");
            var mediaSrc = $(img).attr("libraryurl");
            var mediaImg = $(img).attr("src");
            var projectlibid = $(img).attr("projectlib");

            var currentLib = $("#projectVideo").attr("lib-id");

            if (currentLib == projectlibid)
                return;

            $("#projectlibid").val(projectlibid);

            var url = '{{ route('stream', ':id') }}';
            url = url.replace(':id', mediaId);

            var videoContent = '<video id="projectVideo" name="projectVideo" poster="' + mediaImg + '" media-id="' +
                mediaId + '" lib-id="' + projectlibid + '" class="col-12" preload="auto" >' +
                '<source src="' + url + '" type=video/mp4  media-id="' + mediaId + '" class="col-12"/>' +
                '<p>Video is not visible, most likely your browser does not support HTML5 video</p>' +
                '</video>';

            $('#play').html(videoContent)
            $("#libraryId").val(mediaId);
            $("#cuepointId").val("");


            $("#cuepointList").empty();
            var contador = 1;
            $.each(cuePoints, function(i, item) {
                console.log("Seleccionado()  mirando projectlibraryid: " + item.projectlibraryid);
                if (item.projectlibraryid == projectlibid) {
                    //console.log("Seleccionado()  agrego cuepoint: "  + item.id);
                    var cuePoint = '<button onclick="selectCuePoint(this)" id="cuepoint-' + item.id + '" pos="' +
                        contador + '" name="cuepoint-' + item.id + '" cuepoint-id="' + item.id +
                        '" class="item row justify-content-between align-items-center text-center px-3 py-2 col-12 m-0" type="button">' +
                        '<p>' + contador + '</p>' +
                        '<p class="m-0 c02">' + matchRounded(item.time) + '</p><hr class="col-10 my-1">' +
                        '</button>';

                    $("#cuepointList").append(cuePoint);
                    contador++;
                }
            });

            var defectoCuepoint = '<p class="m-0 c02"   id="dropdownId">  </p>' +
                '<p class="m-0 cMain" id="dropdownName">{{ __('step3.select_cuepoint') }}</p>' +
                '<p class="m-0 c02"   id="dropdownTime"></p>' +
                '<i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>';

            $("#tipSelectVideo").text("{{ __('step3.you_must_select_cuepoint') }}");
            $("#tipSelectVideo").css("display", "block");
            $("#widgetOptions").css("display", "none");
            $("#dropdownMenu2").html(defectoCuepoint);
        }



        function selectCuePoint(button) {

            if ($(button).attr("cuepoint-id") == $("#cuepointId").val()) {
                console.log("Same CuePoint Old == New: " + $(button).attr("cuepoint-id"));
                return;
            }

            $("#cuepointId").val($(button).attr("cuepoint-id"));

            let posDrop = button.getAttribute("pos");
            //console.log(posDrop);
            let counter = document.getElementById("dropdownId");
            //counter.innerHTML=posDrop;
            //$("#dropdownId").html($(button).attr("pos"));
            $("#dropdownName").html("");
            $("#dropdownTime").html($(button).children('p').eq(1).html());

            var defectoCuepoint = '<p class="m-0 c02"   id="dropdownId-Nav">  </p>' +
                '<p class="m-0 cMain" id="dropdownName-Nav">Seleccione Cuepoint</p>' +
                '<p class="m-0 c02"   id="dropdownTime-Nav">00:00:00:0</p>' +
                '<i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>';

            var defectoVideo = '<p class="m-0 c02"   id="dropdownId-Nav3">  </p>' +
                '<p class="m-0 cMain" id="dropdownName-Nav3">Seleccione Video</p>' +
                '<i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>';

            $("#dropdownMenu3").html(defectoCuepoint);
            $("#dropdownMenu4").html(defectoVideo);
            $("#tipSelectVideo").css("display", "none");

            var media = $("#projectVideo").attr("media-id");
            var cuepoint = $(button).attr("cuepoint-id");
            var contador = 1;
            $.each(cuePoints, function(i, item) {
                console.log("CuePoint: " + cuepoint + " - El Item: " + item.id);
                if (item.id == cuepoint) {
                    //Close if is Open EditToolTip
                    if (!$("#toolOptionEdit").hasClass("d-none")) {
                        optionEditorMode = "single";
                        $("#toolOptionEdit").addClass("d-none");
                    }

                    console.log("selectCuePoint() Found %o: ", item);
                    $("#dropdownId").html(posDrop);
                    contador++;

                    var vid = document.getElementById("projectVideo");
                    vid.currentTime = +item.time;

                    $("#cpType").val(item.type);

                    //Tagcuepoint
                    let tag = item.cuepointname;
                    if (tag != null) {
                        $("#cueName").val(item.cuepointname);
                    } else {
                        $("#cueName").val("cue-" + matchRounded(item.time));
                    }


                    if (item.type == 'BROWSE') {
                        console.log("selectCuePoint() Type BROWSE");
                        if (item.type_browse == null) {
                            item.type_browse = {};
                            item.type_browse.type = 'NONE';
                            item.type_browse.goto = null;
                            item.type_browse.options = null;
                            item.type_browse.tag = null;
                        }

                        $("#widgetContainer").empty();
                        //$("#widgetContainerForm").empty();
                        $("#widgetContainer").addClass("d-none");
                        $("#widgetContainerForm").addClass("d-none");

                        $("#pills-nav-tab").prop("onclick", null).off("click");
                        $("#pills-nav-tab").click();
                        $("#pills-nav-tab").attr('onclick', 'selectTypeBrowse()');
                        console.log("selectCuePoint() click on: pills-nav-tab");

                        if (item.type_browse.type == 'NONE') {
                            $("#subtypeNone").removeAttr('onclick');
                            $("#subtypeNone").click();
                            $("#subtypeNone").attr('onclick', 'selectBrowseNone()');
                        } else if (item.type_browse.type == 'URL') {
                            $("#subtypeURL").click();
                            $("#gotourl").val(item.type_browse.goto);

                            if (item.type_browse.options == '_blank')
                                $('#inlineRadio1').prop('checked', true);

                            if (item.type_browse.options == '_self')
                                $('#inlineRadio2').prop('checked', true);
                        } else if (item.type_browse.type == 'CUEPOINT') {
                            $("#subtypeCuepoint").click();

                            $("#cuepointList-Nav > button").each(function(index) {
                                if ($(this).attr("cuepoint-id") == item.type_browse.goto) {
                                    //console.log( "ENCONTRADO CUEPOINT: " + item.type_browse.goto);

                                    $(this).removeAttr("onclick");
                                    $(this).click();

                                    //Carga el valor cuando sea Browser y cue
                                    console.log("POS" + $(this).attr("pos"));
                                    $("#dropdownMenu3").attr("cuepoint-id", $(this).attr("cuepoint-id"));
                                    $("#dropdownId-Nav").html($(this).children('p').eq(0).html());
                                    $("#dropdownName-Nav").html("");
                                    $("#dropdownTime-Nav").html($(this).children('p').eq(1).html());
                                    $(this).attr("onclick", 'selectBrowseCuepoint(this)');
                                }
                            });
                        } else if (item.type_browse.type == 'VIDEO') {
                            $("#subtypeVideo").click();

                            $("#cuepointList-Nav3 > button").each(function(index) {
                                if ($(this).attr("projectlib-id") == item.type_browse.goto) {
                                    console.log("ENCONTRADO VIDEO: " + item.type_browse.goto);

                                    $(this).removeAttr("onclick");
                                    $(this).click();
                                    $("#dropdownMenu4").attr("projectlib-id", $(this).attr(
                                    "projectlib-id"));
                                    $("#dropdownName-Nav3").html($(this).attr("media-name"));
                                    $(this).attr("onclick", 'selectBrowseVideo(this)');
                                }
                            });
                        }

                        populateBrowseTagSelect(item.type_browse.tag || null);
                        $("#widgetOptionTitle").val("");
                        applyOptionWidgetTitleSize(OPTION_WIDGET_TITLE_SIZE_DEFAULT);
                        applyOptionWidgetTitleWeight(OPTION_WIDGET_TITLE_WEIGHT_DEFAULT);
                        applyOptionWidgetFontFamily(OPTION_WIDGET_FONT_DEFAULT);
                        updateWidgetBgImageLabel("");
                    } else if (item.type == 'OPTION') {
                        $("#widgetContainer").removeClass("d-none");
                        $("#widgetContainerForm").addClass("d-none");
                        console.log("selectCuePoint() Type OPTION");

                        if (item.type_option == null) {
                            item.type_option = {};
                        }
                        if (!item.type_option.type_option_data) {
                            item.type_option.type_option_data = [];
                        }
                        if (!item.type_option.type || (item.type_option.type !== 'COL' && item.type_option.type !== 'ROW')) {
                            item.type_option.type = 'ROW';
                        }
                        if (!item.type_option.options) {
                            item.type_option.options = 3;
                        }
                        if (!item.type_option.content || !String(item.type_option.content).trim().length) {
                            item.type_option.content = buildFreshDefaultOptionHtml();
                            item.action = 'UPDATE';
                        }

                        $("#pills-options-tab").prop("onclick", null).off("click");
                        $("#pills-options-tab").click();
                        $("#pills-options-tab").attr('onclick', 'selectTypeOption()');
                        console.log("selectCuePoint() click on: pills-options-tab");

                        $('a[name="cpOptSubType"]').off();

                        if (item.type_option.type == 'COL') {
                            $('#cpOptSubTypeCol').click();
                            console.log("selectCuePoint() click on: cpOptSubTypeCol");
                        }
                        if (item.type_option.type == 'ROW') {
                            $('#cpOptSubTypeRow').click();
                            console.log("selectCuePoint() click on: cpOptSubTypeRow");
                        }

                        $('a[name="cpOptSubType"]').on('shown.bs.tab', setTypeOptionValues);


                        $("#numberOfColRow").prop("onchange", null).off("change");
                        $('#numberOfColRow').val(item.type_option.options);
                        $("#numberOfColRow").attr('onchange', 'setTypeOptionValues()');
                        console.log("selectCuePoint() click on: numberOfColRow");

                        //console.log("Nuevo Contenido: " + item.type_option.content);
                        $("#widgetContainer").empty();
                        $("#widgetContainer").append(item.type_option.content);
                        $("#AB li .content").find(".ui-resizable-handle").remove();
                        ensureOptionWidgetStructure();
                        $("#AB").removeClass("d-none");
                        ifRowCol();
                        Start();


                        //$.each(item.data, function(i, data){
                        //	optionChild = $("#AB li:nth-child("+(i+1)+")");
                        //	optionChild.attr('class', data.class_options );
                        //	optionChild.attr('style', data.style_options );
                        //});
                    } else if (item.type == 'FORM') {
                        console.log("selectCuePoint() Type FORM");
                        $("#widgetContainer").addClass("d-none");
                        $("#widgetOptionTitle").val("");
                        applyOptionWidgetTitleSize(OPTION_WIDGET_TITLE_SIZE_DEFAULT);
                        applyOptionWidgetTitleWeight(OPTION_WIDGET_TITLE_WEIGHT_DEFAULT);
                        applyOptionWidgetFontFamily(OPTION_WIDGET_FONT_DEFAULT);
                        updateWidgetBgImageLabel("");

                        $("#pills-forms-tab").prop("onclick", null).off("click");
                        $("#pills-forms-tab").click();
                        $("#pills-forms-tab").attr('onclick', 'selectTypeForm()');
                        activateDynamicFormEditor(item);

                    }
                }
            });
            $("#widgetOptions").css("display", "block");
        }


        function selectTypeBrowse() {
            console.log("Ejecutando selectTypeBrowse() " + $("#libraryId").val());
            $("#widgetContainerForm").addClass("d-none");
            $("#widgetContainer").addClass("d-none");


            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {

                    if (item.type_browse == null) {
                        item.type_browse = {};
                        item.type_browse.type = 'NONE';
                        item.type_browse.goto = null;
                        item.type_browse.options = null;
                        item.type_browse.tag = null;
                    }

                    item.type = 'BROWSE';
                    item.type_browse.tag = $('#browseTag').val() || null;
                    //item.type_option = null;
                    item.action = 'UPDATE'
                    console.log("Actualizando cuepoint : " + item.id + " con cuepoint: NONE");
                    console.log("Actualizando cuepoint : %o", item);
                }
            });

        }


        function copyCuepointList() {
            console.log("Ejecutando copyCuepointList() " + $("#libraryId").val());

            var cuepointid = $("#cuepointId").val();
            $('#cuepointList-Nav').empty();
            $('#cuepointList > button').clone().appendTo('#cuepointList-Nav');

            $("#cuepointList-Nav > button").each(function(index) {
                $(this).attr("onclick", "selectBrowseCuepoint(this)");


                if ($(this).attr("cuepoint-id") == cuepointid) {
                    $(this).remove();
                }
            });
        }


        function selectBrowseCuepoint(button) {

            $("#dropdownMenu3").attr("cuepoint-id", $(button).attr("cuepoint-id"));
            $("#dropdownId-Nav").html($(button).children('p').eq(0).html())
            $("#dropdownName-Nav").html("");
            $("#dropdownTime-Nav").html($(button).children('p').eq(1).html());

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {

                    if (item.type_browse == null) {
                        item.type_browse = {};
                    }

                    item.type = 'BROWSE';
                    item.type_browse.type = 'CUEPOINT';
                    item.type_browse.goto = $(button).attr("cuepoint-id");
                    item.type_browse.options = null;
                    item.type_browse.tag = $('#browseTag').val() || null;
                    //item.type_option = null;
                    item.action = 'UPDATE'
                    console.log("Actualizando cuepoint : " + item.id + " con cuepoint: " + $(button).attr(
                        "cuepoint-id"));
                    console.log("Actualizando cuepoint : %o", item);
                }
            });
        }


        function copyVideoList() {
            console.log("Ejecutando copyVideoList() " + $("#projectVideo").attr("lib-id"));

            var projectlibid = $("#projectVideo").attr("lib-id");

            $('#cuepointList-Nav3').empty();

            $("#mediaList > li").each(function(index) {
                var currentId = $(this).attr("media-id");
                var currentlib = $(this).attr("proyectlib-id");
                console.log("Ejecutando copyVideoList() mirando " + currentlib);
                if (projectlibid != currentlib) {
                    console.log("Ejecutando copyVideoList() copiando: " + currentlib);
                    var btnAux = '<button onclick="selectBrowseVideo(this)" projectlib-id="' + currentlib +
                        '" media-id="' + currentId + '" media-name="' + $(this).attr("media-name") +
                        '" class="item row justify-content-between align-items-center text-center px-3 py-2 col-12 m-0" type="button">' +
                        '<p class="m-0 cMain"> ' + $(this).attr("media-name") + '</p>' +
                        '</button>';
                    $("#cuepointList-Nav3").append(btnAux);
                }
            });
        }


        function selectBrowseVideo(button) {
			console.log("Ejecutando selectBrowseVideo() " + $(button).attr("cuepoint-id") );

            $("#dropdownMenu4").attr("projectlib-id", $(button).attr("projectlib-id"));
            $("#dropdownName-Nav3").html($(button).attr("media-name"));


            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {

                    if (item.type_browse == null) {
                        item.type_browse = {};
                    }

                    item.type = 'BROWSE';
                    item.type_browse.type = 'VIDEO';
                    item.type_browse.goto = $(button).attr("projectlib-id");
                    item.type_browse.options = null;
                    item.type_browse.tag = $('#browseTag').val() || null;
                    //item.type_option = null;
                    item.action = 'UPDATE'
                    console.log("Actualizando cuepoint : %o", item);
                }
            });
        }


        function selectBrowseURL() {
			console.log("Ejecutando selectBrowseURL()");

            var newURL = $('#gotourl').val();

            if (newURL) {
                // /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)
                var expression =
                    /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/gi;
                var regex = new RegExp(expression);
                newURL = newURL.trim();
                newURL = newURL.match(regex) ? newURL : 'https://' + newURL;
                $('#gotourl').val(newURL);
            }

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {

                    if (item.type_browse == null) {
                        item.type_browse = {};
                    }

                    item.type = 'BROWSE';
                    item.type_browse.type = 'URL';
                    item.type_browse.goto = newURL;
                    item.type_browse.options = $('input:radio[name=goto_opt]:checked').val();
                    item.type_browse.tag = $('#browseTag').val() || null;
                    //item.type_option = null;
                    item.action = 'UPDATE'
                    console.log("Actualizando cuepoint : " + item.id + " con cuepoint: " + $('#gotourl').val());
                    console.log("Actualizando cuepoint : %o", item);
                }
            });
        }


        function selectBrowseNone() {
			console.log("Ejecutando selectBrowseNone()");

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {


                    if (item.type_browse == null) {
                        item.type_browse = {};
                    }

                    item.type = 'BROWSE';
                    item.type_browse.type = 'NONE';
                    item.type_browse.goto = null;
                    item.type_browse.options = null;
                    item.type_browse.tag = $('#browseTag').val() || null;
                    //item.type_option = null;
                    item.action = 'UPDATE'
                    console.log("Actualizando cuepoint : " + item.id + " con cuepoint: NONE");
                    console.log("Actualizando cuepoint : %o", item);
                }
            });
        }


        function selectTypeOption() {
            $("#widgetContainer").removeClass("d-none");
            $("#widgetContainerForm").addClass("d-none");

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {
                    var cpSubType = resolveCurrentOptionSubtype(item);
                    console.log("selectTypeOption() cpSubType: " + cpSubType);

                    if (item.type_option == null) {
                        $("#widgetContainer").html(buildFreshDefaultOptionHtml());
                        item.type_option = {};
                        item.type_option.type_option_data = [];
                    } else if (!item.type_option.type_option_data) {
                        item.type_option.type_option_data = [];
                    }

                    if (!$("#AB").length) {
                        $("#widgetContainer").html(buildFreshDefaultOptionHtml());
                    }

                    ensureOptionWidgetStructure();

                    item.type_option.type = cpSubType;
                    item.type_option.goto = null;
                    item.type_option.options = $('#numberOfColRow').val() || item.type_option.options || 3;
                    item.type_option.content = $("#widgetContainer").html();

                    $("#AB").removeClass("d-none");
                    item.type = 'OPTION';
                    item.action = 'UPDATE';

                    console.log("Actualizando OPTION cuepoint : %o", item);
                    Start();
                    return;
                }
            });
        }


        $('a[name="cpOptSubType"]').on('shown.bs.tab', setTypeOptionValues);

        function setTypeOptionValues() {
            console.log("setTypeOptionValues() cpSubType: " + $("#cuepointId").val());

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {
                    if (item.type_option == null) {
                        item.type_option = {};
                        item.type_option.type_option_data = [];
                    } else if (!item.type_option.type_option_data) {
                        item.type_option.type_option_data = [];
                    }

                    var cpSubType = resolveCurrentOptionSubtype(item);
                    $("#AB").removeClass("d-none");
                    console.log("Actualizando OPTION cuepoint : %o", item);
                    ifRowCol();
                    NumberOnOff();
                    ensureOptionWidgetStructure();

                    item.type_option.type = cpSubType;
                    item.type_option.options = $('#numberOfColRow').val() || item.type_option.options || 3;
                    item.type_option.content = $("#widgetContainer").html();
                    if (Array.isArray(item.type_option.type_option_data)) {
                        item.type_option.type_option_data.forEach(function(optionData) {
                            if (!optionData || !optionData.uuid) {
                                return;
                            }
                            var optionLi = $('#AB li[uuid="' + optionData.uuid + '"]');
                            if (optionLi.length) {
                                optionData.content = optionLi.prop('outerHTML');
                            }
                        });
                    }
                    item.action = 'UPDATE';

                    return;
                }
            });
        }


        function updateCueName() {
            console.log("updateCueName() Name: " + $('#cueName').val());

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {
                    if (item.cuepointname == $('#cueName').val().trim()) {
                        console.log("Same Name, nothing to do");
                        return;
                    }

                    item.cuepointname = $('#cueName').val().trim();
                    item.action = 'UPDATE';

                    console.log("Actualizando OPTION cuepoint : %o", item);
                    return;
                }
            });
        }


        function setOptionDataValues(optionData, values, index) {
            //console.log("setOptionDataValues() cpSubType: " + index + " - Data: " + optionData);
            Start();
            var updated = false;

            $.each(optionData, function(i, item) {
                if (item.uuid == $(values).attr("uuid")) {
                    item.name = "Titulo " + index;
                    item.name =
                        //console.log("Update OptionData : %o",  item);
                        updated = true;
                }
            });

            if (!updated) {
                var newData = newOptionData(index, false, null, 'Titulo ' + index, null, optionChild.attr('class'),
                    optionChild.attr('style'), null, null);
                optionData.push(newData);
                //console.log("New OptionData : %o",  newData);
            }
        }


        function newOptionData(position, image_yn, image, title, content, class_opt, style_opt, sGoto, options) {
            console.log("newOptionData()");

            var cue = {
                position: position,
                image_yorn: image_yn,
                image: image,
                title: title,
                content: content,
                calss_options: class_opt,
                style_options: style_opt ? style_opt : null,
                sGoto: sGoto,
                options: options
            }

            return cue;
        }


        function selectTypeForm() {
            if (typeof window.dynamicSelectTypeForm === 'function') {
                window.dynamicSelectTypeForm();
                return;
            }

            $("#widgetContainerForm").removeClass("d-none");
            $("#widgetContainer").addClass("d-none");

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {

                    if (item.type_form == null) {
                        //$("#widgetContainerForm").html(defaultForm);
                        //Start();

                        /////////////////
                        deleteOldCode();

                        //Hover in Li-Option
                        $(".edit-tooltip").remove();
                        Hoverli();

                        //Edit PANEL
                        ToolEditPanel();
                        formEditTools();
                        formColorsTools();

                        //Draggable toolOptionEdit
                        //$( "#toolOptionEdit" ).draggable();
                        //sortables();

                        //Cambio de Row a Col
                        RowColPress();

                        //Change Device
                        changeDevice();

                        //Numero de Row a Col
                        NumberOnOff();

                        //Background Panel de Opciones y Alfa
                        limitAlpha();
                        //BgAB();
                        //setBG();

                        //Font Size
                        fontSize();

                        resizeAddmedia();
                        //////////////////////

                        item.type_form = {};
                        item.type_form.content = defaultForm;
                        item.type_form.name = "";
                        item.type_form.sendto = "";
                        item.type_form.type = "URL";
                        item.type_form.goto = "";
                        item.type_form.options = "_blank";

                        console.log("Setting default FORM");
                        $("#widgetContainerForm").html(defaultForm);
                        $("#inputName").val("");
                        $("#inputSendTo").val("");
                        $("#gotourlOption-form").val("");
                        $("#gotourlOption-form").val(false);
                        $('#inlineRadioOpt1-form').prop('checked', true);
                    } else {
                        $("#widgetContainerForm").append(item.type_form.content);

                        $("#inputName").val(item.type_form.name);
                        $("#inputSendTo").val(item.type_form.sendto);
                        $("#gotourlOption-form").val(item.type_form.goto);

                        if (item.type_form.options == '_blank')
                            $('#inlineRadioOpt1-form').prop('checked', true);

                        if (item.type_form.options == '_self')
                            $('#inlineRadioOpt2-form').prop('checked', true);

                    }
                    $("#AF").removeClass("d-none");
                    formtitleF();
                    item.type = 'FORM';
                    item.action = 'UPDATE';

                    console.log("1. Actualizando FORM cuepoint : %o", item);
                    formColorsTools();
                    formEditTools();
                    loadCrmField();


                    return;
                }
            });
        }

        function updateTypeForm() {
            if ($("#widgetContainerForm #AF[data-form-builder='dynamic']").length && typeof window.dynamicUpdateTypeForm === 'function') {
                window.dynamicUpdateTypeForm();
                return;
            }

            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {

                    item.type_form.content = $("#widgetContainerForm").html();
                    item.type_form.name = $('#inputName').val().trim();
                    item.type_form.sendto = $('#inputSendTo').val().trim();
                    item.type_form.map_status = $('#map-crm-form-edit').is(':checked');
                    item.action = 'UPDATE';

                    console.log("2. Actualizando FORM cuepoint : %o", item);

                    return;
                }
            });
        }
        // -INICIO
        function copyCuepointListForm() {
            console.log("Ejecutando copyCuepointListForm() " + $("#libraryId").val());

            $("#dropdownMenuAccion > p").html("Ir a Cuepoint");

            var cuepointid = $("#cuepointId").val();
            $('#cuepointList-Nav22-form').empty();
            $('#cuepointList > button').clone().appendTo('#cuepointList-Nav22-form');

            $("#cuepointList-Nav22-form > button").each(function(index) {
                $(this).attr("onclick", "selectBrowseCuepointForm(this)");

                if ($(this).attr("cuepoint-id") == cuepointid) {
                    $(this).remove();
                }
            });


            $.each(cuePoints, function(i, item) {
                if (item.id == $("#cuepointId").val()) {
                    item.type_form.type = "CUEPOINT";
                    item.action = 'UPDATE';
                }
            });

        }


        function selectBrowseCuepointForm(button){
    		$("#dropdownMenu33-form").attr("cuepoint-id", $(button).attr("cuepoint-id"));
        	$("#dropdownName-Nav11-form").html($(button).children('p').eq(0).html());
        	$("#dropdownTime-Nav11-form").html($(button).children('p').eq(1).html());

        	$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				item.type_form.type = "CUEPOINT";
        		    item.type_form.goto = $(button).attr("cuepoint-id");
    				item.action         = 'UPDATE';

    				console.log("Actualizando Form Cuepoint : "  +item.id+ " con cuepoint: " + $(button).attr("cuepoint-id"));
    				console.log("3. Actualizando Form Cuepoint : %o",  item);
    			}
          });
    	}


        function copyVideoListForm(){
    		console.log("Ejecutando copyVideoListForm() " + $("#projectVideo").attr("lib-id"));
    		$("#dropdownMenuAccion > p").html("Ir a Video");

      		var projectlibid = $("#projectVideo").attr("lib-id");

      		$('#cuepointList-Nav33-form').empty();

      		$( "#mediaList > li" ).each(function( index ) {
      			var currentId = $(this).attr("media-id");
      			var currentlib= $(this).attr("proyectlib-id");
      			console.log("Ejecutando copyVideoListForm() mirando " + currentlib);
    			if(  projectlibid != currentlib){
    				console.log("Ejecutando copyVideoListForm() copiando: " + currentlib);
    				var btnAux = '<button onclick="selectBrowseVideoForm(this)" projectlib-id="'+currentlib+'" media-id="' + currentId + '" media-name="' + $(this).attr("media-name") + '" class="item row justify-content-between align-items-center text-center px-3 py-2 col-12 m-0" type="button">'
									+'<p class="m-0 cMain"> '+ $(this).attr("media-name") +'</p>'
								+'</button>';
                  $("#cuepointList-Nav33-form").append(btnAux);
    			}
      		});

      		$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				item.type_form.type = "VIDEO";
    				item.action         = 'UPDATE';
    			}
          	});
      	}





        function selectBrowseVideoForm(button){
    		$("#dropdownMenu44-form").attr("projectlib-id", $(button).attr("projectlib-id"));
        	$("#dropdownName-Nav33-form").html( $(button).attr("media-name") );

        	$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				item.type_form.type = "VIDEO";
        		    item.type_form.goto = $(button).attr("projectlib-id");
					item.action         = 'UPDATE';

					console.log("Actualizando Form Video : "  +item.id+ " con Video: " + $(button).attr("projectlib-id"));
    				console.log("Actualizando Form Video : %o",  item);
    			}
          });
    	}


        function selectFormBrowseURL(){
    		var newURL  = $('#gotourlOption-form').val();
    		var newOpt  = $('input:radio[name=goto_opt_opt_form]:checked').val();

    		if(newURL){
    			//var expression = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/gi;
    			//var regex = new RegExp(expression);
    			//newURL = newURL.trim();
    			//newURL = newURL.match(regex) ? newURL : 'https://' + newURL;

    			newURL = newURL.trim().replace(/\s/g,'');

    			const patron = /^(http:\/\/|https:\/\/|ftp:\/\/|www\.)/;

  				if(!patron.test(newURL)){
  					newURL = 'https://' + newURL;
  	  			}

    			$('#gotourlOption-form').val(newURL);
    		}

        	$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				item.type_form.type = "URL";
        		    item.type_form.goto = newURL;
					item.action         = 'UPDATE';

    				console.log("Actualizando Form de Cuepoint : "  +item.id+ " con URL: " + newURL);
    				console.log("Actualizando Form de Cuepoint : %o",  item);
    			}
          	});
		}

		// -FINALIZA


    	function openDialogImg(target){
    		optionMediaTarget = target || "option-image";
    		console.log("openDialogImg() target=" + optionMediaTarget);
         	$('#libraryModal').modal('show');

            if(optionMediaTarget === "widget-bg"){
                $("#optionUuid").val("");
            } else if (tLi && tLi.length) {
                $("#optionUuid").val(tLi.attr("uuid"));
            }
        }


    	function selectMedia(){
    		console.log("selectMedia()");

            var blnSelected = false;
            var imgSelected = false;
			var fldSelected = false;

            $('#libraryModal input[type=checkbox]').each(function() {

                $(this).change(function() {
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
                    console.log("Seleccionado: " + name);

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

            		var mediaId  = $(this).parent().next().attr("media-id");
            		var mediaSrc = $(this).parent().next().attr("media-src");
            		var mediaPreview = $(this).parent().next().attr("media-preview");
            		var mediaImg = $(this).parent().next().attr("src");

                    blnSelected = true;
                    $(this).prop("checked", false);
                    $(this).parent().removeClass('selected');

                    if(optionMediaTarget === "widget-bg"){
                        applyOptionWidgetBackground(mediaPreview || mediaSrc, name);
                        setTypeOptionValues();
                    } else if (tLi && tLi.length) {
                        var imgS = tLi.find("img");
                        imgS.attr("src", mediaSrc);
                        imgS.attr("imgid", name);
                        setTypeOptionDataImgId(name);
                        setTypeOptionValues();
                        console.log("Lo Actual img: %o", imgS.attr("src"));
                    }

                    $("#deleteMediaFileBtn").hide();
                    console.log("Los cuepoints: %o", cuePoints);
                    console.log(" Id: " + mediaId + ", Media:" + mediaSrc + ", Img:" + mediaImg);
                }
            });


            if(blnSelected)
            	$('#libraryModal').modal('hide');
            if(imgSelected)
				modalMsgShow("No se permite seleccionar Videos");
			if(fldSelected)
				modalMsgShow("No se permite seleccionar Carpetas");

			imgSelected = false;
			fldSelected = false;
			blnSelected = false;
            optionMediaTarget = "option-image";
		}

		function setTypeOptionDataImgId( imgId ){
			console.log("setTypeOptionDataImgId ID: " + imgId);

			$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				arrOpciones = item.type_option.type_option_data;
					var updated = false;

    				$.each(arrOpciones, function(j, data) {
						if(data.uuid == $("#optionUuid").val()){
							data.library_img = imgId;
							updated = true;
						}
        			});

        			if(!updated){
        				var data = {
    		    			uuid : $("#optionUuid").val(),
    		    			library_img : imgId,
    		    			name : null,
    		    			type : 'URL',
    		    			goto : null,
    		    			options : '_blank',
    		    			tag : ($('#optionTag').val() || null),
    		    			content : $('li[uuid=' + $("#optionUuid").val() + ']').prop('outerHTML'),
        				};

        				arrOpciones.push(data);
                	}

    				item.action = 'UPDATE'
    				setTypeOptionValues();
    				console.log("Actualizando LIBRARY_IMG cuepoint : %o", item);

    			}

	        });
    	}


        //-----------------------------------------PRESS A WIDGET (HIDE/SHOW OPTIONS)-----------------------------------------//
        $(".widgetSelect a").click(function() {



            if ($(this).attr('value') == 'OPTION') {
                $("#widgetContainerForm").addClass("d-none");
                $("#widgetContainer").removeClass("d-none");
                $("#AB").removeClass("d-none");
                ifRowCol();
            } else if ($(this).attr('value') == 'FORM') {
                $("#widgetContainer").addClass("d-none");
                $("#widgetContainerForm").removeClass("d-none");
                $("#AF").removeClass("d-none");

            } else if ($(this).attr('value') == 'BROWSE') {
                console.log("none");
                $("#widgetContainer").addClass("d-none");
                $("#widgetContainerForm").addClass("d-none");
                //Close if is Open EditToolTip
                if (!$("#toolOptionEdit").hasClass("d-none")) {
                    optionEditorMode = "single";
                    $("#toolOptionEdit").addClass("d-none");
                }

            }

        });


        //-----------------------------------------IF IS COL OR ROW-----------------------------------------//
        function ifRowCol() {
            console.log("ifRowCol()");
            //var x = 0;
            if ($("#AB").hasClass("optionsCols")) {
                $("#AB").removeClass("cols-1 cols-2 cols-3 cols-4 cols-5 cols-6");
                var colsN = "cols-" + $("#numberOfColRow").val();
                console.log("ifRowCol() colsN = " + colsN);
                $("#AB").addClass(colsN);
                $("#AB li .content").css("width", "100%");
            } else if ($("#AB").hasClass("optionsRows")) {
                $("#AB").removeClass("rows-1 rows-2 rows-3 rows-4 rows-5 rows-6");
                var rowsN = "rows-" + $("#numberOfColRow").val();
                console.log("ifRowCol() rowsN = " + rowsN);
                $("#AB").addClass(rowsN);
                $("#AB .content").css("height", "100%");
            }
        }

        //-----------------------------------------CLICK MOBILE LI - EDIT TOOL TIP - POWER-----------------------------------------//
        var tLi = "";
        var t = "";

        //-----------------------------------------SLIDER WITDH & HEIGTH-----------------------------------------//
        function sliderSet() {
            console.log("sliderSet()");
            //width
            if ($("#AB").hasClass("optionsRows")) {
                //width
                $(".sliderWidth").val(tLi.find(".content:first").width() * 100 / tLi.width());
            } else if ($("#AB").hasClass("optionsCols")) {
                //height
                $(".sliderWidth").val(tLi.find(".content:first").height() * 100 / tLi.height());
            }
        }


        //-----------------------------------------HOVER LI - EDIT TOOL TIP - POWER-----------------------------------------//
        function Hoverli() {
            console.log("Hoverli()");
            $("#AB").off("click.optionSelect");
            $("#AB li p").off('blur');

            $("#AB").on("click.optionSelect", "li, li *", function(event) {
                var selectedLi = $(event.target).closest("li");
                if (!selectedLi.length || !selectedLi.closest("#AB").length) {
                    return;
                }

                t = selectedLi;
                tLi = selectedLi;
                $("#AB li").removeClass("selected");
                tLi.addClass("selected");
                clearStyle();
                $(".edit-tooltip").remove();
                $(".edit-tooltipM").remove();
                t.prepend(
                    '<div class="edit-tooltip"><div class="power on mx-2"><i class="fas fa-power-off"></i></div><i class="fas fa-exchange-alt mx-2 changeP"></i><div class="editBtn  mr-2"><i class="fas fa-pencil-alt"></i></div><i class="fas fa-arrows-alt"></i></div>'
                    );
                $(".addVideoMain").after(
                    '<div class="edit-tooltipM d-lg-none"><div class="mx-2"><p class="numberLi p-0 m-0">0</p></div><div class="power on mx-2"><i class="fas fa-power-off"></i></div><input class="sliderWidth" type="range" min="1" max="100" value="50"><div class="mx-2 posMove"><i class="fas fa-arrow-up"></i><i class="fas fa-arrow-down ml-3"></i></div><i class="fas fa-exchange-alt mx-2 changeP"></i><div class="editBtn  mx-2"><i class="fas fa-pencil-alt"></i></div></div>'
                    );

                sliderSet();
                ChargeToolTip(t);
                EditorOpen();
                loadResizable(t);
                //sortables(t);
                orderNumber();
                getLiImage();
                ctextLiChange();
                /*var c = t.find(".content");
                c.append('<i class="fas fa-arrows-alt moveContent"></i>');*/
            });

            function orderNumber() {
                console.log("orderNumber()");
                $('.posMove .fa-arrow-up').off("click");
                $('.posMove .fa-arrow-down').off("click");

                $(".numberLi").text(tLi.attr("data-id"));
                //console.log(tLi.attr("data-id"));

                $('.posMove .fa-arrow-up').on("click", function() {
                    if (tLi.attr("data-id") == 1) {
                        var lastPos = $('#numberOfColRow').val() - 1;
                        tLi.insertBefore(tLi.siblings(':eq(' + lastPos + ')'));
                        orderPos();
                        Hoverli();
                    } else {
                        tLi.insertBefore(tLi.siblings(':eq(' + (tLi.attr("data-id") - 2) + ')'));
                        orderPos();
                        Hoverli();
                    }
                });

                $('.posMove .fa-arrow-down').on("click", function() {
                    if (tLi.attr("data-id") == $('#numberOfColRow').val()) {
                        tLi.insertBefore(tLi.siblings(':eq(0)'));
                        orderPos();
                        Hoverli();
                    } else {
                        tLi.insertBefore(tLi.siblings(':eq(' + tLi.attr("data-id") + ')'));
                        orderPos();
                        Hoverli();
                    }
                });
            }

            function ctextLiChange() {
                console.log("ctextLiChange()");
                var contents = tLi.find("p");

                tLi.find("p").blur(function() {
                    console.log("cambio PP");
                    setTypeOptionValues();
                });
                tLi.find("p").on('keydown', function(event) {
                    if (event.key == 'Enter') {
                        event.preventDefault();
                        document.execCommand('insertHTML', false, '<br>');
                        const range = document.createRange();
                        const selection = window.getSelection();
                        range.setStartAfter(tLi.find("p")[0].lastChild);
                        range.collapse(true);
                        selection.removeAllRanges();
                        selection.addRange(range);

                    }
                });
            }

            function clearStyle() {
                console.log("clearStyle()");
                tLi.css("transform", "");
            }

            function getLiImage() {
                console.log("getLiImage()");
                $("#imgGetIn").remove();
                var imgS = tLi.find("img");
                var contentS = imgS.parent();

                if (tLi.hasClass("imgOff")) {

                } else {
                    contentS.prepend("<button id='imgGetIn'></button>");
                    $("#imgGetIn").css("width", imgS.css("width"));
                    $("#imgGetIn").css("height", imgS.css("height"));

                    //AQUI LLAMO LA BIBLIOTECA
                    $("#imgGetIn").on("click", function() {
                        openDialogImg("option-image");

                        //console.log("Los cuepoints: %o", cuePoints );
                    });
                }
            };

            //-----------------------------------------ORDERNUMBER POS ARROW-----------------------------------------//

            //-----------------------------------------EDIT TOOLTIP CHARGE-----------------------------------------//
            function ChargeToolTip(t) {
                console.log("ChargeToolTip()");
                //-----------------------------------------ON/OFF-----------------------------------------//
                $(".power").click(function() {
                    t.toggleClass("disable bg-none enable");
                    loadResizable(t);
                    setTypeOptionValues();
                });

                //-----------------------------------------Change Position Content-----------------------------------------//
                $(".changeP").click(function() {
                    t.find(".content:first").appendTo(t);
                    loadResizable(t);
                    sliderSet();
                    setTypeOptionValues();
                });
            }
        }
        //-----------------------------------------END HOVER-----------------------------------------//


        //-----------------------------------------SE LEE Y APLICA LOS CAMBIOS DEL EDIT TOOL PANEL-----------------------------------------//
        function SetOptionChange(option) {
            //console.log("SetOptionChange()");
            _option = option;

            if (!$("#toolOptionEdit").hasClass("d-none")) {
                function applyToStyleTargets(applyChange) {
                    var targets = getCurrentOptionEditorTargets();

                    if (optionEditorMode === "global") {
                        if (targets && targets.length) {
                            applyChange(targets);
                        }
                        syncGlobalStyleFromControls();
                        applyGlobalStyleToInheritedOptions();
                        setTypeOptionValues();
                        return;
                    }

                    if (!_option || !_option.length || getOptionUseGlobalStyle(_option)) {
                        return;
                    }

                    targets = _option;
                    applyChange(targets);
                    setTypeOptionValues();
                }

                //sizes
                $("#toolOptionEdit .sizes .slider-alpha").off('input.optionEdit').on('input.optionEdit', function() {
                    var size = $("#toolOptionEdit .sizes .slider-alpha").val();
                    applyToStyleTargets(function(targets) {
                        targets.removeClass("s-10 s-20 s-30 s-40 s-50 s-60 s-70 s-80 s-90 s-25 s-75 s-100");
                        targets.addClass("s-" + size);
                    });
                });

                //aling
                $("#toolOptionEdit .aling li").off('click.optionEdit').on('click.optionEdit', function() {
                    var alignClass = $(this).attr("data-id") || "aCenter";
                    applyToStyleTargets(function(targets) {
                        targets.removeClass("aCenter aEnd aStart");
                        targets.addClass(alignClass);
                    });
                });

                //image
                $("#toolOptionEdit #optionImageEnabled").off('change.optionEdit').on('change.optionEdit', function() {
                    var imageEnabled = $(this).is(':checked');
                    applyToStyleTargets(function(targets) {
                        targets.each(function() {
                            applyOptionImageState(this, imageEnabled);
                        });
                    });

                    sliderSet();
                    if (tLi && typeof tLi.find === "function" && tLi.length) {
                        loadResizable(tLi);
                    }
                });

                //backgroud
                $("#toolOptionEdit #hexcolorBG").off('change.optionEdit').on('change.optionEdit', function() {
                    var hex = $("#toolOptionEdit #hexcolorBG").val();
                    applyToStyleTargets(function(targets) {
                        targets.css('background-color', hex);
                    });
                });
                $("#toolOptionEdit #colorpickerBG").off('change.optionEdit').on('change.optionEdit', function() {
                    var color = $("#toolOptionEdit #colorpickerBG").val();
                    applyToStyleTargets(function(targets) {
                        targets.css('background-color', color);
                    });
                });

                //Border
                $("#toolOptionEdit #hexcolor").off('change.optionEdit').on('change.optionEdit', function() {
                    var hex = $("#toolOptionEdit #hexcolor").val();
                    var borN = sanitizeOptionBorderWidth($("#toolOptionEdit #borderNumber").val());
                    applyToStyleTargets(function(targets) {
                        targets.css('border', hex + " solid " + borN + "px");
                    });
                });
                $("#toolOptionEdit #colorpicker").off('change.optionEdit').on('change.optionEdit', function() {
                    var color = $("#toolOptionEdit #colorpicker").val();
                    var borN = sanitizeOptionBorderWidth($("#toolOptionEdit #borderNumber").val());
                    applyToStyleTargets(function(targets) {
                        targets.css('border', color + " solid " + borN + "px");
                    });
                });
                $("#toolOptionEdit #borderNumber").off('change.optionEdit').on('change.optionEdit', function() {
                    var color = $("#toolOptionEdit #colorpicker").val() || $("#toolOptionEdit #hexcolor").val();
                    var borN = sanitizeOptionBorderWidth($("#toolOptionEdit #borderNumber").val());
                    $("#toolOptionEdit #borderNumber").val(borN);
                    applyToStyleTargets(function(targets) {
                        targets.css('border', color + " solid " + borN + "px");
                    });
                });

                //FONT
                $("#toolOptionEdit #hexcolorFont").off('change.optionEdit').on('change.optionEdit', function() {
                    var hex = $("#toolOptionEdit #hexcolorFont").val();
                    applyToStyleTargets(function(targets) {
                        targets.find(".context p, .content p").css("color", hex);
                    });
                });
                $("#toolOptionEdit #colorpickerFont").off('change.optionEdit').on('change.optionEdit', function() {
                    var color = $("#toolOptionEdit #colorpickerFont").val();
                    applyToStyleTargets(function(targets) {
                        targets.find(".context p, .content p").css("color", color);
                    });
                });

                $("#toolOptionEdit #optionIconClass").off('input.optionEdit').on('input.optionEdit', function() {
                    if (optionEditorMode === "global" || !_option || !_option.length) {
                        return;
                    }
                    applyOptionIconClass(_option, $(this).val());
                    setTypeOptionValues();
                });

                $("#toolOptionEdit #optionUseGlobalStyle").off('change.optionEdit').on('change.optionEdit', function() {
                    if (optionEditorMode === "global" || !_option || !_option.length) {
                        return;
                    }

                    var useGlobal = $(this).is(":checked");
                    setOptionUseGlobalStyleFlag(_option, useGlobal);
                    if (useGlobal) {
                        applyGlobalStyleToOption(_option);
                    }

                    setOption(_option);
                    setTypeOptionValues();
                });

            } else {
                // console.log("esta cerrado");
            }
        }


        //-----------------------------------------APLICAR MODIFICACIONES CONTENIDO-----------------------------------------//
        function setOption(option) {
            console.log("setOption()");
            _option = option;
            ensureOptionWidgetStructure();

            if (!_option || !_option.length) {
                updateOptionEditorModeUI();
                return;
            }

            ensureOptionUseGlobalFlag(_option);

            var isGlobalMode = optionEditorMode === "global";
            var usingGlobal = !isGlobalMode && getOptionUseGlobalStyle(_option);
            var styleData = isGlobalMode ? readGlobalOptionStyle() : (usingGlobal ? readGlobalOptionStyle() : readGlobalStyleFromOption(_option));
            var sizeValue = parseInt(String(styleData.sizeClass || "s-50").replace("s-", ""), 10);
            if (isNaN(sizeValue) || sizeValue < 10 || sizeValue > 100) {
                sizeValue = 50;
            }

            $("#toolOptionEdit .aling li").removeClass("active");
            var alignTarget = $("#toolOptionEdit .aling li[data-id='" + (styleData.alignClass || "aCenter") + "']");
            if (alignTarget.length) {
                alignTarget.addClass("active");
            } else {
                $("#toolOptionEdit .aling li[data-id='aCenter']").addClass("active");
            }

            $("#toolOptionEdit .sizes .slider-alpha").val(sizeValue);
            $("#toolOptionEdit #optionImageEnabled").prop("checked", styleData.imageEnabled !== false);
            $("#toolOptionEdit #colorpickerBG").val(styleData.backgroundColor);
            $("#toolOptionEdit #hexcolorBG").val(styleData.backgroundColor);
            $("#toolOptionEdit #colorpicker").val(styleData.borderColor);
            $("#toolOptionEdit #hexcolor").val(styleData.borderColor);
            $("#toolOptionEdit #borderNumber").val(sanitizeOptionBorderWidth(styleData.borderWidth));
            $("#toolOptionEdit #colorpickerFont").val(styleData.fontColor);
            $("#toolOptionEdit #hexcolorFont").val(styleData.fontColor);

            if (!isGlobalMode) {
                $("#toolOptionEdit #optionUseGlobalStyle").prop("checked", usingGlobal);
                ensureOptionIconElement(_option);
                $("#toolOptionEdit #optionIconClass").val(readOptionIconClass(_option));
            } else {
                $("#toolOptionEdit #optionIconClass").val("");
            }

            updateOptionEditorModeUI();
        }


        //-----------------------------------------ABRIR EDITOR DE OPCIONES-----------------------------------------//

        function EditorOpen() {
            console.log("EditorOpen()");
            console.log(tLi);
            $(".editBtn").off("click");

            //ClickOptionsTool
            $(".editBtn").on("click", function() {
                $("body").css("overflow", "hidden");
                ensureOptionWidgetStructure();
                optionEditorMode = "single";

                if (!tLi || !tLi.length) {
                    tLi = $("#AB li").first();
                }
                if (!tLi || !tLi.length) {
                    return;
                }

                //console.log("Hola Click");
                var xyPositiont = $(this).offset();
                $("#toolOptionEdit").removeClass("d-none");
                $("#toolOptionEdit").show(500);
                //$("#toolOptionEdit").css("left", xyPositiont.left);
                //$("#toolOptionEdit").css("top", xyPositiont.top - 50)
                SetOptionChange(tLi);
                setOption(tLi);
                $("#optionUuid").val(tLi.attr("uuid"));
                //setTypeOptionValues();
                //Esta funcion existe en tool-option-edit y es la encargada de actualizar los datos
                //del panel derecho con la info del json.

                setOptionValues();

            });

        }


        //-----------------------------------------IF PRESS COL OR ROW-----------------------------------------//
        function RowColPress() {
            console.log("RowColPress()");
            $("#cpOptSubTypeCol").off("click");
            $("#cpOptSubTypeRow").off("click");

            //col
            $("#cpOptSubTypeCol").on("click", function() {
                $("#AB").removeClass();
                var colsNumber = "cols-" + $("#numberOfColRow").val();
                $("#AB").addClass("ActionBox optionsCols " + colsNumber);
                ifRowCol();
                ImagePower()
            });

            //row
            $("#cpOptSubTypeRow").on("click", function() {
                $("#AB").removeClass();
                var rowsNumber = "rows-" + $("#numberOfColRow").val();
                $("#AB").addClass("ActionBox optionsRows " + rowsNumber);
                //eventosOpciones()
                ifRowCol();
                ImagePower()
            });
        }


        //-----------------------------------------HIDE &  SHOW-----------------------------------------//
        function NumberOnOff() {
            console.log("NumberOnOff()");
            //-----------------------------------------CHANGE NUMBER OF COL OR ROW-----------------------------------------//
            //$('#numberOfColRow').on('change', function (e) {
            //	ifRowCol();
            //	NumberOnOff();
            //});

            var xn = 0;

            $("#AB").find("li").each(function() {
                if (xn != $('#numberOfColRow').val()) {
                    $(this).show();
                    xn++;
                    //selectTypeOption();
                } else {
                    $(this).hide();
                    //selectTypeOption();
                }
            });
        }

        //-----------------------------------------FONT SIZE-----------------------------------------//
        function fontSize() {
            /*console.log("fontSize()");
          		var fontW = $("#AB").css('font-size').slice(0,-2);
          		$("#fontNumber").val(fontW)*/

            //console.log("entro  a font");
            $("#fontNumber").change(function() {
                var fontN = $("#fontNumber").val();
                //console.log("la fuente es: "+fontN);
                $("#AB").attr("data-desktop", fontN);
                ifMobile();
                setTypeOptionValues();
                //console.log("The text has been changed.");
            });


            //data-mobile-null
            var fontWM = $("#AB").data("mobile");
            if (fontWM != null) {
                $("#fontNumberM").val(fontWM);
                ifMobile();
            } else {
                var fontM = $("#fontNumberM").val();
                $("#AB").attr("data-mobile", fontM);
                ifMobile();
            }

            //data-desktop-null
            var fontWD = $("#AB").data("desktop");
            if (fontWD != null) {
                $("#fontNumber").val(fontWD);
                ifMobile();
            } else {
                var fontD = $("#fontNumber").val();
                $("#AB").attr("data-desktop", fontM);
                ifMobile();
            }



            $("#fontNumberM").change(function() {
                var fontM = $("#fontNumberM").val();
                //console.log("la fuente es: "+fontN);
                $("#AB").attr("data-mobile", fontM);
                ifMobile();
                setTypeOptionValues();
                //console.log("The text has been changed.");
            });


        }


        //-----------------------------------------CHANGE COLOR BG AB-----------------------------------------//
        function BgAB() {
            console.log("BgAB()");
            //Color_Picker Background
            $('#bg-AB').on('input', function() {
                $('#hexBg-AB').val(this.value);

            });
            $('#hexBg-AB').on('input', function() {
                $('#bg-AB').val(this.value); //
            });

            //LOAD
            //Si cambia el valor de Hex
            $("#hexBg-AB").change(function() {
                var hex = $("#hexBg-AB").val();
                var a = $("#opacity-AB ").val();
                $("#AB").css('background-color', hex);
                addAlpha();
                setTypeOptionValues();
            });

            //Si cambia el valor de ColorPicker
            $("#bg-AB").change(function() {
                var color = $("#bg-AB").val();
                var a = $("#opacity-AB ").val();
                $("#AB").css('background-color', color);
                addAlpha();
                setTypeOptionValues();

            });

            //Si cambia el valor de alpha
            $('#opacity-AB').on('change', function(e) {
                var hex = $("#hexBg-AB").val();
                var a = $("#opacity-AB ").val();
                $("#AB").css('background-color', hex);
                addAlpha();
                setTypeOptionValues();
            });
        }

        function setBG() {
            console.log("addAlpha()");
            var alphaC = $("#AB").css("background-color").split(",").splice(-1, 1, "");
            var alphaN = alphaC[0].replace(")", ""); //console.log(alphaN);
            alphaN = alphaN.slice(1, 5);
            console.log(alphaN);

            var colorAB = RgbaTohex($("#AB").css("background-color"));
            console.log("el color es " + colorAB);
            $("#bg-AB").val(colorAB);
            $('#hexBg-AB').val(colorAB);
            $('#opacity-AB').val(alphaN * 100);
        }


        //-----------------------------------------ADD ALPHS BG-AB-----------------------------------------//
        function addAlpha() {
            console.log("addAlpha()");
            var opAB = $("#opacity-AB").val();
            var opVal = "," + opAB / 100 + ")";

            //console.log(opVal);
            var oldBGColor = $('#AB').css('backgroundColor'); //rgb(100,100,100)

            //console.log("old"+oldBGColor);
            var newBGColor = oldBGColor.replace('rgb', 'rgba').replace(')', opVal); //rgba(100,100,100,.8)
            $('#AB').css({
                backgroundColor: newBGColor + '!important'
            });
        }


        //-----------------------------------------CONVERT TO RGBA-----------------------------------------//
        function hexToRgbA(hex) {
            console.log("hexToRgbA()");
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


        //-----------------------------------------CONVERT TO HEX-----------------------------------------//
        function RgbaTohex(rgba) {
            console.log("RgbaTohex()");
            console.log("color viejo es:" + $('#AB').css('backgroundColor'));
            rgba = rgba.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);

            return rgba && rgba.length === 4 ?
                "#" + ("0" + parseInt(rgba[1], 10).toString(16)).slice(-2) +
                ("0" + parseInt(rgba[2], 10).toString(16)).slice(-2) +
                ("0" + parseInt(rgba[3], 10).toString(16)).slice(-2) :
                "";
        }


        //-----------------------------------------IMAGEN OFF-----------------------------------------//
        function ImagePower() {
            console.log("ImagePower()");
            $("#AB li").each(function() {
                var liImage = $(this).find("img").parent().parent();
                var contentImage = $(this).find("img").parent();

                if (liImage.hasClass("imgOff")) {
                    contentImage.css("width", "0");
                    contentImage.css("height", "0");
                }

                //alert("imagenOFF");
            });
        }


        //-----------------------------------------TOOL_OPTION_EDIT_PANEL-----------------------------------------//
        function ToolEditPanel() {
            console.log("ToolEditPanel()");

            //Close Tool Option Edit
            $("#toolOptionEdit .closeM").off("click");
            $("#toolOptionEdit .toolOptionEditClose").off("click");

            $("#toolOptionEdit .closeM").on("click", function() {
                $("body").css("overflow", "initial");
                optionEditorMode = "single";
                $("#toolOptionEdit").hide(500, function() {
                    $("#toolOptionEdit").addClass("d-none");
                });
            });

            $("#toolOptionEdit .toolOptionEditClose").on("click", function() {
                optionEditorMode = "single";
                $("#toolOptionEdit").hide(500, function() {
                    $("#toolOptionEdit").addClass("d-none");
                });
                $("body").css("overflow", "initial");
            });

            //Color_Picker Border
            $('#colorpicker').on('input', function() {
                $('#hexcolor').val(this.value);
            });
            $('#hexcolor').on('input', function() {
                $('#colorpicker').val(this.value);
            });

            //Color_Picker Background
            $('#colorpickerBG').on('input', function() {
                $('#hexcolorBG').val(this.value);
            });
            $('#hexcolorBG').on('input', function() {
                $('#colorpickerBG').val(this.value);
            });

            //Sizes
            $("#toolOptionEdit .sizes li").click(function() {
                $("#toolOptionEdit .sizes li").removeClass("active");
                $(this).addClass("active");
            });

            //Aligns
            $("#toolOptionEdit .aline li").click(function() {
                $("#toolOptionEdit .aline li").removeClass("active");
                $(this).addClass("active");
            });

            //Font
            $('#colorpickerFont').on('input', function() {
                $('#hexcolorFont').val(this.value);
            });
            $('#hexcolorFont').on('input', function() {
                $('#colorpickerFont').val(this.value);
            });
        }


        //-----------------------------------------SORTABLE-----------------------------------------//
        function sortables() {
            console.log("sortables()");
            //LIS
            new Sortable(document.getElementById('AB'), {
                handle: ".fa-arrows-alt",
                filter: ".context",
                cursor: "grabbing",
                opacity: 0.5,
                swap: true, // Enable swap plugin
                swapClass: 'ABsort-placeholder', // The class applied to the hovered swap item
                animation: 150,

                onSort: function(evt) {
                    orderPos();
                    setTypeOptionValues();
                }
            });

            /*$("#AB").sortable({
                    handle: ".fa-arrows-alt",
                    cancel: ".context",
                    cursor:"grabbing",
                    opacity:0.5,
                    placeholder:'ABsort-placeholder',

                    stop: function( e, ui ){
              			orderPos();
              			selectTypeOption();
            		}
          		});*/
        }


        //-----------------------------------------ORDER POSITION-----------------------------------------//
        function orderPos() {
            console.log("orderPos()");
            var pos = 1;
            $("#AB li").each(function() {
                //console.log($(this).attr("data-id"));
                $(this).attr("data-id", pos);
                pos++;
            });

            pos = 1;
            $("#AB li").off("click");
            setTypeOptionValues();
            $(".numberLi").text(tLi.attr("data-id"));
            Hoverli();
        }


        //-----------------------------------------CHANGE DEVICE-----------------------------------------//
        function changeDevice() {
            console.log("changeDevice()");
            $(".previewPanel li").hover(function() {
                $(this).css("cursor", "pointer");
            });

            $(".previewPanel li").click(function() {
                $(".previewPanel li").removeClass("active");
                $(this).addClass("active");
            });
        }


        //-----------------------------------------LOAD RESIZABLE-----------------------------------------//
        function loadResizable(Option) {
            console.log("entro a loadResizable()");
            var firstC = tLi.find(".content:first");
            var lastC = tLi.find(".content:last");
            $("#AB li .content").removeClass("resizable ui-resizable");

            if (!Option.hasClass("imgOff")) {
                firstC.addClass("resizable ui-resizable");
            }

            //ROW
            if ($("#AB").hasClass("optionsRows")) {

                //SLIDER
                if (tLi.hasClass("imgOff") || tLi.hasClass("disable")) {
                    //console.log("disable");
                    $(".changeP").css("pointer-events", "none");
                    $(".changeP").css("opacity", "0.3");
                    $(".sliderWidth").attr("disabled", "true");
                    $(".sliderWidth").css("opacity", "0.3");
                } else {
                    // console.log("Enable");
                    $(".changeP").css("pointer-events", "initial");
                    $(".changeP").css("opacity", "1");
                    $(".sliderWidth").removeAttr("disabled");
                    $(".sliderWidth").css("opacity", "1");

                    $(".sliderWidth").on('change', function(e) {
                        var liW = $(".sliderWidth").val() + "%";
                        var liWl = 100 - $(".sliderWidth").val() + "%";
                        tLi.find(".content:first").css("width", liW);
                        tLi.find(".content:last").css("width", liWl);
                        //console.log(liWl)
                    });
                }


                //console.log("Rows");
                Option.find(".content").css("height", "100%");

                firstC.resizable({
                    handles: "e",
                    resize: function(event, ui) {
                        var c1 = firstC.width() / firstC.parent().width() * 100;
                        var c2 = 99.5 - c1;
                        firstC.css("width", c1 + "%");
                        firstC.css("height", "100%");
                        lastC.css("width", c2 + "%");
                        lastC.css("height", "100%");
                    },
                    stop: function(event, ui) {
                        var c1 = firstC.width() / firstC.parent().width() * 100;
                        var c2 = 100 - c1;
                        lastC.css("width", c2 + "%");
                        Option.find(".content").css("height", "100%");
                        setTypeOptionValues();
                    }
                });
            }

            //COL
            if ($("#AB").hasClass("optionsCols")) {

                //SLIDER
                if (tLi.hasClass("imgOff") || tLi.hasClass("disable")) {
                    //console.log("disable");
                    $(".changeP").css("pointer-events", "none");
                    $(".changeP").css("opacity", "0.3");
                    $(".sliderWidth").attr("disabled", "true");
                    $(".sliderWidth").css("opacity", "0.3");
                } else {
                    $(".changeP").css("pointer-events", "initial");
                    $(".changeP").css("opacity", "1");
                    $(".sliderWidth").removeAttr("disabled");
                    $(".sliderWidth").css("opacity", "1");

                    $(".sliderWidth").on('change', function(e) {
                        var liW = $(".sliderWidth").val() + "%";
                        var liWl = 100 - $(".sliderWidth").val() + "%";
                        tLi.find(".content:first").css("height", liW);
                        tLi.find(".content:last").css("height", liWl);
                        //console.log(liWl)
                    });
                }

                Option.find(".content").css("width", "100%");

                firstC.resizable({
                    handles: "s",
                    // containment: Option,

                    resize: function(event, ui) {
                        var c1 = firstC.height() / firstC.parent().height() * 100;
                        var c2 = 99 - c1;
                        firstC.css("height", c1 + "%");
                        firstC.css("width", "100%");
                        lastC.css("height", c2 + "%");
                        lastC.css("width", "100%");
                    },
                    stop: function(event, ui) {
                        var c1 = firstC.height() / firstC.parent().height() * 100;
                        var c2 = 100 - c1;
                        lastC.css("height", c2 + "%");
                        Option.find(".content").css("width", "100%");
                        setTypeOptionValues();
                    }
                });
            }

        }


        //-----------------------------------------LIMT INPUT ALPHA-----------------------------------------//
        function limitAlpha() {
            console.log("limitAlpha()");
            $(function() {
                $("#opacity-AB").keydown(function() {

                    // Save old value.
                    if (!$(this).val() || (parseInt($(this).val()) <= 100 && parseInt($(this).val()) >= 0))
                        $(this).data("old", $(this).val());
                });

                $("#opacity-AB").keyup(function() {
                    // Check correct, else revert back to old value.
                    if (!$(this).val() || (parseInt($(this).val()) <= 100 && parseInt($(this).val()) >= 0))
                    ;
                    else
                        $(this).val($(this).data("old"));
                });
            });
        }

        //-----------------------------------------START FUNCTIONS------//


        function deleteOldCode() {
            $(".context").removeClass("w-100 h-100 p-3");
        }


        function ifMobile() {
            $(".addVideoMain").css("opacity", "1");
            if ($(".blockAdd").hasClass("mobile")) {
                var sM = $("#AB").attr("data-mobile");
                $("#AB").css("font-size", sM + "px");
            } else if ($(".blockAdd").hasClass("desktop")) {
                var sD = $("#AB").attr("data-desktop");
                $("#AB").css("font-size", sD + "px");
            }
        }


        function resizeAddmedia() {
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

        //------------------------------------------------------------FORM-------------------------------------------------------------------------------------------//
        //fuction Title
        function formtitleF() {
            if ($("#widgetContainerForm #AF[data-form-builder='dynamic']").length && typeof window.dynamicFormTitleTools === 'function') {
                window.dynamicFormTitleTools();
                return;
            }

            document.querySelector("#AF #form-terms input").setAttribute('id', 'f-terms');
            $("#AF #form-title h3").blur(function() {
                console.log("cambios de titulo");
                updateTypeForm();
            });
        }

        //Panel-Form-Inputs
        function formEditTools() {
            if ($("#widgetContainerForm #AF[data-form-builder='dynamic']").length && typeof window.dynamicFormEditTools === 'function') {
                window.dynamicFormEditTools();
                return;
            }

            //Open Tool Form Edit
            $("#fileds-form").off("click");
            $("#fields-form-edit").hide();

            $("#fields-form").on("click", function() {
                $("body").css("overflow", "hidden");
                $("#fields-form-edit").removeClass("d-none");
                $("#fields-form-edit").show(500);
                loadFieldsForms();
                loadLabelsForms();
            });

            $("#fileds-form-edit .form-edit-close").on("click", function() {
                $("#fields-form-edit").hide(500);
                $("#fields-form-edit").addClass("d-none");
                $("body").css("overflow", "initial");
            });
            //Close Tool Form Edit
            $("#fields-form-edit .closeM").off("click");
            $("#fields-form-edit .form-edit-close").off("click");

            $("#fields-form-edit .closeM").on("click", function() {
                $("body").css("overflow", "initial");
                $("#fields-form-edit").hide(500);
                $("#fields-form-edit").addClass("d-none");
            });

            $("#fields-form-edit .form-edit-close").on("click", function() {
                $("#fields-form-edit").hide(500);
                $("#fields-form-edit").addClass("d-none");
                $("body").css("overflow", "initial");
            });
        }

        //Panel-Form-colors
        function formColorsTools() {
            //Open Tool Form Edit
            $("#colors-form").off("click");
            $("#colors-form-edit .closeM").off("click");
            $("#colors-form-edit .form-edit-close").off("click");

            console.log('-----------------------Load Forms Functions');
            $("#colors-form").on("click", function() {
                console.log('open form edit color');
                $("body").css("overflow", "hidden");
                $("#colors-form-edit").removeClass("d-none");
                $("#colors-form-edit").show(500);
                loadColorsForms();
            });

            $("#colors-form-edit .closeM").on("click", function() {
                $("body").css("overflow", "initial");
                $("#colors-form-edit").hide(500);
                $("#colors-form-edit").addClass("d-none");
            });

            $("#colors-form-edit .form-edit-close").on("click", function() {
                $("#colors-form-edit").hide(500);
                $("#colors-form-edit").addClass("d-none");
                $("body").css("overflow", "initial");
            });
        }

        //Input filds switcher
        $("#fields-form-edit .form-option-edit ul .switch input").change(function() {

            //disable required
            var nameRequired = "#form-" + $(this).attr("id").slice(0, -10) + "-required"
            var itemRequired = $("#fields-form-edit").find(nameRequired);
            if ($(this).is(':checked')) {
                itemRequired.removeAttr("disabled");
            } else {
                itemRequired.attr("disabled", "true");
            }

            //send vars
            switcherInputs($(this).is(':checked'), $(this).attr("id").slice(0, -10), itemRequired.is(':checked'));

        });

        //Input filds switcher
        $(".W-Form .switch input").change(function() {
            //disable required
            console.log('cambio switcher');
            console.log(this);
            //var nameRequired = "#form-"+$(this).attr("id").slice(0, -10)+"-required"
            //var itemRequired = $("#fields-form-edit").find(nameRequired);
            /* if($(this).is(':checked')){
                 itemRequired.removeAttr("disabled");
             }
             else{
                 itemRequired.attr("disabled","true");
             }*/
            //send vars
            switcherCrm($(this).is(':checked'), $(this).attr("id").slice(0, -10), false);
        });

        //LOAD CRM
        function loadCrmField() {
            if ($("#widgetContainerForm #AF[data-form-builder='dynamic']").length && typeof window.dynamicLoadCrmField === 'function') {
                return window.dynamicLoadCrmField();
            }

            let form = document.querySelector('#AF');
            if (form.hasAttribute('crm')) {
                if (form.getAttribute('crm') == 'true') {
                    console.log('es true');
                    $(".W-Form .switch input").prop("checked", true);
                    //active fild
                    document.querySelector('#AF #form-email').classList.remove('d-none');
                    document.querySelector('#AF #form-email').classList.add('d-flex');
                    document.querySelector('#AF #form-email input').setAttribute('required', 'required');
                } else {
                    console.log('es falso');
                    $(".W-Form .switch input").prop("checked", false);
                }
            } else {
                console.log('no esta');
                $(".W-Form .switch input").prop("checked", false);
            }
        }

        //SET CRM FORM
        function switcherCrm(bool, name) {
            if ($("#widgetContainerForm #AF[data-form-builder='dynamic']").length && typeof window.dynamicSwitcherCrm === 'function') {
                window.dynamicSwitcherCrm(bool);
                return;
            }

            //console.log(name);
            //console.log(bool);
            document.querySelector('#AF').setAttribute('crm', bool);

            //active fild
            if (document.querySelector('#AF').getAttribute('crm') == 'true') {

                document.querySelector('#AF #form-email').classList.remove('d-none');
                document.querySelector('#AF #form-email').classList.add('d-flex');
                document.querySelector('#AF #form-email input').setAttribute('required', 'required');
            }
            updateTypeForm();
        }

        //show and hide
        function switcherInputs(bool, name, required) {

            var nameItem = "#form-" + name;
            var item = $("#AF").find(nameItem);
            //required
            var nameItemR = "#f-" + name;
            var itemR = $("#AF").find(nameItemR);

            if (bool == true) {
                $(item).removeClass("d-none");
                $(item).addClass("d-flex");
                if (required == true) {
                    itemR.attr("required", "true");
                } else {
                    $(itemR).removeAttr("required");
                }
            } else {
                $(item).addClass("d-none");
                $(item).removeClass("d-flex");
                $(itemR).removeAttr("required");
            }
            updateTypeForm();
        }
        //Input filds required
        $("#fields-form-edit .form-option-edit ul .required input").change(function() {
            requiredInputs($(this).is(':checked'), $(this).attr("id").slice(5, -9));
        });
        //required
        function requiredInputs(bool, name) {
            console.log('cambio swtich:' + name + '/' + bool);
            var nameItem = "#f-" + name;
            var item = $("#AF").find(nameItem);
            console.log(bool, ("form-" + name));
            if (bool == true) {
                $(item).attr("required", "true");
                console.log("required" + nameItem);

            } else {
                $(item).removeAttr("required");
                console.log("no required" + nameItem)
            }
            updateTypeForm();
        }
        //name of fields
        $("#fields-form-edit li p").blur(function() {
            var n = "#form-" + $(this).parent().parent().attr("id").slice(6);
            var cont = $(this).text();
            setLabel(n, cont);
        });

        function setLabel(n, cont) {
            $("#AF").find(n).find("b").text(cont);
            updateTypeForm();
        }

        function getFormReferenceFieldInput() {
            var referenceField = $("#AF input[type=text], #AF input[type=email], #AF input[type=tel], #AF input[type=date], #AF textarea").first();
            return referenceField.length ? referenceField : $("#AF");
        }

        function getFormEditableInputs() {
            return $("#AF input[type=text], #AF input[type=email], #AF input[type=tel], #AF input[type=date], #AF textarea");
        }

        function getFormReferenceWrapper() {
            var wrapper = $("#AF .form-field").first();
            if (!wrapper.length) {
                wrapper = $("#AF .itemForm").not("#form-title").first();
            }
            return wrapper;
        }

        function getFormFieldWrappers() {
            var wrappers = $("#AF .form-field");
            if (!wrappers.length) {
                wrappers = $("#AF .itemForm").not("#form-title");
            }
            return wrappers;
        }

        function getFieldBorderModePreview(referenceField) {
            var target = referenceField && referenceField.length ? referenceField : getFormReferenceFieldInput();
            var topWidth = parseInt(target.css("border-top-width"), 10) || 0;
            var rightWidth = parseInt(target.css("border-right-width"), 10) || 0;
            var bottomWidth = parseInt(target.css("border-bottom-width"), 10) || 0;
            var leftWidth = parseInt(target.css("border-left-width"), 10) || 0;

            if (topWidth > 0 || rightWidth > 0 || leftWidth > 0) {
                return "all";
            }

            if (bottomWidth > 0) {
                return "bottom";
            }

            return "none";
        }

        function getFieldPlaceholderColorPreview(referenceField) {
            var target = referenceField && referenceField.length ? referenceField : getFormReferenceFieldInput();
            if (!target.length || !target[0]) {
                return "#93aed0";
            }

            var inlineValue = target[0].style ? target[0].style.getPropertyValue("--field-placeholder-color") : "";
            if (inlineValue && inlineValue.trim() !== "") {
                return inlineValue.trim();
            }

            var computedValue = window.getComputedStyle(target[0]).getPropertyValue("--field-placeholder-color");
            if (computedValue && computedValue.trim() !== "") {
                return computedValue.trim();
            }

            return "#93aed0";
        }

        function applyFieldBorderPreview(mode, color) {
            var borderMode = mode || $("#fieldBorderMode-form").val() || "bottom";
            var borderColor = color || $("#hexcolorBorder-filed-form").val() || "#ffffff";
            var inputs = getFormEditableInputs();

            if (borderMode === "all") {
                inputs.css({
                    "border": "1px solid " + borderColor,
                    "border-bottom": "1px solid " + borderColor,
                    "border-color": borderColor,
                    "border-bottom-color": borderColor
                });
                return;
            }

            if (borderMode === "none") {
                inputs.css({
                    "border": "none",
                    "border-bottom": "none",
                    "border-color": borderColor,
                    "border-bottom-color": borderColor
                });
                return;
            }

            inputs.css({
                "border": "none",
                "border-bottom": "1px solid " + borderColor,
                "border-color": borderColor,
                "border-bottom-color": borderColor
            });
        }

        function setFieldBorderModeButtons(mode) {
            var borderMode = mode || "bottom";
            $("#fieldBorderMode-form").val(borderMode);
            $("#colors-form-edit .border-mode-btn").removeClass("active");
            $('#colors-form-edit .border-mode-btn[data-border-mode="' + borderMode + '"]').addClass("active");
        }

        function applyFieldPlaceholderPreview(color) {
            var placeholderColor = color || $("#hexcolorPlaceholder-field-form").val() || "#93aed0";
            getFormEditableInputs().css("--field-placeholder-color", placeholderColor);
        }

        function applyFieldDividerPreview(color, width) {
            var dividerWidth = parseInt(width, 10);
            if (isNaN(dividerWidth) || dividerWidth < 0) {
                dividerWidth = 0;
            }

            var wrappers = getFormFieldWrappers();
            wrappers.css({
                "border-bottom-style": dividerWidth > 0 ? "solid" : "none",
                "border-bottom-width": dividerWidth + "px",
                "border-bottom-color": color,
                "padding-bottom": dividerWidth > 0 ? "12px" : "0px"
            });

            wrappers.last().css({
                "border-bottom-width": "0px",
                "padding-bottom": "0px"
            });
        }

        //Colors and CTA
        $("#colors-form-edit #cta-form").change(function() {
            $("#AF #form-cta").text($(this).val());
            $("#AF #form-cta span").text($(this).val());
            updateTypeForm();
        });

        //colors General rule colorpicker to hex
        $("#colors-form-edit input.colors").change(function() {
            var color = $(this).val();
            $(this).parent().find(".hex-colors").val(color);
        });
        $("#colors-form-edit input.hex-colors").change(function() {
            var hex = $(this).val();
            $(this).parent().find(".colors").val(hex);
        });

        //cta bg
        $("#colors-form-edit .cta .bg input").change(function() {
            var color = $(this).val();
            $("#AF #form-cta").css('background-color', color);
            updateTypeForm();
        });
        //cta text
        $("#colors-form-edit .cta .text input").change(function() {
            var color = $(this).val();
            $("#AF #form-cta").css('color', color);
            updateTypeForm();
        });

        //cta title
        $("#colors-form-edit .title input").change(function() {
            var color = $(this).val();
            $("#AF #form-title h3").css('color', color);
            updateTypeForm();
        });

        //cta Bg
        $("#colors-form-edit .background input").change(function() {
            var color = $(this).val();
            $("#AF").css('background', color);
            updateTypeForm();
        });

        //field bg
        $("#colors-form-edit .field .bg input").change(function() {
            var color = $(this).val();
            getFormEditableInputs().css('background-color', color);
            updateTypeForm();
        });
        //field text
        $("#colors-form-edit .field .texts input").change(function() {
            var color = $(this).val();
            getFormEditableInputs().css('color', color);
            updateTypeForm();
        });

        //field placeholder
        $("#colors-form-edit .field .placeholder input").change(function() {
            var color = $(this).val();
            applyFieldPlaceholderPreview(color);
            updateTypeForm();
        });

        //field border
        $("#colors-form-edit .field .bor input").change(function() {
            var color = $(this).val();
            applyFieldBorderPreview($("#fieldBorderMode-form").val(), color);
            updateTypeForm();
        });

        //field title
        $("#colors-form-edit .field .label input").change(function() {
            var color = $(this).val();
            $("#AF .itemForm label").css('color', color);
            updateTypeForm();
        });

        $("#fieldGap-form").change(function() {
            var value = Math.max(0, parseInt($(this).val(), 10) || 0);
            getFormFieldWrappers().css("margin-top", value + "px");
            updateTypeForm();
        });

        $("#fieldRadius-form").change(function() {
            var value = Math.max(0, parseInt($(this).val(), 10) || 0);
            getFormEditableInputs().css("border-radius", value + "px");
            updateTypeForm();
        });

        $("#colors-form-edit .border-mode-btn").on("click", function() {
            var mode = $(this).attr("data-border-mode");
            setFieldBorderModeButtons(mode);
            applyFieldBorderPreview(mode, $("#hexcolorBorder-filed-form").val());
            updateTypeForm();
        });

        $("#fieldPaddingY-form").change(function() {
            var value = Math.max(0, parseInt($(this).val(), 10) || 0);
            getFormEditableInputs().css({
                "padding-top": value + "px",
                "padding-bottom": value + "px"
            });
            updateTypeForm();
        });

        $("#fieldPaddingX-form").change(function() {
            var value = Math.max(0, parseInt($(this).val(), 10) || 0);
            getFormEditableInputs().css({
                "padding-left": value + "px",
                "padding-right": value + "px"
            });
            updateTypeForm();
        });

        $("#dividerWidth-form").change(function() {
            applyFieldDividerPreview($("#hexcolorDivider-form").val(), $(this).val());
            updateTypeForm();
        });

        $("#colors-form-edit .layout .divider input").change(function() {
            applyFieldDividerPreview($(this).val(), $("#dividerWidth-form").val());
            updateTypeForm();
        });

        //--------------------Load colors and field switcher--------------------------//
        //Fields
        function loadFieldsForms() {
            //envio switchers
            $("#AF .itemForm").each(function() {
                //console.log($(this).hasClass("d-none")+($(this).attr("id").slice(5)+"-form-edit")+$(this).find("input").prop("required"));
                //loadFieldsFormsSet($(this).hasClass("d-none"),($(this).attr("id").slice(5)+"-form-edit"),$(this).find("input").prop("required"));
                let display = !$(this).hasClass("d-none");
                let name = $(this).attr("id").slice(5) + "-form-edit";
                let require = $(this).find("input").prop("required");

                console.log("tiene d-none" + display);
                loadFieldsFormsSet(display, name, require);
            });
        }

        function loadFieldsFormsSet(sw, name, require) {
            $("#fields-form-edit .switch input").each(function() {
                var req = "#form-" + name.slice(0, -10) + "-required";
                if ($(this).attr("id") == name) {
                    //otro
                    if (sw == true) {
                        //console.log(sw+name)
                        $(this).prop("checked", true);
                        if (require == true) {
                            $("#fields-form-edit .required input" + req).prop("checked", true);
                        } else {
                            $("#fields-form-edit .required input" + req).prop("checked", false);
                        }
                    } else {
                        $(this).prop("checked", false);
                        $("#fields-form-edit .required input" + req).prop("checked", false);
                    }

                    //crm email
                    if (name == 'email-form-edit' && document.querySelector('#AF').getAttribute('crm') == 'true') {
                        console.log('CRM IN TRUE' + name);
                        $(this).prop("checked", true);
                        $(this).attr("readonly", "readonly");
                        $(this).attr("disabled", "disabled");
                        $("#fields-form-edit .required input" + req).prop("checked", true);
                        $("#fields-form-edit .required input" + req).attr("readonly", "readonly");
                        $("#fields-form-edit .required input" + req).attr("disabled", "disabled");
                        console.log('Cambiado');
                    } else if (name == 'email-form-edit' && document.querySelector('#AF').getAttribute('crm') ==
                        'false') {
                        $(this).removeProp("readonly", "disabled");
                        $("#fields-form-edit .required input" + req).removeProp("readonly", "disabled")
                    }
                }
            });
        }
        //Colors
        function loadColorsForms() {
            var referenceField = getFormReferenceFieldInput();
            var referenceWrapper = getFormReferenceWrapper();

            //cta text
            $("#cta-form").val($("#form-cta span").text());
            //cta bg
            $("#colorpicker-cta-form").val(RgbaTohex($("#form-cta").css("background-color")));
            $("#hexcolor-cta-form").val(RgbaTohex($("#form-cta").css("background-color")));
            //cta font
            $("#colorpickerFont-cta-form").val(RgbaTohex($("#form-cta").css("color")));
            $("#hexcolorFont-cta-form").val(RgbaTohex($("#form-cta").css("color")));

            //title
            $("#colorpickerFont-title-form").val(RgbaTohex($("#form-title h3").css("color")));
            $("#hexcolorFont-title-form").val(RgbaTohex($("#form-title h3").css("color")));

            //bg
            $("#colorpicker-bg-form").val(RgbaTohex($("#AF").css("background-color")));
            $("#hexcolor-bg-form").val(RgbaTohex($("#AF").css("background-color")));

            //field
            $("#colorpicker-filed-form").val(RgbaTohex(referenceField.css("background-color")));
            $("#hexcolor-filed-form").val(RgbaTohex(referenceField.css("background-color")));
            //field font
            $("#colorpickerFont-field-form").val(RgbaTohex(referenceField.css("color")));
            $("#hexcolorFont-field-form").val(RgbaTohex(referenceField.css("color")));
            //placeholder
            $("#colorpickerPlaceholder-field-form").val(getFieldPlaceholderColorPreview(referenceField));
            $("#hexcolorPlaceholder-field-form").val(getFieldPlaceholderColorPreview(referenceField));
            //border
            $("#colorpickerBorder-filed-form").val(RgbaTohex(referenceField.css("border-color")));
            $("#hexcolorBorder-filed-form").val(RgbaTohex(referenceField.css("border-color")));
            setFieldBorderModeButtons(getFieldBorderModePreview(referenceField));
            //border
            $("#colorpicker-filedTitle-form").val(RgbaTohex($("#AF label").css("color")));
            $("#hexcolor-filedTitle-form").val(RgbaTohex($("#AF label").css("color")));
            //layout
            $("#AF").css("padding", "0px");
            $("#fieldGap-form").val(referenceWrapper.length ? (parseInt(referenceWrapper.css("margin-top"), 10) || 16) : 16);
            $("#fieldRadius-form").val(referenceField.length && referenceField.attr("id") !== "AF" ? (parseInt(referenceField.css("border-radius"), 10) || 0) : 0);
            $("#fieldPaddingY-form").val(referenceField.length && referenceField.attr("id") !== "AF" ? (parseInt(referenceField.css("padding-top"), 10) || 6) : 6);
            $("#fieldPaddingX-form").val(referenceField.length && referenceField.attr("id") !== "AF" ? (parseInt(referenceField.css("padding-left"), 10) || 4) : 4);
            $("#dividerWidth-form").val(referenceWrapper.length ? (parseInt(referenceWrapper.css("border-bottom-width"), 10) || 0) : 0);
            $("#colorpickerDivider-form").val(referenceWrapper.length ? RgbaTohex(referenceWrapper.css("border-bottom-color")) : "#ffffff");
            $("#hexcolorDivider-form").val(referenceWrapper.length ? RgbaTohex(referenceWrapper.css("border-bottom-color")) : "#ffffff");

        }
        //labels
        function loadLabelsForms() {
            $("#AF b").each(function() {
                var labe = "#" + $(this).parent().parent().attr("id").replace("form-", "field-")
                var t = $(this).text();
                $("#fields-form-edit ul").find(labe).find("p").text(t);
                console.log(t);
            });
        }



        //-----------------------------------------START FUNCTIONS-----------------------------------------//
        function Start() {
            console.log("Start()");
            //deleteOldCode
            deleteOldCode();
            ensureOptionWidgetStructure();
            bindRightMenuScrollContainment();

            //Hover in Li-Option
            $(".edit-tooltip").remove();
            Hoverli();

            //Edit PANEL
            ToolEditPanel();
            formEditTools();
            formColorsTools();

            //Draggable toolOptionEdit
            //$( "#toolOptionEdit" ).draggable();
            sortables();

            //Cambio de Row a Col
            RowColPress();

            //Change Device
            changeDevice();

            //Numero de Row a Col
            NumberOnOff();

            //Background Panel de Opciones y Alfa
            limitAlpha();
            BgAB();
            setBG();

            //Font Size
            fontSize();

            resizeAddmedia();
            loadOptionWidgetPanelValues();
        }




        window.onload = function() {
            //remove desktop in mobile version
            var x = window.matchMedia("(max-width: 700px)")
            myFunction(x) // Call listener function at run time
            x.addListener(myFunction) // Attach listener function on state changes


            window.addEventListener("beforeunload", function(e) {
                if (!existsChanges()) {
                    return undefined;
                }

                var confirmationMessage =
                    'It looks like you have been editing something. If you leave before saving, your changes will be lost.';

                (e || window.event).returnValue = confirmationMessage; //Gecko + IE
                return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
            });



            /*----------------------------------Change of Device*/
            $(".previewPanel .devices li").click(function() {
                $(".previewPanel .devices li").removeClass("active");
                var dStyle = $(this).data("id");
                console.log(dStyle);
                $(".blockAdd").removeClass("desktop tablet mobile")
                $(".blockAdd").addClass(dStyle);
                $(this).addClass("active");
                ifMobile();
                resizeAddmedia();

            });

        };



        /*media query*/
        function myFunction(x) {
            if (x.matches) { // If media query matches
                $(".previewPanel .devices li.mobile").click();
                $(".addVideoMain").parent().removeClass("desktop");
                $(".addVideoMain").parent().addClass("mobile");
                $(".previewPanel .devices li.desktop").hide();
                resizeAddmedia();
            } else {
                $(".addVideoMain").parent().addClass("desktop");
                $(".addVideoMain").parent().removeClass("mobile");
                $(".previewPanel .devices li.desktop").show();
                $(".previewPanel .devices li.desktop").click();
                resizeAddmedia();
            }
        }


        function modalMsgClose() {
            $('#msgModal').modal('hide');
        }

        function modalMsgShow(texto) {
            $("#modalMsgContent").text(texto);
            $("#msgOK").attr("onClick", "modalMsgClose()")
            //$('#msgModal').modal('show');
            //setTimeout(
            //	function(){
            //       $("#msgModal").modal("hide");
            //    }, 2000);
            $('#msgModal').modal('show');
        }

    </script>
    <script src="js/form-builder-editor.js"></script>
  </body>
</html>
