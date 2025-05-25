document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById("name");
    const form = document.getElementById("form-addCategory");
    const submitButton = document.getElementById("buttonSubmit");
    const addModal = document.getElementById("addCategory");

    function validateName() {
        const inputValue = nameInput.value.trim();
        const validPattern = /^[A-Za-z0-9ÁÉÍÓÚáéíóúÜüÑñ&().,\s]+$/;

        if (validPattern.test(inputValue) && inputValue.length > 0) {
            nameInput.classList.remove("is-invalid");
            nameInput.classList.add("is-valid");
            submitButton.disabled = false;
        } else {
            nameInput.classList.remove("is-valid");
            nameInput.classList.add("is-invalid");
            submitButton.disabled = true;
        }
    }

    nameInput.addEventListener("input", validateName);

    form.addEventListener("submit", function (event) {
        if (!nameInput.classList.contains("is-valid")) {
            event.preventDefault();
            event.stopPropagation();
            nameInput.classList.add("is-invalid");
            submitButton.disabled = true;
        }
    });

    addModal.addEventListener("show.bs.modal", function () {
        nameInput.classList.remove("is-valid", "is-invalid");
        nameInput.value = "";
        submitButton.disabled = true;
    });
});
