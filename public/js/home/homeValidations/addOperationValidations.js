function initializeFormValidation() {
    const tryInit = () => {
        const form = document.querySelector('#operationAddForm-section form');
        const submitBtn = form?.querySelector('button[type="submit"]');
        if (!form || !submitBtn) {
            setTimeout(tryInit, 100);
            return;
        }

        const typeInputs = form.querySelectorAll('input[name="movement_type"]');
        const categoryInputs = form.querySelectorAll('input[name="category_id"]');
        const subjectInput = form.querySelector('#subject');
        const descriptionInput = form.querySelector('#description');
        const dateInput = form.querySelector('#date');
        const amountInput = form.querySelector('#amount');
        const scheduleCheckbox = form.querySelector('#scheduleIncome');
        const recurrenceSelect = form.querySelector('#period');
        const startDateInput = form.querySelector('#start_date');
        const expirationDateInput = form.querySelector('#expiration_date');

        function showFeedback(input, message) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            let feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = message;
            }
        }

        function clearFeedback(input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            let feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = '';
            }
        }

        function validateRadioGroup(inputs, groupSelector, message) {
            const group = form.querySelector(groupSelector);
            const selected = Array.from(inputs).some(i => i.checked);
            const feedback = group.querySelector('.invalid-feedback');
            if (selected) {
                group.classList.remove('is-invalid-radio');
                group.classList.add('is-valid-radio');
                if (feedback) feedback.textContent = '';
            } else {
                group.classList.remove('is-valid-radio');
                group.classList.add('is-invalid-radio');
                if (feedback) feedback.textContent = message;
            }
            return selected;
        }

        function validateSubject() {
            const value = subjectInput.value.trim();
            if (!value) {
                showFeedback(subjectInput, '⚠️ El asunto es obligatorio.');
                return false;
            }
            if (!/^[\w\sáéíóúÁÉÍÓÚüÜñÑ.,:;()'"¡!¿?\-]+$/u.test(value)) {
                showFeedback(subjectInput, '⚠️ El asunto contiene caracteres inválidos.');
                return false;
            }
            if (value.length > 75) {
                showFeedback(subjectInput, '⚠️ Máximo 75 caracteres.');
                return false;
            }
            clearFeedback(subjectInput);
            return true;
        }

        function validateDescription() {
            const value = descriptionInput.value.trim();
            if (!value) {
                showFeedback(descriptionInput, '⚠️ La descripción es obligatoria.');
                return false;
            }
            if (!/^[\w\sáéíóúÁÉÍÓÚüÜñÑ.,:;()'"¡!¿?\-]+$/u.test(value)) {
                showFeedback(descriptionInput, '⚠️ La descripción contiene caracteres inválidos.');
                return false;
            }
            if (value.length > 255) {
                showFeedback(descriptionInput, '⚠️ Máximo 255 caracteres.');
                return false;
            }
            clearFeedback(descriptionInput);
            return true;
        }

        function validateDate(input, allowFuture = false) {
            const value = input.value;
            if (!value) {
                showFeedback(input, '⚠️ Campo obligatorio.');
                return false;
            }
            const inputDate = new Date(value);
            const now = new Date();
            if (!allowFuture && inputDate > now) {
                showFeedback(input, '⚠️ No se permiten fechas futuras.');
                return false;
            }
            if (allowFuture && inputDate < now) {
                showFeedback(input, '⚠️ No se permiten fechas pasadas.');
                return false;
            }
            clearFeedback(input);
            return true;
        }

        function validateAmount() {
            const value = amountInput.value.trim();
            if (!value) {
                showFeedback(amountInput, '⚠️ La cantidad es obligatoria.');
                return false;
            }
            if (!/^\d{1,10}(\.\d{1,2})?$/.test(value)) {
                showFeedback(amountInput, '⚠️ Máximo 10 dígitos y 2 decimales.');
                return false;
            }
            if (parseFloat(value) < 0) {
                showFeedback(amountInput, '⚠️ No se permiten cantidades negativas.');
                return false;
            }
            clearFeedback(amountInput);
            return true;
        }

        function validateRecurrenceFields() {
            let valid = true;
            if (scheduleCheckbox.checked) {
                if (!recurrenceSelect.value.trim()) {
                    showFeedback(recurrenceSelect, '⚠️ Selecciona una recurrencia.');
                    valid = false;
                } else {
                    clearFeedback(recurrenceSelect);
                }

                valid &= validateDate(startDateInput, false);
                if (expirationDateInput.value) {
                    const expValid = validateDate(expirationDateInput, true);
                    valid &= expValid;
                } else {
                    clearFeedback(expirationDateInput);
                }
            } else {
                [recurrenceSelect, startDateInput, expirationDateInput].forEach(clearFeedback);
            }
            return valid;
        }

        function validateAll() {
            const valid =
                validateRadioGroup(typeInputs, '.validation-group-type', '⚠️ Selecciona un tipo.') &
                validateRadioGroup(categoryInputs, '.validation-group-category', '⚠️ Selecciona una categoría.') &
                validateSubject() &
                validateDescription() &
                validateDate(dateInput, false) &
                validateAmount() &
                validateRecurrenceFields();

            submitBtn.disabled = !valid;
        }

        [
            subjectInput,
            descriptionInput,
            dateInput,
            amountInput,
            recurrenceSelect,
            startDateInput,
            expirationDateInput,
        ].forEach(input => {
            if (!input) return;
            input.addEventListener('input', validateAll);
            input.addEventListener('change', validateAll);
        });

        [...typeInputs, ...categoryInputs, scheduleCheckbox].forEach(input => {
            if (!input) return;
            input.addEventListener('change', validateAll);
        });

        form.addEventListener('submit', e => {
            validateAll();
            if (submitBtn.disabled) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos obligatorios',
                    text: 'Revisa los campos marcados en rojo.',
                    confirmButtonText: 'Entendido'
                });
            }
        });

        validateAll(); 
    };

    tryInit();
}


function setupAddFormAutoReset() {
    const formSection = document.getElementById('operationAddForm-section');
    const form = formSection?.querySelector('form');

    if (!formSection || !form) return;

    const observer = new MutationObserver(() => {
        if (formSection.classList.contains('show')) {
            form.querySelectorAll('.is-invalid, .is-valid, .is-invalid-radio, .is-valid-radio')
                .forEach(el => el.classList.remove('is-invalid', 'is-valid', 'is-invalid-radio', 'is-valid-radio'));

            form.querySelectorAll('.invalid-feedback').forEach(f => f.textContent = '');
        }
    });

    observer.observe(formSection, { attributes: true });
}

export function setupFormValidation() {
    initializeFormValidation();
    setupAddFormAutoReset();
}

setupFormValidation();
