document.addEventListener('DOMContentLoaded', function() {
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
            section.style.display = 'none';
        });
    }

    if (showIncomeFormButton) {
        showIncomeFormButton.addEventListener('click', function() {
            hideContentSections();
            if (incomeSection) {
                incomeSection.style.display = 'flex';
            }
        });
    }

    if (incomeAddFormButton) {
        incomeAddFormButton.addEventListener('click', function() {
            hideContentSections();
            if (incomeAddFormSection) {
                incomeAddFormSection.style.display = 'flex';
            }
        });
    }

    if (backHistoryIncomeButton) {
        backHistoryIncomeButton.addEventListener('click', function() {
            hideContentSections();
            if (incomeSection) {
                incomeSection.style.display = 'flex';
            }
        });
    }

    if (showEgressFormButton) {
        showEgressFormButton.addEventListener('click', function() {
            hideContentSections();
            if (egressSection) {
                egressSection.style.display = 'flex';
            }
        });
    }

    if (egressAddFormButton) {
        egressAddFormButton.addEventListener('click', function() {
            hideContentSections();
            if (egressAddFormSection) {
                egressAddFormSection.style.display = 'flex';
            }
        });
    }

    if (backHistoryEgressButton) {
        backHistoryEgressButton.addEventListener('click', function() {
            hideContentSections();
            if (egressSection) {
                egressSection.style.display = 'flex';
            }
        });
    }


    hideContentSections();
    const homeSection = document.getElementById('home-section');
    if (homeSection) {
        homeSection.style.display = 'flex';
    }
});