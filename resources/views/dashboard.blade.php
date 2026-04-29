<<<<<<< HEAD
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
        <title> {{__('dashboard.title')}} </title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>

    </head>
	<body class="bg-white">


    	@include('nav_bar')

      {{ csrf_field() }}

      <?php if($totalInteractions==0 && \App\Models\UserConfig::getConfigParam('dashboard_projectId') == '--'): ?>

        <!-- Modal New Project-->
        <div class="modal fade bd-example-modal-sm" id="no-projects-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="pointer-events:none">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="col-12">

                <p class="text-h3 cMain text-center mt-3">{{__('dashboard.welcome_title')}}</p>
        		<form class="row justify-content-center bg-white px-3 px-md-4 "  action="{{ route("projects") }}" method="get" >
        	   		<div class="col-12 p-0 m-0 mb-4 row justify-content-center">
        				<label for="project-name" class="text-left cMain mb-0" > {{__('dashboard.welcome_message')}} </label>
        	   		</div>
                   	<div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                   		<button type="subit" class="btn-square px-3 bg-Main cWhite">{{__('dashboard.go_projects')}}</button>
                  	</div>
        		</form>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>

        <!--------------------------------MAIN------------------------------->
        <div class="container-fluid m-0 p-0 vh-100">
             <section class="projects row col-12  mx-0 p-0 w-100">
                <!--Menu Side Left -->
                <x-side-nav/>


                <div class="mainContainer col row p-0 m-0">
                    <div class="main w-100 m-0 p-0 p-lg-5 p-2">

                      <div class="px-2 py-3 my-2 d-flex justify-content-center align-items-center">
                        <div class="col filter d-flex d-lg-none p-3 bg-Main c06 br-r1" ><i class="fas fa-filter"></i></div>

                        <select name="projects" id="projectSelect" class="ml-3 selectBlue">
                        <option value="--"> {{__('dashboard.all_projects')}} </option>
                        @foreach ($projects as $project)
                            @if ($project->project_status_id == 3)
                              @continue
                            @endif
                            <option value="{{ $project->id }}" {{ (\App\Models\UserConfig::getConfigParam('dashboard_projectId')==$project->id)?'selected':'' }}>{{ $project->name }}</option>
                        @endforeach
                        </select>
                      </div>
                      <div class="row filter-m m-0 p-0 d-none d-lg-flex">

                        <div class="col w-100 d-flex flex-column flex-md-row justify-content-between align-items-center  mb-4">
                          <div class="d-flex">
                            <a class="nav-link cMain  text-md-left" href="#" title="" id="linkToShowDateFilterDialog">
                              <i class="fas fa-filter " aria-hidden="true"></i></a>

                              <div class="d-flex cMain calendary bg-06 br-r1 mb-3 mb-lg-0">
                                <div class="d-flex m-2 w-100 align-items-center">
                                @if(\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=='')
                                  {{__('dashboard.no_date_filter')}}
                                @elseif(\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=='n-dias')
                                   @if(\App\Models\UserConfig::getConfigParam('dashboard_dateLastNDays')==1)
                                    {{__('dashboard.last1')}} {{__('dashboard.nday')}}
                                  @else
                                    {{__('dashboard.last')}} {{\App\Models\UserConfig::getConfigParam('dashboard_dateLastNDays')}} {{__('dashboard.ndays')}}
                                  @endif
                                @else
                                  {{\App\Models\UserConfig::getConfigParam('dashboard_dateStart')}} -
                                  {{\App\Models\UserConfig::getConfigParam('dashboard_dateEnd')}}
                                @endif
                                </div>
                              </div>
                              <!--
                            <div class="d-flex cMain calendary bg-06 br-r1 mb-3 mb-lg-0">
                              <div class="d-flex ml-2 align-items-center">
                                <input type="date" id="start" name="trip-start" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateStart'))?\App\Models\UserConfig::getConfigParam('dashboard_dateStart'):date("m/d/Y") }}" >
                              </div>
                              <div class="d-flex ml-0 align-items-center">
                                <label for="end" class="m-0 mr-3 p-0"> | </label>
                                <input type="date" class="date" id="end" name="trip-start" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'))?\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'):date("m/d/Y") }}" >
                              </div>
                            </div>
                            -->
                          </div>
                          <ul class="devices d-flex m-0 p-0 align-items-center m-0 mb-3 mb-lg-0">
                            <li class="m-0 py-1 px-2 mx-1 bg-03 desktop {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-all' || \App\Models\UserConfig::getConfigParam('dashboard_device')=='')?'active':'' }}" data-id="dv-all">{{__('dashboard.all')}}</li>
                            <li class="m-0 py-1 px-2 mx-1 bg-03 desktop {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-desktop')?'active':'' }}" data-id="dv-desktop"><i class="fas fa-desktop c05" aria-hidden="true"></i></li>
                            <li class="m-0 py-1 px-2 mx-1 bg-03 table {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-tablet')?'active':'' }}" data-id="dv-tablet"><i class="fas fa-tablet-alt c05" aria-hidden="true"></i></li>
                            <li class="m-0 py-1 px-2 mx-1 bg-03 mobile {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-mobile')?'active':'' }}" data-id="dv-mobile"><i class="fas fa-mobile-alt c05" aria-hidden="true"></i></li>
                          </ul>
                          <ul class="dates d-flex align-items-center m-0 p-0 ">
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='days' || \App\Models\UserConfig::getConfigParam('dashboard_dates')=='')?'active':'' }}" data-id="days">{{__('dashboard.days')}}</li>
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='week')?'active':'' }}" data-id="week">{{__('dashboard.weeks')}}</li>
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='months')?'active':'' }}" data-id="months">{{__('dashboard.months')}}</li>
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='years')?'active':'' }}" data-id="years">{{__('dashboard.years')}}</li>
                          </ul>
                        </div>
                      </div>
                      <div class="row p-0 m-0 justify-content-between align-items-center">
                        <div class="col-12 col-lg-9 card-dash bg-white mb-4">
                          <canvas id="myChart" ></canvas>
                        </div>
                        <div class="col-12 col-lg-3 pl-lg-4 pl-xl-5 p-0 results">
                          <div class=" m-0 p-3 mb-4 card-dash bg-white interactions">
                            <span id="totalInteractions">{{ $totalInteractions }}</span>
                            <p> {{__('dashboard.interactions')}}</p>

                          </div>
                          <div class=" m-0 p-3 card-dash bg-white completed mb-4">
                            <span id="totalCompleted">{{ $totalCompleted }}</span>
                            <p>{{__('dashboard.completed')}}</p>
                        </div>
                        </div>
                      </div>

                      <div class="row p-0 m-0 justify-content-between">
                        <div class="col m-0 mb-4 mr-xl-2 card-dash bg-white optionAnwserTable">
                          <div class="row p-0 m-0  align-items-center font-weight-bold">
                            <p class="col-5 p-0 m-0">{{__('dashboard.tags_option')}}</p>
                            <p class="col p-0 m-0 bolder">{{__('dashboard.answers')}}</p>
                          </div>
                          <hr class="m-0 p-0 my-2">
                          <ul class="p-0 m-0 w-100" id="tagOptionTableContent">

                            <?php
                              $total_interactions_by_cuepoint = array();
                              foreach($tagOptionData as $key => $data){
                                if(isset($total_interactions_by_cuepoint[$data->cuepointname])){
                                  $total_interactions_by_cuepoint[$data->cuepointname] += $data->interactions;
                                }else{
                                  $total_interactions_by_cuepoint[$data->cuepointname] = $data->interactions;
                                }

                              }
                              $cuepointoptionname_block = "";
                              $fondo_azul_claro_flag = 1;
                              foreach($tagOptionData as $key => $data){
                                if(isset($tagOptionData[$key+1])){
                                  $data_next = $tagOptionData[$key+1];
                                }else{
                                  unset($data_next);
                                }
                                if($fondo_azul_claro_flag==1){
                                  $fondo_celda = 'bg-Main'; // azul oscuro
                                }else{
                                  $fondo_celda = 'bg-03';   // gris
                                }
                                $cuepointoptionname_block .= '
                                <li class="d-flex justify-content-between p-2 my-1 '.$fondo_celda.' br-r1 cWhite">
                                  <p class="m-0 p-0">'.$data->cuepointoptionname.'</p>
                                  <p class="m-0 p-0" title="'.$data->interactions.'/'.$total_interactions_by_cuepoint[$data->cuepointname].'">
                                  '.round($data->interactions/$total_interactions_by_cuepoint[$data->cuepointname]*100).'%
                                  </p>
                                </li>
                                ';
                                $fondo_azul_claro_flag = 0;
                                if(!isset($tagOptionData[$key+1]) || (isset($data_next) && $data_next->cuepointname != $data->cuepointname)){
                                  echo '
                                    <!--El codigo se genera desde aqui-->
                                    <li class="row p-0 m-0  align-items-center">
                                        <p class="col-5 tagOption p-0 m-0 pr-2">'.$data->cuepointname.'</p>
                                          <ul class="col p-0 m-0 no-gutters answersList">
                                            '.$cuepointoptionname_block.'
                                          </ul>
                                    </li>
                                    <hr class="m-0 p-0 my-2">
                                    <!--Hasta aqui-->
                                  ';
                                    $cuepointoptionname_block = "";
                                    $fondo_azul_claro_flag = 1;
                                } // Endif
                              } // end-foreach

                            ?>




                          </ul>
                      </div>
                      <div class="col-xl-8 col-lg-12 m-0 mb-4 ml-xl-3 card-dash bg-white emailTable" >

                        <!-- =================   TABLE - START  ================= -->
                        <div id="interactionTableDataContent">
                        <table id="table_emails" class="tabla-correos w-100">
                              <thead>
                                  <tr>
                        <!--
                                      <th class="Tth">Nombre</th>
                                      <th class="Tth">Email</th>
                        -->
                                      <th class="Tth">ID</th>                                     
                                      <th class="Tth">{{__('dashboard.answer')}}<!-- CUEPOINT NAME --></th>
                                      <th class="Tth">{{__('dashboard.activity')}}</th>
                                      <th class="Tth">{{__('dashboard.date')}}</th>
                                      <th class="Tth">{{__('dashboard.city')}}</th>
                                      <th class="Tth">{{__('dashboard.country')}}</th>
                                      <th class="Tth"></th>
                                  </tr>
                              </thead>
                              <tbody >
                                  @foreach($tableData  as $key =>  $row)
                                  <tr>
                                      <td class="Ttd">{{$key+1}}</td>                                     
                                      <td class="Ttd">{{$row->cuepointoptionname}}</td>
                                      <td class="Ttd">{{$row->actividad}}</td>
                                      <td class="Ttd">{{$row->created_at}}</td>
                                      <td class="Ttd">{{$row->loc_city}}</td>
                                      <td class="Ttd"><img src="https://flagicons.lipis.dev/flags/4x3/{{strtolower($row->loc_country_code)}}.svg" width="20px"></td>                                   
                                      <td class="Ttd">...</td>
                                  </tr>
                                  @endforeach
                              </tbody>
                            </table>
                            </div>

                            <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

                              <!-- Chart.js -->
                              <script src="lib/Chart.js-3.6.2/chart.min.js"></script>
                            <script>
                            let table = new DataTable('#table_emails', {
                                dom: 'Bfrtip',
                                buttons: [
                                    'csv', 'print'
                                ],

                              @if(app()->getLocale()=='es')
                                "language": {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                                    /* //cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json */
                                }
                              @endif

                            });
                            </script>
                            </div>
                        <!-- =================   TABLE - END  ================= -->


                      </div>
                    </div>
                </div>
             </section>
       	</div>

                <!-- Modal filtro de fechas - Interacciones -->
                <div class="modal fade bd-example-modal-sm" id="interactionsFilterByDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="col-12">

                        <p class="text-h4 cMain text-center mt-3">{{__('dashboard.interactions_hist')}}</p>

                        <div class="col-12 pl-4" >

                            <input type="radio" id="date-filter-type1" name="date-filter-type" value="" {{ (\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=="")?"checked":"" }}>
                            <label for="date-filter-type1" class="text-center cMain mb-0 px-3" >{{__('dashboard.all_data')}}</label><br>
                            <input type="radio" id="date-filter-type2" name="date-filter-type" value="n-dias" {{ (\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=="n-dias")?"checked":"" }}>
                            <label for="date-filter-type2" class="text-center cMain mb-0 px-3">{{__('dashboard.intections_for_n_days')}} <input  id="date_filter_n_days_value" type="number" min="1" step="1" max="365" value='{{ \App\Models\UserConfig::getConfigParam("dashboard_dateLastNDays") ?: 1 }}'> {{__('dashboard.ndays')}}</label><br>
                            <input type="radio" id="date-filter-type3" name="date-filter-type" value="inicio-fin" {{ (\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=="inicio-fin")?"checked":"" }}>
                            <label for="date-filter-type3" class="text-center cMain mb-0 px-3">{{__('dashboard.start_end_date')}}
                            </label>
                            <br><br>

                            <div class="rightMenu d-flex flex-column align-items-center w-100 cMain">
                              <div class="col-10 d-flex justify-content-between px-5 py-2 ">
                                Fecha inicio:
                                <input type="date" id="start" size="10"  class="" placeholder="dd/mm/yyyy" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateStart'))?\App\Models\UserConfig::getConfigParam('dashboard_dateStart'):""}}">
                              </div>
                              <div class="col-10 d-flex justify-content-between px-5 py-2 ">
                                Fecha fin:
                                <input type="date" id="end"   size="10"  class="" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'))?\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'):""}}">
                              </div>
                              <br>
                              {{__('dashboard.data_since')}} <b>
                              <label id="data-from" >{{$firstInteractionDate}}</label></b>
                            <div>

                        </div>


                        <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5 mt-4">
                          <input type="hidden" id="selectedDateRadio">
                          <button type="submit" id="saveSelectedDateFilters" name="btnSelect" class="btn-square px-3 bg-Main cWhite">{{__('dashboard.accept')}}</button>
                          <button type="button" class="btn-square px-3 bg-05 cMain ml-5" data-dismiss="modal" id="cancelDateFilter">{{__('dashboard.cancel')}}</button>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

        <script>

          //Calendary

          //-----------------------------Change Date Format ---//
          var now = new Date();
          var last = new Date();
          var today = now.toJSON().slice(0,10);
          last.setMonth(last.getMonth() -12);
          last= last.toJSON().slice(0,10);

          if($("#end").val()=="")
            $("#end").val(today);
          if($("#start").val()=="")
            $("#start").val(last);

          function changeDate(date){
            console.log(date);
            /*var d = date;
            var yy = d.splice(-1)[0];
            var mm = d.splice(-1)[0];
            var dd = d.splice(-1)[0];
            d.splice(0, 0, dd);
            d.splice(0, 0, mm);
            d.splice(0, 0, yy);
            var Ndate = d.join("-");
            */
            return(date);
          }


          //click Filter
          $('.filter').on('click', function(){
            $(".filter-m").toggleClass('d-none');
            $(this).toggleClass('bg-Main');
            $(this).toggleClass('bg-03');
          });


          // Setup
          const labels = [
            @foreach ($chartData as $data)
                            "{{ $data->fecha }}",
            @endforeach
            /*"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"*/
          ];

          const data = {
              labels: labels,
              datasets: [
                {
                      label: "{{__('dashboard.completed')}}",
                      backgroundColor: "#00caf1",
                      borderColor: "#00caf1",
                      data: [
                        @foreach ($chartData as $data)
                            "{{ $data->completed }}",
                        @endforeach
                        /*5, 15, 5, 10, 15, 20*/],
                  },
                  {
                      label: "{{__('dashboard.interactions')}}",
                      backgroundColor: "#00026a", /* "rgb(255, 99, 132)" */
                      borderColor: "#00026a", /* "rgb(255, 99, 132)" */
                      data: [
                        @foreach ($chartData as $data)
                            "{{ $data->interactions }}",
                        @endforeach

                        /*0, 10, 5, 2, 20, 30*/],
                  },

              ],
          };

          // Config
          const config = {
              type: "line",
              data: data,
              options: {
                legend: { display: false }
              },
          };

          const myChart = new Chart(document.getElementById("myChart"), config);

          function removeChartData(chart) {
              chart.data.labels.length = 0;
              chart.data.datasets.forEach((dataset) => {
              dataset.data.length = 0;
              });
              chart.update();
          }

          function addChartData(chart, res) {
            console.log(res);
            for(let i in res) {
                //console.log('fecha'+i);
                //console.log(res[i]['interaction']);
                chart.data.labels.push(i);
                chart.data.datasets[1].data.push(res[i]['interaction']);
                chart.data.datasets[0].data.push(res[i]['completed']);
                chart.update();
            }
          }


          /*------------------------------DEVICES & DATE*/
          $(".devices li").on("click", function() {
            $(".devices li").removeClass("active");
            $(this).addClass("active");
            reloadDate();
          });

          $(".dates li").on("click", function() {
            $(".dates li").removeClass("active");
            $(this).addClass("active");
            reloadDate();
          });
          $( "#projectSelect" ).change(function() {
            reloadDate();
          });
          /*$( "#start" ).change(function() {
            reloadDate();
          });
          $( "#end" ).change(function() {
            reloadDate();
          });
          */

          /********************************************************************************************** */

          function reloadDate(){

            var form = new FormData();
            form.append('_token', $("input[name=_token]").val());
            form.append('dateStart', $( "#start" ).val());
            form.append('dateEnd',$( "#end" ).val());
            form.append('projectId',$("#projectSelect").val());
            form.append('device',$(".devices").find(".active").data("id"));
            form.append('dates',$(".dates").find(".active").data("id"));

            console.log("los datos son: projectSelect = "+$("#projectSelect").val())
            //console.log("los datos son: ID:"+projectId+", Dispositivo:"+device+", Tiempo:"+dates+", Fecha inicio:"+dateStart+", Fecha Fin:"+dateEnd);

            $.ajax({
                url:'ajax-save-session-data',
                type: "POST",
                data:  form,
                cache:  false,
            	  contentType: false,
            		processData: false,
             		dataType: 'json' ,
                success: function(response){
                          console.log('ajax-save-session-data: OK');
                    },
                error: function(request, error){
                  console.log(error);
                  console.log(request);
                  alert("Ajax-save-session-data Error: "+JSON.stringify(error));
                }
            });

            $.ajax({
                		url:    'ajax-getChartData',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            //console.log('getChartData:');
                            const res = (response.data);

                            interactionCompleted(res);


                            removeChartData(myChart);
                            addChartData(myChart, res);

                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });

            $.ajax({
                		url:    'ajax-getTagOptionData',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            //console.log('getTagOptionData:');

                           // console.log('REspuesta');
                            //console.log(JSON.stringify(response.data));
                            //document.getElementById('tagOptionTableContent').innerHTML = response.data;
                            optionPanelCreate(response);

                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });

            $.ajax({
                	url:    'ajax-getInteractionTableData',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            document.getElementById('interactionTableDataContent').innerHTML = response.data;
                            // Reinicializar el DataTable
                            table = $('#table_emails').DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'csv', 'print'
                                ],

                              @if(app()->getLocale()=='es')
                                "language": {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                                    /* //cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json */
                                }
                              @endif

                            });

                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });

          }// End: function reloadDate

        //Construyo el panel de Opciones
          const optionPanelCreate = (response) => {
           //console.log('RESPUESTAS');
           //console.log(response.data);
            const panelOptions = document.getElementById('tagOptionTableContent');
            panelOptions.innerHTML = '';

            for(let i in response.data) {
                //console.log('*************ENTRO');
                let item = response.data[i];
                if(item.name == null){
                    //console.log('************* ROMPO');
                }else{
                //Creo Li Padre
                let row = document.createElement('li');
                row.classList.add('row','p-0','m-0','align-items-center');
                panelOptions.appendChild(row);

                //Creo P de Titulo
                row.innerHTML='';
                let parra = document.createElement('p');
                parra.classList.add('col-5', 'tagOption', 'p-0', 'm-0', 'pr-2');
                parra.innerHTML = item.name;
                row.appendChild(parra);

                //Creo UL contenedor de resultados
                let ulContainer = document.createElement('ul');
                ulContainer.classList.add('col', 'p-0', 'm-0', 'no-gutters', 'answersList');
                row.appendChild(ulContainer);

                //Creo Divisor hr
                let hr = document.createElement('hr');
                hr.classList.add('m-0', 'p-0', 'my-2')
                panelOptions.appendChild(hr);


               // The .each() method is unnecessary here:
               valMax=0;
               clavMax="";
               for (let x in item) {
                if(x == 'name' | x == 'score'){

                }else{

                    //pregunto si es mas alto
                    if(item[x]  > valMax){
                        valMax=item[x];
                        clavMax=x;
                    }

                    // console.log('total'+item['score']);
                    //Creo Li de resultado
                    let li = document.createElement('li');
                    li.classList.add('d-flex', 'justify-content-between', 'p-2', 'my-1', 'bg-Main', 'br-r1', 'cWhite');
                    li.setAttribute('id', x);
                    ulContainer.appendChild(li);

                    //Creo P de Nombre en li
                    let pName = document.createElement('p');
                    pName.classList.add('m-0', 'p-0');
                    pName.innerHTML = x;
                    li.appendChild(pName);

                    //Creo P de valoren li
                    let pVal = document.createElement('p');
                    pVal.classList.add('m-0', 'p-0');


                    //%
                    pVal.innerHTML = item[x]+' / '+Math.trunc(item[x] / item['score'] *100) + '%';


                    //agrego P
                    li.appendChild(pVal);
                }

              }
              //console.log(valMax + clavMax);
              document.getElementById(clavMax).classList.add('bg-01');

                }
            }
          }

        //Contruyo el panel interacciones
          const interactionCompleted = (response) => {
            let totalInteractions=0;
            let totalCompleted=0;

            for (let i in response) {
                totalInteractions += response[i]['interaction'];

                if (response[i]['completed'] != null && response[i]['completed'] >= 0) {
                    totalCompleted += response[i]['completed'];
                    console.log(response[i]['completed']);
				} 
                else if (response[i]['completed'] == null) {
                    console.log("completed = null");
                    response[i]['completed'] = 0;
				}
			}
            console.log(totalInteractions);
            console.log(totalCompleted);

            document.getElementById('totalCompleted').innerHTML = totalCompleted;
            document.getElementById('totalInteractions').innerHTML = totalInteractions;
          }


          $('#linkToShowDateFilterDialog').on('click', function(){
     		    //console.log("linkToShowDateFilterDialog()")
            // Asingar en el campo oculto, el valor seleccinoado. en caso de que la persona haga clic más adelante en cancelar
            var radioVal = $("input[name='date-filter-type']:checked").val()
            console.log(radioVal)
            $('#selectedDateFilter').val(radioVal)
         	  $('#interactionsFilterByDate').modal('show')
          });

          $('#date_filter_n_days_value').on('blur', function () {
            //console.log("Liberar el campo: date_filter_n_days_value")
            $("#date-filter-type2").prop("checked", true);
          })

          $('#start').on('blur', function () {
            $("#date-filter-type3").prop("checked", true);
          })

          $('#end').on('blur', function () {
            $("#date-filter-type3").prop("checked", true);
          })

          function cancelDateFilter(){
            console.log("cancelDateFilter()")
            var radioVal = $('#selectedDateFilter').val()
            console.log(radioVal)
            if(radioVal == "n-dias"){
              $("#date-filter-type2").prop("checked", true);
            }else if(radioVal == "inicio-fin"){
              $("#date-filter-type3").prop("checked", true);
            }else{ // sin filtro
              $("#date-filter-type1").prop("checked", true);
            }
          }

          var acceptClickFlag

          $('#interactionsFilterByDate').on('hidden.bs.modal', function () {
            cancelDateFilter()
          })


          //function saveSelectedMaxHist(){
          $('#saveSelectedDateFilters').on('click', function(e){

            //$("#date_filter_n_days_value").val()
            var form = new FormData();
            form.append('filter_type', $("input[name='date-filter-type']:checked").val());
            form.append('date_filter_n_days_value', $("#date_filter_n_days_value").val());
            form.append('start', $("#start").val());
            form.append('end', $("#end").val());
            form.append('_token', $("input[name=_token]").val());
            $.ajax({
                		url:    'ajax-saveDateFilter',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            console.log('ajax-saveDateFilter -> OK');
                            $('#interactionsFilterByDate').modal('hide');
                            location.reload();
                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });
          });
          //};


        //===========================================================================================
        @if($totalInteractions == 0)
          $("#no-projects-modal").modal("show")
        @endif


        function monitorChange(objeto) {
			objeto.on('change', function() {
				console.log('Before monitorChange() : ' + objeto.attr('id') + " - Value: " + objeto.val()); 
				
				valor = objeto.val();

				if (!valor || valor <= 0){
					objeto.val(1);
				}
				console.log('After monitorChange() : ' + objeto.attr('id') + " - Value: " + objeto.val());
            });
    	}

		
        $(document).ready(function() {
            reloadDate();

            monitorChange($('#date_filter_n_days_value'));
            
        });
        
      </script>
    </body>
