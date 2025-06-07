document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('objectivesForm');
    const addBtn = document.getElementById('addAObjectiveBtn');
    const accordion = document.getElementById('objectivesAccordion');
    const deletedInput = document.getElementById('deletedObjectives');

    let objectiveIndex = accordion.querySelectorAll('.objective-card').length;

    addBtn.addEventListener('click', function () {
        const currentIndex = objectiveIndex++;


        accordion.querySelectorAll('.accordion-collapse').forEach(collapseEl => {
            const instance = bootstrap.Collapse.getInstance(collapseEl)
                || new bootstrap.Collapse(collapseEl, { toggle: false });
            instance.hide();
        });

        
        const template = `
            <div class="accordion-item mb-3 shadow-sm border-0 rounded-3 objective-card" data-index="${currentIndex}" data-id="">
                <h2 class="accordion-header" id="heading${currentIndex}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse${currentIndex}" aria-expanded="true" aria-controls="collapse${currentIndex}">
                        Objetivo: Nuevo
                    </button>
                </h2>
                <div id="collapse${currentIndex}" class="accordion-collapse collapse" aria-labelledby="heading${currentIndex}">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del objetivo</label>
                                <input type="text" name="objectives[${currentIndex}][name]" class="form-control objective-name"
                                    value="" required maxlength="100" data-original="">
                                <div class="valid-feedback">✅ ¡Correcto!</div>
                                <div class="invalid-feedback">⚠️ El nombre es obligatorio y máximo 100 caracteres.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Dinero objetivo</label>
                                <input type="number" name="objectives[${currentIndex}][target_amount]" class="form-control target-amount"
                                    step="0.01" required value="" data-original="">
                                <div class="valid-feedback">✅ ¡Correcto!</div>
                                <div class="invalid-feedback">⚠️ Debe ser un número positivo.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Dinero actual</label>
                                <input type="number" name="objectives[${currentIndex}][current_amount]" class="form-control current-amount"
                                    step="0.01" required value="" data-original="">
                                <div class="valid-feedback">✅ ¡Correcto!</div>
                                <div class="invalid-feedback">⚠️ Debe ser un número positivo.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha límite</label>
                                <input type="date" name="objectives[${currentIndex}][deadline]" class="form-control deadline"
                                    value="" data-original="">
                                <div class="valid-feedback">✅ ¡Correcto!</div>
                                <div class="invalid-feedback">⚠️ La fecha debe ser hoy o posterior.</div>
                            </div>

                            <div class="col-md-4 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="objectives[${currentIndex}][enabled]"
                                        value="1" data-original="0">
                                    <label class="form-check-label">Habilitado</label>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex align-items-center justify-content-end">
                                <input type="hidden" name="objectives[${currentIndex}][id]" value="">
                                <button type="button" class="btn btn-danger btn-sm remove-objective-btn" data-objective-id="">
                                    <i class="fas fa-trash-alt me-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        accordion.insertAdjacentHTML('beforeend', template);

        const newCollapseEl = document.getElementById(`collapse${currentIndex}`);
        const newCollapseInstance = new bootstrap.Collapse(newCollapseEl, { toggle: false });
        newCollapseInstance.show();

        validateObjectives(); 
    });

    accordion.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-objective-btn');
        if (!btn) return;

        const card = btn.closest('.objective-card');
        const idInput = card.querySelector('input[name$="[id]"]');
        const idValue = idInput?.value;

        if (idValue) {
            const currentDeleted = JSON.parse(deletedInput.value || '[]');
            currentDeleted.push(idValue);
            deletedInput.value = JSON.stringify(currentDeleted);
        }

        card.remove();
        validateObjectives();
    });

    form.addEventListener('input', validateObjectives);

    function validateObjectives() {
        const cards = accordion.querySelectorAll('.objective-card');
        let allValid = true;
        const today = new Date().toISOString().split('T')[0];

        cards.forEach(card => {
            const name = card.querySelector('.objective-name');
            const target = card.querySelector('.target-amount');
            const current = card.querySelector('.current-amount');
            const deadline = card.querySelector('.deadline');

            if (!name.value.trim() || name.value.length > 100) {
                name.classList.add('is-invalid');
                name.classList.remove('is-valid');
                allValid = false;
            } else {
                name.classList.remove('is-invalid');
                name.classList.add('is-valid');
            }

            if (!target.value || parseFloat(target.value) < 0) {
                target.classList.add('is-invalid');
                target.classList.remove('is-valid');
                allValid = false;
            } else {
                target.classList.remove('is-invalid');
                target.classList.add('is-valid');
            }

            if (!current.value || parseFloat(current.value) < 0) {
                current.classList.add('is-invalid');
                current.classList.remove('is-valid');
                allValid = false;
            } else {
                current.classList.remove('is-invalid');
                current.classList.add('is-valid');
            }

            if (deadline.value && deadline.value < today) {
                deadline.classList.add('is-invalid');
                deadline.classList.remove('is-valid');
                allValid = false;
            } else {
                deadline.classList.remove('is-invalid');
                deadline.classList.add('is-valid');
            }
        });

        document.getElementById('submitObjectivesBtn').disabled = !allValid;
    }

    form.addEventListener('submit', function () {
        const cards = accordion.querySelectorAll('.objective-card');
        const newObjectives = [];
        const existingObjectives = [];

        cards.forEach(card => {
            const idInput = card.querySelector('input[name$="[id]"]');
            const id = idInput?.value;

            const objectiveData = {
                name: card.querySelector('.objective-name')?.value.trim() || '',
                target_amount: card.querySelector('.target-amount')?.value,
                current_amount: card.querySelector('.current-amount')?.value,
                deadline: card.querySelector('.deadline')?.value,
                enabled: card.querySelector('input[type="checkbox"]')?.checked ? 1 : 0
            };

            if (id) {
                objectiveData.id = id;
                existingObjectives.push(objectiveData);
            } else {
                newObjectives.push(objectiveData);
            }
        });

        console.log('Nuevos:', newObjectives);
        console.log('Existentes:', existingObjectives);

        insertOrUpdateHiddenInput('newObjectives', JSON.stringify(newObjectives));
        insertOrUpdateHiddenInput('existingObjectives', JSON.stringify(existingObjectives));
    });

    function insertOrUpdateHiddenInput(name, value) {
        let input = form.querySelector(`input[name="${name}"]`);
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            form.appendChild(input);
        }
        input.value = value;
    }
});
