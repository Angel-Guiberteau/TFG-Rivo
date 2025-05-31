document.addEventListener("DOMContentLoaded", function () {
    let initialName = "";
    let initialTypes = [];
    let initialIcon = null;

    const nameInput = document.getElementById("nameEdit");
    const submitButton = document.getElementById("buttonSubmitEdit");
    const typeCheckboxes = document.querySelectorAll(".type-checkbox-edit");
    const iconRadios = document.querySelectorAll(".icon-radio-edit");
    const form = document.getElementById("form-editCategory");
    const modalElement = document.getElementById("editCategory");

    function getCheckedTypes() {
        return Array.from(typeCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value)
            .sort();
    }

    function getCheckedIcon() {
        const checkedRadio = Array.from(iconRadios).find(radio => radio.checked);
        return checkedRadio ? checkedRadio.value : null;
    }

    function checkChanges() {
        const currentName = nameInput.value.trim();
        const currentTypes = getCheckedTypes();
        const currentIcon = getCheckedIcon();

        if (currentName !== initialName) return true;
        if (currentTypes.length !== initialTypes.length) return true;
        for (let i = 0; i < currentTypes.length; i++) {
            if (currentTypes[i] !== initialTypes[i]) return true;
        }
        if (currentIcon !== initialIcon) return true;

        return false;
    }

    function validateName() {
        const inputValue = nameInput.value.trim();
        const validPattern = /^[A-Za-z0-9ÁÉÍÓÚáéíóúÜüÑñ&().,\s]+$/;
        const isValid = validPattern.test(inputValue) && inputValue.length > 0;

        nameInput.classList.toggle("is-valid", isValid);
        nameInput.classList.toggle("is-invalid", !isValid && checkChanges());

        return isValid;
    }

    function validateType() {
        return getCheckedTypes().length > 0;
    }

    function validateIcon() {
        return getCheckedIcon() !== null;
    }

    function validateForm() {
        const nameValid = validateName();
        const typeValid = validateType();
        const iconValid = validateIcon();
        const changesMade = checkChanges();

        submitButton.disabled = !(nameValid && typeValid && iconValid && changesMade);
    }

    // Listener para abrir modal y rellenar inputs con data attributes del botón clicado
    modalElement.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // botón que disparó el modal
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const types = JSON.parse(button.getAttribute('data-types'));
        const iconId = parseInt(button.getAttribute('data-icon'));

        document.getElementById("edit_id").value = id;
        nameInput.value = name;

        typeCheckboxes.forEach(cb => {
            cb.checked = types.includes(parseInt(cb.value));
        });

        iconRadios.forEach(radio => {
            radio.checked = parseInt(radio.value) === iconId;
        });

        initialName = nameInput.value.trim();
        initialTypes = getCheckedTypes();
        initialIcon = getCheckedIcon();

        nameInput.classList.remove("is-valid", "is-invalid");
        submitButton.disabled = true;

        validateForm();
    });

    nameInput.addEventListener("input", validateForm);
    typeCheckboxes.forEach(cb => cb.addEventListener("change", validateForm));
    iconRadios.forEach(radio => radio.addEventListener("change", validateForm));

    form.addEventListener("submit", function (event) {
        if (submitButton.disabled) {
            event.preventDefault();
            event.stopPropagation();
            nameInput.classList.add("is-invalid");
        }
    });
});
