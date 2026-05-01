<div id="colors-form-edit" class="d-none">
    <div class="form-edit-close"></div>
    <div class="form-colors-edit">
        <ul>
            <a class="closeM cWhite" href="#">
                <i class="fas fa-times"></i>
            </a>  
            <li class="cta">                    
                <p class="p-0 m-0 mr-2">{{__('step4.button')}}:</p>
                <div class="name d-flex  justify-content-betwee align-items-center w-100">         
                    <input class="px-2 col text-left" type="text" id="cta-form" placeholder="Enviar" onfocusout="setOptionName()">
                </div>
                <div class="colores d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center bg">
                        <span>Fondo:</span>
                        <input class="mx-2 colors" type="color" id="colorpicker-cta-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-cta-form">
                    </div> 
                    <div class="d-flex align-items-center text">
                        <span>Texto:</span>
                        <input class="mx-2 colors" type="color" id="colorpickerFont-cta-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-cta-form">
                    </div>
                </div>
                <hr class="my-2">     
            </li>
            <li class="title">
                <a class="closeM cWhite" href="#">
                    <i class="fas fa-times"></i>
                </a>      
                <p class="p-0 m-0 mr-2">Título:</p>            
                <div class="colores d-flex align-items-center justify-content-between">              
                    <div class="d-flex align-items-center">
                        <span>Color Texto:</span>
                        <input class="mx-2 colors" type="color" id="colorpickerFont-title-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-title-form">
                    </div>
                </div>
                <hr class="my-2">     
            </li>
            <li class="background">
                <a class="closeM cWhite" href="#">
                    <i class="fas fa-times"></i>
                </a>      
                <p class="p-0 m-0 mr-2">Fondo:</p>            
                <div class="colores d-flex align-items-center justify-content-between">              
                    <div class="d-flex align-items-center">
                        <span>Color Fondo:</span>
                        <input class="mx-2 colors" type="color" id="colorpicker-bg-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-bg-form">
                    </div>
                </div>
                <hr class="my-2">     
            </li>
            <li class="field">                     
                <p class="p-0 m-0 mr-2">Campo:</p>              
                <div class="colores d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center bg">
                        <span>Fondo:</span>
                        <input class="mx-2 colors" type="color" id="colorpicker-filed-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-filed-form">
                    </div> 
                    <div class="d-flex align-items-center texts">
                        <span>Texto:</span>
                        <input class="mx-2 colors" type="color" id="colorpickerFont-field-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-field-form">
                    </div>
                </div>
                <div class="colores d-flex align-items-center justify-content-between mt-3">
                    <div class="d-flex align-items-center bor">
                        <span>Borde:</span>
                        <input class="mx-2 colors" type="color" id="colorpickerBorder-filed-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorBorder-filed-form">
                    </div> 
                    <div class="d-flex align-items-center label">
                        <span>Etiqueta:</span>
                        <input class="mx-2 colors" type="color" id="colorpicker-filedTitle-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                        <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-filedTitle-form">
                    </div> 
                    <!--
                    <div class="d-flex align-items-center">
                        <span>Estilo:</span>
                        <ul class="d-flex align-items-center">
                            <li><i class="fa fa-times" aria-hidden="true"></i></li>
                            <li><i class="fa fa-underline" aria-hidden="true"></i></li>
                            <li><i class="fa fa-square-o" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                    -->
                </div>
                <hr class="my-2">     
            </li>
        </ul>
    </div>

</div>

