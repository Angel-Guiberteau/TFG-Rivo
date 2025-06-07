document.addEventListener("DOMContentLoaded", () => {

    flatpickr("#birth_date", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d-m-Y",
        locale: "es",
        maxDate: "today",
        altInputClass: "form-control custom-flatpickr",
        onReady: function (selectedDates, dateStr, instance) {
            instance.altInput.placeholder = "Selecciona una fecha";
        }
    });

    const userForm = document.querySelector('#personalData form');
    const submitBtn = userForm.querySelector('button[type="submit"]');

    const fields = [
        'name',
        'last_name',
        'birth_date',
        'rol_id',
        'email',
        'username',
        'password'
    ];

    function setValidationState(input, isValid, customMessage = '') {
        input.classList.toggle('is-valid', isValid);
        input.classList.toggle('is-invalid', !isValid);

        const feedbackContainer = input.closest('.input-group') || input.parentElement;
        let feedback = feedbackContainer.querySelector('.invalid-feedback');

        if (!feedback) {
            feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback');
            feedbackContainer.appendChild(feedback);
        }

        feedback.textContent = !isValid ? customMessage || '⚠️ Este campo es obligatorio' : '';
    }

    function validateField(input) {
        const fieldId = input.id;
        const value = input.value.trim();
        let isValid = true;

        if (fieldId === 'name' || fieldId === 'last_name' || fieldId === 'username') {
            isValid = value.length > 0;
            setValidationState(input, isValid, '⚠️ Este campo es obligatorio');
        } else if (fieldId === 'birth_date') {
            isValid = value !== '';
            setValidationState(input, isValid, '⚠️ Debes seleccionar una fecha');
        } else if (fieldId === 'rol_id') {
            isValid = input.value !== '';
            setValidationState(input, isValid, '⚠️ Debes seleccionar un rol');
        } else if (fieldId === 'email') {
            isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            setValidationState(input, isValid, '⚠️ Correo electrónico inválido');
        } else if (fieldId === 'password') {
            if (value === '') {
                setValidationState(input, true);
                isValid = true;
            } else {
                isValid = value.length >= 8;
                setValidationState(input, isValid, '⚠️ Debe tener al menos 8 caracteres');
            }
        }

        return isValid;
    }

    function validateForm() {
        let allValid = true;
        fields.forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                const valid = validateField(input);
                allValid = allValid && valid;
            }
        });
        submitBtn.disabled = !allValid;
    }

    // Eventos
    userForm.addEventListener('input', e => {
        if (fields.includes(e.target.id)) {
            validateField(e.target);
            validateForm();
        }
    });

    userForm.addEventListener('change', e => {
        if (fields.includes(e.target.id)) {
            validateField(e.target);
            validateForm();
        }
    });

    validateForm();

    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        const helperText = document.createElement('div');
        helperText.classList.add('form-text', 'mt-1'); 
        helperText.textContent = 'Solo completa este campo si deseas cambiar la contraseña';

        const parent = passwordInput.closest('.input-group') || passwordInput.parentElement;
        parent.parentElement.insertBefore(helperText, parent.nextSibling);
    }

});
