<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black income-article" id="income-section" style="display: none;">
    <div class="col-12 col-lg-10 mx-auto mt-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-3">Historial de ingresos</h2>
            <button class="btn btn-primary fw-bold btn-sm fs-4 custom-gradient-btn w-25" id="incomeAddForm">
                    <i class="fa fa-plus"></i>
            </button>
        </div>
        
        <hr class="separator">

        <div class="d-flex justify-content-end d-lg-none mb-3">
            <button id="toggleFiltrosBtn" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-sliders-h me-1"></i> Mostrar filtros
            </button>
        </div>
    
        <div id="filter-container" class="row g-3 mb-4 d-lg-flex collapse-transition">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="input-group px-0">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="income-search" class="form-control border-start-0" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <input type="date" id="income-date-from" class="form-control" title="Desde">
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <select id="income-category" class="form-select" title="Categoría">
                    TRAES CATEGORÍAS DEL USUARIO
                </select>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <input type="number" id="income-amount-min" class="form-control" placeholder="Mín €">
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <input type="number" id="income-amount-max" class="form-control" placeholder="Máx €">
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <select id="income-sort" class="form-select" title="Ordenar por">
                    <option value="date_desc">Más reciente</option>
                    <option value="date_asc">Más antiguo</option>
                    <option value="amount_desc">Mayor cantidad</option>
                    <option value="amount_asc">Menor cantidad</option>
                    <option value="name_asc">A-Z</option>
                    <option value="name_desc">Z-A</option>
                </select>
            </div>
        </div>
        <div class="px-lg-4">
            <div class="row movement-block">
                @foreach ($allIncomes as $index => $simpleIncome)
                    <div class="col-12 col-lg-6 movement-item {{ $index % 2 === 0 ? 'border-lg-end' : '' }}" style="{{ $index >= 6 ? 'display: none;' : '' }}">
                        <div class="movement-row">
                            <div class="movement-left d-flex align-items-center gap-3">
                                <div class="movement-icon">
                                    {!! $simpleIncome->category->icon->icon !!}
                                </div>
                                <div class="movement-info">
                                    <p class="movement-date mb-0">
                                        {{ \Carbon\Carbon::parse($simpleIncome->action_date)->locale('es')->translatedFormat('j M') }}
                                    </p>
                                    <p class="badge mb-1 
                                        {{ $simpleIncome->movement_type_id == 1 ? 'badge-income' : 
                                        ($simpleIncome->movement_type_id == 2 ? 'badge-expense' : 
                                        ($simpleIncome->movement_type_id == 3 ? 'badge-save' : '') ) }}">
                                        {{ $simpleIncome->movement_type_id == 1 ? 'Ingreso' : 
                                        ($simpleIncome->movement_type_id == 2 ? 'Gasto' : 
                                        ($simpleIncome->movement_type_id == 3 ? 'Ahorro' : '') ) }}
                                    </p>
                                    <p class="movement-name mb-0">{{ $simpleIncome->category->name }}</p>
                                </div>
                            </div>
                            <div class="movement-right">
                                <p class="movement-amount m-0 fs-5 {{ $simpleIncome->movement_type_id == 2 ? 'negative' : 'positive' }}">
                                    {{ $simpleIncome->movement_type_id == 2 ? '-' : '+' }}{{ number_format($simpleIncome->amount, 2) }}€
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="text-center mt-3 mb-3 mb-lg-0">
                    <button id="loadMoreBtn" class="rivo-btn">Ver más</button>
                </div>
            </div>
        </div>
    </div>
</article>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('toggleFiltrosBtn');
        const container = document.getElementById('filter-container');

        const isMobile = window.innerWidth < 992;

        if (isMobile) {
            container.style.display = 'none';
            container.classList.remove('show');
        }

        let visible = false;

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
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('.movement-item');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        let visibleCount = 6;

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
    });
</script>



