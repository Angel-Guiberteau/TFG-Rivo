document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const heading = document.querySelector('.login-container h2');

    function typeHeading(text) {
        heading.textContent = '';
        heading.classList.add('typing'); // Activa el cursor
        let index = 0;

        const interval = setInterval(() => {
            heading.textContent += text.charAt(index);
            index++;
            if (index === text.length) {
                clearInterval(interval);
                heading.classList.remove('typing'); // Oculta el cursor al terminar
            }
        }, 50);
    }

    document.querySelector('.login-container').addEventListener('click', function (e) {
        if (e.target.tagName === 'A' && e.target.closest('.register')) {
            e.preventDefault();

            const isLoginVisible = loginForm.classList.contains('active');

            loginForm.classList.toggle('active', !isLoginVisible);
            registerForm.classList.toggle('active', isLoginVisible);

            loginForm.setAttribute('aria-hidden', isLoginVisible);
            registerForm.setAttribute('aria-hidden', !isLoginVisible);

            const newTitle = isLoginVisible ? 'Registrarse' : 'Iniciar sesión';
            typeHeading(newTitle);
        }
    });
});
