<div id="colors-form-edit" class="d-none">
    <div class="form-edit-close"></div>
    <div class="form-colors-edit">
        <ul>
            <a class="closeM cWhite" href="#">
                <i class="fas fa-times"></i>
            </a>  
            <li class="cta">                    
                <div class="style-card">
                    <p class="p-0 m-0 mr-2">{{__('step4.button')}}:</p>
                    <div class="name d-flex justify-content-betwee align-items-center w-100">         
                        <input class="px-2 col text-left" type="text" id="cta-form" placeholder="Enviar" onfocusout="setOptionName()">
                    </div>
                    <div class="style-list mt-3">
                        <div class="style-color-row bg">
                            <span>Fondo:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpicker-cta-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-cta-form">
                            </div>
                        </div> 
                        <div class="style-color-row text">
                            <span>Texto:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpickerFont-cta-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-cta-form">
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="title">
                <div class="style-card">
                    <p class="p-0 m-0 mr-2">Título:</p>            
                    <div class="style-list mt-3">              
                        <div class="style-color-row">
                            <span>Color Texto:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpickerFont-title-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-title-form">
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="background">
                <div class="style-card">
                    <p class="p-0 m-0 mr-2">Fondo:</p>            
                    <div class="style-list mt-3">              
                        <div class="style-color-row">
                            <span>Color Fondo:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpicker-bg-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-bg-form">
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="field">                     
                <div class="style-card">
                    <p class="p-0 m-0 mr-2">Campo:</p>              
                    <div class="style-list mt-3">
                        <div class="style-color-row bg">
                            <span>Fondo:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpicker-filed-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-filed-form">
                            </div>
                        </div> 
                        <div class="style-color-row texts">
                            <span>Texto:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpickerFont-field-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorFont-field-form">
                            </div>
                        </div>
                        <div class="style-color-row placeholder">
                            <span>Placeholder:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpickerPlaceholder-field-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#93aed0"> 
                                <input class="p-2 hex-colors" type="text"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#93aed0" id="hexcolorPlaceholder-field-form">
                            </div>
                        </div>
                        <div class="style-color-row bor">
                            <span>Borde:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpickerBorder-filed-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolorBorder-filed-form">
                            </div>
                        </div> 
                        <div class="style-color-row label">
                            <span>Etiqueta:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpicker-filedTitle-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55"> 
                                <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#bada55" id="hexcolor-filedTitle-form">
                            </div>
                        </div> 
                    </div>
                </div>
            </li>
            <li class="layout">
                <p class="p-0 m-0 mr-2">Estilo:</p>
                <div class="layout-section">
                    <h6 class="section-title">Campo</h6>
                    <div class="style-list">
                        <label class="style-row">
                            <span>Separacion:</span>
                            <input class="style-number" type="number" id="fieldGap-form" min="0" max="80" step="1" value="16">
                        </label>
                        <label class="style-row">
                            <span>Radio campo:</span>
                            <input class="style-number" type="number" id="fieldRadius-form" min="0" max="60" step="1" value="0">
                        </label>
                        <label class="style-row">
                            <span>Tipo borde:</span>
                            <input type="hidden" id="fieldBorderMode-form" value="bottom">
                            <div class="border-mode-group" role="group" aria-label="Tipo borde">
                                <button type="button" class="border-mode-btn active" data-border-mode="bottom" title="Solo abajo" aria-label="Solo abajo">
                                    <span class="border-mode-icon mode-bottom" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="border-mode-btn" data-border-mode="all" title="Completo" aria-label="Completo">
                                    <span class="border-mode-icon mode-all" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="border-mode-btn" data-border-mode="none" title="Sin borde" aria-label="Sin borde">
                                    <span class="border-mode-icon mode-none" aria-hidden="true"></span>
                                </button>
                            </div>
                        </label>
                        <label class="style-row">
                            <span>Padding Y input:</span>
                            <input class="style-number" type="number" id="fieldPaddingY-form" min="0" max="40" step="1" value="6">
                        </label>
                        <label class="style-row">
                            <span>Padding X input:</span>
                            <input class="style-number" type="number" id="fieldPaddingX-form" min="0" max="60" step="1" value="4">
                        </label>
                    </div>
                </div>

                <div class="layout-section mt-3">
                    <h6 class="section-title">Separador</h6>
                    <div class="style-list">
                        <label class="style-row">
                            <span>Grosor separador:</span>
                            <input class="style-number" type="number" id="dividerWidth-form" min="0" max="8" step="1" value="0">
                        </label>
                    </div>
                    <div class="colores mt-3">
                        <div class="style-color-row divider">
                            <span>Color separador:</span>
                            <div class="color-inputs">
                                <input class="mx-2 colors" type="color" id="colorpickerDivider-form" name="color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#ffffff">
                                <input class="p-2 hex-colors" type="text" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="#ffffff" id="hexcolorDivider-form">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-2">
            </li>
        </ul>
    </div>

</div>

