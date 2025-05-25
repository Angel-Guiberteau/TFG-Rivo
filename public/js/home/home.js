// HOME JS

window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    setTimeout(() => {
        loader.style.animation = 'fadeOut 0.6s ease-in-out forwards';
        setTimeout(() => loader.remove(), 600);
    }, 3000);
});




