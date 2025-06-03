document.addEventListener('DOMContentLoaded', () => {

    const salary = document.getElementById('salary');
    const familyHelp = document.getElementById('familyHelp');
    const stateHelp = document.getElementById('stateHelp');

    const step3Inputs = [
        document.getElementById('homeExpenses'),
        document.getElementById('servicesHomeExpenses'),
        document.getElementById('feedingExpenses'),
        document.getElementById('transportationExpenses'),
    ];
    const step3Msg = document.getElementById('expensesDisabledMsg');
    const step3SumErrorMsg = document.getElementById('expensesSumErrorMsg');

    const step4Inputs = [
        document.getElementById('healthExpenses'),
        document.getElementById('telephoneExpenses'),
        document.getElementById('educationExpenses'),
        document.getElementById('otherExpenses'),
    ];
    const step4Msg = document.getElementById('otherExpensesDisabledMsg');
    const step4SumErrorMsg = document.getElementById('otherExpensesSumErrorMsg');

    let expensesDisabledDueToExcess = false;

    function getTotalIncome() {
        const vals = [salary, familyHelp, stateHelp].map(i => i && i.value.trim() !== '' ? parseFloat(i.value) : 0);
        return vals.reduce((a, b) => a + b, 0);
    }

    function getTotalExpenses() {
        const allExpenses = [...step3Inputs, ...step4Inputs];
        const vals = allExpenses.map(i => i && i.value.trim() !== '' ? parseFloat(i.value) : 0);
        return vals.reduce((a, b) => a + b, 0);
    }

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

    function validateInput(input) {
        clearValidation(input);
        if (input.disabled) return true;

        const val = input.value.trim();
        if (val === '') {
            input.classList.remove('is-valid', 'is-invalid');
            return true;
        }

        const regex = /^\d{1,8}(\.\d{1,2})?$/;

        if (!regex.test(val)) {
            setValidationError(input, '⚠️ Introduce un número válido con hasta 2 decimales.');
            return false;
        }

        if (parseFloat(val) < 0) {
            setValidationError(input, '⚠️ No se permiten valores negativos.');
            return false;
        }

        setValidationSuccess(input);
        return true;
    }

    function toggleInputs(inputs, alertMsg) {
        const shouldDisable = getTotalIncome() <= 0;

        inputs.forEach(input => {
            if (shouldDisable) {
                input.disabled = true;
                clearValidation(input);
                input.value = '';
            } else if (!expensesDisabledDueToExcess) {
                input.disabled = false;
            }
        });

        if (alertMsg) {
            if (shouldDisable) {
                alertMsg.classList.remove('d-none');
            } else {
                alertMsg.classList.add('d-none');
            }
        }
    }

    function validateAllExpenses() {
        let allValid = true;

        [...step3Inputs, ...step4Inputs].forEach(input => {
            if (!validateInput(input)) allValid = false;
        });

        step3SumErrorMsg.classList.add('d-none');
        step4SumErrorMsg.classList.add('d-none');

        if (!allValid) return false;

        const totalIncome = getTotalIncome();
        const totalExpenses = getTotalExpenses();

        if (totalExpenses > totalIncome) {
            const errorMessage = `⚠️ La suma total de gastos no puede ser mayor que la suma de ingresos (${totalIncome.toFixed(2)}€).`;

            step3SumErrorMsg.textContent = errorMessage;
            step4SumErrorMsg.textContent = errorMessage;

            step3SumErrorMsg.classList.remove('d-none');
            step4SumErrorMsg.classList.remove('d-none');

            // Limpiar campos (pero NO deshabilitarlos)
            [...step3Inputs, ...step4Inputs].forEach(input => {
                input.value = '';
                clearValidation(input);
            });

            expensesDisabledDueToExcess = true;

            return false;
        } else {
            expensesDisabledDueToExcess = false;
            toggleInputs(step3Inputs, step3Msg);
            toggleInputs(step4Inputs, step4Msg);
        }

        return true;
    }


    function init() {
        toggleInputs(step3Inputs, step3Msg);
        toggleInputs(step4Inputs, step4Msg);
        validateAllExpenses();
    }

    [salary, familyHelp, stateHelp].forEach(input => {
        if (input) {
            input.addEventListener('input', () => {
                toggleInputs(step3Inputs, step3Msg);
                toggleInputs(step4Inputs, step4Msg);
                validateAllExpenses();
            });
        }
    });

    [...step3Inputs, ...step4Inputs].forEach(input => {
        if (input) {
            input.addEventListener('input', () => {
                if (expensesDisabledDueToExcess) {

                    expensesDisabledDueToExcess = false;

                    [...step3Inputs, ...step4Inputs].forEach(i => {
                        if (getTotalIncome() > 0) {
                            i.disabled = false;
                        }
                    });

                    // Ocultar los mensajes de error
                    step3SumErrorMsg.classList.add('d-none');
                    step4SumErrorMsg.classList.add('d-none');
                }

                validateInput(input);
                validateAllExpenses();
            });
        }
    });

    init();

    window.validateSteps3and4 = () => {
        toggleInputs(step3Inputs, step3Msg);
        toggleInputs(step4Inputs, step4Msg);
        return validateAllExpenses();
    };
});
