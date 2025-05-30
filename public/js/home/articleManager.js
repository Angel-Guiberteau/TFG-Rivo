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

    const contentSections = document.querySelectorAll('main > section > article.home-article, main > section > article.income-article, main > section > article.egress-article');

    function hideContentSections() {
        contentSections.forEach(section => {
            section.classList.remove('show');
            setTimeout(() => {
                section.classList.add('fade-section');
                section.style.display = 'none';
            }, 300);
        });
    }

    function showSection(section) {
        if (!section) return;

        section.style.display = 'flex';
        requestAnimationFrame(() => {
            section.classList.add('show');
            section.classList.remove('fade-section');
        });
    }

    if (showIncomeFormButton) {
        showIncomeFormButton.addEventListener('click', function () {
            hideContentSections();
            showSection(incomeSection);
        });
    }

    if (incomeAddFormButton) {
        incomeAddFormButton.addEventListener('click', function () {
            hideContentSections();
            showSection(incomeAddFormSection);
        });
    }

    if (backHistoryIncomeButton) {
        backHistoryIncomeButton.addEventListener('click', function () {
            hideContentSections();
            showSection(incomeSection);
        });
    }

    if (showEgressFormButton) {
        showEgressFormButton.addEventListener('click', function () {
            hideContentSections();
            showSection(egressSection);
        });
    }

    if (egressAddFormButton) {
        egressAddFormButton.addEventListener('click', function () {
            hideContentSections();
            showSection(egressAddFormSection);
        });
    }

    if (backHistoryEgressButton) {
        backHistoryEgressButton.addEventListener('click', function () {
            hideContentSections();
            showSection(egressSection);
        });
    }
    
    if (showHomeButton) {
        showHomeButton.addEventListener('click', function () {
            hideContentSections();
            showSection(homeSection);
        });
    }

    hideContentSections();
    showSection(homeSection);
});
