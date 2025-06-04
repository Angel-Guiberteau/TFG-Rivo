document.addEventListener("DOMContentLoaded", () => {
    const fabToggle = document.getElementById("fab-toggle");
    const fabMenu = document.getElementById("fab-menu");
    const fabIcon = document.getElementById("fab-icon");

    const options = [
        { id: "home", icon: "fas fa-home", color: "text-secondary", targetId: "showHome" },
        { id: "income", icon: "fas fa-plus", color: "text-success", targetId: "showIncomeForm" },
        { id: "expense", icon: "fas fa-minus", color: "text-danger", targetId: "showExpenseForm" },
        { id: "save", icon: "fas fa-piggy-bank", color: "text-warning", targetId: "showSaveForm" }
    ];

    let isOpen = false;

    function renderMenu() {
        fabMenu.innerHTML = "";

        const current = fabIcon.getAttribute("data-id");

        options
            .filter(opt => opt.id !== current)
            .forEach(opt => {
                const btn = document.createElement("button");
                btn.classList.add("fab-option");
                btn.setAttribute("data-id", opt.id);
                btn.innerHTML = `<i class="${opt.icon} ${opt.color}"></i>`;

                btn.addEventListener("click", () => {
                    fabIcon.className = `${opt.icon}`;
                    fabIcon.setAttribute("data-id", opt.id);

                    fabMenu.classList.remove("open");
                    isOpen = false;

                    const desktopBtn = document.getElementById(opt.targetId);
                    if (desktopBtn) {
                        desktopBtn.click();
                    }
                });

                fabMenu.appendChild(btn);
            });
    }

    fabToggle.addEventListener("click", () => {
        isOpen = !isOpen;
        if (isOpen) {
            renderMenu();
            fabMenu.classList.add("open");
        } else {
            fabMenu.classList.remove("open");
        }
    });
    window.setFabIcon = function (id) {
        const option = options.find(opt => opt.id === id);
        const fabIcon = document.getElementById("fab-icon");
        if (option && fabIcon) {
            fabIcon.className = `${option.icon}`;
            fabIcon.setAttribute("data-id", id);
        } else if (fabIcon) {
            // Si es una vista fuera del FAB, por ejemplo "objective"
            fabIcon.className = "fas fa-dot-circle"; // o cualquier icono neutral
            fabIcon.setAttribute("data-id", "custom");
        }
    };
});
