document.addEventListener('DOMContentLoaded', function () {
    const addModal = document.getElementById('addIcon');
    const input = document.getElementById('name');
    const button = document.getElementById('buttonSubmit');
    const iconPreview = document.getElementById('iconPreviewAdd');

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

    input.addEventListener('input', async function () {
        const value = input.value.trim();

        const structurallyValid = isValidFaClass(value);

        if (!structurallyValid) {
            iconPreview.innerHTML = '';
            button.disabled = true;
            updateValidationState(false);
            return;
        }

        const renderable = await renderAndCheckIcon(value);

        if (renderable) {
            iconPreview.innerHTML = `<i class="${value}"></i>`;
        } else {
            iconPreview.innerHTML = '';
        }

        button.disabled = !renderable;
        updateValidationState(renderable);
    });
});
