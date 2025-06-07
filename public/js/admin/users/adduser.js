document.addEventListener('DOMContentLoaded', () => {

    const birthInput = document.getElementById("birth_date");
    const birthPicker = flatpickr(birthInput, {
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

    const submitBtn = document.getElementById('submit-user');

    const fields = {
        name: { required: true },
        last_name: { required: true },
        birth_date: { required: true },
        rol_id: { required: true },
        email: { required: true, type: 'email' },
        username: { required: true },
        password: { required: true, minLength: 8 }
    };

    const errorMessages = {
        name: '⚠️ El nombre es obligatorio.',
        last_name: '⚠️ El apellido es obligatorio.',
        birth_date: '⚠️ La fecha de nacimiento es obligatoria.',
        rol_id: '⚠️ Debes seleccionar un rol.',
        email: '⚠️ Introduce un correo válido.',
        username: '⚠️ El nombre de usuario es obligatorio.',
        password: '⚠️ La contraseña es obligatoria y debe tener al menos 8 caracteres.'
    };

    function showError(field, message) {
        let feedback = field.parentElement.querySelector('.invalid-feedback');

        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            field.parentElement.appendChild(feedback);
        }

        feedback.textContent = message;
    }

    function removeError(field) {
        const feedback = field.parentElement.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.remove();
        }
    }

    function validateField(field, rules) {
        const value = field.value.trim();
        let valid = true;
        let errorMessage = '';

        if (rules.required && value === '') {
            valid = false;
            errorMessage = errorMessages[field.id];
        }

        if (rules.type === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                valid = false;
                errorMessage = errorMessages[field.id];
            }
        }

        if (field.id === 'password' && value.length < rules.minLength) {
            valid = false;
            errorMessage = errorMessages[field.id];
        }

        field.classList.remove('is-valid', 'is-invalid');
        removeError(field);

        if (valid) {
            field.classList.add('is-valid');
        } else {
            field.classList.add('is-invalid');
            showError(field, errorMessage);
        }

        return valid;
    }

    function validateForm() {
        let allValid = true;

        for (const [id, rules] of Object.entries(fields)) {
            const input = document.getElementById(id);
            if (input) {
                const isValid = validateField(input, rules);
                if (!isValid) allValid = false;
            }
        }

        submitBtn.disabled = !allValid;
    }

    for (const id of Object.keys(fields)) {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', () => {
                validateField(input, fields[id]);
                validateForm();
            });

            if (input.tagName === 'SELECT') {
                input.addEventListener('change', () => {
                    validateField(input, fields[id]);
                    validateForm();
                });
            }
        }
    }

    validateForm();
});
