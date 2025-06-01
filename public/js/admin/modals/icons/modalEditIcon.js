document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editIcon');
    const input = document.getElementById('nameEdit');
    const button = document.getElementById('buttonSubmitEdit');
    const iconPreview = document.getElementById('iconPreviewEdit');

    let originalValue = '';

    function isValidIconHtml(html) {
        const temp = document.createElement('div');
        temp.innerHTML = html.trim();

        if (temp.childNodes.length !== 1) return false;

        const node = temp.childNodes[0];
        return node.nodeType === 1
            && node.tagName.toLowerCase() === 'i'
            && node.className.trim() !== '';
    }

    function updateValidationState(isValid) {
        if (isValid) {
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
        } else {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
        }
    }

    editModal.addEventListener('show.bs.modal', function (event) {
        const triggerButton = event.relatedTarget;

        const iconId = triggerButton.getAttribute('data-id');
        const iconHTML = triggerButton.getAttribute('data-name');

        originalValue = iconHTML.trim();

        document.getElementById('edit_id').value = iconId;
        input.value = iconHTML;
        iconPreview.innerHTML = iconHTML;
        button.disabled = true;

        input.classList.remove('is-valid', 'is-invalid');
    });

    input.addEventListener('input', function () {
        const currentValue = input.value.trim();
        const isChanged = currentValue !== originalValue;
        const isValid = isValidIconHtml(currentValue);

        iconPreview.innerHTML = isValid ? currentValue : '';

        button.disabled = !(isChanged && isValid);
        updateValidationState(isChanged && isValid);
    });
});