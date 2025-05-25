document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById("nameEdit");
    const form = document.getElementById("form-editCategory");
    const submitButton = document.getElementById("buttonSubmitEdit");
    const editModal = document.getElementById("editCategory");

    let hasChanged = false;

    function validateName() {
        const inputValue = nameInput.value.trim();
        const validPattern = /^[A-Za-z0-9ÁÉÍÓÚáéíóúÜüÑñ&().,\s]+$/;

        if (validPattern.test(inputValue) && inputValue.length > 0 && hasChanged) {
            nameInput.classList.remove("is-invalid");
            nameInput.classList.add("is-valid");
            submitButton.disabled = false;
        } else {
            nameInput.classList.remove("is-valid");
            if (hasChanged) {
                nameInput.classList.add("is-invalid");
            } else {
                nameInput.classList.remove("is-invalid");
            }
            submitButton.disabled = true;
        }
    }

    nameInput.addEventListener("input", function () {
        hasChanged = true;
        validateName();
    });

    form.addEventListener("submit", function (event) {
        if (!nameInput.classList.contains("is-valid")) {
            event.preventDefault();
            event.stopPropagation();
            nameInput.classList.add("is-invalid");
            submitButton.disabled = true;
        }
    });

    editModal.addEventListener("show.bs.modal", function () {
        hasChanged = false;
        nameInput.classList.remove("is-valid", "is-invalid");
        submitButton.disabled = true;
    });
});
