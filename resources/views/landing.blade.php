<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <link rel="stylesheet" href="css/StyleLanding.css">
       
        <title>	PlayFunnel - {{$project->name}} </title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        	<meta name="csrf-token" content="{{ csrf_token() }}">        
		
        <?php
        //header('p3p: CP="CAO PSA OUR"');
        //session()->put("tko",csrf_token());
        ?>
        
      
    </head>
	<body>
		<?php
    	 	if($project->aspect=="d-mobile")
    		 	$aspect = "f916aspect";
    		elseif($project->aspect=="d-square")
    			$aspect = "f133aspect";
    		else // d-main
    			$aspect = "f169aspect";
    		
    		// Preview no interations 
    		   if(request()->query('preview') === 'true'){
                session()->put("preview", 1);
               }else{
                session()->put("preview", 0);
               }
      
    		    //echo ("<script>alert(".session('preview').")</script>");
        ?>
		{{ csrf_field() }}

        


        <!-------------------------------------MAIN------------------------------------------>        
        <div class="mainContainer2 <?= $aspect ?>">
        	{!!$project->landing_page!!} 
        </div>

        <img id="powered" src="images/SVG/powered_pF_logo_white.svg" alt="Get In" class="getIn">
        <script>
        // ___ FINAL DEL VIDEO
		const landingListen = function(){  

			//console.log("remove1");
			document.getElementById("imgGetIn_land").remove();
			//console.log("remove2");
            document.querySelector(".edit-landing").remove();
			//console.log("ya remove");
            document.querySelector('h1').removeAttribute('contenteditable');
            document.querySelector('p').removeAttribute('contenteditable');
            document.querySelector('#cta_landing').removeAttribute('contenteditable');

            
            const elements = document.querySelectorAll('.ui-resizable-handle'); 
            elements.forEach(element => { element.remove(); });
		}
        landingListen();
        </script>
	</body>
</html>