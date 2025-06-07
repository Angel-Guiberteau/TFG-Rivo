document.addEventListener('DOMContentLoaded', () => {
    let deletedAccounts = [];

    document.querySelectorAll('.delete-account-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const card = btn.closest('.account-card');
            const isExisting = btn.dataset.existing === 'true';

            if (isExisting) {
                deletedAccounts.push(id);
                document.getElementById('deletedAccounts').value = JSON.stringify(deletedAccounts);
            }

            card.remove();
            checkFormValidity(); // Revalidar formulario
        });
    });

    let accountCounter = 1000;

    document.getElementById('addAccountBtn')?.addEventListener('click', () => {
        const container = document.getElementById('accountsContainer');
        const index = `new_${accountCounter++}`;

        const newCard = document.createElement('div');
        newCard.className = 'col-md-6 col-lg-4 mb-4 account-card';
        newCard.innerHTML = `
            <div class="card h-100 rounded shadow overflow-hidden">
                <div class="card-body p-4 bg-white">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-account-btn" data-id="${index}" data-existing="false">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted">Nombre de la cuenta</label>
                        <input type="text" name="news[${index}][name]" class="form-control text-center">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted">Saldo</label>
                        <input type="number" step="0.01" name="news[${index}][balance]" class="form-control text-center">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted">Moneda</label>
                        <input type="text" name="news[${index}][currency]" class="form-control text-center" value="EUR">
                    </div>

                    <div class="form-check form-switch text-center">
                        <input class="form-check-input" type="checkbox" role="switch" id="enabledSwitch${index}" name="news[${index}][enabled]" value="1" checked>
                        <label class="form-check-label" for="enabledSwitch${index}">Habilitada</label>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(newCard);

        newCard.querySelector('.delete-account-btn').addEventListener('click', () => {
            newCard.remove();
            checkFormValidity();
        });

        attachValidationListeners(newCard);
    });

    function validateInput(input) {
        const name = input.name;
        const value = input.value.trim();
        let valid = false;
        let message = '';

        if (name.includes('[name]')) {
            valid = value.length > 0;
            message = valid ? '' : '⚠️ El nombre no puede estar vacío.';
        } else if (name.includes('[balance]')) {
            valid = !isNaN(value) && value !== '';
            message = valid ? '' : '⚠️ Introduce un saldo válido.';
        } else if (name.includes('[currency]')) {
            valid = value.length > 0 && value.length <= 3;
            message = valid ? '' : '⚠️ La moneda debe tener máximo 3 caracteres.';
        }

        input.classList.remove('is-valid', 'is-invalid');

        let feedback = input.parentElement.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            input.parentElement.appendChild(feedback);
        }

        if (valid) {
            input.classList.add('is-valid');
            feedback.textContent = '';
        } else {
            input.classList.add('is-invalid');
            feedback.textContent = message;
        }

        checkFormValidity();
    }

    function checkFormValidity() {
        const form = document.querySelector('#personalAccounts form');
        const inputs = form.querySelectorAll('input[type="text"], input[type="number"]');
        const submitBtn = document.getElementById('saveAccountsBtn');
        let allValid = true;

        inputs.forEach(input => {
            const value = input.value.trim();
            const isValid = input.classList.contains('is-valid');
            if (!isValid || value === '') {
                allValid = false;
            }
        });

        submitBtn.disabled = !allValid;
    }

    function attachValidationListeners(container) {
        const inputs = container.querySelectorAll('input[type="text"], input[type="number"]');
        inputs.forEach(input => {
            input.addEventListener('input', () => validateInput(input));
            validateInput(input);
        });
    }

    attachValidationListeners(document.getElementById('accountsContainer'));
});
