<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/Style.css">
    <title> {{ __("PlayFunnel - The Interactive Video Funnel") }}</title>   
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
	<!-- <script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=ZnVDjqSpdkKhL-QSLVJPHxNn5J9lQMrIKjfhn2VbOSq4bdzH3ya0iMirnB9MRrVJbDRbeRxislY6HWs8B1zcbzcmcrlUKTijP23Cay_sgMJbuKw2rG85EeLJIYw1LpwvEnNR7IEKGXxjBDYfFWJ7hA" charset="UTF-8"></script> -->
</head>
<body class="bg-light logIn">
    <div class="container-fluid">
        <section class="row col-12 justify-content-center align-items-center m-0">
            
            <div class="logo_playF col-12 d-flex justify-content-center justify-content-md-start mt-3 mt-md-5">
                <a href="/"><img src="../../images/SVG/logo-playFunnel.svg" class="logoImg col-6 col-md-2" alt="Descripción de la imagen"></a>
            </div>
            
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 formy p-0 px-md-1 px-0 d-flex justify-content-center">
                <form class="row justify-content-center bg-white px-3 px-md-4 " action="{{ route('password.update') }}" method="POST">
                <input type="hidden" name="token" value="{{ $token }}">
                	{{ csrf_field() }}
                    <div class="col-12">
                        <p class="text-h2 text-center ">{{__("reset_pass.type_your_new")}} <br> {{__("reset_pass.password")}}</p>
                    </div>
                    <div class="form-group col-12">
                      <label for="exampleInputEmail1" class="text-c02 mb-0">{{__("reset_pass.Email")}}</label>
                      <?php
                        $email = $_GET['email'];
                      ?>
                      <input type="email" class="inputForm" id="email" name="email"  value="{{ $email ?? old('email') }}" required aria-describedby="emailHelp" readonly>
                      <small id="emailHelp" class="d-none form-text text-muted">{{__("reset_pass.never_share_email")}}</small>
                    </div>
                    <div class="form-group col-12">
                      <label for="exampleInputEmail1" class="text-c02 mb-0">{{__("reset_pass.Password")}}</label>
                      <input type="password" class="inputForm" id="password" name="password" required aria-describedby="emailHelp">
                      <small id="emailHelp" class="d-none form-text text-muted">{{__("reset_pass.never_share_email")}}</small>
                    </div>
                    <div class="form-group col-12">
                      <label for="exampleInputEmail1" class="text-c02 mb-0">{{__("reset_pass.ConfirmPassword")}}</label>
                      <input type="password" class="inputForm" id="password_confirmation" name="password_confirmation" required aria-describedby="emailHelp">
                      <small id="emailHelp" class="d-none form-text text-muted">{{__("reset_pass.never_share_email")}}</small>
                    </div>
                    <button type="submit" class="btn btn-cMain my-4">{{__("reset_pass.continue")}}</button>
                    <a class="text-center pb-2 text-c02 col-12"><span class="text-c01"><a href="/">{{__("reset_pass.back_to_login")}}</a></span></a>
                    @if(isset($errors))
                         @foreach ($errors->all() as $error)
                          <div class="alert alert-danger" role="alert">{{ $error }}</div>
                        @endforeach
              		@endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </form>
                  
            </div>
        </section>
    </div>
</body>
</html>