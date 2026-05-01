<div id="fields-form-edit" class="d-none">
    <div class="form-edit-close"></div>
    <div class="form-option-edit form-builder-edit form-builder-shell setup4">
        <a class="closeM cWhite" href="#">
            <i class="fas fa-times"></i>
        </a>

        <div class="form-builder-head cMain">
            <p class="m-0 p-0 title cMain">Constructor del formulario</p>
            <p class="m-0 p-0 subtitle cMain">Anade, reordena y configura cada campo.</p>
        </div>

        <div class="form-builder-general form-builder-section">
            <div class="builder-setting fieldDes">
                <label class="builder-setting-label cMain" for="form-title-text">Titulo</label>
                <input type="text" id="form-title-text" class="text-left builder-general-input cMain" placeholder="Titulo del formulario">
            </div>

            <div class="builder-setting fieldDes">
                <label class="builder-setting-label cMain" for="form-cta-text">Texto del boton</label>
                <input type="text" id="form-cta-text" class="text-left builder-general-input cMain" placeholder="Enviar">
            </div>

            <div class="builder-setting builder-setting-inline activePanel">
                <label class="builder-setting-label cMain" for="form-title-visible">Mostrar titulo</label>
                <label class="switch m-0 p-0">
                    <input type="checkbox" id="form-title-visible" checked>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <div class="form-builder-toolbar form-builder-section" id="form-builder-toolbar">
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="name">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-user"></i></span>
                <span class="form-builder-toolbar-text">Nombre</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="email">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
                <span class="form-builder-toolbar-text">Email</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="phone">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></span>
                <span class="form-builder-toolbar-text">Telefono</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="text">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-font"></i></span>
                <span class="form-builder-toolbar-text">Texto</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="textarea">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-comment-alt"></i></span>
                <span class="form-builder-toolbar-text">Comentario</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="date">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-calendar-alt"></i></span>
                <span class="form-builder-toolbar-text">Fecha</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="postalcode">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-map-marker-alt"></i></span>
                <span class="form-builder-toolbar-text">Codigo postal</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="radio">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="far fa-dot-circle"></i></span>
                <span class="form-builder-toolbar-text">Radio</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="checkbox">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="far fa-check-square"></i></span>
                <span class="form-builder-toolbar-text">Checkbox</span>
            </button>
            <button type="button" class="builder-add-btn form-builder-toolbar-btn bg-05 cMain" data-add-field="terms">
                <span class="form-builder-toolbar-icon" aria-hidden="true"><i class="fas fa-file-signature"></i></span>
                <span class="form-builder-toolbar-text">Terminos</span>
            </button>
        </div>

        <div class="form-builder-body form-builder-section widgets">
            <p id="form-builder-empty" class="builder-empty m-0 d-none">
                No hay campos todavia. Usa los botones de arriba para empezar.
            </p>
            <div id="form-field-list" class="form-builder-list"></div>
        </div>
    </div>
</div>
