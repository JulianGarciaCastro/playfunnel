  <!---------------------------------------------------Tooltip-->
<div class="toolOptionEdit d-none" draggable="true" id="toolOptionEdit">
	<div class="toolOptionEditClose">
		
	</div>
	<div class="OptionsEdit">
		
			<a class="closeM cWhite" href="#">
				<i class="fas fa-times"></i>
			</a>
		<div class="name d-flex justify-content-betwee align-items-center w-100">
			<p class="p-0 m-0 mr-2">NOMBRE:</p>
			<input class="px-2 col text-left" type="text" id="optionName" placeholder="Nombre de la opción" onfocusout="setOptionName()">
		</div>
		<hr class="my-2">
		<div class="accion p-0 m-0">
			<p class="p-0 m-0">ACCIÓN IR A:</p> 
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
				<a class="nav-link active" id="goto-url" data-toggle="tab" href="#home" role="tab" aria-controls="home"
					aria-selected="true" onclick="copyUrlOption()"> <i class="fas fa-external-link-alt mx-1"></i>URL</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" id="goto-cue" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
					aria-selected="false" onclick="copyCuepointListOption()"><i class="fas fa-route mx-1"></i> Cue</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" id="goto-video" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
					aria-selected="false" onclick="copyVideoListOption()"> <i class="fas fa-film mx-1"></i>Video</a>
				</li>
			</ul>
		<div class="tab-content" id="goto-content">
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				<div class="pt-1 px-0 fieldDes">
					<label for="gotourlOption"  class="w-100 p-0 m-0" >Dirección:</label>
					<input id="gotourlOption" name ="gotourlOption" class="w-100 py-1 px-2 m-0 col-12 text-left" placeholder="Direccion..." type="text" onfocusout="selectOptionBrowseURL()">
				</div>
				<div class="pt-1 px-0 fieldDes">
					<label for="urlOption"  class="w-100 p-0 m-0" >Abrir en</label>
					<ul class="openRadio p-0 m-0" id="urlOption">
					<li class="form-check form-check-inline py-1 px-4 m-0">
						<input class="form-check-input" type="radio" name="goto_opt_opt" id="inlineRadioOpt1" value="_blank" checked="checked" onclick="selectOptionBrowseURL()">
						<label class="form-check-label" for="inlineRadio1">_Blank</label>
					</li>
					<li class="form-check form-check-inline py-1 px-4 m-0">
						<input class="form-check-input" type="radio" name="goto_opt_opt" id="inlineRadioOpt2" value="_self" onclick="selectOptionBrowseURL()">
						<label class="form-check-label" for="inlineRadio2">_Self</label>
					</li>
					</ul> 
				</div>
			</div>
			<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
				<p class="p-0 m-0 pt-2">Lista de Cuepoints</p>                        
				<div class="row d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 py-1">
				<div class="col-12 d-flex justify-content-between align-items-center text-center px-2" id="dropdownMenu33" data-toggle="dropdown" >
					<p class="m-0 c02"   id="dropdownId-Nav11">--</p>
					<p class="m-0 cMain" id="dropdownName-Nav11">Seleccione Cuepoint</p>
					<p class="m-0 c02"   id="dropdownTime-Nav11">00:00:00</p>
					<i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>  
				</div>
				<div  id="cuepointList-Nav22" name="cuepointList-Nav22" class="dropdown-menu col-12 " aria-labelledby="dropdownMenu33">
				</div>                          
				</div> 
			</div>
			<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
				<p class="p-0 m-0 pt-2">Lista de Video</p>                        
			<div class="row d-flex p-0 bg-05 align-items-center px-0 justify-content-between m-0 py-1">
				<div class="col-12 d-flex justify-content-between align-items-center text-center px-2" id="dropdownMenu44" data-toggle="dropdown" >
				<p class="m-0 c02"   id="dropdownId-Nav33">--</p>
				<p class="m-0 cMain" id="dropdownName-Nav33">Seleccione Video</p>
				<i class="h4 cMain fas fa-caret-square-down ml-2 d-flex align-items-center my-0"></i>                        
				</div>
				<div  id="cuepointList-Nav33" name="cuepointList-Nav33" class="dropdown-menu col-12 " aria-labelledby="dropdownMenu44">
				</div>
			</div> 
			</div>
		</div>
		<!--END ACCION--> 
		<hr class="my-2">         
		</div>
		<div class="d-flex color align-items-center justify-content-between mr-3">
			<div class="d-flex align-items-center justify-content-between">
			<p class="m-0 p-0">FONDO</p>
			<input class="mx-2" type="color" id="colorpickerBG" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
			<input class="" type="text" class="p-2" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorBG">
			</div>
		</div>
		<hr class="my-2">   
			<div class="activePanel d-flex p-0 m-0 align-items-center justify-content-between">
			
			<p class="m-0 p-0 mr-3">IMAGEN</p>
			<label class="switch m-0 p-0">
			<input type="checkbox" checked>
			<span class="slider round"></span>
			</label>
			</div>   
			<hr class="my-2">
			<div class="aline d-flex aling m-0 p-0 justify-content-between">
			<p class="m-0 p-0">ALINEACION</p>
			<ul class="d-flex justify-content-between m-0 p-0">
				<li  class="mx-2"data-id="aStart"> <img class="" src="images/SVG/aStart.svg"></li>
				<li  class="mx-2 active" data-id="aCenter"> <img class="" src="images/SVG/aCenter.svg"></li>
				<li  class="mx-2 "data-id="aEnd"> <img class="" src="images/SVG/aEnd.svg"></li>
			</ul>
			</div> 
			<hr class="my-2">
			<div class="d-flex sizes m-0 p-0  justify-content-between">
			<p class="m-0 p-0">TAMAÑO</p>
			<ul class="d-flex justify-content-between m-0 p-0">
			<li class="" data-id="s-25" >25%</li>
			<li class="mx-2 active" data-id="s-50">50%</li>
			<li class="m" data-id="s-75">75%</li>
			<li class="" data-id="s-100">100%</li>
			</ul>
		</div> 
		<hr class="my-2">
		<div class="d-flex color align-items-center justify-content-between">
			<div class="d-flex align-items-center justify-content-between">
			<p class="m-0 p-0">BORDER</p>
			<input class="mx-2" type="color" id="colorpicker" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
			<input class="" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor">
			</div>
			<div class="d-flex align-items-center justify-content-between">
			<img class="ml-3" src="images/SVG/border.svg">
			<input class="ml-2" id="borderNumber" type="number" value="0">
			</div>
		</div> 
		<hr class="my-2">
		<div class="d-flex color align-items-center justify-content-between">
			<div class="d-flex align-items-center justify-content-between">
			<p class="m-0 p-0">TEXTO</p>
			<input class="mx-2" type="color" id="colorpickerFont" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
			<input class="" type="text" class="p-2" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont">
			</div>
			
		</div>
	</div>
