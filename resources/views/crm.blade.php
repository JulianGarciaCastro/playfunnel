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
        <title> {{__('crm.title')}} </title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>

    </head>
	<body class="bg-white">


    	@include('nav_bar')

        @php
            if(app()->getLocale()=='es'){
                $formattedDate = 'Y-m-d h:m:s';
            }else{
                $formattedDate = 'd-m-Y h:m:s';
            }
        @endphp

      {{ csrf_field() }}

        <!--------------------------------MAIN------------------------------->
        <div class="container-fluid m-0 p-0 vh-100">
             <section class="projects row col-12  mx-0 p-0 w-100">
              <!--Menu Side Left -->
              <x-side-nav/>

                <div class="mainContainer col row p-0 m-0">
                    <div class="main w-100 m-0 p-0 p-lg-5 p-2">
                    <div class=" ">
                            <h2 class="font-weight-light cMain h3">{{__('crm.crm')}}</h2>
                        </div>
                      <div class="px-2 py-3 my-2 d-flex justify-content-center align-items-center">
                        <div class="col filter d-flex d-lg-none p-3 bg-Main c06 br-r1" ><i class="fas fa-filter"></i></div>
                        <select name="projects" id="projectSelect" class="ml-3 selectBlue">
                        <option value="--"> {{__('crm.all_projects')}} </option>
                        @foreach ($projects as $project)
                            @if ($project->project_status_id == 3)
                              @continue
                            @endif
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                        </select>
                      </div>



                      <div class="col-xl-12 col-lg-12 m-0 mb-4 ml-xl-3 card-dash bg-white emailTable" >

                        <!-- =================   TABLE - START  ================= -->
                        <div id="interactionTableDataContent">
                        <table id="table_emails" class="tabla-correos w-100">
                              <thead>
                                  <tr>
                        <!--
                                      <th class="Tth">Nombre</th>
                                      <th class="Tth">Email</th>
                        -->
                                      <th class="Tth">#</th>
                                      <th class="Tth">{{__('crm.name')}}</th>
                                      <th class="Tth">Email</th>
                                      <th class="Tth">{{__('crm.phone')}}</th>
                                      <th class="Tth">{{__('crm.address')}}</th>
                                      <th class="Tth">{{__('crm.birthday')}}</th>
                                      <th class="Tth">{{__('crm.city')}}</th>
                                      <th class="Tth">{{__('crm.state')}}</th>
                                      <th class="Tth">{{__('crm.zip')}}</th>
                                      <th class="Tth">{{__('crm.country')}}</th>
                                      <th class="Tth">{{__('crm.created')}}</th>
                                      <th class="Tth"></th>
                                  </tr>
                              </thead>
                              <tbody id="table-content">

                                  @foreach($customers  as $key =>  $customer)
                                  <tr>
                                      <td class="Ttd">{{$key+1}}</td>
                                      <td class="Ttd">{{ $customer->name }}</td>
                                      <td class="Ttd">{{ $customer->email }}</td>
                                      <td class="Ttd">{{ $customer->tel }}</td>
                                      <td class="Ttd">{{ $customer->address }}</td>
                                      <td class="Ttd">{{ $customer->birthday }}</td>
                                      <td class="Ttd">{{ $customer->city }}</td>
                                      <td class="Ttd">{{ $customer->state }}</td>
                                      <td class="Ttd">{{ $customer->cp }}</td>
                                      @if(isset($customer->contry))
                                      <td class="Ttd"><img src="https://flagicons.lipis.dev/flags/4x3/{{strtolower($customer->contry)}}.svg" width="20px"></td>
                                      @else
                                      <td class="Ttd"></td>
                                      @endif
                                      <td class="Ttd">{{ date($formattedDate, strtotime($customer->created_at)) }}</td>
                                      <td class="Ttd"><a onclick="viewCustomerById({{ $customer->id }})">...</a></td>
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

        <!-- Modal Histórico de interacciones -->
         <div class="modal fade bd-example-modal-md show" id="interactionsFilterByCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="close-modal"><a onclick="closeModal()"><i class="fas fa-times" aria-hidden="true"></i></a></div>
                <div class="modal-content justify-content-start col-12 p-4" id="viewCustomer">

                </div>
              </div>
            </div>
          </div>




        <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

          <!-- Chart.js -->
          <script src="lib/Chart.js-3.6.2/chart.min.js"></script>
        <script>
            //If select other project
            $( "#projectSelect" ).change(function() {
                if($(this).val() == '--'){
                    window.location.reload();
                }else{
                    reloadDate();
                }

            });

            //Call customers by Project
            function reloadDate(){

                var form = new FormData();
                form.append('_token', $("input[name=_token]").val());
                form.append('projectId',$("#projectSelect").val());
                console.log("los datos son: projectSelect = "+$("#projectSelect").val())
                //console.log("los datos son: ID:"+projectId+", Dispositivo:"+device+", Tiempo:"+dates+", Fecha inicio:"+dateStart+", Fecha Fin:"+dateEnd);

                $.ajax({
                	url:    'crm-CustomerByProjectId',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            		contentType: false, // 'application/json; charset=utf-8'
            		processData: false,
             		dataType: 'json' ,
                    success: function(response){
                            if(response.success == 'Y') {
                            // Reinicializar el DataTable
                            console.log(response.customers);
                            createTable(response.customers);
                            }
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  alert("Error: "+JSON.stringify(error));
            		}
                });
            }

            //Call Re-build table customers by Project
            const createTable = (customers) =>{
                //delete content
                document.querySelector('#table-content').remove();
                const newContent = document.createElement("tbody");
                newContent.setAttribute('id','table-content');
                document.querySelector('#table_emails').append(newContent);




                customers.forEach((element, index) => {
                    console.log(index+1);
                    const fieldCustomer = document.createElement("tr");
                    document.querySelector('#table-content').append(fieldCustomer);
                    for (const field in element) {
                        console.log(field);
                        if(field == 'id'){
                            const fieldValue = document.createElement("td");
                            fieldValue.classList.add('Ttd');
                            fieldValue.textContent = index+1;
                            fieldCustomer.append(fieldValue);
                        }else if(field == 'created_at'){
                            const fieldValue = document.createElement("td");
                            fieldValue.classList.add('Ttd');
                            fieldValue.textContent = formatDate(element[field]);
                            fieldCustomer.append(fieldValue);
                        }

                        else if(field == 'updated_at'){
                            const fieldValue = document.createElement("td");
                            fieldValue.classList.add('Ttd');
                            const link = document.createElement("a");
                            link.setAttribute('onclick','viewCustomerById('+element.id+')');
                            link.textContent = '...';
                            fieldValue.append(link);
                            fieldCustomer.append(fieldValue);

                        }
                        else{
                            const fieldValue = document.createElement("td");
                            fieldValue.classList.add('Ttd');
                            fieldValue.textContent = element[field];
                           fieldCustomer.append(fieldValue);
                        }
                    }

                });
            }

            //Change format to date from ISO to yyyy-mm-dd hh:mm:ss
            const formatDate = ( date ) => {
                const fechaOriginal = date;
                const fechaObjeto = new Date(fechaOriginal);

                const anio = fechaObjeto.getUTCFullYear();
                const mes = fechaObjeto.getUTCMonth() + 1; // Los meses en JavaScript son base 0 (enero = 0)
                const dia = fechaObjeto.getUTCDate();
                const hora = fechaObjeto.getUTCHours();
                const minutos = fechaObjeto.getUTCMinutes();
                const segundos = fechaObjeto.getUTCSeconds();

                // Formatea la cadena de fecha deseada

                //console.log(fechaFormateada);



                @if(app()->getLocale()=='es')
                const fechaFormateada = `${anio}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')} ${hora.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
                @else
                const fechaFormateada = `${dia.toString().padStart(2, '0')}-${mes.toString().padStart(2, '0')}-${anio} ${hora.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
                @endif
                console.log(fechaFormateada);
                return  fechaFormateada;
            }

            //Press View in Customer
            const viewCustomerById = ( customerId ) => {
                //console.log(customerId);

                //Call BBDD
                var form = new FormData();
                form.append('_token', $("input[name=_token]").val());
                form.append('CustomerId',customerId);

                $.ajax({
                	url:    'crm-CustomerById',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            		contentType: false, // 'application/json; charset=utf-8'
            		processData: false,
             		dataType: 'json' ,
                    success: function(response){
                            if(response.success == 'Y') {
                            // Reinicializar el DataTable
                            //console.log(response);
                            createCustomer(response);
                            }
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  alert("Error: "+JSON.stringify(error));
            		}
                });


            }

            //Build view customers and Interactions
            const createCustomer = (interactions) =>{
                console.log(interactions);
                viewCustomer = document.querySelector('#interactionsFilterByCustomer #viewCustomer');

                //clean modal
                viewCustomer.innerHTML = '';

                //createTable
                const header = document.createElement('div');
                header.classList.add('d-flex');
                const i = document.createElement('i');
                i.classList.add('far','fa-user-circle','mr-4');
                i.setAttribute('aria-hidden','true')
                const title = document.createElement('div');
                const titulo = document.createElement('div');
                const h2 = document.createElement('h2');
                h2.textContent = interactions.customers.name;
                const p = document.createElement('p');
                p.textContent = interactions.customers.email;
                title.append(h2,p);
                header.append(i,title);
                viewCustomer.append(header);


                //create Interactions Panels
                let projectsSet = [];
                interactions.iteractions.forEach((element, index) => {
                    //create main container
                    const interactionProject = document.createElement('div');

                    //create hr h4 ul
                    if(!projectsSet.includes(element.projectid)){
                        console.log('create new project ul');
                        const hr = document.createElement('hr');
                        const h6 = document.createElement('h6');
                        h6.textContent = element.nameProject;
                        h6.classList.add('cMain');
                        const ul = document.createElement('ul');
                        ul.setAttribute('data-project',element.projectid);
                        h6.classList.add('p-3');
                        interactionProject.append(hr, h6, ul)
                        viewCustomer.append(interactionProject);
                        projectsSet.push(element.projectid);
                        console.log(projectsSet);
                    }else{
                        console.log('same project ul');
                    }


                    //interactions
                    const li = document.createElement('li');
                    li.classList.add('d-flex','justify-content-between');
                    const route = document.createElement('div');
                    route.classList.add('routeTitle','w-50');
                    route.textContent = element.cuepointoptionname;
                    const date = document.createElement('div');
                    date.classList.add('dateTitle');
                    date.textContent = formatDate(element.created_at);
                    li.append(route, date);
                    const ul = document.querySelector('[data-project="'+element.projectid+'"]');
                    const hr = document.createElement('hr');
                    ul.append(hr, li);
                });

                $('#interactionsFilterByCustomer').modal().show();


            }


            //Close modal
            const closeModal = () =>{
                $('#interactionsFilterByCustomer').modal('hide');
            }


        </script>





    </body>
</html>

