document.addEventListener("DOMContentLoaded", function () {
    
    flatpickr("#birth_date", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d-m-Y",
        locale: "es",
        maxDate: "today",
        altInputClass: "form-control custom-flatpickr",
        onReady: function (selectedDates, dateStr, instance) {
            instance.altInput.placeholder = "Selecciona una fecha";
        }
    });

    const form = document.querySelector("form");

    const fields = {
        name: {
            input: document.getElementById("name"),
            validate: (v) => v.trim() !== "",
            message: "El nombre es obligatorio"
        },
        last_name: {
            input: document.getElementById("last_name"),
            validate: (v) => v.trim() !== "",
            message: "El apellido es obligatorio"
        },
        birth_date: {
            input: document.getElementById("birth_date"),
            validate: (v) => {
                if (!v.trim()) return false;
                const selected = new Date(v);
                const today = new Date();
                return selected <= today;
            },
            message: "Selecciona una fecha válida anterior a hoy"
        },
        rol_id: {
            input: document.getElementById("rol_id"),
            validate: (v) => v !== "",
            message: "Selecciona un rol"
        },
        email: {
            input: document.getElementById("email"),
            validate: (v) =>
                /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(v),
            message: "Introduce un correo electrónico válido"
        },
        username: {
            input: document.getElementById("username"),
            validate: (v) => v.trim().length >= 3,
            message: "El nombre de usuario debe tener al menos 3 caracteres"
        },
        password: {
            input: document.getElementById("password"),
            validate: (v) => v.trim().length >= 8,
            message: "La contraseña debe tener al menos 8 caracteres"
        }
    };

    const showError = (input, message) => {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");

        let feedback = input.parentElement.querySelector(".invalid-feedback");
        if (!feedback) {
            feedback = document.createElement("div");
            feedback.classList.add("invalid-feedback");
            input.parentElement.appendChild(feedback);
        }
        feedback.textContent = message;
    };

    const showSuccess = (input) => {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");

        const feedback = input.parentElement.querySelector(".invalid-feedback");
        if (feedback) feedback.remove();
    };

    const validateField = (field) => {
        const value = field.input.value;
        if (!field.validate(value)) {
            showError(field.input, field.message);
            return false;
        } else {
            showSuccess(field.input);
            return true;
        }
    };

    Object.values(fields).forEach(field => {
        ["input", "blur", "change"].forEach(evt => {
            field.input.addEventListener(evt, () => validateField(field));
        });
    });

    form.addEventListener("submit", function (e) {
        let valid = true;
        Object.values(fields).forEach(field => {
            if (!validateField(field)) valid = false;
        });

        if (!valid) {
            e.preventDefault(); 
        }
    });
});
