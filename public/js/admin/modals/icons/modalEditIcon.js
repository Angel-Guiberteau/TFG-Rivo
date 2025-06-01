document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editIcon');
    const input = document.getElementById('nameEdit');
    const button = document.getElementById('buttonSubmitEdit');
    const iconPreview = document.getElementById('iconPreviewEdit');

    let originalValue = '';

    const validFaPrefixes = ['fas', 'far', 'fal', 'fad', 'fab'];

    function isValidFaClass(classString) {
        const classList = classString.trim().split(/\s+/);
        if (classList.length < 2) return false;

        const hasValidPrefix = classList.some(cls => validFaPrefixes.includes(cls));
        const hasFaIcon = classList.some(cls => /^fa-[a-z0-9-]+$/i.test(cls));

        return hasValidPrefix && hasFaIcon;
    }

    async function renderAndCheckIcon(classString) {
        const i = document.createElement('i');
        i.className = classString;
        i.style.position = 'absolute';
        i.style.visibility = 'hidden';
        i.style.opacity = '0';
        document.body.appendChild(i);

        await new Promise(resolve => requestAnimationFrame(resolve));

        const validRender = i.offsetWidth > 0 && i.offsetHeight > 0;
        document.body.removeChild(i);
        return validRender;
    }

    function updateValidationState(isValid) {
        input.classList.toggle('is-valid', isValid);
        input.classList.toggle('is-invalid', !isValid);
    }

    editModal.addEventListener('show.bs.modal', function (event) {
        const triggerButton = event.relatedTarget;

        const iconId = triggerButton.getAttribute('data-id');
        const iconClass = triggerButton.getAttribute('data-name') || '';

        originalValue = iconClass.trim();

        document.getElementById('edit_id').value = iconId;
        input.value = iconClass;
        iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        button.disabled = true;

        input.classList.remove('is-valid', 'is-invalid');
    });

    input.addEventListener('input', async function () {
        const currentValue = input.value.trim();
        const isChanged = currentValue !== originalValue;
        const structurallyValid = isValidFaClass(currentValue);

        if (!isChanged || !structurallyValid) {
            iconPreview.innerHTML = '';
            updateValidationState(false);
            button.disabled = true;
            return;
        }

        const renderable = await renderAndCheckIcon(currentValue);

        iconPreview.innerHTML = renderable ? `<i class="${currentValue}" style="font-size: 1.5rem;"></i>` : '';
        updateValidationState(renderable);
        button.disabled = !(isChanged && renderable);
    });
});