</div>
  
  <script>
		function copyCuepointListOption(){
      		console.log("Ejecutando copyCuepointListOption() " + $("#libraryId").val() );

      		$("#dropdownMenuAccion > p").html("Ir a Cuepoint");
      	
      		var cuepointid = $("#cuepointId").val();
      		$('#cuepointList-Nav22').empty();
      		$('#cuepointList > button').clone().appendTo('#cuepointList-Nav22');
    
      		$( "#cuepointList-Nav22 > button" ).each(function( index ) {
        	      $(this).attr("onclick","selectBrowseCuepointOption(this)");	
    	
        	      if( $(this).attr("cuepoint-id") == cuepointid ){
        	          $(this).remove( );
        	      }
      		});             	
      	}
    
      
		function selectBrowseCuepointOption(button){
    		$("#dropdownMenu33").attr("cuepoint-id", $(button).attr("cuepoint-id"));
        	$("#dropdownName-Nav11").html($(button).children('p').eq(0).html());
        	$("#dropdownTime-Nav11").html($(button).children('p').eq(1).html());
    
        	$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				arrOpciones = item.type_option.type_option_data;
					var updated = false;
					
    				$.each(arrOpciones, function(j, data) {
						if(data.uuid == $("#optionUuid").val()){
							data.type 	 = "CUEPOINT";
							data.goto 	 = $(button).attr("cuepoint-id");
							data.options = null;
							data.content = $('li[uuid=' + data.uuid + ']').prop('outerHTML');
							updated = true;
						}
        			});

        			if(!updated){
        				var data = {
        		    			uuid : $("#optionUuid").val(),
								type : "CUEPOINT",
        		              	name : null,
        		              	goto : $(button).attr("cuepoint-id"),
        		              	options : null,
        		              	content : $('li[uuid=' + $("#optionUuid").val() + ']').prop('outerHTML'),
        				};

        				arrOpciones.push(data);				
                	}
    				
    				
    				item.action = 'UPDATE'
    				console.log("Actualizando Opcion Cuepoint : "  +item.id+ " con cuepoint: " + $(button).attr("cuepoint-id"));
    				console.log("Actualizando Opcion Cuepoint : %o",  item);
    			}
          });	
    	}
    
    
    	function copyVideoListOption(){
    		console.log("Ejecutando copyVideoList() " + $("#projectVideo").attr("lib-id"));
    		$("#dropdownMenuAccion > p").html("Ir a Video");
    		
      		var projectlibid = $("#projectVideo").attr("lib-id");
      	 
      		$('#cuepointList-Nav33').empty();
      	
      		$( "#mediaList > li" ).each(function( index ) {
      			var currentId = $(this).attr("media-id");
      			var currentlib= $(this).attr("proyectlib-id");
      			console.log("Ejecutando copyVideoList() mirando " + currentlib);
    			if(  projectlibid != currentlib){
    				console.log("Ejecutando copyVideoList() copiando: " + currentlib);
    				var btnAux = '<button onclick="selectBrowseVideoOption(this)" projectlib-id="'+currentlib+'" media-id="' + currentId + '" media-name="' + $(this).attr("media-name") + '" class="item row justify-content-between align-items-center text-center px-3 py-2 col-12 m-0" type="button">' 
                  				+'<p class="m-0 cMain"> '+ $(this).attr("media-name") +'</p>'
                  			+'</button>';
                  $("#cuepointList-Nav33").append(btnAux);
    			}
      		});    	
      	}

    
    	function selectBrowseVideoOption(button){
    		$("#dropdownMenu44").attr("projectlib-id", $(button).attr("projectlib-id"));
        	$("#dropdownName-Nav33").html( $(button).attr("media-name") );
    
        	$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				arrOpciones = item.type_option.type_option_data;
					var updated = false;
					
    				$.each(arrOpciones, function(j, data) {
						if(data.uuid == $("#optionUuid").val()){
							data.type 	 = "VIDEO";
							data.goto 	 = $(button).attr("projectlib-id");
							data.options = null;
							data.content = $('li[uuid=' + data.uuid + ']').prop('outerHTML');
							updated = true;
						}
        			});

        			if(!updated){
        				var data = {
        		    			uuid : $("#optionUuid").val(),
								type : "VIDEO",
        		              	name : null,
        		              	goto : $(button).attr("projectlib-id"),
								options : null,
								content : $('li[uuid=' + $("#optionUuid").val() + ']').prop('outerHTML'),
        				};

        				arrOpciones.push(data);				
                	}
    				
    				item.action = 'UPDATE' 
    				console.log("Actualizando Opcion Video : "  +item.id+ " con Video: " + $(button).attr("projectlib-id"));
    				console.log("Actualizando Opcion Video : %o",  item);
    			}
          });	
    	}



    	function selectOptionBrowseURL(){
    		var newURL  = $('#gotourlOption').val();
    		var newOpt  = $('input:radio[name=goto_opt_opt]:checked').val();

    		if(newURL){
    			var expression = /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/gi;
    			var regex = new RegExp(expression);
    			newURL = newURL.trim(); 
    			newURL = newURL.match(regex) ? newURL : 'http://' + newURL;
    			$('#gotourlOption').val(newURL);
    		}
    		
        	$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				arrOpciones = item.type_option.type_option_data;
					var updated = false;

    				$.each(arrOpciones, function(j, data) {
						if(data.uuid == $("#optionUuid").val()){
							data.goto 	 = newURL;
							data.options = newOpt;
							data.content = $('li[uuid=' + data.uuid + ']').prop('outerHTML');
							updated 	 = true;
						}
        			});

        			if(!updated){
        				var data = {
        		    			uuid : $("#optionUuid").val(),
								type : "URL",
        		              	name : null,
        		              	goto : newURL,
        		              	options : newOpt,
        		              	content : $('li[uuid=' + $("#optionUuid").val() + ']').prop('outerHTML'),
        				};

        				arrOpciones.push(data);				
                	}
    				
    				item.action = 'UPDATE' 
    				console.log("Actualizando Option de Cuepoint : "  +item.id+ " con URL: " + newURL);
    				console.log("Actualizando Opcion de Cuepoint : %o",  item);
    			}
          	});	
		}


    	function setOptionName(){
    		var newName = $('#optionName').val();
    		
        	$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				arrOpciones = item.type_option.type_option_data;
					var updated = false;

    				$.each(arrOpciones, function(j, data) {
						if(data.uuid == $("#optionUuid").val()){
							data.name 	 = newName;
							data.content = $('li[uuid=' + data.uuid + ']').prop('outerHTML');
							updated 	 = true;
						}
        			});

        			if(!updated){
        				var data = {
        		    			uuid : $("#optionUuid").val(),
        		    			type : "URL",
        		              	name : newName,
        		              	goto : null,
								options : null,
        		              	content : $('li[uuid=' + $("#optionUuid").val() + ']').prop('outerHTML'),
        				};

        				arrOpciones.push(data);				
                	}
    				
    				item.action = 'UPDATE' 
    				console.log("Actualizando Opcion de Cuepoint : "  +item.id+ " con Name: " + newName);
    				console.log("Actualizando Opcion de Cuepoint : %o",  item);
    				return false;
    			}
          	});	
		}



    	function setURLOption(){
    		$.each(cuePoints, function(i, item) {
    			if(item.id == $("#cuepointId").val()){
    				arrOpciones = item.type_option.type_option_data;
					var updated = false;

    				$.each(arrOpciones, function(j, data) {
						if(data.uuid == $("#optionUuid").val()){
							data.type 	 = "URL";
							data.content = $('li[uuid=' + data.uuid + ']').prop('outerHTML');
							updated 	 = true;
						}
        			});

        			if(!updated){
        				var data = {
        		    			uuid : $("#optionUuid").val(),
        		              	type : "URL",
        		              	name : null,
        		              	goto : newURL,
        		              	options : newOpt,
        		              	content : $('li[uuid=' + $("#optionUuid").val() + ']').prop('outerHTML'),
        				};

        				arrOpciones.push(data);				
                	}
    				
    				item.action = 'UPDATE' 
    				console.log("Actualizando Option de Cuepoint : "  +item.id+ " con URL: " + newURL);
    				console.log("Actualizando Opcion de Cuepoint : %o",  item);
    			}
          	});
        }



    	function setOptionValues(){

    		//copyCuepointListOption();
    		//copyVideoListOption()
			
			$.each(cuePoints, function(i, item) {
				if(item.id == $("#cuepointId").val()){
					arrOpciones = item.type_option.type_option_data;
					var found = false;
    				$.each(arrOpciones, function(j, data) {
						if(data.uuid == $("#optionUuid").val()){
							found = true;	
							$("#optionName").val(data.name);

							if(data.type == "URL"){
								$("#goto-url").click();
								$("#gotourlOption").val(data.goto);

								if(data.options == '_blank')
	          						$('#inlineRadioOpt1').prop('checked', true);
								else
	          						$('#inlineRadioOpt2').prop('checked', true);
							}
							else if(data.type == "CUEPOINT"){
								$("#goto-cue").click();
								
								$("#cuepointList-Nav22 > button" ).each(function( index ) {	
					                if( $(this).attr("cuepoint-id") == data.goto){
					                    console.log( "ENCONTRADO CUEPOINT: " + data.goto);

					                    $(this).removeAttr("onclick");
					                    $(this).click();
					                    $("#dropdownMenu33").attr("cuepoint-id", $(this).attr("cuepoint-id"));
					                  	$("#dropdownName-Nav11").html($(this).children('p').eq(0).html());
					                  	$("#dropdownTime-Nav11").html($(this).children('p').eq(1).html());
					                    $(this).attr("onclick", 'selectBrowseCuepointOption(this)');
					                    
					                }
					        	});
							}
							else if(data.type == "VIDEO"){								
								$("#goto-video").click();
								
					        	$("#cuepointList-Nav33 > button" ).each(function( index ) {
					                if( $(this).attr("projectlib-id") == data.goto){
					                    console.log( "ENCONTRADO VIDEO: " + data.goto);
					                    
										$(this).removeAttr("onclick");
					                    $(this).click();
					                    $("#dropdownMenu44").attr("projectlib-id", $(this).attr("projectlib-id"));
					                  	$("#dropdownName-Nav33").html( $(this).attr("media-name") );
					                    $(this).attr("onclick", 'selectBrowseVideoOption(this)');
					                }
					        	});            								 
							}
						}
        			});

    				if(!found){
        				console.log("No se encontro!!!");
        				$("#optionName").val("");
        				$("#dropdownMenuAccion > p").html("Seleccione una Acción");

    					//Url
    					$("#gotourlOption").val("");
    					$('#inlineRadioOpt1').prop('checked', true);

						//Cuepoint
						$("#dropdownMenu33").attr("cuepoint-id", "Seleccione Cuepoint");
	                  	$("#dropdownName-Nav11").html("Seleccione Cuepoint");
	                  	$("#dropdownTime-Nav11").html("00:00:00");
    					
    					//Video
    					$("#dropdownMenu44").attr("projectlib-id", "");
	                  	$("#dropdownName-Nav33").html( "Seleccione Video" );

	                  	$("#pills-contact-tab").click();
    					
        			}
				}
			});
		}


		function copyUrlOption(){
			$("#dropdownMenuAccion > p").html("Ir a Url");
		}
		
  </script>
  