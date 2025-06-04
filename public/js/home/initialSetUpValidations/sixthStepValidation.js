document.addEventListener('DOMContentLoaded', () => {
    const objPersonalize = document.getElementById('objPersonalize');
    const objectiveRadios = document.querySelectorAll('input[name="objective"]');

    function clearValidation(input) {
        input.classList.remove('is-invalid', 'is-valid');
        const feedback = input.parentElement.parentElement.querySelector('.invalid-feedback');
        if (feedback) feedback.textContent = '';
    }

    function setValidationError(input, message) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        const feedback = input.parentElement.parentElement.querySelector('.invalid-feedback');
        if (feedback) feedback.textContent = message;
    }

    function setValidationSuccess(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        const feedback = input.parentElement.parentElement.querySelector('.invalid-feedback');
        if (feedback) feedback.textContent = '';
    }

    function validateCustomObjective() {
        clearValidation(objPersonalize);
        const value = objPersonalize.value.trim();

        if (value === '') return true; // No obligatorio

        if (value.length > 75) {
            setValidationError(objPersonalize, '⚠️ Máximo 75 caracteres.');
            return false;
        }

        const regex = /^[a-zA-ZÀ-ÿ0-9\s.,:()'"¿?!¡-]*$/;

        if (!regex.test(value)) {
            setValidationError(objPersonalize, '⚠️ El objetivo no puede contener caracteres especiales.');
            return false;
        }

        setValidationSuccess(objPersonalize);
        return true;
    }

    objPersonalize.addEventListener('input', () => {
        clearRadiosS6();
        validateCustomObjective();
    });

    objectiveRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            clearCustomObjective();
        });
    });

    // Función global para limpiar radios
    window.clearRadiosS6 = function () {
        objectiveRadios.forEach(radio => radio.checked = false);
    };

    // Función global para limpiar input personalizado
    window.clearPersonalizeObj = function () {
        objPersonalize.value = '';
        clearValidation(objPersonalize);
    };

    // Función de validación general para el paso 6
    window.validateStep6 = function () {
        return validateCustomObjective();
    };
});
