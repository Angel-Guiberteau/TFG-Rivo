document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submit-endPoint');

    const inputs = {
        name: document.getElementById('name'),
        url: document.getElementById('url'),
        method: document.getElementById('method'),
        parameters: document.getElementById('parameters'),
        return: document.getElementById('return'),
        description: document.getElementById('description')
    };

    const requiredFields = ['name', 'url', 'method', 'return'];
    const fieldLimits = {
        name: 75,
        url: 255,
        method: 7,
        parameters: 75,
        return: 15,
        description: 255
    };

    const safePattern = /^[\w\s\-\/\.\{\}\:\[\]]*$/;

    const validFields = {
        name: false,
        url: false,
        method: false,
        return: false
    };

    const originalValues = {};
    Object.entries(inputs).forEach(([name, input]) => {
        originalValues[name] = input.value.trim();
    });

    function setMessage(input, message, isValid) {
        input.classList.remove('is-valid', 'is-invalid');
        input.classList.add(isValid ? 'is-valid' : 'is-invalid');

        let messageDiv = input.parentNode.querySelector('.validation-message');
        if (!messageDiv) {
            messageDiv = document.createElement('div');
            messageDiv.classList.add('validation-message', 'mt-1', 'small');
            input.parentNode.appendChild(messageDiv);
        }

        messageDiv.textContent = message;
        messageDiv.classList.remove('text-danger', 'text-success');
        messageDiv.classList.add(isValid ? 'text-success' : 'text-danger');
    }

    function validateField(name, input) {
        const value = input.value.trim();
        const max = fieldLimits[name];

        if (requiredFields.includes(name) && value === '') {
            setMessage(input, 'Este campo es obligatorio.', false);
            if (validFields.hasOwnProperty(name)) validFields[name] = false;
            return false;
        }

        if (value.length > max) {
            setMessage(input, `Máximo ${max} caracteres permitidos.`, false);
            if (validFields.hasOwnProperty(name)) validFields[name] = false;
            return false;
        }

        if (!safePattern.test(value)) {
            setMessage(input, 'Contiene caracteres no permitidos.', false);
            if (validFields.hasOwnProperty(name)) validFields[name] = false;
            return false;
        }

        if ((name === 'url' || name === 'parameters') && /\{[a-zA-Z0-9_]+\}/.test(value)) {
            setMessage(input, 'Campo válido con parámetros dinámicos.', true);
        } else {
            setMessage(input, 'Campo válido.', true);
        }

        if (validFields.hasOwnProperty(name)) validFields[name] = true;
        return true;
    }

    function hasChanged() {
        return Object.entries(inputs).some(([name, input]) => {
            return input.value.trim() !== originalValues[name];
        });
    }

    function checkFormValidity() {
        const allValid = Object.values(validFields).every(Boolean);
        const anyChanged = hasChanged();
        submitBtn.disabled = !(allValid && anyChanged);
    }

    Object.entries(inputs).forEach(([name, input]) => {
        input.addEventListener('input', () => {
            validateField(name, input);
            checkFormValidity();
        });
    });

    form.addEventListener('submit', (e) => {
        if (submitBtn.disabled) {
            e.preventDefault();
        }
    });

    Object.entries(inputs).forEach(([name, input]) => {
        if (input.value.trim() !== '') {
            validateField(name, input);
        }
    });
    checkFormValidity();
});
