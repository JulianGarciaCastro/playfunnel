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
    <title>	PlayFunnel - The Interactive Video Funnel - Facturacion </title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
  </head>
  <body class="bg-cWhite">
    @include('nav_bar')
    <!--------------------------------MAIN------------------------------->
    <div class="dashboard-perfil container-fluid p-0">
      <!------UP----------->
      <section class="dashboard-Nav row w-100 p-0 justify-content-center m-0 projects ">

        <!--Menu Side Left -->
        <x-side-nav/>

        <div class="panelUp container justify-content-center row p-0 px-1">
          <div class="perfil-data row col-12 mx-0 justify-content-center">
            <div class="circle row justify-content-center align-items-center p-0 m-0">
              {{$user->name[0]}}
            </div>
            <div class="ml-4">
              <h5 class="mb-0 text-b nameUp">{{$user->name}} {{$user->lastname}} </h5>
              <p>{{$user->email}}</p>
            </div>
          </div>
          <div class="nav-options w-100  row justify-content-left align-items-end col-12 p-0">
            <div class="btn-nav active col-md-3 col-4 col-md-3">
              <p class="m-0">FACTURACION</p>
            </div>
          </div>
        </div>
      </section>
      <!------CONTENT----------->
      <br />
      <section class="row dashboard-Content w-100 m-0 p-0">

        <div class="content row justify-content-between col-12 p-0 m-0">
          <!------CENTER---------->
          <div class="row right col align-items-center justify-content-center p-0 m-0 mx-0 ">
            <div class="col-12 row justify-content-center px-0 ">
              <table class="table w-100 billing mx-3">
                <thead>
                  <tr>
                    <th>Plan</th>
                    <th class="d-none d-md-block">Capacidad</th>
                    <th>Fecha</th>
                    <th>Precio</th>
                    <th class="d-none d-md-block">Estado</th>
                    <th>Descargar</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($plans as $plan)
                  <tr>
                    <td>{{ $plan->getPlanName() }}</td>
                    <td class="d-none d-md-block">{{ $plan->getPlanSize() }} GB</td>
                    <td>{{ $plan->getPlanSubscriptionDate() }} </td>
                    <td>{{ $plan->getPlanPrice() }}</td>
                    <td class="d-none d-md-block">
                      @if( $plan->isPlanSubscriptionActive())
                        <i class="fa fa-check cSucess" aria-hidden="true"></i>
                      @else
                        Desactivado
                      @endif
                    </td>
                    <td>
                      <button class="btn-square-min bg-Main cWhite m-0 " onclick="window.location.href='generate-bill-pdf?planid={{ $plan->getPlanID() }}';">
                        <i class="btn-square-min bg-Main cWhite fa fa-download" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 							integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 		integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
