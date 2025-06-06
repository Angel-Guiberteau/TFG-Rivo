document.addEventListener('DOMContentLoaded', () => {
    const form          = document.getElementById('form-safeEndPoint');
    const submitBtn     = document.getElementById('submit-endPoint');
    const addRowBtn     = document.getElementById('add-return-row');
    const returnZone    = document.getElementById('return-container');

    if (!form || !submitBtn) return;

    const fieldLimits = {
        name: 75,
        url: 255,
        method: 7,
        parameters: 75,
        return: 15,
        description: 255,
        'returnName[]': 15,
        'type[]': 15
    };

    const safePattern = /^[\w\s\-\/.\{\}\[\]:ñÑáéíóúÁÉÍÓÚüÜ]*$/;

    const paint = (input, ok, msg) => {
        input.classList.remove('is-valid', 'is-invalid');
        input.classList.add(ok ? 'is-valid' : 'is-invalid');

        let helper = input.parentNode.querySelector('.validation-message');
        if (!helper) {
            helper = document.createElement('div');
            helper.className = 'validation-message mt-1 small';
            input.parentNode.appendChild(helper);
        }
        helper.textContent = msg;
        helper.classList.remove('text-danger', 'text-success');
        helper.classList.add(ok ? 'text-success' : 'text-danger');
    };

    const validateField = input => {
        const name   = input.name;
        const value  = input.value.trim();
        const maxLen = fieldLimits[name] ?? 255;
        const req    = input.hasAttribute('required');

        if (req && value === '') {
            paint(input, false, 'Este campo es obligatorio.');
            return false;
        }
        if (value.length > maxLen) {
            paint(input, false, `Máximo ${maxLen} caracteres.`);
            return false;
        }
        if (!safePattern.test(value)) {
            paint(input, false, 'Caracteres no permitidos.');
            return false;
        }
        paint(input, true, 'Campo válido.');
        return true;
    };

    const checkAllFieldsValid = () => {
        return Array.from(form.querySelectorAll('input, textarea')).every(input => {
            const isRequired = input.hasAttribute('required');
            const isValid = input.classList.contains('is-valid');
            return !isRequired || isValid;
        });
    };

    form.querySelectorAll('input, textarea').forEach(inp => {
        inp.addEventListener('input', () => {
            validateField(inp);
            submitBtn.disabled = !checkAllFieldsValid();
        });
    });

    if (addRowBtn && returnZone) {
        addRowBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'return-row row g-2 mb-2';
            row.innerHTML = `
                <div class="col-5">
                    <input type="text" name="returnName[]" class="form-control" placeholder="Dato" maxlength="15" required>
                </div>
                <div class="col-5">
                    <input type="text" name="type[]" class="form-control" placeholder="Tipo" maxlength="15" required>
                </div>
                <div class="col-2 d-flex align-items-start">
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            returnZone.insertBefore(row, addRowBtn);

            row.querySelectorAll('input').forEach(inp => {
                inp.addEventListener('input', () => {
                    validateField(inp);
                    submitBtn.disabled = !checkAllFieldsValid();
                });
            });

            row.querySelector('.remove-row').addEventListener('click', () => {
                row.remove();
                submitBtn.disabled = !checkAllFieldsValid();
            });
        });
    }

    form.addEventListener('submit', (e) => {
        const allValid = Array.from(form.querySelectorAll('input, textarea')).every(inp => {
            return !inp.hasAttribute('required') || inp.classList.contains('is-valid');
        });

        if (!allValid) {
            e.preventDefault(); // detener si hay errores
            return;
        }

        const returnInputs = Array.from(form.querySelectorAll('input[name="returnName[]"]'));
        const typeInputs   = Array.from(form.querySelectorAll('input[name="type[]"]'));

        const pairs = returnInputs.map((inp, i) => {
            const key = inp.value.trim();
            const type = typeInputs[i]?.value.trim() ?? '';
            return `'${key}' ${type}`;
        });

        const formattedReturn = `[${pairs.join(' | ')}]`;

        let hidden = form.querySelector('input[name="returnData"]');
        if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'returnData';
            form.appendChild(hidden);
        }
        hidden.value = formattedReturn;
    });
});
