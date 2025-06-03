document.addEventListener('DOMContentLoaded', () => {
    const ahorroInput = document.querySelector('#ahorro_actual');
    const alertNoObjective = document.querySelector('#noObjectiveAlert');

    function clearValidation(input) {
        input.classList.remove('is-invalid', 'is-valid');
        const feedback = input.closest('.field-group')?.querySelector('.invalid-feedback');
        if (feedback) feedback.textContent = '';
    }

    function setValidationError(input, message) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        const feedback = input.closest('.field-group')?.querySelector('.invalid-feedback');
        if (feedback) feedback.textContent = message;
    }

    function setValidationSuccess(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        const feedback = input.closest('.field-group')?.querySelector('.invalid-feedback');
        if (feedback) feedback.textContent = '';
    }

    function validateAhorroInput() {
        clearValidation(ahorroInput);
        const value = ahorroInput.value.trim();

        if (value === '') return true;

        const regex = /^\d{1,10}(\.\d{1,2})?$/;

        if (!regex.test(value)) {
            setValidationError(ahorroInput, '⚠️ Introduce un número positivo con hasta 2 decimales y máximo 10 cifras enteras.');
            return false;
        }

        const num = parseFloat(value);
        if (num < 0) {
            setValidationError(ahorroInput, '⚠️ El valor no puede ser negativo.');
            return false;
        }

        setValidationSuccess(ahorroInput);
        return true;
    }

    function checkObjectiveSelected() {
        // IMPORTANTE: buscar radios e input aunque estén ocultos (dentro de step6)
        const radios = document.querySelectorAll('#sixthStep input[name="objective"]');
        const objPersonalize = document.querySelector('#sixthStep #objPersonalize');

        let anyRadioChecked = false;
        radios.forEach(radio => {
            if (radio.checked) anyRadioChecked = true;
        });

        const textEntered = objPersonalize && objPersonalize.value.trim().length > 0;

        if (!anyRadioChecked && !textEntered) {
            alertNoObjective.classList.remove('d-none');
        } else {
            alertNoObjective.classList.add('d-none');
        }
    }

    ahorroInput.addEventListener('input', () => {
        validateAhorroInput();
    });

    // Añadir eventos a radios e input personalizados del step6
    const radios = document.querySelectorAll('#sixthStep input[name="objective"]');
    const objPersonalize = document.querySelector('#sixthStep #objPersonalize');

    radios.forEach(radio => {
        radio.addEventListener('change', checkObjectiveSelected);
    });

    if (objPersonalize) {
        objPersonalize.addEventListener('input', checkObjectiveSelected);
    }

    checkObjectiveSelected();

    window.validateStep9 = function() {
        const validAhorro = validateAhorroInput();
        checkObjectiveSelected();
        return validAhorro;
    };
});
