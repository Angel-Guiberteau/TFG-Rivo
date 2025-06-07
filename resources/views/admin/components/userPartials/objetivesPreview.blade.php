<div class="card-header bg-primary text-white">
    <i class="fas fa-bullseye me-2"></i>Objetivos del usuario
</div>
<div class="card-body">
    @forelse($objectives as $objective)
        @php
            $percentage = min(100, round(($objective->current_amount / $objective->target_amount) * 100, 2));
        @endphp

        <div class="card mb-3 shadow-sm border">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div class="me-3 w-100">
                        <h5 class="card-title fw-bold mb-1 text-{{ $objective->enabled ? 'dark' : 'secondary' }}">
                            <i class="fas fa-flag-checkered me-2"></i>{{ $objective->name }}
                        </h5>
                        <div class="text-end mt-3 w-100">
                            <span class="badge bg-{{ $objective->enabled ? 'success' : 'secondary' }} px-3 py-2">
                                {{ $objective->enabled ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <p class="mb-1"><strong>Meta:</strong> {{ number_format($objective->target_amount, 2) }} €</p>
                        <p class="mb-1"><strong>Actual:</strong> {{ number_format($objective->current_amount, 2) }} €</p>
                        <p class="mb-1"><strong>Fecha límite:</strong> {{ \Carbon\Carbon::parse($objective->deadline)->format('d/m/Y') }}</p>
                        <p class="mb-3"><strong>Activo:</strong> {{ $objective->enabled ? 'Sí' : 'No' }}</p>

                        <!-- Barra de progreso -->
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar 
                                        {{ $percentage >= 100 ? 'bg-success' : ($percentage >= 50 ? 'bg-info' : 'bg-warning') }}"
                                role="progressbar"
                                style="width: {{ $percentage }}%;"
                                aria-valuenow="{{ $percentage }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                {{ $percentage }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted mb-0">Este usuario no tiene objetivos registrados.</p>
    @endforelse
</div>