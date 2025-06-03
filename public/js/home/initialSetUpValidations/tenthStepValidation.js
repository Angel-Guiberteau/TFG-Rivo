document.addEventListener("DOMContentLoaded", () => {
    const accountNameInput = document.getElementById("nombre_cuenta");
    const nextBtnStep10 = document.getElementById("next10");

    function createFeedback(input) {
        const wrapper = input.closest(".field-group");
        return wrapper.querySelector(".invalid-feedback");
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

    function validateAccountName() {
        const value = accountNameInput.value.trim();

        if (!value) {
            return setInvalid(accountNameInput, "⚠️ El nombre de la cuenta es obligatorio.");
        }

        if (value.length > 75) {
            return setInvalid(accountNameInput, "⚠️ No puede superar los 75 caracteres.");
        }

        if (!/^[a-zA-Z0-9\s]+$/.test(value)) {
            return setInvalid(accountNameInput, "⚠️ Solo letras, números y espacios.");
        }

        return setValid(accountNameInput);
    }

    function isAccountNameValid() {
        const value = accountNameInput.value.trim();
        return (
            value.length > 0 &&
            value.length <= 75 &&
            /^[a-zA-Z0-9\s]+$/.test(value)
        );
    }

    function validateAllFields() {
        const allValid = isAccountNameValid();
        nextBtnStep10.disabled = !allValid;
    }

    accountNameInput.addEventListener("input", () => {
        validateAccountName();
        validateAllFields();
    });

    nextBtnStep10.addEventListener("click", (e) => {
        validateAllFields();
        if (nextBtnStep10.disabled) e.preventDefault();
    });

    nextBtnStep10.disabled = true;
});
