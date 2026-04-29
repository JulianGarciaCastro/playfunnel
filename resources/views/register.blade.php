<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/Style.css">
    <title>{{ __('register.title') }}</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <script src="https://www.google.com/recaptcha/api.js"></script>    
</head>

<body class="bg-light logIn">
    <div class="container-fluid">
        <section class="row col-12 justify-content-center align-items-center m-0">
            <div class="logo_playF col-12 d-flex justify-content-center justify-content-md-end mt-3 "> <a
                    href="/locale/es"><img src="https://flagicons.lipis.dev/flags/4x3/es.svg"
                        alt="Descripción de la imagen" style="width:30px"></a> &nbsp; <a href="/locale/en"><img
                        src="https://flagicons.lipis.dev/flags/4x3/gb.svg" alt="Descripción de la imagen"
                        style="width:30px"></a> </div>
            <div class="logo_playF col-12 d-flex justify-content-center justify-content-md-start mt-3 mt-md-5"> <a
                    href="/"><img src="images/SVG/logo-playFunnel.svg" class="logoImg col-6 col-md-2"
                        alt="Descripción de la imagen"></a> </div>
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 formy p-0 px-md-1 px-0 d-flex flex-column justify-content-center">
                <form class="row justify-content-center px-3 px-md-4" id="signupForm" action="register" method="POST"
                    onsubmit="return validateRegister(event)"> {{ csrf_field() }} <div class="col-11">
                        <p class="text-h2 cMain text-center">{{ __('register.register') }}</p>
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
                                class="form-control" id="password" name="password" minlength="8" placeholder="{{ __('register.password') }}">
                        </div> <small id="passwordHelp"
                            class="d-none form-text text-muted">{{ __('register.no_password_detected') }}</small>
                    </div>
                    <div class="form-group col-12 p-0"> 
                        <div class="input-icon"> <i class="material-icons">lock</i> <input type="password"
                                class="form-control" id="password_confirmation" name="password_confirmation" minlength="8"
                                placeholder="{{ __('register.confirm_password') }}"> </div> <small id="passwordConfirmationHelp"
                                class="d-none form-text text-muted">{{ __('register.passwords_doesnt_mach') }}</small>
                    </div> 
                    <button type="submit" class="g-recaptcha btn btn-cMain my-1 col-12"
                        data-sitekey={{ config('services.recaptcha_v3.siteKey') }} data-callback='onSubmit'
                        data-action='submit'>{{ __('register.register') }} 
                    </button>  
                    <div class="text-center pb-2 col-12 mt-4">
                      <span class="text-c01">
                        {{ __('register.back_to_login') }} <a class="c01" href="/">{{ __('register.back_to_login_link') }}</a>
                       </span>
                      </div>                                     
                    @if (isset($errors))
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
          
            </div>
        </section>
    </div> <!-- Alert mesage modal --> 
</body>
<script src="js/jquery-3.5.1.min.js"></script>
<script>
    //$(document).ready(function(){

    function modalPopupAlert(message) {
        console.log("modalPopupAlert()")
        console.log(message)
        //$('#alert-modal').modal('show');
    }

    function validateRegister(e) {

        /* if (!$("#name").val()) {
            alert("{{ __('register.type_your_name') }}");
            modalPopupAlert("{{ __('register.type_your_name') }}");
            $('#name').focus()
            e.preventDefault();
            return false;
        }*/

        if (!$("#email").val()) {
            alert("{{ __('register.type_your_email') }}");
            $('#email').focus()
            e.preventDefault();
            return false;
        }

        if (!$("#password").val()) {
            alert("{{ __('register.type_your_password') }}");
            $('#password').focus()
            e.preventDefault();
            return false;
        }

        if (!$("#password_confirmation").val()) {
            alert("{{ __('register.confirm_your_password') }}");
            $('#password_confirmation').focus()
            e.preventDefault();
            return false;
        }

        if ($("#password").val() != $("#password_confirmation").val()) {
            alert("{{ __('register.confirmation_doesnt_match') }}");
            $('#password_confirmation').focus()
            e.preventDefault();
            return false;
        }

        if (!$("#termsConditions").is(':checked')) {
            e.preventDefault();
            alert("{{ __('register.accept_terms') }}");
            return false;
        }

        return true;
    }

    function onSubmit(token) {
        document.getElementById("signupForm").requestSubmit();
    }
    //}
</script>


</html>
