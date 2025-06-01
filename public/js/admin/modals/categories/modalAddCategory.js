document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById("name");
    const form = document.getElementById("form-addCategory");
    const submitButton = document.getElementById("buttonSubmit");
    const addModal = document.getElementById("addCategory");

    const typeCheckboxes = document.querySelectorAll(".type-checkbox");
    const iconRadios = document.querySelectorAll(".icon-radio");

    function isTypeSelected() {
        return Array.from(typeCheckboxes).some(checkbox => checkbox.checked);
    }

    function isIconSelected() {
        return Array.from(iconRadios).some(radio => radio.checked);
    }

    function validateName() {
        const inputValue = nameInput.value.trim();
        const validPattern = /^[A-Za-z0-9ÁÉÍÓÚáéíóúÜüÑñ&().,\s]+$/;

        if (validPattern.test(inputValue) && inputValue.length > 0) {
            nameInput.classList.remove("is-invalid");
            nameInput.classList.add("is-valid");
            return true;
        } else {
            nameInput.classList.remove("is-valid");
            nameInput.classList.add("is-invalid");
            return false;
        }
    }

    function validateForm() {
        const nameValid = validateName();
        const typeValid = isTypeSelected();
        const iconValid = isIconSelected();

        submitButton.disabled = !(nameValid && typeValid && iconValid);
    }

    nameInput.addEventListener("input", validateForm);
    typeCheckboxes.forEach(checkbox => checkbox.addEventListener("change", validateForm));
    iconRadios.forEach(radio => radio.addEventListener("change", validateForm));

    form.addEventListener("submit", function (event) {
        if (submitButton.disabled) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    addModal.addEventListener("show.bs.modal", function () {
        nameInput.classList.remove("is-valid", "is-invalid");
        nameInput.value = "";
        typeCheckboxes.forEach(cb => cb.checked = false);
        iconRadios.forEach(r => r.checked = false);
        submitButton.disabled = true;
    });
});
