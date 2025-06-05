let validationInitialized = false;

function initObjectiveValidation() {
    if (validationInitialized) return;
    validationInitialized = true;

    const tryInit = () => {
        const form = document.querySelector('#objectiveAdd-section form');
        if (!form) return setTimeout(tryInit, 100);

        const nameInput = form.querySelector('#objectiveName');
        const amountInput = form.querySelector('#objectiveAmount');
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!nameInput || !amountInput || !submitBtn) return;

        submitBtn.disabled = true;

        function showFeedback(input, message) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            const feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = message;
            }
        }

        function clearFeedback(input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            const feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = '';
            }
        }

        function validateName() {
            const value = nameInput.value.trim();
            if (!value) {
                showFeedback(nameInput, '⚠️ El nombre es obligatorio.');
                return false;
            }
            if (!/^[\w\sáéíóúÁÉÍÓÚüÜñÑ.,:;()'"¡!¿?\-]+$/u.test(value)) {
                showFeedback(nameInput, '⚠️ El nombre contiene caracteres inválidos.');
                return false;
            }
            if (value.length > 75) {
                showFeedback(nameInput, '⚠️ Máximo 75 caracteres.');
                return false;
            }
            clearFeedback(nameInput);
            return true;
        }

        function validateAmount() {
            const value = amountInput.value.trim();
            if (!value) {
                showFeedback(amountInput, '⚠️ El dinero es obligatorio.');
                return false;
            }
            if (!/^\d{1,10}(\.\d{1,2})?$/.test(value)) {
                if (/[a-zA-Z]/.test(value)) {
                    showFeedback(amountInput, '⚠️ Solo se permiten números. No se permiten letras.');
                } else {
                    showFeedback(amountInput, '⚠️ Máximo 10 dígitos enteros y 2 decimales.');
                }
                return false;
            }
            if (parseFloat(value) < 0) {
                showFeedback(amountInput, '⚠️ No se permiten cantidades negativas.');
                return false;
            }
            clearFeedback(amountInput);
            return true;
        }

        function updateSubmitState() {
            const valid = validateName() && validateAmount();
            submitBtn.disabled = !valid;
        }

        // Eventos
        nameInput.addEventListener('input', () => {
            validateName();
            updateSubmitState();
        });

        amountInput.addEventListener('keydown', (e) => {
            const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', 'Home', 'End', '.'];
            if (e.ctrlKey && ['a', 'c', 'v', 'x'].includes(e.key.toLowerCase())) return;
            if (allowedKeys.includes(e.key) || (e.key >= '0' && e.key <= '9')) return;
            e.preventDefault();
        });

        amountInput.addEventListener('input', () => {
            validateAmount();
            updateSubmitState();
        });

        form.addEventListener('submit', (e) => {
            const allValid = validateName() && validateAmount();
            if (!allValid) {
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

        const resetBtn = form.querySelector('#resetObjectiveForm');

        resetBtn.addEventListener('click', () => {
            form.reset();

            nameInput.classList.remove('is-valid', 'is-invalid');
            amountInput.classList.remove('is-valid', 'is-invalid');

            nameInput.nextElementSibling.textContent = '';
            amountInput.nextElementSibling.textContent = '';

            resetBtn.classList.add('d-none');

            submitBtn.disabled = true;
        });


        updateSubmitState();
    };

    tryInit();
}

function resetObjectiveFormVisualState() {
    const section = document.getElementById('objectiveAdd-section');
    const form = section?.querySelector('form');
    if (!section || !form) return;

    const observer = new MutationObserver(() => {
        if (section.classList.contains('show')) {
            form.querySelectorAll('.is-invalid, .is-valid').forEach(el =>
                el.classList.remove('is-invalid', 'is-valid')
            );
            form.querySelectorAll('.invalid-feedback').forEach(f => f.textContent = '');
        }
    });

    observer.observe(section, { attributes: true });
}

export function setObjetiveValidation() {
    initObjectiveValidation();
    resetObjectiveFormVisualState();
}
