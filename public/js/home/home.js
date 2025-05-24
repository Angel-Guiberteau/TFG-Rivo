// HOME JS

window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    setTimeout(() => {
        loader.style.animation = 'fadeOut 0.6s ease-in-out forwards';
        setTimeout(() => loader.remove(), 600);
    }, 3000);
});

document.addEventListener('DOMContentLoaded', function () {

    const showIncomeBtn = document.getElementById('showIncomeForm');
    const showEgressBtn = document.getElementById('showEgressFrom');
    const homeArticle = document.querySelector('.home-article');
    const incomeArticle = document.querySelector('.income-article');
    const egressArticle = document.querySelector('.egress-article');

    if (showIncomeBtn) {
        showIncomeBtn.addEventListener('click', function () {
            homeArticle.style.display = 'none';
            incomeArticle.style.display = 'block';
            egressArticle.style.display = 'none';
        });
    }
    if (showEgressBtn) {
        showEgressBtn.addEventListener('click', function () {
            homeArticle.style.display = 'none';
            incomeArticle.style.display = 'none';
            egressArticle.style.display = 'block';
        });
    }

    if (incomeArticle) {
        incomeArticle.style.display = 'none';
    }

    if (egressArticle) {
        egressArticle.style.display = 'none';
    }

});


// INCOME JS
const radios = document.querySelectorAll('input[name="category"]');

function updateCategoryStyles() {
    document.querySelectorAll('.category-option').forEach(opt => opt.classList.remove('active'));
    const checkedRadio = document.querySelector('input[name="category"]:checked');
    if (checkedRadio) {
        checkedRadio.nextElementSibling.classList.add('active');
    }
}

radios.forEach(radio => {
    radio.addEventListener('change', updateCategoryStyles);
});

updateCategoryStyles();


