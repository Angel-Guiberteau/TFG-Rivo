

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

    // Preselección de íconos ya asignados
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

                // Solo agregar si no está ya en la lista
                if (!deletedArray.includes(categoryId)) {
                    deletedArray.push(categoryId);
                    deletedInput.value = JSON.stringify(deletedArray);
                }
            }

            // Eliminar visualmente la tarjeta
            const categoryCard = this.closest('.category-card');
            if (categoryCard) {
                categoryCard.remove();
            }
        });
    });
}


document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.progress-line-container .step');
    const sections = {
        stepInfo: document.getElementById('personalData'),
        stepCreation: document.getElementById('personalCategories'),
        stepPreview: document.getElementById('personalAccounts')
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
    attachDeleteCategoryListeners(); // 👈 Se llama al cargar también por si ya hay existentes

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

            const newCategoryHtml = `
                <div class="col-md-6 col-lg-4 mb-4 category-card">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body d-flex flex-column p-4 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-medium text-muted mb-0">Nombre de la categoría</label>
                                <!-- 🔽 BOTÓN DE ELIMINAR -->
                                <button type="button" class="btn btn-sm btn-danger delete-category-btn" title="Eliminar categoría">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <input type="text" name="news[${randomId}][name]"
                                class="form-control border-0 border-bottom rounded-0 bg-light text-center fs-5 fw-semibold mb-3"
                                required
                                placeholder="Introduce el nombre de la categoría">

                            <div class="text-center mb-3">
                                <label class="form-label fw-medium text-muted">Icono actual</label>
                                <div class="fs-2 text-primary"><i class="fa-regular fa-circle-question"></i></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Seleccionar nuevo icono</label>
                                <input type="hidden" name="news[${randomId}][icon]" id="icon_new_${randomId}">
                                <div class="icon-scroll-wrapper border rounded-4 p-3 bg-white shadow-sm">
                                    <div class="icon-grid">
                                        ${iconOptionsHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', newCategoryHtml);
            initIconSelection();
            attachDeleteCategoryListeners(); // 👈 Necesario para los nuevos botones
        });
    }
});