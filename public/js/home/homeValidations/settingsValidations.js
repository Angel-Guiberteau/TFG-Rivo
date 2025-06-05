export function setSettingsValidation() {
    const form = document.querySelector('#settings-section form');
    const submitButton = form.querySelector('button[type="submit"]');

    const fields = {
        username: {
            input: form.querySelector('#username'),
            validate: value => /^[a-zA-Z0-9\s]{1,75}$/.test(value),
            message: '⚠️ No se permiten caracteres especiales ni más de 75 caracteres.'
        },
        name: {
            input: form.querySelector('#name'),
            validate: value => /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,75}$/.test(value),
            message: '⚠️ No se permiten caracteres especiales ni más de 75 caracteres.'
        },
        last_name: {
            input: form.querySelector('#last_name'),
            validate: value => /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,75}$/.test(value),
            message: '⚠️ No se permiten caracteres especiales ni más de 75 caracteres.'
        },
        birth_date: {
            input: form.querySelector('#birth_date'),
            validate: value => {
                const birth = new Date(value);
                const today = new Date();
                const age = today.getFullYear() - birth.getFullYear();
                const hasBirthdayPassed = (
                    today.getMonth() > birth.getMonth() ||
                    (today.getMonth() === birth.getMonth() && today.getDate() >= birth.getDate())
                );
                return birth instanceof Date && !isNaN(birth) && (age > 18 || (age === 18 && hasBirthdayPassed));
            },
            message: '⚠️ Debes tener al menos 18 años.'
        },
        email: {
            input: form.querySelector('#email'),
            validate: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) && value.length <= 255,
            message: '⚠️ Introduce un correo válido y menor de 255 caracteres.'
        },
        password: {
            input: form.querySelector('#password'),
            validate: value => value.length === 0 || value.length >= 8,
            message: '⚠️ La contraseña debe tener al menos 8 caracteres.'
        }
    };

    const validateField = (fieldKey) => {
        const { input, validate, message } = fields[fieldKey];
        const feedback = input.parentElement.querySelector('.invalid-feedback') || createFeedback(input);

        if (validate(input.value.trim())) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            feedback.style.display = 'none';
            return true;
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            feedback.textContent = message;
            feedback.style.display = 'block';
            return false;
        }
    };

    const createFeedback = (input) => {
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        feedback.style.display = 'block';
        input.parentElement.appendChild(feedback);
        return feedback;
    };

    const validateForm = () => {
        const allValid = Object.entries(fields).every(([key, { input }]) => {
            
            return key === 'password' ? fields[key].validate(input.value.trim()) : validateField(key);
        });
        submitButton.disabled = !allValid;
    };

    // Validación en cada cambio
    Object.keys(fields).forEach(fieldKey => {
        const input = fields[fieldKey].input;
        input.addEventListener('input', () => {
            validateField(fieldKey);
            validateForm();
        });
    });

    // Validación inicial
    Object.keys(fields).forEach(fieldKey => validateField(fieldKey));
    validateForm();
}
