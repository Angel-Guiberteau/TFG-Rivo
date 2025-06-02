document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('toggleFiltrosBtn');
    const container = document.getElementById('filter-container');

    const isMobile = window.innerWidth < 992;

    if (isMobile && container) {
        container.style.display = 'none';
        container.classList.remove('show');
    }

    let visible = false;

    if (btn && container) {
        btn.addEventListener('click', () => {
            if (!visible) {
                container.style.display = 'flex';
                requestAnimationFrame(() => {
                    container.classList.add('show');
                });
                btn.innerHTML = '<i class="fas fa-sliders-h me-1"></i> Ocultar filtros';
            } else {
                container.classList.remove('show');
                setTimeout(() => {
                    container.style.display = 'none';
                }, 150);
                btn.innerHTML = '<i class="fas fa-sliders-h me-1"></i> Mostrar filtros';
            }
            visible = !visible;
        });
    }

    const items = document.querySelectorAll('.movement-item');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    let visibleCount = 6;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            let nextVisible = visibleCount + 6;
            for (let i = visibleCount; i < nextVisible && i < items.length; i++) {
                items[i].style.display = 'block';
            }
            visibleCount = nextVisible;

            if (visibleCount >= items.length) {
                loadMoreBtn.style.display = 'none';
            }
        });
    }
});