</html>

=======
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
        <title> {{__('dashboard.title')}} </title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>

    </head>
	<body class="bg-white">


    	@include('nav_bar')

      {{ csrf_field() }}

      <?php if($totalInteractions==0 && \App\Models\UserConfig::getConfigParam('dashboard_projectId') == '--'): ?>

        <!-- Modal New Project-->
        <div class="modal fade bd-example-modal-sm" id="no-projects-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="pointer-events:none">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="col-12">

                <p class="text-h3 cMain text-center mt-3">{{__('dashboard.welcome_title')}}</p>
        		<form class="row justify-content-center bg-white px-3 px-md-4 "  action="{{ route("projects") }}" method="get" >
        	   		<div class="col-12 p-0 m-0 mb-4 row justify-content-center">
        				<label for="project-name" class="text-left cMain mb-0" > {{__('dashboard.welcome_message')}} </label>
        	   		</div>
                   	<div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
                   		<button type="subit" class="btn-square px-3 bg-Main cWhite">{{__('dashboard.go_projects')}}</button>
                  	</div>
        		</form>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>

        <!--------------------------------MAIN------------------------------->
        <div class="container-fluid m-0 p-0 vh-100">
             <section class="projects row col-12  mx-0 p-0 w-100">
                <!--Menu Side Left -->
                <x-side-nav/>


                <div class="mainContainer col row p-0 m-0">
                    <div class="main w-100 m-0 p-0 p-lg-5 p-2">

                      <div class="px-2 py-3 my-2 d-flex justify-content-center align-items-center">
                        <div class="col filter d-flex d-lg-none p-3 bg-Main c06 br-r1" ><i class="fas fa-filter"></i></div>

                        <select name="projects" id="projectSelect" class="ml-3 selectBlue">
                        <option value="--"> {{__('dashboard.all_projects')}} </option>
                        @foreach ($projects as $project)
                            @if ($project->project_status_id == 3)
                              @continue
                            @endif
                            <option value="{{ $project->id }}" {{ (\App\Models\UserConfig::getConfigParam('dashboard_projectId')==$project->id)?'selected':'' }}>{{ $project->name }}</option>
                        @endforeach
                        </select>
                      </div>
                      <div class="row filter-m m-0 p-0 d-none d-lg-flex">

                        <div class="col w-100 d-flex flex-column flex-md-row justify-content-between align-items-center  mb-4">
                          <div class="d-flex">
                            <a class="nav-link cMain  text-md-left" href="#" title="" id="linkToShowDateFilterDialog">
                              <i class="fas fa-filter " aria-hidden="true"></i></a>

                              <div class="d-flex cMain calendary bg-06 br-r1 mb-3 mb-lg-0">
                                <div class="d-flex m-2 w-100 align-items-center">
                                @if(\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=='')
                                  {{__('dashboard.no_date_filter')}}
                                @elseif(\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=='n-dias')
                                   @if(\App\Models\UserConfig::getConfigParam('dashboard_dateLastNDays')==1)
                                    {{__('dashboard.last1')}} {{__('dashboard.nday')}}
                                  @else
                                    {{__('dashboard.last')}} {{\App\Models\UserConfig::getConfigParam('dashboard_dateLastNDays')}} {{__('dashboard.ndays')}}
                                  @endif
                                @else
                                  {{\App\Models\UserConfig::getConfigParam('dashboard_dateStart')}} -
                                  {{\App\Models\UserConfig::getConfigParam('dashboard_dateEnd')}}
                                @endif
                                </div>
                              </div>
                              <!--
                            <div class="d-flex cMain calendary bg-06 br-r1 mb-3 mb-lg-0">
                              <div class="d-flex ml-2 align-items-center">
                                <input type="date" id="start" name="trip-start" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateStart'))?\App\Models\UserConfig::getConfigParam('dashboard_dateStart'):date("m/d/Y") }}" >
                              </div>
                              <div class="d-flex ml-0 align-items-center">
                                <label for="end" class="m-0 mr-3 p-0"> | </label>
                                <input type="date" class="date" id="end" name="trip-start" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'))?\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'):date("m/d/Y") }}" >
                              </div>
                            </div>
                            -->
                          </div>
                          <ul class="devices d-flex m-0 p-0 align-items-center m-0 mb-3 mb-lg-0">
                            <li class="m-0 py-1 px-2 mx-1 bg-03 desktop {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-all' || \App\Models\UserConfig::getConfigParam('dashboard_device')=='')?'active':'' }}" data-id="dv-all">{{__('dashboard.all')}}</li>
                            <li class="m-0 py-1 px-2 mx-1 bg-03 desktop {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-desktop')?'active':'' }}" data-id="dv-desktop"><i class="fas fa-desktop c05" aria-hidden="true"></i></li>
                            <li class="m-0 py-1 px-2 mx-1 bg-03 table {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-tablet')?'active':'' }}" data-id="dv-tablet"><i class="fas fa-tablet-alt c05" aria-hidden="true"></i></li>
                            <li class="m-0 py-1 px-2 mx-1 bg-03 mobile {{ (\App\Models\UserConfig::getConfigParam('dashboard_device')=='dv-mobile')?'active':'' }}" data-id="dv-mobile"><i class="fas fa-mobile-alt c05" aria-hidden="true"></i></li>
                          </ul>
                          <ul class="dates d-flex align-items-center m-0 p-0 ">
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='days' || \App\Models\UserConfig::getConfigParam('dashboard_dates')=='')?'active':'' }}" data-id="days">{{__('dashboard.days')}}</li>
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='week')?'active':'' }}" data-id="week">{{__('dashboard.weeks')}}</li>
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='months')?'active':'' }}" data-id="months">{{__('dashboard.months')}}</li>
                            <li class="mx-1 py-1 px-2 bg-03  {{ (\App\Models\UserConfig::getConfigParam('dashboard_dates')=='years')?'active':'' }}" data-id="years">{{__('dashboard.years')}}</li>
                          </ul>
                        </div>
                      </div>
                      <div class="row p-0 m-0 justify-content-between align-items-center">
                        <div class="col-12 col-lg-9 card-dash bg-white mb-4">
                          <canvas id="myChart" ></canvas>
                        </div>
                        <div class="col-12 col-lg-3 pl-lg-4 pl-xl-5 p-0 results">
                          <div class=" m-0 p-3 mb-4 card-dash bg-white interactions">
                            <span id="totalInteractions">{{ $totalInteractions }}</span>
                            <p> {{__('dashboard.interactions')}}</p>

                          </div>
                          <div class=" m-0 p-3 card-dash bg-white completed mb-4">
                            <span id="totalCompleted">{{ $totalCompleted }}</span>
                            <p>{{__('dashboard.completed')}}</p>
                        </div>
                        </div>
                      </div>

                      <div class="row p-0 m-0 justify-content-between">
                        <div class="col m-0 mb-4 mr-xl-2 card-dash bg-white optionAnwserTable">
                          <div class="row p-0 m-0  align-items-center font-weight-bold">
                            <p class="col-5 p-0 m-0">{{__('dashboard.tags_option')}}</p>
                            <p class="col p-0 m-0 bolder">{{__('dashboard.answers')}}</p>
                          </div>
                          <hr class="m-0 p-0 my-2">
                          <ul class="p-0 m-0 w-100" id="tagOptionTableContent">

                            <?php
                              $total_interactions_by_cuepoint = array();
                              foreach($tagOptionData as $key => $data){
                                if(isset($total_interactions_by_cuepoint[$data->cuepointname])){
                                  $total_interactions_by_cuepoint[$data->cuepointname] += $data->interactions;
                                }else{
                                  $total_interactions_by_cuepoint[$data->cuepointname] = $data->interactions;
                                }

                              }
                              $cuepointoptionname_block = "";
                              $fondo_azul_claro_flag = 1;
                              foreach($tagOptionData as $key => $data){
                                if(isset($tagOptionData[$key+1])){
                                  $data_next = $tagOptionData[$key+1];
                                }else{
                                  unset($data_next);
                                }
                                if($fondo_azul_claro_flag==1){
                                  $fondo_celda = 'bg-Main'; // azul oscuro
                                }else{
                                  $fondo_celda = 'bg-03';   // gris
                                }
                                $cuepointoptionname_block .= '
                                <li class="d-flex justify-content-between p-2 my-1 '.$fondo_celda.' br-r1 cWhite">
                                  <p class="m-0 p-0">'.$data->cuepointoptionname.'</p>
                                  <p class="m-0 p-0" title="'.$data->interactions.'/'.$total_interactions_by_cuepoint[$data->cuepointname].'">
                                  '.round($data->interactions/$total_interactions_by_cuepoint[$data->cuepointname]*100).'%
                                  </p>
                                </li>
                                ';
                                $fondo_azul_claro_flag = 0;
                                if(!isset($tagOptionData[$key+1]) || (isset($data_next) && $data_next->cuepointname != $data->cuepointname)){
                                  echo '
                                    <!--El codigo se genera desde aqui-->
                                    <li class="row p-0 m-0  align-items-center">
                                        <p class="col-5 tagOption p-0 m-0 pr-2">'.$data->cuepointname.'</p>
                                          <ul class="col p-0 m-0 no-gutters answersList">
                                            '.$cuepointoptionname_block.'
                                          </ul>
                                    </li>
                                    <hr class="m-0 p-0 my-2">
                                    <!--Hasta aqui-->
                                  ';
                                    $cuepointoptionname_block = "";
                                    $fondo_azul_claro_flag = 1;
                                } // Endif
                              } // end-foreach

                            ?>




                          </ul>
                      </div>
                      <div class="col-xl-8 col-lg-12 m-0 mb-4 ml-xl-3 card-dash bg-white emailTable" >

                        <!-- =================   TABLE - START  ================= -->
                        <div id="interactionTableDataContent">
                        <table id="table_emails" class="tabla-correos w-100">
                              <thead>
                                  <tr>
                        <!--
                                      <th class="Tth">Nombre</th>
                                      <th class="Tth">Email</th>
                        -->
                                      <th class="Tth">ID</th>                                     
                                      <th class="Tth">{{__('dashboard.answer')}}<!-- CUEPOINT NAME --></th>
                                      <th class="Tth">{{__('dashboard.activity')}}</th>
                                      <th class="Tth">{{__('dashboard.date')}}</th>
                                      <th class="Tth">{{__('dashboard.city')}}</th>
                                      <th class="Tth">{{__('dashboard.country')}}</th>
                                      <th class="Tth"></th>
                                  </tr>
                              </thead>
                              <tbody >
                                  @foreach($tableData  as $key =>  $row)
                                  <tr>
                                      <td class="Ttd">{{$key+1}}</td>                                     
                                      <td class="Ttd">{{$row->cuepointoptionname}}</td>
                                      <td class="Ttd">{{$row->actividad}}</td>
                                      <td class="Ttd">{{$row->created_at}}</td>
                                      <td class="Ttd">{{$row->loc_city}}</td>
                                      <td class="Ttd"><img src="https://flagicons.lipis.dev/flags/4x3/{{strtolower($row->loc_country_code)}}.svg" width="20px"></td>                                   
                                      <td class="Ttd">...</td>
                                  </tr>
                                  @endforeach
                              </tbody>
                            </table>
                            </div>

                            <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

                              <!-- Chart.js -->
                              <script src="lib/Chart.js-3.6.2/chart.min.js"></script>
                            <script>
                            let table = new DataTable('#table_emails', {
                                dom: 'Bfrtip',
                                buttons: [
                                    'csv', 'print'
                                ],

                              @if(app()->getLocale()=='es')
                                "language": {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                                    /* //cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json */
                                }
                              @endif

                            });
                            </script>
                            </div>
                        <!-- =================   TABLE - END  ================= -->


                      </div>
                    </div>
                </div>
             </section>
       	</div>

                <!-- Modal filtro de fechas - Interacciones -->
                <div class="modal fade bd-example-modal-sm" id="interactionsFilterByDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="col-12">

                        <p class="text-h4 cMain text-center mt-3">{{__('dashboard.interactions_hist')}}</p>

                        <div class="col-12 pl-4" >

                            <input type="radio" id="date-filter-type1" name="date-filter-type" value="" {{ (\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=="")?"checked":"" }}>
                            <label for="date-filter-type1" class="text-center cMain mb-0 px-3" >{{__('dashboard.all_data')}}</label><br>
                            <input type="radio" id="date-filter-type2" name="date-filter-type" value="n-dias" {{ (\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=="n-dias")?"checked":"" }}>
                            <label for="date-filter-type2" class="text-center cMain mb-0 px-3">{{__('dashboard.intections_for_n_days')}} <input  id="date_filter_n_days_value" type="number" min="1" step="1" max="365" value='{{ \App\Models\UserConfig::getConfigParam("dashboard_dateLastNDays") ?: 1 }}'> {{__('dashboard.ndays')}}</label><br>
                            <input type="radio" id="date-filter-type3" name="date-filter-type" value="inicio-fin" {{ (\App\Models\UserConfig::getConfigParam('dashboard_dateFilter')=="inicio-fin")?"checked":"" }}>
                            <label for="date-filter-type3" class="text-center cMain mb-0 px-3">{{__('dashboard.start_end_date')}}
                            </label>
                            <br><br>

                            <div class="rightMenu d-flex flex-column align-items-center w-100 cMain">
                              <div class="col-10 d-flex justify-content-between px-5 py-2 ">
                                Fecha inicio:
                                <input type="date" id="start" size="10"  class="" placeholder="dd/mm/yyyy" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateStart'))?\App\Models\UserConfig::getConfigParam('dashboard_dateStart'):""}}">
                              </div>
                              <div class="col-10 d-flex justify-content-between px-5 py-2 ">
                                Fecha fin:
                                <input type="date" id="end"   size="10"  class="" value="{{ (\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'))?\App\Models\UserConfig::getConfigParam('dashboard_dateEnd'):""}}">
                              </div>
                              <br>
                              {{__('dashboard.data_since')}} <b>
                              <label id="data-from" >{{$firstInteractionDate}}</label></b>
                            <div>

                        </div>


                        <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5 mt-4">
                          <input type="hidden" id="selectedDateRadio">
                          <button type="submit" id="saveSelectedDateFilters" name="btnSelect" class="btn-square px-3 bg-Main cWhite">{{__('dashboard.accept')}}</button>
                          <button type="button" class="btn-square px-3 bg-05 cMain ml-5" data-dismiss="modal" id="cancelDateFilter">{{__('dashboard.cancel')}}</button>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

        <script>

          //Calendary

          //-----------------------------Change Date Format ---//
          var now = new Date();
          var last = new Date();
          var today = now.toJSON().slice(0,10);
          last.setMonth(last.getMonth() -12);
          last= last.toJSON().slice(0,10);

          if($("#end").val()=="")
            $("#end").val(today);
          if($("#start").val()=="")
            $("#start").val(last);

          function changeDate(date){
            console.log(date);
            /*var d = date;
            var yy = d.splice(-1)[0];
            var mm = d.splice(-1)[0];
            var dd = d.splice(-1)[0];
            d.splice(0, 0, dd);
            d.splice(0, 0, mm);
            d.splice(0, 0, yy);
            var Ndate = d.join("-");
            */
            return(date);
          }


          //click Filter
          $('.filter').on('click', function(){
            $(".filter-m").toggleClass('d-none');
            $(this).toggleClass('bg-Main');
            $(this).toggleClass('bg-03');
          });


          // Setup
          const labels = [
            @foreach ($chartData as $data)
                            "{{ $data->fecha }}",
            @endforeach
            /*"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"*/
          ];

          const data = {
              labels: labels,
              datasets: [
                {
                      label: "{{__('dashboard.completed')}}",
                      backgroundColor: "#00caf1",
                      borderColor: "#00caf1",
                      data: [
                        @foreach ($chartData as $data)
                            "{{ $data->completed }}",
                        @endforeach
                        /*5, 15, 5, 10, 15, 20*/],
                  },
                  {
                      label: "{{__('dashboard.interactions')}}",
                      backgroundColor: "#00026a", /* "rgb(255, 99, 132)" */
                      borderColor: "#00026a", /* "rgb(255, 99, 132)" */
                      data: [
                        @foreach ($chartData as $data)
                            "{{ $data->interactions }}",
                        @endforeach

                        /*0, 10, 5, 2, 20, 30*/],
                  },

              ],
          };

          // Config
          const config = {
              type: "line",
              data: data,
              options: {
                legend: { display: false }
              },
          };

          const myChart = new Chart(document.getElementById("myChart"), config);

          function removeChartData(chart) {
              chart.data.labels.length = 0;
              chart.data.datasets.forEach((dataset) => {
              dataset.data.length = 0;
              });
              chart.update();
          }

          function addChartData(chart, res) {
            console.log(res);
            for(let i in res) {
                //console.log('fecha'+i);
                //console.log(res[i]['interaction']);
                chart.data.labels.push(i);
                chart.data.datasets[1].data.push(res[i]['interaction']);
                chart.data.datasets[0].data.push(res[i]['completed']);
                chart.update();
            }
          }


          /*------------------------------DEVICES & DATE*/
          $(".devices li").on("click", function() {
            $(".devices li").removeClass("active");
            $(this).addClass("active");
            reloadDate();
          });

          $(".dates li").on("click", function() {
            $(".dates li").removeClass("active");
            $(this).addClass("active");
            reloadDate();
          });
          $( "#projectSelect" ).change(function() {
            reloadDate();
          });
          /*$( "#start" ).change(function() {
            reloadDate();
          });
          $( "#end" ).change(function() {
            reloadDate();
          });
          */

          /********************************************************************************************** */

          function reloadDate(){

            var form = new FormData();
            form.append('_token', $("input[name=_token]").val());
            form.append('dateStart', $( "#start" ).val());
            form.append('dateEnd',$( "#end" ).val());
            form.append('projectId',$("#projectSelect").val());
            form.append('device',$(".devices").find(".active").data("id"));
            form.append('dates',$(".dates").find(".active").data("id"));

            console.log("los datos son: projectSelect = "+$("#projectSelect").val())
            //console.log("los datos son: ID:"+projectId+", Dispositivo:"+device+", Tiempo:"+dates+", Fecha inicio:"+dateStart+", Fecha Fin:"+dateEnd);

            $.ajax({
                url:'ajax-save-session-data',
                type: "POST",
                data:  form,
                cache:  false,
            	  contentType: false,
            		processData: false,
             		dataType: 'json' ,
                success: function(response){
                          console.log('ajax-save-session-data: OK');
                    },
                error: function(request, error){
                  console.log(error);
                  console.log(request);
                  alert("Ajax-save-session-data Error: "+JSON.stringify(error));
                }
            });

            $.ajax({
                		url:    'ajax-getChartData',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            //console.log('getChartData:');
                            const res = (response.data);

                            interactionCompleted(res);


                            removeChartData(myChart);
                            addChartData(myChart, res);

                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });

            $.ajax({
                		url:    'ajax-getTagOptionData',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            //console.log('getTagOptionData:');

                           // console.log('REspuesta');
                            //console.log(JSON.stringify(response.data));
                            //document.getElementById('tagOptionTableContent').innerHTML = response.data;
                            optionPanelCreate(response);

                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });

            $.ajax({
                	url:    'ajax-getInteractionTableData',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            document.getElementById('interactionTableDataContent').innerHTML = response.data;
                            // Reinicializar el DataTable
                            table = $('#table_emails').DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'csv', 'print'
                                ],

                              @if(app()->getLocale()=='es')
                                "language": {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                                    /* //cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json */
                                }
                              @endif

                            });

                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });

          }// End: function reloadDate

        //Construyo el panel de Opciones
          const optionPanelCreate = (response) => {
           //console.log('RESPUESTAS');
           //console.log(response.data);
            const panelOptions = document.getElementById('tagOptionTableContent');
            panelOptions.innerHTML = '';

            for(let i in response.data) {
                //console.log('*************ENTRO');
                let item = response.data[i];
                if(item.name == null){
                    //console.log('************* ROMPO');
                }else{
                //Creo Li Padre
                let row = document.createElement('li');
                row.classList.add('row','p-0','m-0','align-items-center');
                panelOptions.appendChild(row);

                //Creo P de Titulo
                row.innerHTML='';
                let parra = document.createElement('p');
                parra.classList.add('col-5', 'tagOption', 'p-0', 'm-0', 'pr-2');
                parra.innerHTML = item.name;
                row.appendChild(parra);

                //Creo UL contenedor de resultados
                let ulContainer = document.createElement('ul');
                ulContainer.classList.add('col', 'p-0', 'm-0', 'no-gutters', 'answersList');
                row.appendChild(ulContainer);

                //Creo Divisor hr
                let hr = document.createElement('hr');
                hr.classList.add('m-0', 'p-0', 'my-2')
                panelOptions.appendChild(hr);


               // The .each() method is unnecessary here:
               valMax=0;
               clavMax="";
               for (let x in item) {
                if(x == 'name' | x == 'score'){

                }else{

                    //pregunto si es mas alto
                    if(item[x]  > valMax){
                        valMax=item[x];
                        clavMax=x;
                    }

                    // console.log('total'+item['score']);
                    //Creo Li de resultado
                    let li = document.createElement('li');
                    li.classList.add('d-flex', 'justify-content-between', 'p-2', 'my-1', 'bg-Main', 'br-r1', 'cWhite');
                    li.setAttribute('id', x);
                    ulContainer.appendChild(li);

                    //Creo P de Nombre en li
                    let pName = document.createElement('p');
                    pName.classList.add('m-0', 'p-0');
                    pName.innerHTML = x;
                    li.appendChild(pName);

                    //Creo P de valoren li
                    let pVal = document.createElement('p');
                    pVal.classList.add('m-0', 'p-0');


                    //%
                    pVal.innerHTML = item[x]+' / '+Math.trunc(item[x] / item['score'] *100) + '%';


                    //agrego P
                    li.appendChild(pVal);
                }

              }
              //console.log(valMax + clavMax);
              document.getElementById(clavMax).classList.add('bg-01');

                }
            }
          }

        //Contruyo el panel interacciones
          const interactionCompleted = (response) => {
            let totalInteractions=0;
            let totalCompleted=0;

            for (let i in response) {
                totalInteractions += response[i]['interaction'];

                if (response[i]['completed'] != null && response[i]['completed'] >= 0) {
                    totalCompleted += response[i]['completed'];
                    console.log(response[i]['completed']);
				} 
                else if (response[i]['completed'] == null) {
                    console.log("completed = null");
                    response[i]['completed'] = 0;
				}
			}
            console.log(totalInteractions);
            console.log(totalCompleted);

            document.getElementById('totalCompleted').innerHTML = totalCompleted;
            document.getElementById('totalInteractions').innerHTML = totalInteractions;
          }


          $('#linkToShowDateFilterDialog').on('click', function(){
     		    //console.log("linkToShowDateFilterDialog()")
            // Asingar en el campo oculto, el valor seleccinoado. en caso de que la persona haga clic más adelante en cancelar
            var radioVal = $("input[name='date-filter-type']:checked").val()
            console.log(radioVal)
            $('#selectedDateFilter').val(radioVal)
         	  $('#interactionsFilterByDate').modal('show')
          });

          $('#date_filter_n_days_value').on('blur', function () {
            //console.log("Liberar el campo: date_filter_n_days_value")
            $("#date-filter-type2").prop("checked", true);
          })

          $('#start').on('blur', function () {
            $("#date-filter-type3").prop("checked", true);
          })

          $('#end').on('blur', function () {
            $("#date-filter-type3").prop("checked", true);
          })

          function cancelDateFilter(){
            console.log("cancelDateFilter()")
            var radioVal = $('#selectedDateFilter').val()
            console.log(radioVal)
            if(radioVal == "n-dias"){
              $("#date-filter-type2").prop("checked", true);
            }else if(radioVal == "inicio-fin"){
              $("#date-filter-type3").prop("checked", true);
            }else{ // sin filtro
              $("#date-filter-type1").prop("checked", true);
            }
          }

          var acceptClickFlag

          $('#interactionsFilterByDate').on('hidden.bs.modal', function () {
            cancelDateFilter()
          })


          //function saveSelectedMaxHist(){
          $('#saveSelectedDateFilters').on('click', function(e){

            //$("#date_filter_n_days_value").val()
            var form = new FormData();
            form.append('filter_type', $("input[name='date-filter-type']:checked").val());
            form.append('date_filter_n_days_value', $("#date_filter_n_days_value").val());
            form.append('start', $("#start").val());
            form.append('end', $("#end").val());
            form.append('_token', $("input[name=_token]").val());
            $.ajax({
                		url:    'ajax-saveDateFilter',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            			  contentType: false, // 'application/json; charset=utf-8'
            			  processData: false,
             			  dataType: 'json' ,
                    success: function(response){
                      		if(response.success == 'Y') {
                            console.log('ajax-saveDateFilter -> OK');
                            $('#interactionsFilterByDate').modal('hide');
                            location.reload();
                      		}
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  console.log(request);
            				  alert("Error: "+JSON.stringify(error));
            			  }
            });
          });
          //};


        //===========================================================================================
        @if($totalInteractions == 0)
          $("#no-projects-modal").modal("show")
        @endif


        function monitorChange(objeto) {
			objeto.on('change', function() {
				console.log('Before monitorChange() : ' + objeto.attr('id') + " - Value: " + objeto.val()); 
				
				valor = objeto.val();

				if (!valor || valor <= 0){
					objeto.val(1);
				}
				console.log('After monitorChange() : ' + objeto.attr('id') + " - Value: " + objeto.val());
            });
    	}

		
        $(document).ready(function() {
            reloadDate();

            monitorChange($('#date_filter_n_days_value'));
            
        });
        
      </script>
    </body>
</html>

>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
