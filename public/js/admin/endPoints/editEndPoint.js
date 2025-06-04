document.addEventListener('DOMContentLoaded', () => {
    const form       = document.getElementById('form-safeEditEndPoint');
    const submitBtn  = document.getElementById('submit-endPoint');
    const addRowBtn  = document.getElementById('add-return-row');
    const returnZone = document.getElementById('return-container');

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

    const originalValues = new Map();

    // Asignar valores originales con índice por orden
    form.querySelectorAll('input, textarea').forEach((input, index) => {
        input.dataset.index = index;
        originalValues.set(input.name + '-' + index, input.value.trim());
    });

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
        const original = originalValues.get(input.name + '-' + input.dataset.index);

        if (value === original) {
            input.classList.remove('is-valid', 'is-invalid');
            const helper = input.parentNode.querySelector('.validation-message');
            if (helper) helper.remove();
            return null; // sin cambio, no marcar
        }

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
            const original = originalValues.get(input.name + '-' + input.dataset.index);
            const changed = input.value.trim() !== original;
            return !isRequired || !changed || isValid;
        });
    };

    const hasAnyChange = () => {
        return Array.from(form.querySelectorAll('input, textarea')).some(input => {
            const key = input.name + '-' + input.dataset.index;
            return input.value.trim() !== (originalValues.get(key) ?? '');
        });
    };

    const updateSubmitState = () => {
        submitBtn.disabled = !(checkAllFieldsValid() && hasAnyChange());
    };

    form.querySelectorAll('input, textarea').forEach(inp => {
        inp.addEventListener('input', () => {
            validateField(inp);
            updateSubmitState();
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

            row.querySelectorAll('input').forEach((inp, index) => {
                inp.dataset.index = `${Date.now()}-${index}`;
                originalValues.set(inp.name + '-' + inp.dataset.index, '');
                inp.addEventListener('input', () => {
                    validateField(inp);
                    updateSubmitState();
                });
            });

            row.querySelector('.remove-row').addEventListener('click', () => {
                row.remove();
                updateSubmitState();
            });
        });
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const allValid = checkAllFieldsValid();
        if (!allValid || !hasAnyChange()) return;

        const returnInputs = Array.from(form.querySelectorAll('input[name="returnName[]"]'));
        const typeInputs   = Array.from(form.querySelectorAll('input[name="type[]"]'));

        const pairs = returnInputs.map((inp, i) => {
            const key = inp.value.trim();
            const type = typeInputs[i]?.value.trim() ?? '';
            return `'${key}' ${type}`;
        });

        const formattedReturn = `[${pairs.join(' | ')}]`;

        const formData = new FormData(form);
        formData.append('returnData', formattedReturn);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });

            const swalBox = document.createElement('div');
            swalBox.style.position = 'fixed';
            swalBox.style.bottom = '1rem';
            swalBox.style.right = '1rem';
            swalBox.style.minWidth = '300px';
            swalBox.style.maxWidth = '90%';
            swalBox.style.textAlign = 'center';
            swalBox.style.padding = '0.8rem 1.5rem';
            swalBox.style.borderRadius = '8px';
            swalBox.style.fontSize = '0.9rem';
            swalBox.style.zIndex = 9999;
            swalBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';

            if (response.ok) {
                const data = await response.json();

                const swalBox = document.createElement('div');
                swalBox.textContent = data.success || data.error || "Respuesta inesperada";
                swalBox.style.position = 'fixed';
                swalBox.style.bottom = '1rem';
                swalBox.style.right = '1rem';
                swalBox.style.minWidth = '300px';
                swalBox.style.maxWidth = '90%';
                swalBox.style.textAlign = 'center';
                swalBox.style.padding = '0.8rem 1.5rem';
                swalBox.style.borderRadius = '8px';
                swalBox.style.fontSize = '0.9rem';
                swalBox.style.zIndex = 9999;
                swalBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';

                if (data.success) {
                    sessionStorage.setItem('swalMessage', data.success);
                    setTimeout(() => {
                        window.location.href = '/admin/endPoints';
                    });
                } else {
                    swalBox.style.backgroundColor = '#f2dede';
                    swalBox.style.color = '#a94442';
                    swalBox.style.border = '1px solid #ebccd1';
                    document.body.appendChild(swalBox);

                    setTimeout(() => swalBox.remove(), 3000);
                }
            } else {
                const swalBox = document.createElement('div');
                swalBox.textContent = "Hubo un problema en el servidor.";
                swalBox.style.position = 'fixed';
                swalBox.style.bottom = '1rem';
                swalBox.style.right = '1rem';
                swalBox.style.minWidth = '300px';
                swalBox.style.maxWidth = '90%';
                swalBox.style.textAlign = 'center';
                swalBox.style.padding = '0.8rem 1.5rem';
                swalBox.style.backgroundColor = '#f2dede'; 
                swalBox.style.color = '#a94442';
                swalBox.style.border = '1px solid #ebccd1';
                swalBox.style.borderRadius = '8px';
                swalBox.style.fontSize = '0.9rem';
                swalBox.style.zIndex = 9999;
                swalBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
                document.body.appendChild(swalBox);
                setTimeout(() => swalBox.remove(), 3000);
            }
        } catch (error) {
            console.error("Error al procesar la solicitud:", error);
            const swalBox = document.createElement('div');
            swalBox.textContent = "Hubo un problema en el servidor.";
            swalBox.style.position = 'fixed';
            swalBox.style.bottom = '1rem';
            swalBox.style.right = '1rem';
            swalBox.style.minWidth = '300px';
            swalBox.style.maxWidth = '90%';
            swalBox.style.textAlign = 'center';
            swalBox.style.padding = '0.8rem 1.5rem';
            swalBox.style.backgroundColor = '#f2dede'; 
            swalBox.style.color = '#a94442';
            swalBox.style.border = '1px solid #ebccd1';
            swalBox.style.borderRadius = '8px';
            swalBox.style.fontSize = '0.9rem';
            swalBox.style.zIndex = 9999;
            swalBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
            document.body.appendChild(swalBox);
            setTimeout(() => location.reload(), 2000);
        }
    });

    updateSubmitState();
});
