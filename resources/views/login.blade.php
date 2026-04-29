<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Style.css">
    <title> {{ __('login.title') }} </title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">   
  
	<!-- <script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=ABK8ziiPikx02WK96_YtG1dns-K4N28gIeUNhmUO8vCod0VwQ6R91uapOet63bxNYc5fnChxef8l_zp0V-Jd6siZMA8KRgq4IGWsGP_RqIPA4VLhvNPtlAPbVe9y_8e5vhZOcV4pysT3quveDYq1XA" charset="UTF-8"></script> -->
</head>
<body class="bg-light logIn">
    <div class="container-fluid">
        <section class="row col-12 justify-content-center align-items-center m-0">

            <div class="logo_playF col-12 d-flex justify-content-center justify-content-md-end mt-3 ">
                <div id="langs-3" class="d-flex justify-content-center flex-column">
                    <a href="/locale/es" class="<?= (app()->getLocale()=='es')?'active':'d-none' ?>"><img src="https://flagicons.lipis.dev/flags/4x3/es.svg" class="  " alt="Descripción de la imagen" style="width:20px"></a>              
                    <a href="/locale/en" class="<?= (app()->getLocale()=='en')?'active':'d-none' ?>"><img src="https://flagicons.lipis.dev/flags/4x3/gb.svg" class="  " alt="Descripción de la imagen" style="width:20px"></a>               
                </div>
                <i id="langs-down" class="material-icons cMain">arrow_drop_down</i>                           
            </div>


            <div class="logo_playF col-12 d-flex justify-content-center justify-content-md-start mt-3 mt-md-5">
                <img src="images/SVG/logo-playFunnel.svg" class="logoImg col-6 col-md-2" alt="Descripción de la imagen">
            </div>

            
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 formy p-0 px-md-1 px-0 d-flex flex-column justify-content-center">                
                <!-- <form class="row justify-content-center bg-white px-3 px-md-4 " action="/dashboard" method="GET" >  -->
                <form class="row justify-content-center px-3 px-md-4 "  action="login" method="POST" >
                	{{ csrf_field() }}
                    <div class="col-12">
                        <p class="text-h2 text-center ">{{__('login.enter_login')}}</p>
                        <p class="text-center pb-2 text-c02">{{__('login.account')}}<br><span class="text-c01"><a href="register">{{__('login.start_now')}}</a></span></p>
                    </div>               
                    <div class="form-group col-12 p-0"> 
                        <div class="input-icon"> <i class="material-icons">email</i> <input type="email"
                                class="form-control" id="email" name="email" aria-describedby="emailHelp"
                                placeholder="{{ __('register.email') }}" value="{{ old('email') }}"> </div> <small
                            id="emailHelp"
                            class="d-none form-text text-muted">{{ __('register.no_mail_detected') }}</small>
                    </div>
                    <div class="form-group col-12 p-0">
                        <div class="input-icon"> <i class="material-icons">lock</i> <input type="password"
                                class="form-control" id="password" name="password" placeholder="{{ __('register.password') }}">
                        </div> <small id="passwordHelp"
                            class="d-none form-text text-muted">{{ __('register.no_password_detected') }}</small>
                           <small id="emailHelp" class="d-flex form-text text-muted justify-content-end text-c01"><a href="#" id="forgot_link">{{__('login.forgot_password')}}</a></small>
                            
                    </div>
                    
                    
                  
                    <button type="submit" class="btn btn-cMain my-4 w-100">{{__('login.login_btn')}}</button>
                     @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(isset($errors))
                         @foreach ($errors->all() as $error)
                          <div class="alert alert-danger" role="alert">{{ $error }}</div>
                        @endforeach
              		@endif
                  </form>
                  <div class="google-login col-12 p-0">
                    <div class="or-separate" bis_skin_checked="1"><hr class="css-17kses8"><span class="css-ccfh0q">{{ __('register.google_or') }}</span><hr class="css-17kses8"></div>
                    <a href="{{ route('google.login') }}" class="btn cMain w-100"><img src="/images/google-g-logo.png" />Google</a>
                    <div class="terms">
                      <p class="pl-4 pt-3 text-c02 mt-4"> {{ __('profile.info_abnout') }} 
                        <a href="https://playfunnel.net/terminos-y-condiciones" target="_blank" class="c01 col-12 text-center pt-3 px-0">
                          {{ __('profile.service_conditions') }} 
                        </a>
                        {{ __('profile.or') }} 
                        <a href="https://playfunnel.net/politica-de-privacidad" target="_blank" class="c01 col-12 text-center px-0">
                          {{ __('profile.our_privacy_policy') }}
                        </a> 
                      </p>
                    </div>
                  </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        window.onload = function() { 
          
          /*---------Langs--*/
          $("#langs-down").click(function() {
            $("#langs-3 a").each(function(){
                if(!$(this).hasClass("active")){
                    $(this).toggleClass("d-none");       
                }else{
                  $(this).parent().prepend($(this));
                }   
            });
            $("#langs-down").toggleClass("rotate"); 
          });

          $("#forgot_link").click(function() {
        	  var email = $("#email").val();
        	  var encodedEmail = encodeURIComponent(email);
              window.location.href = "forgot_pass?email="+encodedEmail;
          });

        }
      </script>
        
</body>
</html>

