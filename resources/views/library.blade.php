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
        <title>	{{__('library.title')}} </title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
    </head>
    
    <body class="bg-white">
    	@include('nav_bar')
    	
    	<x-manage-library :library="$library" :user="$user"/>
		<x-messages/>

        <!--------------------------------MAIN------------------------------->
        <div class="container-fluid m-0 p-0 vh-100">
             <section class="projects row col-12  mx-0 p-0 w-100">
                 <!--Menu Side Left -->
                 <x-side-nav/>

				
                <div class="libreryContainer mainContainer librery col row p-0 m-0">
                  
                </div>
             </section>
        </div>

        <!------------SCRIPTS PAGE-->
        <script type="text/javascript">
    		
          	          

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
        <title>	{{__('library.title')}} </title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
    </head>
    
    <body class="bg-white">
    	@include('nav_bar')
    	
    	<x-manage-library :library="$library" :user="$user"/>
		<x-messages/>

        <!--------------------------------MAIN------------------------------->
        <div class="container-fluid m-0 p-0 vh-100">
             <section class="projects row col-12  mx-0 p-0 w-100">
                 <!--Menu Side Left -->
                 <x-side-nav/>

				
                <div class="libreryContainer mainContainer librery col row p-0 m-0">
                  
                </div>
             </section>
        </div>

        <!------------SCRIPTS PAGE-->
        <script type="text/javascript">
    		
          	          

        </script>
    </body>
</html>
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
