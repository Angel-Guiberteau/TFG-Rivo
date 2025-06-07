document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.progress-line-container .step');
    const sections = {
        stepInfo: document.getElementById('personalData'),
        stepCreation: document.getElementById('personalCategories'),
        stepPreview: document.getElementById('personalAccounts'),
        stepObjetives: document.getElementById('personalObjetives')
    };

    steps.forEach(step => {
        step.addEventListener('click', function () {
            steps.forEach(s => s.classList.remove('active'));
            this.classList.add('active');

            Object.values(sections).forEach(section => {
                if (section) section.classList.add('d-none');
            });

            const sectionToShow = sections[this.id];
            if (sectionToShow) sectionToShow.classList.remove('d-none');
        });
    });

    initIconSelection();
    attachDeleteCategoryListeners();

    let counter = 0;
    const addBtn = document.getElementById('addCustomCategoryBtn');
    if (addBtn) {
        addBtn.addEventListener('click', function () {
            const container = document.getElementById('categoryContainer');
            const randomId = counter++;

            const iconOptionsHtml = allIcons.map(icon => `
                <div class="icon-option"
                    data-icon='${icon.icon}'
                    data-target="icon_new_${randomId}">
                    ${icon.icon}
                </div>
            `).join('');

            const movementTypesHtml = movementTypes.map(type => {
                const checkboxId = `movement_type_${randomId}_${type.id}`;
                return `
                    <div class="form-check mb-2">
                        <input class="form-check-input type-checkbox-edit"
                            id="${checkboxId}"
                            type="checkbox"
                            name="news[${randomId}][movement_types][]"
                            value="${type.id}">
                        <label class="form-check-label" for="${checkboxId}">${type.name}</label>
                    </div>
                `;
            }).join('');

            const newCategoryHtml = `
                <div class="col-md-6 col-lg-4 mb-4 category-card">
                    <div class="card h-100 rounded shadow rounded-4 overflow-hidden">
                        <div class="card-body d-flex flex-column p-4 bg-white">
                            <input type="hidden" name="news[${randomId}][id]" value="">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-category-btn">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Nombre de la categoría <span class="text-danger">*</span></label>
                                <input type="text" name="news[${randomId}][name]"
                                    class="form-control rounded bg-light text-center fs-5 fw-semibold shadow-sm"
                                    placeholder="Introduce el nombre de la categoría">
                            </div>

                            <div class="text-center mb-3">
                                <label class="form-label fw-medium text-muted">Icono actual</label>
                                <div class="fs-2 text-custom"><i class="fa-regular fa-circle-question"></i></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Seleccionar nuevo icono <span class="text-danger">*</span></label>
                                <input type="hidden" name="news[${randomId}][icon]" id="icon_new_${randomId}">
                                <div class="icon-scroll-wrapper border rounded-4 p-3 bg-white shadow-sm">
                                    <div class="icon-grid">
                                        ${iconOptionsHtml}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium text-muted">Tipos de movimiento <span class="text-danger">*</span></label>
                                <div class="types d-flex flex-row flex-wrap mb-2">
                                    ${movementTypesHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', newCategoryHtml);
            initIconSelection();
            attachDeleteCategoryListeners();
            validateCategoryForm();
        });
    }
});

function initIconSelection() {
    document.querySelectorAll('.icon-option').forEach(icon => {
        icon.onclick = () => {
            const targetId = icon.getAttribute('data-target');
            const newValue = icon.getAttribute('data-icon');
            const hiddenInput = document.getElementById(targetId);
            if (!hiddenInput) return;

            hiddenInput.value = newValue;

            const wrapper = icon.closest('.icon-scroll-wrapper');
            if (wrapper) {
                wrapper.querySelectorAll('.icon-option').forEach(el => el.classList.remove('selected'));
            }

            icon.classList.add('selected');
        };
    });

    document.querySelectorAll('input[type="hidden"][id^="icon_"]').forEach(input => {
        const selectedValue = input.value;
        const grid = input.closest('.card-body')?.querySelector('.icon-grid') 
                    || input.closest('.card')?.querySelector('.icon-grid');
        if (!grid) return;

        const selectedIcon = [...grid.querySelectorAll('.icon-option')].find(icon => icon.getAttribute('data-icon') === selectedValue);
        if (selectedIcon) {
            selectedIcon.classList.add('selected');
        }
    });
}

function attachDeleteCategoryListeners() {
    document.querySelectorAll('.delete-category-btn').forEach(button => {
        button.addEventListener('click', function () {
            const isExisting = this.dataset.existing === "true";
            const categoryId = this.dataset.id;

            if (isExisting && categoryId) {
                const deletedInput = document.getElementById('deletedCategories');
                let deletedArray = JSON.parse(deletedInput.value || '[]');

                if (!deletedArray.includes(categoryId)) {
                    deletedArray.push(categoryId);
                    deletedInput.value = JSON.stringify(deletedArray);
                }
            }

            const categoryCard = this.closest('.category-card');
            if (categoryCard) {
                categoryCard.remove();
            }

            validateCategoryForm();
        });
    });
}

function showSuccessMessage(input, message) {
    removeFeedbackMessages(input);
    const feedback = document.createElement('div');
    feedback.className = 'valid-feedback d-block small text-success';
    feedback.textContent = message;
    input.insertAdjacentElement('afterend', feedback);
}

function showErrorMessage(input, message) {
    removeFeedbackMessages(input);
    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback d-block small';
    feedback.textContent = message;
    input.insertAdjacentElement('afterend', feedback);
}

function removeFeedbackMessages(input) {
    const successFeedback = input.querySelector('.valid-feedback') || input.parentElement.querySelector('.valid-feedback');
    if (successFeedback) successFeedback.remove();
    const errorFeedback = input.querySelector('.invalid-feedback') || input.parentElement.querySelector('.invalid-feedback');
    if (errorFeedback) errorFeedback.remove();
}

function validateCategoryForm() {
    const categoryForm = document.querySelector('#personalCategories form');
    const submitBtn = categoryForm.querySelector('button[type="submit"]');
    let isValid = true;
    const categoryCards = categoryForm.querySelectorAll('.category-card');

    categoryCards.forEach(card => {
        const nameInput = card.querySelector('input[type="text"]');
        const iconInput = card.querySelector('input[type="hidden"][id^="icon_"]');
        const iconWrapper = card.querySelector('.icon-scroll-wrapper');
        const selectedIcon = iconWrapper.querySelector('.icon-option.selected');

        if (!nameInput.value.trim()) {
            nameInput.classList.add('is-invalid');
            nameInput.classList.remove('is-valid');
            showErrorMessage(nameInput, 'El nombre de la categoría es obligatorio.');
            isValid = false;
        } else if (nameInput.value.trim().length > 30) {
            nameInput.classList.add('is-invalid');
            nameInput.classList.remove('is-valid');
            showErrorMessage(nameInput, 'El nombre no puede superar 30 caracteres.');
            isValid = false;
        } else {
            nameInput.classList.remove('is-invalid');
            nameInput.classList.add('is-valid');
            showSuccessMessage(nameInput, 'Nombre válido');
        }

        if (!selectedIcon || !iconInput.value.trim()) {
            iconWrapper.classList.add('border', 'border-danger');
            iconWrapper.classList.remove('border-success');
            isValid = false;
        } else {
            iconWrapper.classList.remove('border-danger');
            iconWrapper.classList.add('border', 'border-success');
        }

        const movementTypeCheckboxes = card.querySelectorAll('.type-checkbox-edit');
        const anyChecked = [...movementTypeCheckboxes].some(cb => cb.checked);
        const movementTypesWrapper = card.querySelector('.types');

        if (!anyChecked) {
            
            if (!movementTypesWrapper.querySelector('.invalid-feedback')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block small';
                errorDiv.textContent = 'Selecciona al menos un tipo de movimiento.';
                movementTypesWrapper.appendChild(errorDiv);
            }
            isValid = false;
        } else {
            movementTypesWrapper.classList.remove('border-danger');
            const errorMsg = movementTypesWrapper.querySelector('.invalid-feedback');
            if (errorMsg) errorMsg.remove();
        }
    });

    submitBtn.disabled = !isValid;
}


document.addEventListener('DOMContentLoaded', () => {
    const categoryForm = document.querySelector('#personalCategories form');
    if (!categoryForm) return;

    categoryForm.addEventListener('input', e => {
        if (e.target.matches('.category-card input[type="text"]')) {
            validateCategoryForm();
        }
    });

    categoryForm.addEventListener('click', e => {
        if (e.target.closest('.icon-option') || e.target.classList.contains('type-checkbox-edit')) {
            setTimeout(() => validateCategoryForm(), 50);
        }
    });

    const container = document.getElementById('categoryContainer');
    const observer = new MutationObserver(() => {
        validateCategoryForm();
    });
    observer.observe(container, { childList: true });

    validateCategoryForm();
});
