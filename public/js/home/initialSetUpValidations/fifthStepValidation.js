document.addEventListener('DOMContentLoaded', () => {
    const personalizePercentage = document.getElementById('personalizePercentage');
    const percentageRadios = document.querySelectorAll('input[name="percentage"]');

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

    function validatePercentageInput() {
        clearValidation(personalizePercentage);

        const value = personalizePercentage.value.trim();
        if (value === '') return true; 

        const regex = /^(100(\.0{1,2})?|(\d{1,2})(\.\d{1,2})?)$/;

        if (!regex.test(value)) {
            setValidationError(personalizePercentage, '⚠️ Introduce un porcentaje válido (0-100, máx. 2 decimales).');
            return false;
        }

        const num = parseFloat(value);
        if (num < 0 || num > 100) {
            setValidationError(personalizePercentage, '⚠️ El porcentaje debe estar entre 0 y 100.');
            return false;
        }

        setValidationSuccess(personalizePercentage);
        return true;
    }

    personalizePercentage.addEventListener('input', () => {
        clearRadios();
        validatePercentageInput();
    });


    personalizePercentage.addEventListener('keydown', (e) => {
        const allowedKeys = [
            'Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', '.', 
        ];

        if (e.ctrlKey || e.metaKey) return;

        if (
            (e.key.length === 1 && !/[0-9.]/.test(e.key)) &&
            !allowedKeys.includes(e.key)
        ) {
            e.preventDefault();
        }

        if (e.key === '.' && personalizePercentage.value.includes('.')) {
            e.preventDefault();
        }
    });

    personalizePercentage.addEventListener('paste', (e) => {
        const pasted = (e.clipboardData || window.clipboardData).getData('text');
        if (!/^\d{1,3}(\.\d{0,2})?$/.test(pasted)) {
            e.preventDefault();
        }
    });

    percentageRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            clearPercentageInput();
        });
    });

    window.clearRadios = function () {
        percentageRadios.forEach(radio => radio.checked = false);
    };

    window.clearPercentageInput = function () {
        personalizePercentage.value = '';
        clearValidation(personalizePercentage);
    };

    window.validateStep5 = function () {
        return validatePercentageInput();
    };

    personalizePercentage.addEventListener('blur', () => {
        const value = personalizePercentage.value.trim();
        if (value === '') return;

        const num = parseFloat(value);
        if (!isNaN(num) && num >= 0 && num <= 100) {
            personalizePercentage.value = num.toFixed(2);
        }
    });

});
