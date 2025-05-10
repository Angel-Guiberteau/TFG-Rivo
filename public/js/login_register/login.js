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

    // PASSWORD CHECK
    const passwordInput = document.querySelector("#register-form input[name='password']");
    const strengthBar = document.getElementById("strengthBar");
    const strengthText = document.getElementById("strengthText");
    const wrapper = document.querySelector(".password-strength-wrapper");

    passwordInput.addEventListener("input", () => {
        const password = passwordInput.value.trim();

        if (password === "") {
            wrapper.classList.remove("active");
            strengthBar.style.width = "0%";
            strengthBar.style.backgroundColor = "#ccc";
            strengthText.textContent = "";
            return;
        }

        wrapper.classList.add("active");
        const strength = getPasswordStrength(password);
        updateStrengthBar(strength);
    });

    function getPasswordStrength(password) {
        let strength = 0;
        const checks = [/.{8,}/, /[a-z]/, /[A-Z]/, /[0-9]/, /[^A-Za-z0-9]/];
        checks.forEach((regex) => {
            if (regex.test(password)) strength++;
        });
        return strength;
    }

    function updateStrengthBar(strength) {
        const colors = ['#dc3545', '#ff9800', '#ffc107', '#7e57c2', '#4A148C'];
        const texts = ['Muy débil', 'Débil', 'Aceptable', 'Buena', 'Muy segura'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];

        strengthBar.style.width = widths[strength - 1] || '0%';
        strengthBar.style.backgroundColor = colors[strength - 1] || '#ccc';
        strengthText.textContent = texts[strength - 1] || '';
    }
});
