document.addEventListener('DOMContentLoaded', function () {
    const addModal = document.getElementById('addIcon');
    const input = document.getElementById('name');
    const button = document.getElementById('buttonSubmit');
    const iconPreview = document.getElementById('iconPreviewAdd');

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

    addModal.addEventListener('show.bs.modal', function () {
        input.value = '';
        iconPreview.innerHTML = '';
        button.disabled = true;

        input.classList.remove('is-valid', 'is-invalid');
    });

    input.addEventListener('input', function () {
        const value = input.value.trim();
        const valid = value !== '' && isValidIconHtml(value);

        iconPreview.innerHTML = valid ? value : '';
        button.disabled = !valid;
        updateValidationState(valid);
    });
});