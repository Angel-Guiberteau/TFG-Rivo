<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black home-article show fade-section"
id="{{ $type }}-section" style="display: none;">

    <div class="col-12 col-lg-10 mx-auto w-100 mt-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-3">Historial de {{ $title }}</h2>
            <button class="btn btn-primary fw-bold btn-sm fs-4 custom-gradient-btn w-25" id="{{ $type }}AddForm">
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <hr class="separator">

        <div id="filter-container-{{ $type }}" class="row g-3 p-4 mb-0 d-lg-flex collapse-transition">
            <div class="col-12 col-lg-4">
                <div class="input-group px-0">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="{{ $type }}-search" class=" form-control custom-input" placeholder="Buscar...">
                </div>
            </div>
        </div>

        <div class="px-lg-4">
            <div class="row movement-block" id="{{ $type }}-movements">
                {{-- Movements by Js --}}
            </div>
            <div class="text-center mt-3 w-100 d-flex flex-row justify-content-center align-items-center">
                <button id="{{ $type }}-loadMoreBtn" class="rivo-btn">Ver más</button>
            </div>
        </div>
    </div>
</article>
