<div class="col-12 col-lg-6 mt-2 mt-lg-4 objective-item" data-id="{{ $objective->id }}">
    <div class="w-100 info-container py-4 px-3">
        <div class="d-flex flex-row justify-content-start align-items-center">
            <img src="{{ asset('img/logos/purpleRivo.png') }}" alt="">
            <div class="d-flex flex-column align-items-start gap-0">
                <h3 class="mb-1 fs-4 fw-bold truncate-title">Objetivo: {{ $objective->name }}</h3>
                <p class="fs-5 mb-0">Progreso: {{ $objective->current_amount }}€ / {{ $objective->target_amount }}€ ahorrado — <strong>{{ $objective->target_amount > 0 ? number_format(($objective->current_amount / $objective->target_amount) * 100, 2) : '0.00' }}%</strong></p>
            </div>
        </div>
        <div class="progress-bar">
            <div style="
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
                background-color: #6b00e5;
                width: {{ $objective->target_amount > 0 ? ($objective->current_amount / $objective->target_amount) * 100 : 0 }}%;
                height: 100%;">
            </div>
        </div>
        @if (isset($modifiable))
            <div class="d-flex flex-row w-100 justify-content-end gap-2 mt-3">
                <button class="btn-objective edit" data-id="{{ $objective->id }}">
                    <i class="fas fa-pen"></i>
                    Editar
                </button>
                <button class="btn-objective delete" data-id="{{ $objective->id }}">
                    <i class="fas fa-trash"></i>
                    Eliminar
                </button>
            </div>
        @endif
    </div>
</div>
