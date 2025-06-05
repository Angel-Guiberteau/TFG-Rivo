import { fetchData } from './helpers/api.js';
import { openTransactionDetail } from './transactionInfo.js';

document.addEventListener('DOMContentLoaded', function () {
    const homeSection = document.getElementById('home-section');
    const showHomeButton = document.getElementById('showHome');

    const contentSections = document.querySelectorAll(
        'main > section > article.home-article, main > section > article.income-article, main > section > article.egress-article, main > section > article.objective-article, main > section > article.settings-article, main > section > article.category-article'
    );

    function setupCategoryFilteringByType(initialType = null) {
        const typeRadios = document.querySelectorAll('.type-radio');
        const categoryLabels = document.querySelectorAll('#categoryOptions label[data-types]');
        const TYPE_MAP = { income: '1', expense: '2', save: '3' };
        const goalSection = document.getElementById('goalSelector');

        const filter = (key) => {
            const wanted = TYPE_MAP[key] || '';

            categoryLabels.forEach(label => {
                const types = label.dataset.types.split(',').map(v => v.trim());
                const input = label.querySelector('input[type="radio"]');
                if (types.includes(wanted)) {
                    label.classList.remove('hidden-category');
                } else {
                    label.classList.add('hidden-category');
                    if (input) input.checked = false;
                }
            });

            if (goalSection) {
                if (key === 'save') {
                    goalSection.classList.remove('d-none');
                    goalSection.style.display = 'block';
                } else {
                    goalSection.style.display = 'none';
                }
            }
        };

        typeRadios.forEach(radio => {
            radio.addEventListener('change', () => filter(radio.value));
        });

        const selectedRadio = document.querySelector('.type-radio:checked');
        const startType = initialType || selectedRadio?.value || 'income';
        filter(startType);
    }


    function formatShortDate(dateStr) {
        const date = new Date(dateStr);
        const day = date.getDate();
        const month = date.toLocaleString('es-ES', { month: 'short' }).replace('.', '');
        return `${day} ${month}.`;
    }

    function getBadgeClass(typeId) {
        switch (typeId) {
            case 1: return 'income';
            case 2: return 'expense';
            case 3: return 'saveMoney';
            default: return '';
        }
    }

    function getMovementLabel(typeId) {
        switch (typeId) {
            case 1: return 'Ingreso';
            case 2: return 'Gasto';
            case 3: return 'Ahorro';
            default: return '';
        }
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function hideContentSections() {
        contentSections.forEach(section => {
            section.classList.remove('show');
            setTimeout(() => {
                section.classList.add('fade-section');
                section.style.display = 'none';
            }, 300);
        });
    }

    function renderMovement(movement, index) {
        const movementHTML = `
            <div class="col-12 col-lg-6 movement-item ${index % 2 === 0 ? 'border-lg-end' : ''}">
                <div class="movement-row" data-id="${movement.id}">
                    <div class="movement-left d-flex align-items-center gap-3">
                        <div class="movement-icon">
                            ${movement.category?.icon?.icon ?? ''}
                        </div>
                        <div class="movement-info">
                            <p class="movement-date mb-0">${formatShortDate(movement.action_date)}</p>
                            <p class="badge-${getBadgeClass(movement.movement_type_id)} mb-1">
                                ${getMovementLabel(movement.movement_type_id)}
                            </p>
                            <p class="movement-name mb-0">${movement.category?.name ?? 'Sin categoría'}</p>
                        </div>
                    </div>
                    <div class="movement-right">
                        <p class="movement-amount m-0 fs-5 ${movement.movement_type_id == 2 ? 'negative' : 'positive'}">
                            ${movement.movement_type_id == 2 ? '-' : '+'}${Number(movement.amount).toFixed(2)}€
                        </p>
                    </div>
                </div>
            </div>
        `;
        return movementHTML;
    }

    function showSection(section, onShow = null) {
        if (!section) return;
        section.style.display = 'flex';
        requestAnimationFrame(async () => {
            section.classList.add('show');
            if (onShow && typeof onShow === 'function') {
                await onShow();
            }
            section.classList.remove('fade-section');
        });
    }

    async function refreshHistory(type) {
        const container = document.getElementById(`${type}-movements`);
        const loadMoreBtn = document.getElementById(`${type}-loadMoreBtn`);
        if (!container) return;

        container.innerHTML = '';
        if (loadMoreBtn) loadMoreBtn.style.display = 'block';

        const res = await fetchData(`/api/operation/${type}Operations?offset=0`);
        if (!res || !Array.isArray(res)) return;

        res.forEach((movement, i) => {
            const html = renderMovement(movement, i);
            container.insertAdjacentHTML('beforeend', html);

            const newRow = container.querySelector(`.movement-row[data-id="${movement.id}"]`);
            if (newRow) {
                newRow.addEventListener('click', () => openTransactionDetail(movement.id));
            }
        });
    }

    window.refreshHistory = refreshHistory;
    function setMovementType(type) {
        const form = document.getElementById('operationAddForm-section');
        const radio = form.querySelector(`.type-radio[value="${type}"]`);
        if (radio) {
            radio.checked = true;
            radio.dispatchEvent(new Event('change'));
        }
    }


    function setupHistory(type) {
        const section = document.getElementById(`${type}-section`);
        const formSection = document.getElementById(`operationAddForm-section`);
        const showFormBtn = document.getElementById(`show${capitalize(type)}Form`);
        const addFormBtn = document.getElementById(`${type}AddForm`);
        const backHistoryBtn = document.getElementById(`back-history${capitalize(type)}`);
        const movementsContainer = document.getElementById(`${type}-movements`);
        const loadMoreBtn = document.getElementById(`${type}-loadMoreBtn`);

        let offset = 0;
        const limit = 6;
        let allLoaded = false;

        async function loadMore() {
            const res = await fetchData(`/api/operation/${type}Operations?offset=${offset}`);
            if (!res || res.length === 0) {
                allLoaded = true;
                if (loadMoreBtn) loadMoreBtn.style.display = 'none';
                return;
            }

            res.forEach((movement, i) => {
                const index = offset + i;
                const html = renderMovement(movement, index);
                movementsContainer.insertAdjacentHTML('beforeend', html);

                const newRow = movementsContainer.querySelector(`.movement-row[data-id="${movement.id}"]`);
                if (newRow) {
                    newRow.addEventListener('click', () => openTransactionDetail(movement.id));
                }
            });

            offset += limit;
            if (res.length < limit && loadMoreBtn) loadMoreBtn.style.display = 'none';
        }

        if (showFormBtn) {
            showFormBtn.addEventListener('click', () => {
                hideContentSections();
                showSection(section, async () => {
                    offset = 0;
                    allLoaded = false;
                    movementsContainer.innerHTML = '';
                    if (loadMoreBtn) loadMoreBtn.style.display = 'block';
                    await loadMore();
                });
            });
        }

        if (addFormBtn) {
            addFormBtn.addEventListener('click', () => {
                hideContentSections();
                showSection(formSection, () => {
                    setMovementType(type);
                    setupCategoryFilteringByType(type);
                });
            });
        }



        if (backHistoryBtn) {
            backHistoryBtn.addEventListener('click', () => {
                hideContentSections();
                showSection(section);
            });
        }

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => {
                if (!allLoaded) loadMore();
            });
        }

    }

    if (showHomeButton) {
        showHomeButton.addEventListener('click', () => {
            hideContentSections();
            showSection(homeSection);
        });
    }


    setupHistory('income');
    setupHistory('expense');
    setupHistory('save');




    const showObjectiveBtn = document.querySelectorAll('.showObjectiveButton');
    const objectiveSection = document.getElementById('objectiveAdd-section');
    if (showObjectiveBtn && objectiveSection) {
        showObjectiveBtn.forEach(btn => {
            btn.addEventListener('click', () => {
                hideContentSections();
                showSection(objectiveSection);
                setFabIcon('custom');
            });
        });
    }

    const showSettingsBtn = document.getElementById('showSettingsButton');
    const settingsSection = document.getElementById('settings-section');

        if (showSettingsBtn && settingsSection) {
        showSettingsBtn.addEventListener('click', () => {
            hideContentSections();
            showSection(settingsSection);
            setFabIcon('custom');
        });
    }

    const showCategoryFormButton = document.querySelectorAll('.addCategoryButton');
    const categorySection = document.getElementById('categoryAdd-section');
    const iconGrid = categorySection.querySelector('.icon-grid');
    const hiddenIconInput = categorySection.querySelector('input[name="icon"]');

    if (showCategoryFormButton && categorySection) {
        showCategoryFormButton.forEach(btn => {
            btn.addEventListener('click', async () => {
                hideContentSections();
                showSection(categorySection);
                setFabIcon('custom');

                if (iconGrid && iconGrid.children.length === 0) {
                    try {
                        const res = await fetch('/api/icon/getAllIcons');
                        const icons = await res.json();

                        icons.forEach(icon => {
                            const div = document.createElement('div');
                            div.classList.add('icon-option');
                            div.dataset.icon = icon.icon;
                            div.dataset.id = icon.id;
                            div.innerHTML = icon.icon;

                            div.addEventListener('click', () => {
                                iconGrid.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
                                div.classList.add('selected');
                                hiddenIconInput.value = icon.id;
                            });

                            iconGrid.appendChild(div);
                        });
                    } catch (error) {
                        console.error('Error cargando iconos:', error);
                    }
                }
            });
        });

    }

    hideContentSections();
    showSection(homeSection);
    setupCategoryFilteringByType();
});
