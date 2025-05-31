// HOME JS

window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    setTimeout(() => {
        loader.style.animation = 'fadeOut 0.6s ease-in-out forwards';
        setTimeout(() => loader.remove(), 600);
    }, 3000);
});

document.querySelectorAll('.action-button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.action-button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});


