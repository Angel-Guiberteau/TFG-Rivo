import { fetchData } from './helpers/api.js';
import { openTransactionDetail } from './transactionInfo.js';

document.addEventListener('DOMContentLoaded', function () {
    const homeSection = document.getElementById('home-section');
    const showHomeButton = document.getElementById('showHome');

    const showIncomeFormButton = document.getElementById('showIncomeForm');
    const incomeSection = document.getElementById('income-section');
    const incomeAddFormButton = document.getElementById('incomeAddForm');
    const incomeAddFormSection = document.getElementById('incomeAddForm-section');
    const backHistoryIncomeButton = document.getElementById('back-historyIncome');

    const showEgressFormButton = document.getElementById('showEgressFrom');
    const egressSection = document.getElementById('egress-section');
    const egressAddFormButton = document.getElementById('egressAddForm');
    const egressAddFormSection = document.getElementById('egressAddForm-section');
    const backHistoryEgressButton = document.getElementById('back-historyEgress');

    const contentSections = document.querySelectorAll(
        'main > section > article.home-article, main > section > article.income-article, main > section > article.egress-article'
    );

    let incomeOffset = 0;
    const incomeLimit = 6;
    let allLoaded = false;

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

    function hideContentSections() {
        contentSections.forEach(section => {
            section.classList.remove('show');
            setTimeout(() => {
                section.classList.add('fade-section');
                section.style.display = 'none';
            }, 300);
        });
    }

    function renderIncomeMovements(operations, offset = 0) {
        const container = document.getElementById('income-movements');
        if (!container) return;

        operations.forEach((movement, index) => {
            const isFirstLoad = offset === 0;
            const absoluteIndex = offset + index;

            const movementHTML = `
                <div class="col-12 col-lg-6 movement-item ${absoluteIndex % 2 === 0 ? 'border-lg-end' : ''}"
                    style="display: ${isFirstLoad && absoluteIndex >= 6 ? 'none' : 'block'};">
                    <div class="movement-row" data-id="${movement.id}">
                        <div class="movement-left d-flex align-items-center gap-3">
                            <div class="movement-icon">
                                ${movement.category.icon.icon ?? ''}
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

            container.insertAdjacentHTML('beforeend', movementHTML);

            const newRow = container.querySelector(`.movement-row[data-id="${movement.id}"]`);
            if (newRow) {
                newRow.addEventListener('click', () => openTransactionDetail(movement.id));
            }
        });
    }


    async function loadMoreIncomes() {
        const res = await fetchData(`/api/operation/incomeOperations?offset=${incomeOffset}`);
        const loadMoreBtn = document.getElementById('loadMoreBtn');

        if (!res || res.length === 0) {
            allLoaded = true;
            if (loadMoreBtn) loadMoreBtn.style.display = 'none';
            return;
        }

        renderIncomeMovements(res, incomeOffset);
        incomeOffset += incomeLimit;

        if (res.length < incomeLimit && loadMoreBtn) {
            allLoaded = true;
            loadMoreBtn.style.display = 'none';
        }
    }

    
    function showSection(section) {
        if (!section) return;

        section.style.display = 'flex';
        requestAnimationFrame(async () => {
            section.classList.add('show');

            if (section.id === 'income-section') {
                incomeOffset = 0;
                allLoaded = false;
                const container = document.getElementById('income-movements');
                const loadMoreBtn = document.getElementById('loadMoreBtn');
                if (container) container.innerHTML = '';
                if (loadMoreBtn) loadMoreBtn.style.display = 'block';
                await loadMoreIncomes();
            }

            section.classList.remove('fade-section');
        });
    }

    if (showIncomeFormButton) {
        showIncomeFormButton.addEventListener('click', () => {
            hideContentSections();
            showSection(incomeSection);
        });
    }

    if (incomeAddFormButton) {
        incomeAddFormButton.addEventListener('click', () => {
            hideContentSections();
            showSection(incomeAddFormSection);
        });
    }

    if (backHistoryIncomeButton) {
        backHistoryIncomeButton.addEventListener('click', () => {
            hideContentSections();
            showSection(incomeSection);
        });
    }

    if (showEgressFormButton) {
        showEgressFormButton.addEventListener('click', () => {
            hideContentSections();
            showSection(egressSection);
        });
    }

    if (egressAddFormButton) {
        egressAddFormButton.addEventListener('click', () => {
            hideContentSections();
            showSection(egressAddFormSection);
        });
    }

    if (backHistoryEgressButton) {
        backHistoryEgressButton.addEventListener('click', () => {
            hideContentSections();
            showSection(egressSection);
        });
    }

    if (showHomeButton) {
        showHomeButton.addEventListener('click', () => {
            hideContentSections();
            showSection(homeSection);
        });
    }

    hideContentSections();
    showSection(homeSection);


    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            if (!allLoaded) loadMoreIncomes();
        });
    }
});
