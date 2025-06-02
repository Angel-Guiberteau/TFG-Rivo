
document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('loader');
    if (loader) {
        setTimeout(() => {
            loader.style.animation = 'fadeOut 0.6s ease-in-out forwards';
            setTimeout(() => loader.remove(), 600);
        }, 3000);
    }

    const actionButtons = document.querySelectorAll('.action-button');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            actionButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    setTimeout(() => {
        const alert = document.querySelector('.rivo-alert');
        if (alert) alert.remove();
    }, 4000);
});
