document.addEventListener("DOMContentLoaded", () => {
    const nameInput = document.getElementById('name');
    const lastNameInput = document.getElementById('last_name');
    const usernameInput = document.getElementById('username');
    const birthDateInput = document.getElementById('birth_date');
    const nextBtnStep1 = document.getElementById('next1');

    flatpickr("#birth_date", {
        dateFormat: "Y-m-d",
        locale: "es",
        maxDate: new Date().fp_incr(-6575),
        onChange: () => {
            validateField(birthDateInput);
            validateAllFields();
        }
    });

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

    function validateNameLikeField(input, fieldLabel) {
        const value = input.value.trim();
        if (!value) return setInvalid(input, `⚠️ ${fieldLabel} es obligatorio.`);
        if (value.length > 75) return setInvalid(input, `⚠️ ${fieldLabel} no puede superar los 75 caracteres.`);
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value))
            return setInvalid(input, `⚠️ ${fieldLabel} solo puede contener letras y espacios.`);
        return setValid(input);
    }

    function validateUsername() {
        const value = usernameInput.value.trim();
        if (!value) return setInvalid(usernameInput, "⚠️ El nombre de usuario es obligatorio.");
        if (value.length > 75) return setInvalid(usernameInput, "⚠️ El nombre de usuario no puede superar los 75 caracteres.");
        return setValid(usernameInput);
    }

    function validateBirthDate() {
        const value = birthDateInput.value;
        if (!value) return setInvalid(birthDateInput, "⚠️ La fecha de nacimiento es obligatoria.");

        const birthDate = new Date(value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        const dayDiff = today.getDate() - birthDate.getDate();

        const isOver18 = age > 18 || (age === 18 && (monthDiff > 0 || (monthDiff === 0 && dayDiff >= 0)));
        return isOver18
            ? setValid(birthDateInput)
            : setInvalid(birthDateInput, "⚠️ Debes ser mayor de 18 años.");
    }

    function validateField(input) {
        if (input === nameInput) return validateNameLikeField(input, "El nombre");
        if (input === lastNameInput) return validateNameLikeField(input, "Los apellidos");
        if (input === usernameInput) return validateUsername();
        if (input === birthDateInput) return validateBirthDate();
    }

    function isFieldValid(input) {
        const value = input.value.trim();

        if (input === nameInput || input === lastNameInput) {
            if (!value) return false;
            if (value.length > 75) return false;
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) return false;
            return true;
        }

        if (input === usernameInput) {
            if (!value) return false;
            if (value.length > 75) return false;
            return true;
        }

        if (input === birthDateInput) {
            if (!value) return false;
            const birthDate = new Date(value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            const dayDiff = today.getDate() - birthDate.getDate();
            return age > 18 || (age === 18 && (monthDiff > 0 || (monthDiff === 0 && dayDiff >= 0)));
        }

        return false;
    }

    function validateAllFields() {
        const allValid = 
            isFieldValid(nameInput) &&
            isFieldValid(lastNameInput) &&
            isFieldValid(usernameInput) &&
            isFieldValid(birthDateInput);

        nextBtnStep1.disabled = !allValid;
    }

    nameInput.addEventListener("input", () => {
        validateField(nameInput);
        validateAllFields();
    });

    lastNameInput.addEventListener("input", () => {
        validateField(lastNameInput);
        validateAllFields();
    });

    usernameInput.addEventListener("input", () => {
        validateField(usernameInput);
        validateAllFields();
    });

    birthDateInput.addEventListener("change", () => {
        validateField(birthDateInput);
        validateAllFields();
    });

    nextBtnStep1.addEventListener("click", (e) => {
        validateAllFields();
        if (nextBtnStep1.disabled) e.preventDefault();
    });

    nextBtnStep1.disabled = true;
});
