{{-- <nav class="mobile-nav">
    <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
        <i class="fas fa-home fs-3 text-secondary"></i>
        <span class="fs-6">Inicio</span>
    </button>
    <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
        <i class="fas fa-plus fs-3 text-success"></i>
        <span class="fs-6">Ingreso</span>
    </button>
    <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
        <i class="fas fa-minus fs-3 text-danger" style="text-shadow: 0 0 1px currentColor;"></i>
        <span class="fs-6">Gasto</span>
    </button>
    <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
        <i class="fas fa-piggy-bank fs-3 text-warning"></i>
        <span class="fs-6">Ahorro</span>
    </button>
</nav> --}}

<nav class="mobile-nav">
    <div id="fab-container">
        <button id="fab-toggle" class="fab-option fab-active">
            <i id="fab-icon" class="fas fa-home" data-id="home"></i>
        </button>
        <div id="fab-menu" class="fab-menu"></div>
    </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const fabToggle = document.getElementById("fab-toggle");
        const fabMenu = document.getElementById("fab-menu");
        const fabIcon = document.getElementById("fab-icon");

        const options = [
            { id: "home", icon: "fas fa-home", color: "text-secondary", targetId: "showHome" },
            { id: "income", icon: "fas fa-plus", color: "text-success", targetId: "showIncomeForm" },
            { id: "expense", icon: "fas fa-minus", color: "text-danger", targetId: "showEgressFrom" },
            { id: "save", icon: "fas fa-piggy-bank", color: "text-warning", targetId: "showSavingForm" },
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
    });
</script>






