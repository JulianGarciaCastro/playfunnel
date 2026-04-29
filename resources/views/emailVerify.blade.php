<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/Style.css">
    <title>	PlayFunnel - The Interactive Video Funnel </title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body class="bg-light logIn">
    <div class="container-fluid">
        <section class="row col-12 justify-content-center align-items-center m-0">

            <div class="logo_playF col-12 d-flex justify-content-center justify-content-md-start mt-3 mt-md-5">
                <img src="../../images/SVG/logo-playFunnel.svg" class="logoImg col-6 col-md-2" alt="Descripción de la imagen">
            </div>

            <div class="col-12 col-md-8 col-lg-6 col-xl-4 formy p-0 px-md-1 px-0 d-flex justify-content-center">
                <form id="myForm" name="myForm" class="row justify-content-center bg-white px-3 px-md-4 " method="POST" action="{{ route('verification.resend') }}">
                    {{ csrf_field() }}
                    <div class="col-12">
                        <p class="text-h6 cMain text-center ">{{__('emails.verify_account')}}</p>
                        <p class="text-center pb-2 c02 font-weight-bold">{{ $email}}</p>
                          <!-----------------------------------------------------------------Este Mensaje deberia cambiar-->
                        <p class="text-center pb-2 c02">{{__('emails.verify_email_inbox')}}</p>

                           <!-----------------------------------------------------------------Este Mensaje deberia cambiar-->
                        <!--   <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button> -->
                    </div>
                    <a href="#"><p class="c01"  onclick="document.getElementById('myForm').submit()">{{__('emails.verify_send_email')}}</p></a>
                  </form>

            </div>
        </section>
    </div>
</body>
</html>
