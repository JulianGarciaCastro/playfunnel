<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
    <title>	{{__('profile.title')}}</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
</head>
<body class="bg-cWhite">
  @include('nav_bar')

    <!-------------------------------------------------------------------------------MAIN-->
    <div class="dashboard-perfil container-fluid p-0">
          <!------UP----------->
          <section class="projects dashboard-Nav row w-100 p-0 justify-content-center m-0">

         <!--Menu Side Left -->
         <x-side-nav/>

            <div class="panelUp container justify-content-center row p-0 px-1">
             <div class="perfil-data row col-12 mx-0 justify-content-center">
                <div class="circle row justify-content-center align-items-center p-0 m-0">
                  @if($user->name)
                  	{{$user->name[0]}}
                  @else
                  	PF
                  @endif
                </div>
                <div class="ml-4">
                  <h5 class="mb-0 text-b nameUp">{{$user->name}} {{$user->lastname}} </h5>
                  <p>{{$user->email}}</p>
                </div>
             </div>
              <div class="nav-options w-100  row justify-content-center align-items-end col-12 p-0">
                <div class="btn-nav  active col-4 col-md-3 col-lg-2 col-xl-3">
                  <p class="m-0">{{__('profile.identification')}}</p>
                </div>
                <div class="btn-nav col-4 col-md-3 col-lg-2 col-xl-3">
                  <a href="/account" ><p class="m-0">{{__('profile.account')}}</p> </a>
                </div>
             </div>
            </div>
         </section>
             <!------CONTENT----------->
          <section class="row dashboard-Content w-100 m-0 p-0t">
            <div class="content row justify-content-between col-12">
               <!------LEFT----------->
              <div class="left col-md-7 col-12">
                <form class="row col-12 justify-content-center px-0 mx-0" action="profile" method="POST">
                {{ csrf_field() }}
                  <div class="col-12 px-0">
                      <p class="text-h4 cMain">{{__('profile.edit_personal_info')}}</p>
                  </div>
                  <div class="form-group col-12 px-0">
                    <div class="d-flex col-12 px-0 justify-content-between align-items-end row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0 col-md-2 col-12 mr-4 p-0">{{__('profile.name')}}:</label>
                      <input type="text" class="inputForm col" id="name" name="name" aria-describedby="" value="{{$user->name}}">
                    </div>
                    <small id="" class="d-none form-text text-muted">{{__('profile.not_share_email')}}</small>
                  </div>
                  <div class="form-group col-12 px-0">
                    <div class="d-flex col-12 px-0 justify-content-between align-items-end row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0 col-md-2 col-12 mr-4 p-0">{{__('profile.lastname')}}:</label>
                      <input type="text" class="inputForm col" id="lastname" name="lastname" aria-describedby="" value="{{$user->lastname}}">
                    </div>
                    <small id="" class="d-none form-text text-muted">{{__('profile.not_share_email')}}</small>
                  </div>
                  <div class="form-group col-12 px-0">
                    <div class="d-flex col-12 px-0 justify-content-between align-items-end row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0 col-md-2 col-122 mr-4 p-0">{{__('profile.country')}}:</label>
                      <input type="text" class="inputForm col" id="country" name="country" aria-describedby="" value="{{$user->country}}">
                    </div>
                    <small id="" class="d-none form-text text-muted">{{__('profile.not_share_email')}}</small>
                  </div>
                  <div class="form-group col-12 px-0">
                    <div class="d-flex col-12 px-0 justify-content-between align-items-end row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0 col-md-2 col-12 mr-4 p-0">{{__('profile.city')}}:</label>
                      <input type="text" class="inputForm col" id="city" name="city" aria-describedby="" value="{{$user->city}}">
                    </div>
                    <small id="" class="d-none form-text text-muted">{{__('profile.not_share_email')}}</small>
                  </div>
                  <div class="form-group col-12 px-0">
                    <div class="d-flex col-12 px-0 justify-content-between align-items-end row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0 col-md-2 col-12 mr-4 p-0">{{__('profile.address')}}:</label>
                      <input type="text" class="inputForm col" id="address" name="address" aria-describedby="" value="{{$user->address}}">
                    </div>
                    <small id="" class="d-none form-text text-muted">{{__('profile.not_share_email')}}</small>
                  </div>
                  <div class="form-group col-12 px-0 row justify-content-between">
                    <div class="d-flex  px-0  align-items-end justify-content-between col-12 col-md-5 row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0  mr-md-2 p-0 col-12 col-md-2 mr-4">{{__('profile.zip')}}: </label>
                      <input type="text" class="inputForm short col" id="postal" name="postal" aria-describedby="" value="{{$user->postalcode}}">
                    </div>
                    <div class="d-flex  px-0 justify-content-between align-items-end col-12 col-md-6 mt-4 mt-md-0 pt-3 pt-md-0 row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0  mr-md-2 p-0 col-2 mr-4">{{__('profile.phone')}}: </label>
                      <input type="text" class="inputForm short col" id="phone" name="phone" aria-describedby="" value="{{$user->phone}}">
                    </div>
                  </div>
                  <div class="form-group col-12 px-0">
                    <div class="d-flex col-12 px-0 justify-content-between align-items-end row m-0">
                      <label for="exampleInputEmail1" class="cMain mb-0 col-md-5 col-4 p-0">{{__('profile.birthday')}}:</label>
                      <input type="date" class="inputForm medium col" id="birthdate" name="birthdate" aria-describedby="" value="{{$user->birthdate}}">
                    </div>
                    <small id="" class="d-none form-text text-muted">{{__('profile.not_share_email')}}</small>
                  </div>
                  <!--
                  <div class="row justify-content-between col-12 px-0">
                    <button type="submit" class="btn btn-cCancel my-4">Descartar</button>
                    <button type="submit" class="btn btn-cMain my-4">Guardar</button>
                  </div>
                  -->
                 <button type="submit" class="btn btn-cMain my-4" >{{__('profile.save')}}</button>
                </form>
              </div>
               <!------RIGHT---------->
              <div class="right col align-items-center justify-content-center  mx-0 row">
                <div class="col-12 row justify-content-center px-0">
                  <div class="circle row justify-content-center align-items-center p-0 m-0 ">
                    <img class="imgProfile" id="imgHeader" name="imgHeader" src="{{ asset( $user->profile_img) }}" />
                  </div>
                  <div class="col-12 row justify-content-center px-0">
                    <label for="files" class="labels col-12 p-0 text-center cMain"><i class="fas fa-search mr-2"></i>{{__('profile.change_image')}}</label>
                    <input style="visibility:hidden;" type="file" id="files" name="files" value="{{$user->profile_img}}" />
                  </div>


                  <p class="col-12 cMain">
                  {{__('profile.info_abnout')}} <a href="https://playfunnel.net/terminos-y-condiciones" target="_blank" class="c01 col-12 text-center pt-3 px-0">{{__('profile.service_conditions')}} </a>
                  {{__('profile.or')}} <a href="https://playfunnel.net/politica-de-privacidad"  target="_blank" class="c01 col-12 text-center px-0">{{__('profile.our_privacy_policy')}}</a>
                  </p>
                 </div>
              </div>

            </div>
          </section>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 						 integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 	 integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"> </script>
    <script>
       function readURL(input) {
            if (input.files && input.files[0]) {

            	var fileTypes = ['jpg', 'jpeg', 'png', 'bmp'];  						//acceptable file types
            	var extension = input.files[0].name.split('.').pop().toLowerCase(), 	//file extension from input file
            	isSuccess = fileTypes.indexOf(extension) > -1;  						//is extension in acceptable types

            	if(!isSuccess){
            		alert('Tipo de Archivo no valido');
            		$("#files")[0].value = '';
            		return null;
            	}

            	var fileSize = input.files[0].size;
            	fileSize = (fileSize/(1024*1024)).toFixed(2);
            	//alert('Tama�o Fichero:' + fileSize );

                var reader = new FileReader();

                if(fileSize >= 10.0){
            		alert('Archivo no puede superar los 10MB');
            		$("#files")[0].value = '';
            		return null;
            	}

                reader.onload = function (e) {
                    $('#imgHeader').attr('src', e.target.result);
                    $('#imgHeader').removeClass("imgProfile");
                    $('#imgHeader').addClass("picProfile");


                    var image = input.files[0];
					var form = new FormData();
					form.append('_token', $("input[name=_token]").val());
					form.append('image', image);

                	$.ajax({
                		url:  '/ajax-profile-img',
                    	type: 'POST',
                    	data: form,
                    	cache: false,
    					contentType: false,
    					processData: false,
                    	success:function(response){
                      		console.log("Response: " + response);
                      		if(response) {
                        		//alert("Response: " + JSON.stringify(response))
                        		$("#files")[0].value = '';
                      		}
                    	},
                    	error:function(request, error){
        					console.log(error);
        					console.log(request);
        					alert("Error: "+JSON.stringify(error));
        					$("#files")[0].value = '';
    					}
                   	});

                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string

            }
        }

        $("#files").change(function () {
            readURL(this);
        });

        $( document ).ready(function() {
        	var strURL = $('#imgHeader').prop('src');
        	console.log(strURL);

            if (strURL.indexOf("avatars") >= 0){
				$('#imgHeader').removeClass("imgProfile");
                $('#imgHeader').addClass("picProfile");
            }
        });

    </script>

</body>

</html>
