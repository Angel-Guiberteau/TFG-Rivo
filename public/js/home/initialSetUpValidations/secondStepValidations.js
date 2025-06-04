document.addEventListener("DOMContentLoaded", () => {
    const salaryInput = document.getElementById("salary");
    const familyHelpInput = document.getElementById("familyHelp");
    const stateHelpInput = document.getElementById("stateHelp");

    const moneyInputs = [salaryInput, familyHelpInput, stateHelpInput];

    function createFeedback(input) {
        const wrapper = input.closest('.field-group');
        return wrapper.querySelector('.invalid-feedback');
    }

    function setValid(input) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        createFeedback(input).textContent = "";
        return true;
    }

    function setInvalid(input, message) {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        createFeedback(input).textContent = message;
        return false;
    }

    function validateMoneyField(input, label) {
        const value = input.value.trim();

        if (!value) {
            input.classList.remove("is-valid", "is-invalid");
            createFeedback(input).textContent = "";
            return true;
        }

        const number = parseFloat(value);

        if (isNaN(number)) {
            return setInvalid(input, `⚠️ ${label} debe ser un número válido.`);
        }

        if (number < 0) {
            return setInvalid(input, `⚠️ ${label} no puede ser negativo.`);
        }

        const [integerPart, decimalPart] = value.split('.');
        if (integerPart.length > 10) {
            return setInvalid(input, `⚠️ ${label} no puede tener más de 10 cifras enteras.`);
        }

        if (decimalPart && decimalPart.length > 2) {
            return setInvalid(input, `⚠️ ${label} solo puede tener hasta 2 decimales.`);
        }

        return setValid(input);
    }

    moneyInputs.forEach(input => {
        input.addEventListener("keydown", (e) => {
            const allowedKeys = [
                "Backspace", "Tab", "ArrowLeft", "ArrowRight", "Delete", ".",
            ];

            if ((e.ctrlKey || e.metaKey) && ["a", "c", "v", "x"].includes(e.key.toLowerCase())) return;

            if (allowedKeys.includes(e.key)) return;

            if (!/^\d$/.test(e.key)) {
                e.preventDefault();
            }
        });

        input.addEventListener("input", () => validateMoneyField(input, input.placeholder));
    });
});
