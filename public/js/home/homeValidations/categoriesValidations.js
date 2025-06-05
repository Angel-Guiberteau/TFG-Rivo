let validationInitialized = false;

export function initCategoryValidation() {
    if (validationInitialized) return;
    validationInitialized = true;

    const tryInit = () => {
        const form = document.querySelector('#categoryAdd-section form');
        if (!form) return setTimeout(tryInit, 100);

        const submitBtn = form.querySelector('#submitCategories');
        const resetBtn = form.querySelector('#resetCategoryButton');

        const iconInput = form.querySelector('input[name="icon"]');
        const iconFeedback = document.getElementById('icon-feedback');
        const iconOptions = form.querySelector('.icon-grid');

        const nameInput = form.querySelector('#categoryName');
        const nameFeedback = nameInput.parentElement.querySelector('.invalid-feedback');

        const checkboxes = form.querySelectorAll('input[name="types[]"]');
        const typesFeedback = document.getElementById('types-feedback');

        submitBtn.disabled = true;

        // ---- FUNCIONES AUXILIARES ----

        function showFeedback(input, feedbackEl, message) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            if (feedbackEl) {
                feedbackEl.textContent = message;
                feedbackEl.classList.remove('d-none');
            }
        }

        function clearFeedback(input, feedbackEl) {
            input.classList.remove('is-invalid');
            input.classList.remove('is-valid');
            if (feedbackEl) {
                feedbackEl.textContent = '';
                feedbackEl.classList.add('d-none');
            }
        }

        function clearValidationState() {
            nameInput.classList.remove('is-valid', 'is-invalid');
            nameFeedback.classList.add('d-none');

            const iconWrapper = form.querySelector('.icon-scroll-wrapper');
            iconWrapper.classList.remove('is-valid', 'is-invalid');
            iconFeedback.classList.add('d-none');

            const typesWrapper = form.querySelector('.categories-grid.operation-types');
            typesWrapper.classList.remove('is-valid', 'is-invalid');
            typesFeedback.classList.add('d-none');
        }

        window.clearCategoryValidation = clearValidationState;

        window.validateIcon = function validateIcon() {
            const valid = iconInput.value.trim() !== '';
            const container = form.querySelector('.icon-scroll-wrapper');
            if (!valid) {
                container.classList.add('is-invalid');
                iconFeedback.textContent = '⚠️ Debes seleccionar un icono.';
                iconFeedback.classList.remove('d-none');
            } else {
                container.classList.remove('is-invalid');
                container.classList.add('is-valid');
                iconFeedback.classList.add('d-none');
            }
            return valid;
        };

        window.validateName = function validateName() {
            const value = nameInput.value.trim();
            if (!value) {
                showFeedback(nameInput, nameFeedback, '⚠️ El nombre es obligatorio.');
                return false;
            }
            if (!/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]{1,30}$/.test(value)) {
                showFeedback(nameInput, nameFeedback, '⚠️ No se permiten caracteres especiales ni más de 30 caracteres.');
                return false;
            }
            nameInput.classList.add('is-valid');
            nameInput.classList.remove('is-invalid');
            nameFeedback.classList.add('d-none');
            return true;
        };

        window.validateTypes = function validateTypes() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            const container = form.querySelector('.categories-grid.operation-types');
            if (!anyChecked) {
                container.classList.add('is-invalid');
                typesFeedback.textContent = '⚠️ Debes seleccionar al menos un tipo de operación.';
                typesFeedback.classList.remove('d-none');
            } else {
                container.classList.remove('is-invalid');
                container.classList.add('is-valid');
                typesFeedback.classList.add('d-none');
            }
            return anyChecked;
        };

        window.updateSubmitState = function updateSubmitState() {
            const valid = validateIcon() && validateName() && validateTypes();
            submitBtn.disabled = !valid;
        };

        iconOptions.addEventListener('click', (e) => {
            const target = e.target.closest('.icon-option');
            if (!target) return;

            iconOptions.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
            target.classList.add('selected');
            iconInput.value = target.dataset.id || '';

            validateIcon();
            updateSubmitState();
        });

        ['input', 'change', 'paste', 'keyup'].forEach(evt => {
            nameInput.addEventListener(evt, () => {
                validateName();
                updateSubmitState();
            });
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                validateTypes();
                updateSubmitState();
            });
        });

        form.addEventListener('submit', (e) => {
            if (!(validateIcon() && validateName() && validateTypes())) {
                e.preventDefault();
                submitBtn.disabled = true;
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos obligatorios',
                    text: 'Revisa los campos marcados en rojo.',
                    confirmButtonText: 'Entendido'
                });
            }
        });

        resetBtn.addEventListener('click', () => {
            form.reset();
            iconInput.value = '';
            iconOptions.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
            clearValidationState();
            submitBtn.disabled = true;
        });
    };

    tryInit();
}
