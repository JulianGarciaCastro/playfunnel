(function(window, $) {
    'use strict';

    let formFieldCounter = 0;

    const FORM_FIELD_LABELS = {
        text: 'Texto',
        email: 'Email',
        tel: 'Telefono',
        textarea: 'Comentario',
        date: 'Fecha',
        postalcode: 'Codigo postal',
        radio: 'Radio',
        checkbox: 'Checkbox'
    };

    const BASE_FORM_CRM_LABELS = {
        '': 'Sin CRM',
        name: 'Nombre',
        email: 'Email',
        tel: 'Telefono',
        birthday: 'Cumpleanos',
        postalcode: 'Codigo postal',
        comments: 'Comentario'
    };

    const FORM_FIELD_TEMPLATES = {
        name: { type: 'text', label: 'First name', description: '', placeholder: 'Jhon Doe', required: true, crmKey: 'name', options: [] },
        email: { type: 'email', label: 'Email', description: '', placeholder: 'Doe@email.com', required: true, crmKey: 'email', options: [] },
        phone: { type: 'tel', label: 'Telephone', description: '', placeholder: '123-45-678', required: false, crmKey: 'tel', options: [] },
        text: { type: 'text', label: 'Question', description: '', placeholder: 'Write your answer', required: false, crmKey: '', options: [] },
        textarea: { type: 'textarea', label: 'Comment', description: '', placeholder: 'Write your answer', required: false, crmKey: 'comments', options: [] },
        date: { type: 'date', label: 'Date', description: '', placeholder: '', required: false, crmKey: 'birthday', options: [] },
        postalcode: { type: 'postalcode', label: 'Postal Code', description: '', placeholder: '28040', required: false, crmKey: 'postalcode', options: [] },
        radio: { type: 'radio', label: 'Choose one option', description: '', placeholder: '', required: false, crmKey: '', options: ['Option 1', 'Option 2'] },
        checkbox: { type: 'checkbox', label: 'Choose one or more options', description: '', placeholder: '', required: false, crmKey: '', options: ['Option 1', 'Option 2'] },
        terms: { type: 'checkbox', label: 'Accept Terms and Conditions', description: '', placeholder: '', required: true, crmKey: '', options: ['Accept terms and conditions'], isTerms: true }
    };

    const FORM_FIELD_ICON_OPTIONS = [
        { value: '', label: 'Sin icono', preview: 'fa fa-ban' },
        { value: 'fa fa-user', label: 'Usuario' },
        { value: 'fa fa-envelope', label: 'Email' },
        { value: 'fa fa-phone', label: 'Telefono' },
        { value: 'fa fa-font', label: 'Texto' },
        { value: 'fa fa-commenting', label: 'Comentario' },
        { value: 'fa fa-calendar', label: 'Fecha' },
        { value: 'fa fa-birthday-cake', label: 'Cumpleanos' },
        { value: 'fa fa-map-marker', label: 'Ubicacion' },
        { value: 'fa fa-building', label: 'Empresa' },
        { value: 'fa fa-briefcase', label: 'Trabajo' },
        { value: 'fa fa-globe', label: 'Web' },
        { value: 'fa fa-tag', label: 'Etiqueta' },
        { value: 'fa fa-link', label: 'Enlace' },
        { value: 'fa fa-dot-circle', label: 'Radio' },
        { value: 'fa fa-check-square', label: 'Check' }
    ];

    function cloneValue(value) {
        return JSON.parse(JSON.stringify(value));
    }

    function getCrmCustomFields() {
        if (!Array.isArray(window.crmCustomFields)) {
            return [];
        }

        return window.crmCustomFields.filter(function(field) {
            return field && field.id && field.name;
        }).map(function(field) {
            return {
                id: Number(field.id),
                name: String(field.name),
                slug: String(field.slug || ''),
                type: String(field.type || 'text')
            };
        });
    }

    function getCrmLabelMap() {
        const labelMap = Object.assign({}, BASE_FORM_CRM_LABELS);

        getCrmCustomFields().forEach(function(field) {
            labelMap['custom:' + field.id] = 'Personalizado: ' + field.name;
        });

        return labelMap;
    }

    function buildCrmOptionsHtml(selectedKey) {
        const currentKey = selectedKey || '';
        const labelMap = getCrmLabelMap();
        const baseOptions = Object.keys(BASE_FORM_CRM_LABELS).map(function(key) {
            return `<option value="${escapeHtml(key)}" ${currentKey === key ? 'selected' : ''}>${escapeHtml(BASE_FORM_CRM_LABELS[key])}</option>`;
        });
        const customFields = getCrmCustomFields();
        const customOptions = customFields.map(function(field) {
            const value = 'custom:' + field.id;
            const label = field.slug ? `${field.name} (${field.slug})` : field.name;
            return `<option value="${escapeHtml(value)}" ${currentKey === value ? 'selected' : ''}>${escapeHtml(label)}</option>`;
        });

        if (currentKey && !(currentKey in labelMap)) {
            customOptions.unshift(`<option value="${escapeHtml(currentKey)}" selected>Campo CRM no disponible</option>`);
        }

        if (!customOptions.length) {
            return baseOptions.join('');
        }

        return [
            `<optgroup label="Campos base">${baseOptions.join('')}</optgroup>`,
            `<optgroup label="Campos personalizados">${customOptions.join('')}</optgroup>`
        ].join('');
    }

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function nextFieldId() {
        formFieldCounter += 1;
        return 'field_' + Date.now() + '_' + formFieldCounter;
    }

    function createField(templateKey) {
        const field = cloneValue(FORM_FIELD_TEMPLATES[templateKey] || FORM_FIELD_TEMPLATES.text);
        field.id = nextFieldId();
        return field;
    }

    function getDefaultAppearance() {
        return {
            ctaBg: '#F2F2F2',
            ctaColor: '#000000',
            titleColor: '#00026a',
            background: '#B6C8DD',
            formPadding: 0,
            fieldBg: '#B6C8DD',
            fieldText: '#00026a',
            placeholderColor: '#93AED0',
            fieldBorder: '#FFFFFF',
            fieldBorderMode: 'bottom',
            labelColor: '#00026a',
            fieldGap: 16,
            dividerColor: '#FFFFFF',
            dividerWidth: 0,
            fieldRadius: 0,
            fieldPaddingY: 6,
            fieldPaddingX: 4
        };
    }

    function normalizeAppearanceNumber(value, fallback, minimum, maximum) {
        const parsed = Number(value);
        if (!Number.isFinite(parsed)) {
            return fallback;
        }

        const min = Number.isFinite(minimum) ? minimum : parsed;
        const max = Number.isFinite(maximum) ? maximum : parsed;
        return Math.min(max, Math.max(min, parsed));
    }

    function normalizeFieldBorderMode(value) {
        return ['all', 'bottom', 'none'].includes(value) ? value : 'bottom';
    }

    function normalizeAppearance(appearance) {
        const defaults = getDefaultAppearance();
        const normalized = Object.assign({}, defaults, appearance || {});

        normalized.formPadding = 0;
        normalized.fieldGap = normalizeAppearanceNumber(normalized.fieldGap, defaults.fieldGap, 0, 80);
        normalized.dividerWidth = normalizeAppearanceNumber(normalized.dividerWidth, defaults.dividerWidth, 0, 8);
        normalized.fieldRadius = normalizeAppearanceNumber(normalized.fieldRadius, defaults.fieldRadius, 0, 60);
        normalized.fieldPaddingY = normalizeAppearanceNumber(normalized.fieldPaddingY, defaults.fieldPaddingY, 0, 40);
        normalized.fieldPaddingX = normalizeAppearanceNumber(normalized.fieldPaddingX, defaults.fieldPaddingX, 0, 60);
        normalized.fieldBorderMode = normalizeFieldBorderMode(normalized.fieldBorderMode);

        return normalized;
    }

    function readStyleNumber(value, fallback) {
        const parsed = parseFloat(String(value || '').replace(',', '.'));
        return Number.isFinite(parsed) ? parsed : fallback;
    }

    function detectInlineFieldBorderMode(input, fallback) {
        if (!input || !input.style) {
            return fallback;
        }

        const topWidth = readStyleNumber(input.style.borderTopWidth || input.style.borderWidth, 0);
        const rightWidth = readStyleNumber(input.style.borderRightWidth || input.style.borderWidth, 0);
        const bottomWidth = readStyleNumber(input.style.borderBottomWidth || input.style.borderWidth, 0);
        const leftWidth = readStyleNumber(input.style.borderLeftWidth || input.style.borderWidth, 0);

        if (topWidth > 0 || rightWidth > 0 || leftWidth > 0) {
            return 'all';
        }

        if (bottomWidth > 0) {
            return 'bottom';
        }

        return normalizeFieldBorderMode(fallback);
    }

    function detectComputedFieldBorderMode(input, fallback) {
        if (!input) {
            return fallback;
        }

        const styles = window.getComputedStyle(input);
        const topWidth = readStyleNumber(styles.borderTopWidth, 0);
        const rightWidth = readStyleNumber(styles.borderRightWidth, 0);
        const bottomWidth = readStyleNumber(styles.borderBottomWidth, 0);
        const leftWidth = readStyleNumber(styles.borderLeftWidth, 0);

        if (topWidth > 0 || rightWidth > 0 || leftWidth > 0) {
            return 'all';
        }

        if (bottomWidth > 0) {
            return 'bottom';
        }

        return normalizeFieldBorderMode(fallback);
    }

    function readStoredAppearance(form) {
        if (!form) {
            return null;
        }

        const rawAppearance = form.getAttribute('data-form-appearance');
        if (!rawAppearance) {
            return null;
        }

        try {
            return JSON.parse(rawAppearance);
        } catch (error) {
            return null;
        }
    }

    function normalizeField(field, index) {
        const normalized = cloneValue(field || {});
        normalized.id = normalized.id || nextFieldId();
        normalized.type = normalized.type === 'phone' ? 'tel' : (normalized.type || 'text');
        normalized.label = (normalized.label || FORM_FIELD_LABELS[normalized.type] || ('Campo ' + (index + 1))).trim();
        normalized.description = String(normalized.description || '').trim();
        normalized.placeholder = normalized.placeholder || '';
        normalized.required = normalized.required === true || normalized.required === 'true';
        normalized.crmKey = normalized.crmKey || '';
        normalized.isTerms = normalized.isTerms === true || normalized.isTerms === 'true';
        normalized.options = Array.isArray(normalized.options) ? normalized.options : [];
        const hasCustomIcon = Object.prototype.hasOwnProperty.call(normalized, 'iconClass');

        if (normalized.type === 'radio' || normalized.type === 'checkbox') {
            normalized.options = normalized.options.map(option => String(option).trim()).filter(Boolean);
            if (!normalized.options.length) {
                normalized.options = normalized.isTerms ? ['Accept terms and conditions'] : ['Option 1', 'Option 2'];
            }
        } else {
            normalized.options = [];
        }

        normalized.iconClass = hasCustomIcon
            ? normalizeFieldIconClass(normalized.iconClass, getDefaultFieldIconClass(normalized))
            : getDefaultFieldIconClass(normalized);

        return normalized;
    }

    function normalizeState(state) {
        const normalized = cloneValue(state || {});
        normalized.titleEnabled = normalized.titleEnabled !== false;
        normalized.titleText = (normalized.titleText || 'Title').trim();
        normalized.ctaText = (normalized.ctaText || 'My Button Example').trim();
        normalized.crmEnabled = normalized.crmEnabled === true || normalized.crmEnabled === 'true';
        normalized.appearance = normalizeAppearance(normalized.appearance);
        normalized.fields = Array.isArray(normalized.fields) ? normalized.fields.map(normalizeField) : [];

        if (normalized.crmEnabled) {
            let emailField = normalized.fields.find(field => field.crmKey === 'email' || field.type === 'email');
            if (!emailField) {
                emailField = createField('email');
                normalized.fields.unshift(emailField);
            }
            emailField.crmKey = 'email';
            emailField.required = true;
        }

        return normalized;
    }

    function getDefaultState() {
        return normalizeState({
            titleEnabled: true,
            titleText: 'Title',
            ctaText: 'My Button Example',
            crmEnabled: false,
            appearance: getDefaultAppearance(),
            fields: [createField('name'), createField('email'), createField('terms')]
        });
    }

    function getSelectedCuePointItem() {
        const cuepointId = $('#cuepointId').val();
        return (window.cuePoints || []).find(item => String(item.id) === String(cuepointId)) || null;
    }

    function getLegacyFieldLabel(wrapper) {
        const labelNode = wrapper ? wrapper.querySelector('label b') : null;
        if (labelNode) {
            return labelNode.textContent.replace(/:\s*$/, '').trim();
        }
        const label = wrapper ? wrapper.querySelector('label') : null;
        return label ? label.textContent.replace(/:\s*$/, '').trim() : '';
    }

    function getFieldDescriptionText(wrapper) {
        const descriptionNode = wrapper ? wrapper.querySelector('.field-description') : null;
        return descriptionNode ? descriptionNode.textContent.trim() : '';
    }

    function normalizeFieldIconClass(value, fallback) {
        if (value === '') {
            return '';
        }

        const normalizedValue = typeof value === 'string' ? value.trim().replace(/\s+/g, ' ') : '';
        if (!normalizedValue) {
            return fallback || '';
        }

        return FORM_FIELD_ICON_OPTIONS.some(function(option) {
            return option.value === normalizedValue;
        }) ? normalizedValue : (fallback || '');
    }

    function getDefaultFieldIconClass(field) {
        if (field && field.isTerms) {
            return 'fa fa-check-square';
        }

        return {
            text: 'fa fa-font',
            email: 'fa fa-envelope',
            tel: 'fa fa-phone',
            textarea: 'fa fa-commenting',
            date: 'fa fa-calendar',
            postalcode: 'fa fa-map-marker',
            radio: 'fa fa-dot-circle',
            checkbox: 'fa fa-check-square'
        }[(field && field.type) || 'text'] || 'fa fa-font';
    }

    function getLegacyFieldIconClass(wrapper) {
        const iconNode = wrapper ? wrapper.querySelector('label i') : null;
        if (!iconNode) {
            return '';
        }

        const iconClass = Array.from(iconNode.classList).filter(function(className) {
            return !['m-0', 'p-0', 'mr-2', 'mr-1', 'mt-1', 'mt-0'].includes(className);
        }).join(' ').trim();

        return normalizeFieldIconClass(iconClass, '');
    }

    function parseLegacyFields(form) {
        const legacyMap = [
            { selector: '#form-name', type: 'text', crmKey: 'name' },
            { selector: '#form-email', type: 'email', crmKey: 'email' },
            { selector: '#form-tel', type: 'tel', crmKey: 'tel' },
            { selector: '#form-text', type: 'text', crmKey: '' },
            { selector: '#form-textArea', type: 'textarea', crmKey: 'comments' },
            { selector: '#form-birthday', type: 'date', crmKey: 'birthday' },
            { selector: '#form-cp', type: 'postalcode', crmKey: 'postalcode' },
            { selector: '#form-terms', type: 'checkbox', crmKey: '', isTerms: true }
        ];

        const fields = legacyMap.map(function(config, index) {
            const wrapper = form.querySelector(config.selector);
            if (!wrapper || wrapper.classList.contains('d-none')) {
                return null;
            }

            const input = wrapper.querySelector('input, textarea');
            return normalizeField({
                id: wrapper.id || ('legacy_' + index),
                type: config.type,
                label: getLegacyFieldLabel(wrapper) || FORM_FIELD_LABELS[config.type] || ('Campo ' + (index + 1)),
                description: getFieldDescriptionText(wrapper),
                placeholder: input ? (input.getAttribute('placeholder') || '') : '',
                required: input ? input.required : false,
                crmKey: config.crmKey,
                isTerms: config.isTerms === true,
                options: config.type === 'checkbox' ? [getLegacyFieldLabel(wrapper)] : [],
                iconClass: getLegacyFieldIconClass(wrapper)
            }, index);
        }).filter(Boolean);

        return fields.length ? fields : getDefaultState().fields;
    }

    function parseState(content) {
        const container = document.createElement('div');
        container.innerHTML = content || '';
        const form = container.querySelector('#AF');
        if (!form) {
            return getDefaultState();
        }

        const titleNode = form.querySelector('#form-title');
        const ctaNode = form.querySelector('#form-cta');
        const referenceField = form.querySelector('.form-field') || form.querySelector('.itemForm:not(#form-title)');
        const referenceInput = form.querySelector('input[type=text], input[type=email], input[type=tel], input[type=date], textarea');
        const referenceLabel = form.querySelector('.form-field label, .itemForm label');
        const storedAppearance = readStoredAppearance(form) || {};
        const modernFields = Array.from(form.querySelectorAll('.form-field[data-field-id]'));
        const fields = modernFields.length ? modernFields.map(function(wrapper, index) {
            let options = [];
            const optionsValue = wrapper.getAttribute('data-field-options');

            if (optionsValue) {
                try {
                    options = JSON.parse(optionsValue);
                } catch (error) {
                    options = [];
                }
            }

            const input = wrapper.querySelector('input, textarea');
            return normalizeField({
                id: wrapper.getAttribute('data-field-id') || nextFieldId(),
                type: wrapper.getAttribute('data-field-type') || 'text',
                label: wrapper.getAttribute('data-field-label') || getLegacyFieldLabel(wrapper),
                description: wrapper.getAttribute('data-field-description') || getFieldDescriptionText(wrapper),
                placeholder: wrapper.getAttribute('data-placeholder') || (input ? (input.getAttribute('placeholder') || '') : ''),
                required: wrapper.getAttribute('data-required') === 'true',
                crmKey: wrapper.getAttribute('data-crm-key') || '',
                isTerms: wrapper.getAttribute('data-is-terms') === 'true',
                options: options,
                iconClass: wrapper.hasAttribute('data-icon-class') ? wrapper.getAttribute('data-icon-class') : undefined
            }, index);
        }) : parseLegacyFields(form);

        return normalizeState({
            titleEnabled: !titleNode || !titleNode.classList.contains('d-none'),
            titleText: titleNode && titleNode.querySelector('h3') ? titleNode.querySelector('h3').textContent.trim() : 'Title',
            ctaText: ctaNode ? ctaNode.textContent.trim() : 'My Button Example',
            crmEnabled: form.getAttribute('crm') === 'true',
            appearance: Object.assign({}, storedAppearance, {
                ctaBg: ctaNode && ctaNode.style ? (ctaNode.style.backgroundColor || getDefaultAppearance().ctaBg) : getDefaultAppearance().ctaBg,
                ctaColor: ctaNode && ctaNode.style ? (ctaNode.style.color || getDefaultAppearance().ctaColor) : getDefaultAppearance().ctaColor,
                titleColor: titleNode && titleNode.querySelector('h3') && titleNode.querySelector('h3').style ? (titleNode.querySelector('h3').style.color || getDefaultAppearance().titleColor) : getDefaultAppearance().titleColor,
                background: form.style ? (form.style.backgroundColor || getDefaultAppearance().background) : getDefaultAppearance().background,
                formPadding: form.style ? readStyleNumber(form.style.paddingTop, (storedAppearance.formPadding || getDefaultAppearance().formPadding)) : getDefaultAppearance().formPadding,
                fieldBg: referenceInput && referenceInput.style ? (referenceInput.style.backgroundColor || getDefaultAppearance().fieldBg) : getDefaultAppearance().fieldBg,
                fieldText: referenceInput && referenceInput.style ? (referenceInput.style.color || getDefaultAppearance().fieldText) : getDefaultAppearance().fieldText,
                placeholderColor: referenceInput && referenceInput.style ? (referenceInput.style.getPropertyValue('--field-placeholder-color') || storedAppearance.placeholderColor || getDefaultAppearance().placeholderColor) : getDefaultAppearance().placeholderColor,
                fieldBorder: referenceInput && referenceInput.style ? (referenceInput.style.borderColor || getDefaultAppearance().fieldBorder) : getDefaultAppearance().fieldBorder,
                fieldBorderMode: detectInlineFieldBorderMode(referenceInput, storedAppearance.fieldBorderMode || getDefaultAppearance().fieldBorderMode),
                labelColor: referenceLabel && referenceLabel.style ? (referenceLabel.style.color || getDefaultAppearance().labelColor) : getDefaultAppearance().labelColor,
                fieldGap: referenceField && referenceField.style ? readStyleNumber(referenceField.style.marginTop, (storedAppearance.fieldGap || getDefaultAppearance().fieldGap)) : getDefaultAppearance().fieldGap,
                dividerColor: referenceField && referenceField.style ? (referenceField.style.borderBottomColor || (storedAppearance.dividerColor || getDefaultAppearance().dividerColor)) : getDefaultAppearance().dividerColor,
                dividerWidth: referenceField && referenceField.style ? readStyleNumber(referenceField.style.borderBottomWidth, (storedAppearance.dividerWidth || getDefaultAppearance().dividerWidth)) : getDefaultAppearance().dividerWidth,
                fieldRadius: referenceInput && referenceInput.style ? readStyleNumber(referenceInput.style.borderRadius, (storedAppearance.fieldRadius || getDefaultAppearance().fieldRadius)) : getDefaultAppearance().fieldRadius,
                fieldPaddingY: referenceInput && referenceInput.style ? readStyleNumber(referenceInput.style.paddingTop, (storedAppearance.fieldPaddingY || getDefaultAppearance().fieldPaddingY)) : getDefaultAppearance().fieldPaddingY,
                fieldPaddingX: referenceInput && referenceInput.style ? readStyleNumber(referenceInput.style.paddingLeft, (storedAppearance.fieldPaddingX || getDefaultAppearance().fieldPaddingX)) : getDefaultAppearance().fieldPaddingX
            }),
            fields: fields
        });
    }

    function ensureTypeFormDefaults(item) {
        if (!item.type_form) {
            item.type_form = {
                content: '',
                name: '',
                sendto: '',
                type: 'URL',
                goto: '',
                options: '_blank'
            };
        }

        if (!item.type_form._builderState) {
            item.type_form._builderState = parseState(item.type_form.content || window.defaultForm);
        }

        item.type_form._builderState = normalizeState(item.type_form._builderState);

        if (!item.type_form.content) {
            item.type_form.content = buildWidgetHtml(item.type_form._builderState);
        }

        item.type_form.type = item.type_form.type || 'URL';
        item.type_form.options = item.type_form.options || '_blank';

        return item.type_form;
    }

    function getFieldIconClass(field) {
        return normalizeFieldIconClass(field ? field.iconClass : '', getDefaultFieldIconClass(field));
    }

    function getFieldIconOption(field) {
        const iconClass = getFieldIconClass(field);
        return FORM_FIELD_ICON_OPTIONS.find(function(option) {
            return option.value === iconClass;
        }) || FORM_FIELD_ICON_OPTIONS[0];
    }

    function buildFieldLabelIconHtml(field) {
        const iconClass = getFieldIconClass(field);
        if (!iconClass) {
            return '';
        }

        return `<i class="${escapeHtml(iconClass)} m-0 p-0 mr-2" aria-hidden="true"></i>`;
    }

    function buildIconPickerHtml(field) {
        const selectedOption = getFieldIconOption(field);
        const selectedIcon = selectedOption.value;
        const previewIcon = selectedOption.preview || selectedOption.value || 'fa fa-ban';
        const triggerEmptyClass = selectedIcon ? '' : ' is-empty';

        return `
            <div class="builder-icon-picker builder-icon-picker-head">
                <button type="button" class="builder-icon-trigger builder-icon-trigger-head${triggerEmptyClass}" data-action="toggle-icon-picker" aria-expanded="false" title="Cambiar icono: ${escapeHtml(selectedOption.label)}" aria-label="Cambiar icono">
                    <span class="builder-icon-trigger-preview${triggerEmptyClass}" aria-hidden="true"><i class="${escapeHtml(previewIcon)}"></i></span>
                </button>
                <div class="builder-icon-popover d-none">
                    <div class="builder-icon-popover-head">
                        <span class="builder-icon-popover-title">Icono</span>
                        <button type="button" class="builder-icon-popover-close" data-action="close-icon-picker" aria-label="Cerrar selector de iconos">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="builder-icon-search-wrap">
                        <input type="text" class="builder-input cMain text-left builder-icon-search" placeholder="Buscar icono">
                    </div>
                    <div class="builder-icon-popover-grid">
                    ${FORM_FIELD_ICON_OPTIONS.map(function(option) {
                        const isActive = selectedIcon === option.value;
                        const previewIcon = option.preview || option.value || 'fa fa-ban';
                        const emptyClass = option.value ? '' : ' is-empty';
                        return `
                            <button type="button" class="builder-icon-choice${isActive ? ' active' : ''}" data-icon-class="${escapeHtml(option.value)}" data-icon-label="${escapeHtml(option.label.toLowerCase())}" title="${escapeHtml(option.label)}" aria-label="${escapeHtml(option.label)}">
                                <span class="builder-icon-choice-preview${emptyClass}" aria-hidden="true"><i class="${escapeHtml(previewIcon)}"></i></span>
                            </button>
                        `;
                    }).join('')}
                    </div>
                </div>
            </div>
        `;
    }

    function getFieldInputType(field) {
        return field.type === 'postalcode' ? 'text' : field.type;
    }

    function buildDescriptionHtml(field, appearance) {
        if (!field.description) {
            return '';
        }

        return `<span class="field-description" style="color:${appearance.labelColor};">${escapeHtml(field.description)}</span>`;
    }

    function buildFieldWrapperStyle(appearance, hasDivider) {
        const wrapperStyles = [
            `margin-top:${appearance.fieldGap}px`
        ];

        if (hasDivider && appearance.dividerWidth > 0) {
            wrapperStyles.push(`padding-bottom:${Math.max(Math.round(appearance.fieldGap * 0.75), 8)}px`);
            wrapperStyles.push(`border-bottom:${appearance.dividerWidth}px solid ${appearance.dividerColor}`);
        } else {
            wrapperStyles.push('padding-bottom:0');
            wrapperStyles.push('border-bottom:none');
        }

        return wrapperStyles.join(';');
    }

    function buildFieldBorderStyle(appearance) {
        if (appearance.fieldBorderMode === 'all') {
            return [
                `border:1px solid ${appearance.fieldBorder}`,
                `border-bottom:1px solid ${appearance.fieldBorder}`,
                `border-color:${appearance.fieldBorder}`
            ];
        }

        if (appearance.fieldBorderMode === 'none') {
            return [
                'border:none',
                'border-bottom:none',
                `border-color:${appearance.fieldBorder}`,
                `border-bottom-color:${appearance.fieldBorder}`
            ];
        }

        return [
            'border:none',
            `border-bottom:1px solid ${appearance.fieldBorder}`,
            `border-color:${appearance.fieldBorder}`,
            `border-bottom-color:${appearance.fieldBorder}`
        ];
    }

    function buildFieldInputStyle(appearance) {
        return [
            `background-color:${appearance.fieldBg}`,
            `color:${appearance.fieldText}`,
            `--field-placeholder-color:${appearance.placeholderColor}`,
            `border-radius:${appearance.fieldRadius}px`,
            `padding:${appearance.fieldPaddingY}px ${appearance.fieldPaddingX}px`,
            'box-sizing:border-box'
        ].concat(buildFieldBorderStyle(appearance)).join(';');
    }

    function buildChoiceFieldHtml(field, appearance, index, totalFields) {
        const options = field.options.length ? field.options : ['Option 1'];
        const choiceType = field.type === 'radio' ? 'radio' : 'checkbox';
        const serializedOptions = escapeHtml(JSON.stringify(options));
        const descriptionHtml = buildDescriptionHtml(field, appearance);
        const singleCheckbox = choiceType === 'checkbox' && options.length === 1;
        const wrapperStyle = buildFieldWrapperStyle(appearance, index < totalFields - 1);

        const optionsHtml = options.map(function(option, index) {
            const requiredAttr = field.required && (field.type === 'radio' ? index === 0 : singleCheckbox) ? 'required="required"' : '';
            return `
                <li>
                    <label class="choice-option" style="color:${appearance.labelColor};">
                        <input type="${choiceType}" id="${field.id}_${index}" name="${field.id}" value="${escapeHtml(option)}" ${requiredAttr}>
                        <span>${escapeHtml(option)}</span>
                    </label>
                </li>
            `;
        }).join('');
        const labelIconHtml = buildFieldLabelIconHtml(field);

        return `
            <div class="itemForm d-flex form-field choice-group${singleCheckbox ? ' single-checkbox' : ''}" id="form-${field.id}" style="${wrapperStyle}" data-field-id="${field.id}" data-field-type="${field.type}" data-field-label="${escapeHtml(field.label)}" data-field-description="${escapeHtml(field.description)}" data-placeholder="${escapeHtml(field.placeholder)}" data-required="${field.required}" data-crm-key="${escapeHtml(field.crmKey)}" data-is-terms="${field.isTerms ? 'true' : 'false'}" data-field-options="${serializedOptions}" data-icon-class="${escapeHtml(field.iconClass)}">
                <label class="choice-label" style="color:${appearance.labelColor};">${labelIconHtml}<b>${escapeHtml(field.label)}:</b></label>
                ${descriptionHtml}
                <ul class="choice-options p-0 m-0">${optionsHtml}</ul>
            </div>
        `;
    }

    function buildFieldHtml(field, appearance, index, totalFields) {
        if (field.type === 'radio' || field.type === 'checkbox') {
            return buildChoiceFieldHtml(field, appearance, index, totalFields);
        }

        const inputStyle = buildFieldInputStyle(appearance);
        const labelStyle = `color:${appearance.labelColor};`;
        const requiredAttr = field.required ? 'required="required"' : '';
        const descriptionHtml = buildDescriptionHtml(field, appearance);
        const wrapperStyle = buildFieldWrapperStyle(appearance, index < totalFields - 1);
        const labelIconHtml = buildFieldLabelIconHtml(field);
        const wrapperAttrs = `data-field-id="${field.id}" data-field-type="${field.type}" data-field-label="${escapeHtml(field.label)}" data-field-description="${escapeHtml(field.description)}" data-placeholder="${escapeHtml(field.placeholder)}" data-required="${field.required}" data-crm-key="${escapeHtml(field.crmKey)}" data-is-terms="false" data-field-options="[]" data-icon-class="${escapeHtml(field.iconClass)}"`;

        if (field.type === 'textarea') {
            return `
                <div class="itemForm d-flex form-field" id="form-${field.id}" style="${wrapperStyle}" ${wrapperAttrs}>
                    <label for="${field.id}" style="${labelStyle}">${labelIconHtml}<b>${escapeHtml(field.label)}:</b></label>
                    ${descriptionHtml}
                    <textarea id="${field.id}" name="${field.id}" placeholder="${escapeHtml(field.placeholder)}" ${requiredAttr} style="${inputStyle}"></textarea>
                </div>
            `;
        }

        return `
            <div class="itemForm d-flex form-field" id="form-${field.id}" style="${wrapperStyle}" ${wrapperAttrs}>
                <label for="${field.id}" style="${labelStyle}">${labelIconHtml}<b>${escapeHtml(field.label)}:</b></label>
                ${descriptionHtml}
                <input type="${getFieldInputType(field)}" id="${field.id}" name="${field.id}" placeholder="${escapeHtml(field.placeholder)}" ${requiredAttr} style="${inputStyle}">
            </div>
        `;
    }

    function buildWidgetHtml(state) {
        const normalizedState = normalizeState(state);
        const fieldsHtml = normalizedState.fields.map(function(field, index) {
            return buildFieldHtml(field, normalizedState.appearance, index, normalizedState.fields.length);
        }).join('');
        const titleClass = normalizedState.titleEnabled ? 'itemForm' : 'itemForm d-none';
        const formAppearanceData = escapeHtml(JSON.stringify(normalizedState.appearance));

        return `
            <button class="fileds-form" id="fields-form" type="button"><i class="fa fa-server"></i></button>
            <button class="colors-form" id="colors-form" type="button"><i class="fas fa-pencil-alt"></i></button>
            <form id="AF" class="ActionBox ui-sortable d-none" crm="${normalizedState.crmEnabled ? 'true' : 'false'}" data-form-builder="dynamic" data-form-appearance="${formAppearanceData}" style="background-color:${normalizedState.appearance.background};padding:${normalizedState.appearance.formPadding}px;">
                <div class="${titleClass}" id="form-title">
                    <h3 contenteditable style="color:${normalizedState.appearance.titleColor};">${escapeHtml(normalizedState.titleText)}</h3>
                </div>
                ${fieldsHtml}
                <div class="d-flex">
                    <button type="button" id="form-cta" style="background-color:${normalizedState.appearance.ctaBg};color:${normalizedState.appearance.ctaColor};">
                        <span>${escapeHtml(normalizedState.ctaText)}</span>
                    </button>
                </div>
            </form>
        `;
    }

    function readCurrentAppearance() {
        const defaults = getDefaultAppearance();
        const form = document.querySelector('#widgetContainerForm #AF');
        const storedAppearance = readStoredAppearance(form) || {};
        const firstFieldWrapper = form ? form.querySelector('.form-field') || form.querySelector('.itemForm:not(#form-title)') : null;
        const firstFieldInput = form ? form.querySelector('input[type=text], input[type=email], input[type=tel], input[type=date], textarea') : null;
        const firstLabel = form ? form.querySelector('.form-field label, .itemForm label') : null;

        return normalizeAppearance(Object.assign({}, defaults, storedAppearance, {
            ctaBg: $('#AF #form-cta').css('background-color') || defaults.ctaBg,
            ctaColor: $('#AF #form-cta').css('color') || defaults.ctaColor,
            titleColor: $('#AF #form-title h3').css('color') || defaults.titleColor,
            background: $('#AF').css('background-color') || defaults.background,
            formPadding: form ? readStyleNumber(window.getComputedStyle(form).paddingTop, (storedAppearance.formPadding || defaults.formPadding)) : defaults.formPadding,
            fieldBg: firstFieldInput ? window.getComputedStyle(firstFieldInput).backgroundColor : defaults.fieldBg,
            fieldText: firstFieldInput ? window.getComputedStyle(firstFieldInput).color : defaults.fieldText,
            placeholderColor: firstFieldInput ? (window.getComputedStyle(firstFieldInput).getPropertyValue('--field-placeholder-color').trim() || storedAppearance.placeholderColor || defaults.placeholderColor) : (storedAppearance.placeholderColor || defaults.placeholderColor),
            fieldBorder: firstFieldInput ? window.getComputedStyle(firstFieldInput).borderColor : defaults.fieldBorder,
            fieldBorderMode: detectComputedFieldBorderMode(firstFieldInput, storedAppearance.fieldBorderMode || defaults.fieldBorderMode),
            labelColor: firstLabel ? window.getComputedStyle(firstLabel).color : defaults.labelColor,
            fieldGap: firstFieldWrapper ? readStyleNumber(window.getComputedStyle(firstFieldWrapper).marginTop, (storedAppearance.fieldGap || defaults.fieldGap)) : defaults.fieldGap,
            dividerColor: firstFieldWrapper ? window.getComputedStyle(firstFieldWrapper).borderBottomColor : defaults.dividerColor,
            dividerWidth: firstFieldWrapper ? readStyleNumber(window.getComputedStyle(firstFieldWrapper).borderBottomWidth, (storedAppearance.dividerWidth || defaults.dividerWidth)) : defaults.dividerWidth,
            fieldRadius: firstFieldInput ? readStyleNumber(window.getComputedStyle(firstFieldInput).borderRadius, (storedAppearance.fieldRadius || defaults.fieldRadius)) : (storedAppearance.fieldRadius || defaults.fieldRadius),
            fieldPaddingY: firstFieldInput ? readStyleNumber(window.getComputedStyle(firstFieldInput).paddingTop, (storedAppearance.fieldPaddingY || defaults.fieldPaddingY)) : (storedAppearance.fieldPaddingY || defaults.fieldPaddingY),
            fieldPaddingX: firstFieldInput ? readStyleNumber(window.getComputedStyle(firstFieldInput).paddingLeft, (storedAppearance.fieldPaddingX || defaults.fieldPaddingX)) : (storedAppearance.fieldPaddingX || defaults.fieldPaddingX)
        }));
    }

    function syncStateFromPreview(item) {
        const typeForm = ensureTypeFormDefaults(item);
        const form = document.querySelector('#widgetContainerForm #AF');
        if (!form) {
            return typeForm._builderState;
        }

        typeForm._builderState.titleEnabled = !$('#AF #form-title').hasClass('d-none');
        typeForm._builderState.titleText = ($('#AF #form-title h3').text() || 'Title').trim() || 'Title';
        typeForm._builderState.ctaText = ($('#AF #form-cta span').text() || $('#AF #form-cta').text() || 'My Button Example').trim();
        typeForm._builderState.crmEnabled = form.getAttribute('crm') === 'true';
        typeForm._builderState.appearance = readCurrentAppearance();
        typeForm._builderState = normalizeState(typeForm._builderState);
        return typeForm._builderState;
    }

    function renderCurrentFormPreview(item) {
        const typeForm = ensureTypeFormDefaults(item);
        typeForm._builderState = normalizeState(typeForm._builderState);
        typeForm.content = buildWidgetHtml(typeForm._builderState);

        $('#widgetContainerForm').empty().append(typeForm.content).removeClass('d-none');
        $('#AF').removeClass('d-none').off('submit').on('submit', function(event) {
            event.preventDefault();
        });

        window.dynamicFormTitleTools();
        window.dynamicFormEditTools();
        window.formColorsTools();
        window.dynamicLoadCrmField();
    }

    function buildFieldEditor(field) {
        const typeLabel = field.isTerms ? 'Terminos' : (FORM_FIELD_LABELS[field.type] || field.type);
        const crmOptions = buildCrmOptionsHtml(field.crmKey);
        const placeholderField = (field.type === 'radio' || field.type === 'checkbox') ? '' : `
            <div class="builder-field-group fieldDes">
                <label class="cMain">Placeholder</label>
                <input type="text" class="builder-input cMain text-left" data-field-prop="placeholder" value="${escapeHtml(field.placeholder)}">
            </div>
        `;
        const optionsField = (field.type === 'radio' || field.type === 'checkbox') ? `
            <div class="builder-field-group fieldDes">
                <label class="cMain">Opciones (una por linea)</label>
                <textarea class="builder-input cMain" data-field-prop="options">${escapeHtml(field.options.join('\n'))}</textarea>
            </div>
        ` : '';
        const iconPicker = buildIconPickerHtml(field);

        return `
            <div class="builder-field-card form-builder-card card card-dash bg-white" data-field-id="${field.id}">
                <div class="builder-field-top form-builder-card-head card-header bg-05">
                    <div class="builder-field-meta cMain">
                        <i class="fas fa-grip-vertical builder-drag-handle"></i>
                        <span class="builder-type-pill cMain">${escapeHtml(typeLabel)}</span>
                        ${iconPicker}
                    </div>
                    <div class="builder-field-actions">
                        <button type="button" class="builder-icon-btn btn-square-min bg-white cMain" data-action="duplicate" title="Duplicar"><i class="far fa-copy"></i></button>
                        <button type="button" class="builder-icon-btn btn-square-min bg-white cMain" data-action="remove" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="builder-field-content card-body">
                    <div class="builder-field-grid two-cols">
                        <div class="builder-field-group fieldDes">
                            <label class="cMain">Etiqueta</label>
                            <input type="text" class="builder-input cMain text-left" data-field-prop="label" value="${escapeHtml(field.label)}">
                        </div>
                        ${placeholderField || `
                            <div class="builder-field-group fieldDes">
                                <label class="cMain">CRM</label>
                                <select class="builder-input cMain" data-field-prop="crmKey">${crmOptions}</select>
                            </div>
                        `}
                    </div>
                    <div class="builder-field-grid two-cols mt-2">
                        ${placeholderField ? `
                            <div class="builder-field-group fieldDes">
                                <label class="cMain">CRM</label>
                                <select class="builder-input cMain" data-field-prop="crmKey">${crmOptions}</select>
                            </div>
                        ` : `
                            <div class="builder-field-group fieldDes">
                                <label class="cMain">Tipo</label>
                                <input type="text" class="cMain text-left" value="${escapeHtml(typeLabel)}" disabled>
                            </div>
                        `}
                        <div class="builder-field-group fieldDes">
                            <label class="builder-inline-checkbox cMain">
                                <input type="checkbox" class="builder-input" data-field-prop="required" ${field.required ? 'checked' : ''}>
                                Campo requerido
                            </label>
                        </div>
                    </div>
                    <div class="builder-field-group fieldDes mt-2">
                        <label class="cMain">Texto de ayuda</label>
                        <textarea class="builder-input cMain" data-field-prop="description" placeholder="Opcional">${escapeHtml(field.description)}</textarea>
                    </div>
                    ${optionsField}
                </div>
            </div>
        `;
    }

    function renderFormBuilderPanel(item) {
        const typeForm = ensureTypeFormDefaults(item);
        const state = normalizeState(typeForm._builderState);
        typeForm._builderState = state;

        $('#form-title-visible').prop('checked', state.titleEnabled);
        $('#form-title-text').val(state.titleText);
        $('#form-cta-text').val(state.ctaText);
        $('#form-field-list').html(state.fields.map(buildFieldEditor).join(''));
        $('#form-builder-empty').toggleClass('d-none', !!state.fields.length);

        if ($('#form-field-list').data('ui-sortable')) {
            $('#form-field-list').sortable('destroy');
        }

        if (state.fields.length) {
            $('#form-field-list').sortable({
                handle: '.builder-drag-handle',
                placeholder: 'builder-sort-placeholder',
                update: function() {
                    const currentItem = getSelectedCuePointItem();
                    if (!currentItem || currentItem.type !== 'FORM') {
                        return;
                    }

                    const order = $('#form-field-list').children().map(function() {
                        return $(this).attr('data-field-id');
                    }).get();

                    const typeFormCurrent = ensureTypeFormDefaults(currentItem);
                    typeFormCurrent._builderState.fields.sort(function(first, second) {
                        return order.indexOf(first.id) - order.indexOf(second.id);
                    });
                    window.dynamicUpdateTypeForm();
                }
            });
        }
    }

    function activateFormEditor(item) {
        const typeForm = ensureTypeFormDefaults(item);
        $('#widgetContainer').addClass('d-none');
        $('#widgetContainerForm').removeClass('d-none');

        renderCurrentFormPreview(item);
        renderFormBuilderPanel(item);

        $('#inputName').val(typeForm.name || '');
        $('#inputSendTo').val(typeForm.sendto || '');

        if (typeForm.type === 'URL') {
            $('#goto-url-form').click();
            $('#gotourlOption-form').val(typeForm.goto);
            if (typeForm.options === '_blank') {
                $('#inlineRadioOpt1-form').prop('checked', true);
            }
            if (typeForm.options === '_self') {
                $('#inlineRadioOpt2-form').prop('checked', true);
            }
        } else if (typeForm.type === 'CUEPOINT') {
            $('#goto-cue-form').click();
            $('#cuepointList-Nav22-form > button').each(function() {
                if ($(this).attr('cuepoint-id') == typeForm.goto) {
                    $(this).removeAttr('onclick');
                    $(this).click();
                    $('#cuepointList-Nav22-form').attr('cuepoint-id', $(this).attr('cuepoint-id'));
                    $('#dropdownId-Nav11-form').html($(this).children('p').eq(0).html());
                    $('#dropdownName-Nav11-form').html('');
                    $('#dropdownTime-Nav11-form').html($(this).children('p').eq(1).html());
                    $(this).attr('onclick', 'selectBrowseCuepointForm(this)');
                }
            });
        } else if (typeForm.type === 'VIDEO') {
            $('#goto-video-form').click();
            $('#cuepointList-Nav33-form > button').each(function() {
                if ($(this).attr('projectlib-id') == typeForm.goto) {
                    $(this).removeAttr('onclick');
                    $(this).click();
                    $('#dropdownMenu44-form').attr('projectlib-id', $(this).attr('projectlib-id'));
                    $('#dropdownName-Nav33-form').html($(this).attr('media-name'));
                    $(this).attr('onclick', 'selectBrowseVideoForm(this)');
                }
            });
        }
    }

    function getCurrentBuilderState() {
        const item = getSelectedCuePointItem();
        return item && item.type === 'FORM' ? ensureTypeFormDefaults(item)._builderState : null;
    }

    function updateField(fieldId, callback) {
        const item = getSelectedCuePointItem();
        if (!item || item.type !== 'FORM') {
            return;
        }

        const typeForm = ensureTypeFormDefaults(item);
        const field = typeForm._builderState.fields.find(function(currentField) {
            return currentField.id === fieldId;
        });
        if (!field) {
            return;
        }

        callback(field, typeForm._builderState);
        window.dynamicUpdateTypeForm();
    }

    function closeIconPickers(scope) {
        const root = scope ? $(scope) : $('#fields-form-edit');
        root.find('.builder-icon-picker').removeClass('is-open');
        root.find('.builder-icon-popover').addClass('d-none');
        root.find('.builder-icon-trigger').attr('aria-expanded', 'false');
        root.find('.builder-icon-search').val('');
        root.find('.builder-icon-choice').removeClass('d-none');
    }

    function openIconPicker(picker) {
        const targetPicker = $(picker);
        closeIconPickers($('#fields-form-edit'));
        targetPicker.addClass('is-open');
        targetPicker.find('.builder-icon-popover').removeClass('d-none');
        targetPicker.find('.builder-icon-trigger').attr('aria-expanded', 'true');
        const searchInput = targetPicker.find('.builder-icon-search');
        searchInput.val('');
        targetPicker.find('.builder-icon-choice').removeClass('d-none');
        window.setTimeout(function() {
            searchInput.trigger('focus');
        }, 0);
    }

    function mergeBuilderOverrides(state, overrides) {
        if (!overrides || typeof overrides !== 'object') {
            return state;
        }

        const mergedState = Object.assign({}, state, overrides);
        if (overrides.appearance) {
            mergedState.appearance = Object.assign({}, state.appearance || {}, overrides.appearance);
        }

        return normalizeState(mergedState);
    }

    window.dynamicFormTitleTools = function() {
        $('#AF #form-title h3').off('blur').on('blur', function() {
            const item = getSelectedCuePointItem();
            if (!item || item.type !== 'FORM') {
                return;
            }

            ensureTypeFormDefaults(item)._builderState.titleText = ($(this).text() || 'Title').trim() || 'Title';
            window.dynamicUpdateTypeForm();
        });
    };

    window.dynamicFormEditTools = function() {
        $('#fields-form').off('click').on('click', function() {
            const item = getSelectedCuePointItem();
            if (!item || item.type !== 'FORM') {
                return;
            }

            $('body').css('overflow', 'hidden');
            $('#fields-form-edit').removeClass('d-none').show(500);
            renderFormBuilderPanel(item);
        });

        $('#fields-form-edit .closeM, #fields-form-edit .form-edit-close').off('click').on('click', function() {
            $('body').css('overflow', 'initial');
            $('#fields-form-edit').hide(500).addClass('d-none');
        });

        $('#form-builder-toolbar').off('click', '[data-add-field]').on('click', '[data-add-field]', function() {
            const item = getSelectedCuePointItem();
            if (!item || item.type !== 'FORM') {
                return;
            }

            ensureTypeFormDefaults(item)._builderState.fields.push(createField($(this).attr('data-add-field')));
            window.dynamicUpdateTypeForm();
        });

        $('#fields-form-edit').off('change', '#form-title-text').on('change', '#form-title-text', function() {
            const state = getCurrentBuilderState();
            if (state) {
                state.titleText = ($(this).val() || 'Title').trim() || 'Title';
                window.dynamicUpdateTypeForm({
                    titleText: state.titleText
                });
            }
        });

        $('#fields-form-edit').off('change', '#form-cta-text').on('change', '#form-cta-text', function() {
            const state = getCurrentBuilderState();
            if (state) {
                state.ctaText = ($(this).val() || 'My Button Example').trim() || 'My Button Example';
                window.dynamicUpdateTypeForm({
                    ctaText: state.ctaText
                });
            }
        });

        $('#fields-form-edit').off('change', '#form-title-visible').on('change', '#form-title-visible', function() {
            const state = getCurrentBuilderState();
            if (state) {
                state.titleEnabled = $(this).is(':checked');
                window.dynamicUpdateTypeForm({
                    titleEnabled: state.titleEnabled
                });
            }
        });

        $('#fields-form-edit').off('change', '.builder-field-card .builder-input').on('change', '.builder-field-card .builder-input', function() {
            const fieldId = $(this).closest('.builder-field-card').attr('data-field-id');
            const property = $(this).attr('data-field-prop');

            updateField(fieldId, function(field) {
                if (property === 'required') {
                    field.required = $(this).is(':checked');
                } else if (property === 'options') {
                    field.options = ($(this).val() || '').split(/\r?\n/).map(function(option) {
                        return option.trim();
                    }).filter(Boolean);
                } else {
                    field[property] = $(this).val();
                }
            }.bind(this));
        });

        $('#fields-form-edit').off('click', '.builder-icon-btn').on('click', '.builder-icon-btn', function() {
            const fieldId = $(this).closest('.builder-field-card').attr('data-field-id');
            const action = $(this).attr('data-action');
            const item = getSelectedCuePointItem();
            if (!item || item.type !== 'FORM') {
                return;
            }

            const typeForm = ensureTypeFormDefaults(item);
            if (action === 'duplicate') {
                const index = typeForm._builderState.fields.findIndex(function(field) {
                    return field.id === fieldId;
                });
                if (index !== -1) {
                    const duplicated = normalizeField(cloneValue(typeForm._builderState.fields[index]), index);
                    duplicated.id = nextFieldId();
                    typeForm._builderState.fields.splice(index + 1, 0, duplicated);
                    window.dynamicUpdateTypeForm();
                }
                return;
            }

            if (action === 'remove') {
                typeForm._builderState.fields = typeForm._builderState.fields.filter(function(field) {
                    return field.id !== fieldId;
                });
                window.dynamicUpdateTypeForm();
            }
        });

        $('#fields-form-edit').off('click', '.builder-icon-choice').on('click', '.builder-icon-choice', function() {
            const fieldId = $(this).closest('.builder-field-card').attr('data-field-id');
            const iconClass = $(this).attr('data-icon-class');

            updateField(fieldId, function(field) {
                field.iconClass = typeof iconClass === 'string' ? iconClass : '';
            });
        });

        $('#fields-form-edit').off('click', '[data-action="toggle-icon-picker"]').on('click', '[data-action="toggle-icon-picker"]', function(event) {
            event.preventDefault();
            event.stopPropagation();
            const picker = $(this).closest('.builder-icon-picker');
            if (picker.hasClass('is-open')) {
                closeIconPickers(picker);
                return;
            }
            openIconPicker(picker);
        });

        $('#fields-form-edit').off('click', '[data-action="close-icon-picker"]').on('click', '[data-action="close-icon-picker"]', function(event) {
            event.preventDefault();
            event.stopPropagation();
            closeIconPickers($(this).closest('.builder-icon-picker'));
        });

        $('#fields-form-edit').off('input', '.builder-icon-search').on('input', '.builder-icon-search', function() {
            const query = ($(this).val() || '').trim().toLowerCase();
            $(this).closest('.builder-icon-picker').find('.builder-icon-choice').each(function() {
                const label = ($(this).attr('data-icon-label') || '').toLowerCase();
                $(this).toggleClass('d-none', !!query && label.indexOf(query) === -1);
            });
        });

        $(document).off('click.builderIconPicker').on('click.builderIconPicker', function(event) {
            if ($(event.target).closest('#fields-form-edit .builder-icon-picker').length) {
                return;
            }
            closeIconPickers($('#fields-form-edit'));
        });
    };

    window.dynamicLoadCrmField = function() {
        const state = getCurrentBuilderState();
        if (!state) {
            return false;
        }

        $('#map-crm-form-edit').prop('checked', state.crmEnabled);
        return state.crmEnabled;
    };

    window.dynamicSwitcherCrm = function(enabled) {
        const state = getCurrentBuilderState();
        if (!state) {
            return;
        }

        state.crmEnabled = enabled === true || enabled === 'true';
        window.dynamicUpdateTypeForm({
            crmEnabled: state.crmEnabled
        });
    };

    window.dynamicSelectTypeForm = function() {
        const item = getSelectedCuePointItem();
        if (!item) {
            return;
        }

        item.type = 'FORM';
        item.action = 'UPDATE';
        activateFormEditor(item);
    };

    window.dynamicUpdateTypeForm = function(overrides) {
        const item = getSelectedCuePointItem();
        if (!item || item.type !== 'FORM') {
            return;
        }

        const typeForm = ensureTypeFormDefaults(item);
        typeForm._builderState = mergeBuilderOverrides(syncStateFromPreview(item), overrides);
        typeForm.name = ($('#inputName').val() || '').trim();
        typeForm.sendto = ($('#inputSendTo').val() || '').trim();
        typeForm.content = buildWidgetHtml(typeForm._builderState);
        item.action = 'UPDATE';

        renderCurrentFormPreview(item);
        if (!$('#fields-form-edit').hasClass('d-none')) {
            renderFormBuilderPanel(item);
        }
    };

    window.activateDynamicFormEditor = activateFormEditor;
    window.ensureDynamicTypeFormDefaults = ensureTypeFormDefaults;
    window.getDefaultDynamicFormHtml = function() {
        return buildWidgetHtml(getDefaultState());
    };

    $(function() {
        if (typeof window.defaultForm !== 'undefined') {
            window.defaultForm = window.getDefaultDynamicFormHtml();
        }
    });
})(window, window.jQuery);
