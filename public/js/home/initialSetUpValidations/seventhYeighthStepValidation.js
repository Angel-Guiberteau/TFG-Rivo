document.addEventListener('DOMContentLoaded', () => {
    const variableInputs = document.querySelectorAll('.variableExpense');
    const moneySpans = document.querySelectorAll('.avaibleMoneyToVariableExpenses');

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

    function validateVariableInput(input) {
        clearValidation(input);
        const value = input.value.trim();

        if (value === '') return true;

        const regex = /^\d+(\.\d{1,2})?$/;

        if (!regex.test(value)) {
            setValidationError(input, '⚠️ Introduce un número positivo con hasta 2 decimales.');
            return false;
        }

        const num = parseFloat(value);
        if (num < 0) {
            setValidationError(input, '⚠️ El valor no puede ser negativo.');
            return false;
        }

        setValidationSuccess(input);
        return true;
    }

    function checkIfZeroAvailableMoney() {
        moneySpans.forEach(span => {
            const raw = span.textContent
                .replace(/[^\d,\.]/g, '')
                .replace(/\.(?=\d{3})/g, '')
                .replace(',', '.');

            const parsed = parseFloat(raw);
            const alert = span.closest('section')?.querySelector('.zeroMoneyWarning');

            if (!isNaN(parsed) && parsed === 0 && alert) {
                alert.classList.remove('d-none');
            } else if (alert) {
                alert.classList.add('d-none');
            }
        });
    }

    variableInputs.forEach(input => {
        input.addEventListener('input', () => {
            validateVariableInput(input);
            checkIfZeroAvailableMoney();
        });
    });

    function validateStepCommon() {
        let allValid = true;
        variableInputs.forEach(input => {
            const isValid = validateVariableInput(input);
            if (!isValid) allValid = false;
        });
        checkIfZeroAvailableMoney();
        return allValid;
    }

    window.validateStep7 = validateStepCommon;
    window.validateStep8 = validateStepCommon;
});
