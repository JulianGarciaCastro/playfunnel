(function(window) {
    'use strict';

    function getVisibleFormWrappers(form) {
        return Array.from(form.querySelectorAll('.form-field[data-field-id], .itemForm[id^="form-"]')).filter(function(wrapper) {
            return wrapper.id !== 'form-title' && !wrapper.classList.contains('d-none');
        });
    }

    function getWrapperLabel(wrapper) {
        return wrapper.getAttribute('data-field-label')
            || (wrapper.querySelector('label b') ? wrapper.querySelector('label b').textContent.replace(/:\s*$/, '').trim() : '')
            || wrapper.id
            || 'Campo';
    }

    function normalizeValueForMail(value) {
        if (Array.isArray(value)) {
            return value;
        }

        if (value === true) {
            return 'Yes';
        }

        if (value === false || value == null) {
            return '';
        }

        return value;
    }

    function collectFieldPayload(wrapper) {
        const type = wrapper.getAttribute('data-field-type') || ((wrapper.querySelector('textarea') ? 'textarea' : (wrapper.querySelector('input') ? wrapper.querySelector('input').type : 'text')));
        const crmKey = wrapper.getAttribute('data-crm-key') || '';
        const name = wrapper.getAttribute('data-field-id') || (wrapper.querySelector('input, textarea') ? wrapper.querySelector('input, textarea').name : wrapper.id);
        const label = getWrapperLabel(wrapper);
        let value = '';

        if (type === 'checkbox') {
            const checkboxes = Array.from(wrapper.querySelectorAll('input[type="checkbox"]'));
            if (checkboxes.length > 1) {
                value = checkboxes.filter(function(input) {
                    return input.checked;
                }).map(function(input) {
                    return input.value;
                });
            } else {
                value = checkboxes.length ? !!checkboxes[0].checked : false;
            }
        } else if (type === 'radio') {
            const checked = wrapper.querySelector('input[type="radio"]:checked');
            value = checked ? checked.value : '';
        } else {
            const input = wrapper.querySelector('input, textarea');
            value = input ? input.value : '';
        }

        return {
            name: name,
            label: label,
            type: type,
            crmKey: crmKey,
            value: normalizeValueForMail(value)
        };
    }

    function validateChoiceGroups(form) {
        let invalidInput = null;

        getVisibleFormWrappers(form).forEach(function(wrapper) {
            const type = wrapper.getAttribute('data-field-type');
            const required = wrapper.getAttribute('data-required') === 'true';
            if (!required || (type !== 'checkbox' && type !== 'radio')) {
                return;
            }

            const selector = type === 'radio' ? 'input[type="radio"]' : 'input[type="checkbox"]';
            const inputs = Array.from(wrapper.querySelectorAll(selector));
            const hasValue = inputs.some(function(input) {
                return input.checked;
            });

            inputs.forEach(function(input, index) {
                input.setCustomValidity(!hasValue && index === 0 ? 'Seleccione una opcion.' : '');
            });

            if (!hasValue && !invalidInput) {
                invalidInput = inputs[0] || null;
            }
        });

        return invalidInput;
    }

    function buildCrmFormData(fields) {
        const formData = new FormData();
        const crmMap = {
            name: 'f-name',
            email: 'f-email',
            tel: 'f-tel',
            birthday: 'f-birthday',
            postalcode: 'f-cp',
            comments: 'f-comments'
        };
        const customFieldData = [];

        fields.forEach(function(field) {
            if (!field.crmKey) {
                return;
            }

            if (field.crmKey.indexOf('custom:') === 0) {
                const customFieldId = parseInt(field.crmKey.split(':')[1], 10);
                if (customFieldId > 0) {
                    customFieldData.push({
                        id: customFieldId,
                        value: field.value
                    });
                }
                return;
            }

            if (!(field.crmKey in crmMap)) {
                return;
            }

            const value = Array.isArray(field.value) ? field.value.join(', ') : field.value;
            formData.append(crmMap[field.crmKey], value);
        });

        if (customFieldData.length) {
            formData.append('crm_custom_field_data', JSON.stringify(customFieldData));
        }

        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('projectid', window.project.id);
        return formData;
    }

    function goToUrl(url, option) {
        if (typeof goUrl === 'function') {
            goUrl(url, option);
            return;
        }

        if (typeof window.goUrl === 'function') {
            window.goUrl(url, option);
        }
    }

    function goToCuepoint(cuepointId) {
        if (typeof goCuepoint === 'function') {
            goCuepoint(cuepointId);
            return;
        }

        if (typeof window.goCuepoint === 'function') {
            window.goCuepoint(cuepointId);
        }
    }

    function goToVideo(projectlibId) {
        if (typeof goVideo === 'function') {
            goVideo(projectlibId);
            return;
        }

        if (typeof window.goVideo === 'function') {
            window.goVideo(projectlibId);
        }
    }

    window.loadCrmField = function() {
        const form = document.querySelector('#AF');
        return !!(form && form.getAttribute('crm') === 'true');
    };

    window.sendCrm = function(formData) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'crm-register', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.send(formData);
    };

    window.sendForm = function(inputs, sendto, nameForm, crm) {
        if (window.sessionPreview) {
            console.log('Modo preview: Formulario no enviado.');
            return;
        }

        const fields = Array.from(inputs).map(collectFieldPayload);
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('sendto', sendto);
        formData.append('nameForm', nameForm);
        formData.append('field_data', JSON.stringify(fields));

        if (crm) {
            window.sendCrm(buildCrmFormData(fields));
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'sendForm', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.send(formData);
    };

    window.playFunnelDynamicListenFormActions = function(item) {
        const cta = document.getElementById('form-cta');
        const formElement = document.getElementById('AF');
        if (!cta || !formElement) {
            return;
        }

        cta.onclick = function(event) {
            event.preventDefault();
            validateChoiceGroups(formElement);

            if (!formElement.checkValidity()) {
                formElement.reportValidity();
                return;
            }

            document.getElementById('widgetContainer').classList.remove('active');
            formElement.classList.add('d-none');

            const inputs = getVisibleFormWrappers(formElement);
            window.sendForm(inputs, item.type_form.sendto, item.type_form.name, window.loadCrmField());

            if (item.type_form.type === 'URL') {
                goToUrl(item.type_form.goto, item.type_form.options);
                return;
            }

            if (item.type_form.type === 'CUEPOINT') {
                goToCuepoint(item.type_form.goto);
                document.getElementById('widgetContainer').innerHTML = '';
                return;
            }

            if (item.type_form.type === 'VIDEO') {
                goToVideo(item.type_form.goto);
                document.getElementById('widgetContainer').innerHTML = '';
            }
        };
    };

    window.listenFormActions = window.playFunnelDynamicListenFormActions;
})(window);
