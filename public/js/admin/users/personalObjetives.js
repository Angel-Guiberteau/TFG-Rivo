document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('objectivesForm');
    let objectiveIndex = parseInt(form.dataset.initialIndex) || 0;
    const addBtn = document.getElementById('addAObjectiveBtn');
    const accordion = document.getElementById('objectivesAccordion');
    const deleted = new Set();
    const news = new Set();

    addBtn.addEventListener('click', function () {
        const template = `
            <div class="accordion-item mb-3 shadow-sm border-0 rounded-3 objective-card" data-index="${objectiveIndex}">
                <h2 class="accordion-header" id="heading${objectiveIndex}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${objectiveIndex}" aria-expanded="true" aria-controls="collapse${objectiveIndex}">
                        Objetivo: Nuevo
                    </button>
                </h2>
                <div id="collapse${objectiveIndex}" class="accordion-collapse collapse show" aria-labelledby="heading${objectiveIndex}">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del objetivo</label>
                                <input type="text" name="objectives[${objectiveIndex}][name]" class="form-control objective-name" required maxlength="100">
                                <div class="valid-feedback">¡Correcto!</div>
                                <div class="invalid-feedback">El nombre es obligatorio y máximo 100 caracteres.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Monto objetivo</label>
                                <input type="number" name="objectives[${objectiveIndex}][target_amount]" class="form-control target-amount" step="0.01" required>
                                <div class="valid-feedback">¡Correcto!</div>
                                <div class="invalid-feedback">Debe ser un número positivo.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Monto actual</label>
                                <input type="number" name="objectives[${objectiveIndex}][current_amount]" class="form-control current-amount" step="0.01" required>
                                <div class="valid-feedback">¡Correcto!</div>
                                <div class="invalid-feedback">Debe ser un número positivo.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha límite</label>
                                <input type="date" name="objectives[${objectiveIndex}][deadline]" class="form-control deadline">
                                <div class="valid-feedback">¡Correcto!</div>
                                <div class="invalid-feedback">La fecha debe ser hoy o posterior.</div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-check form-switch me-2">
                                    <input class="form-check-input" type="checkbox" name="objectives[${objectiveIndex}][enabled]" value="1">
                                    <label class="form-check-label">Habilitado</label>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-objective-btn">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        accordion.insertAdjacentHTML('beforeend', template);

        news.add(objectiveIndex);

        const collapseEl = document.getElementById(`collapse${objectiveIndex}`);
        new bootstrap.Collapse(collapseEl, { toggle: true });

        objectiveIndex++;
        updateTrackingInputs();
        validateObjectives();
    });

    accordion.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-objective-btn')) {
            const card = e.target.closest('.objective-card');
            const idInput = card.querySelector('input[name$="[id]"]');
            const index = card.dataset.index;

            if (idInput && idInput.value) {
                deleted.add(idInput.value);
            }

            if (news.has(parseInt(index))) {
                news.delete(parseInt(index));
            }

            card.remove();
            updateTrackingInputs();
            validateObjectives();
        }
    });

    form.addEventListener('input', () => {
        validateObjectives();
    });

    function updateTrackingInputs() {
        document.getElementById('deletedObjectives').value = JSON.stringify(Array.from(deleted));
        document.getElementById('newObjectives').value = JSON.stringify(Array.from(news));
    }

    function validateObjectives() {
        const cards = form.querySelectorAll('.objective-card');
        let allValid = true;
        const today = new Date().toISOString().split('T')[0];

        cards.forEach(card => {
            const name = card.querySelector('.objective-name');
            const target = card.querySelector('.target-amount');
            const current = card.querySelector('.current-amount');
            const deadline = card.querySelector('.deadline');

            if (!name.value.trim() || name.value.trim().length > 100) {
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

        const submitBtn = document.getElementById('submitObjectivesBtn');
        if (submitBtn) {
            submitBtn.disabled = !allValid;
        }
    }

    validateObjectives();
});