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
    <title> PlayFunnel - The Interactive Video Funnel </title>   
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
	<!-- <script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=ZnVDjqSpdkKhL-QSLVJPHxNn5J9lQMrIKjfhn2VbOSq4bdzH3ya0iMirnB9MRrVJbDRbeRxislY6HWs8B1zcbzcmcrlUKTijP23Cay_sgMJbuKw2rG85EeLJIYw1LpwvEnNR7IEKGXxjBDYfFWJ7hA" charset="UTF-8"></script> -->
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
                <a href="/"><img src="images/SVG/logo-playFunnel.svg" class="logoImg col-6 col-md-2" alt="Descripción de la imagen"></a>
            </div>
            
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 formy p-0 px-md-1 px-0 d-flex flex-column justify-content-center">                
                <form class="row justify-content-center px-3 px-md-4 " action="forgot_pass" method="POST">
                	{{ csrf_field() }}
                    <div class="col-12">
                        <p class="text-h2 text-center ">{{__('login.forgot-password-title')}}</p>
                        <p class="text-center pb-2 text-c02">{{__('login.forgot-password-text')}}
                        </p>
                    </div>
                 
                    <div class="form-group col-12 p-0 mb-3"> 
                        <div class="input-icon"> 
                        <i class="material-icons">email</i>                     
                      <input type="email" class="inputForm" id="email" name="email" aria-describedby="emailHelp" value="<?= $_GET['email']?>">                    
                    </div>                  
                      <small id="emailHelp" class="d-none form-text text-muted">{{__('login.request')}}</small>
                    </div>
                    @error('email')<span class="alert alert-danger w-100 text-center">{{ $message }}</span>@enderror
                    
                    
                    <button type="submit" class="btn btn-cMain my-4 w-100">{{__('login.request')}}</button>
                    <small id="gotoLogin" class="d-flex form-text text-muted justify-content-end text-c01"><a href="/" id="forgot_link">{{__('login.go-loging')}}</a></small>                 
                  
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </form>
                  
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
            window.location.href = "forgot_pass?email="+$("#email").val()
          });

        }
      </script>
</body>
</html>
