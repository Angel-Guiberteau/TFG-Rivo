<div class="accordion-item mb-3 shadow-sm border-0 rounded-3 objective-card" data-index="{{ $index }}">
    <h2 class="accordion-header" id="heading{{ $index }}">
        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
            Objetivo: {{ old("objectives.$index.name", $objective->name ?? 'Nuevo') }}
        </button>
    </h2>
    <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}">
        <div class="accordion-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre del objetivo</label>
                    <input type="text" name="objectives[{{ $index }}][name]" class="form-control objective-name" value="{{ old("objectives.$index.name", $objective->name ?? '') }}" required maxlength="100">
                    <div class="valid-feedback">¡Correcto!</div>
                    <div class="invalid-feedback">El nombre es obligatorio y máximo 100 caracteres.</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Monto objetivo</label>
                    <input type="number" name="objectives[{{ $index }}][target_amount]" class="form-control target-amount" step="0.01" value="{{ old("objectives.$index.target_amount", $objective->target_amount ?? '') }}" required>
                    <div class="valid-feedback">¡Correcto!</div>
                    <div class="invalid-feedback">Debe ser un número positivo.</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Monto actual</label>
                    <input type="number" name="objectives[{{ $index }}][current_amount]" class="form-control current-amount" step="0.01" value="{{ old("objectives.$index.current_amount", $objective->current_amount ?? '') }}" required>
                    <div class="valid-feedback">¡Correcto!</div>
                    <div class="invalid-feedback">Debe ser un número positivo.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha límite</label>
                    <input type="date" name="objectives[{{ $index }}][deadline]" class="form-control deadline" value="{{ old("objectives.$index.deadline", $objective->deadline ?? '') }}">
                    <div class="valid-feedback">¡Correcto!</div>
                    <div class="invalid-feedback">La fecha debe ser hoy o posterior.</div>
                </div>

                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="objectives[{{ $index }}][enabled]" value="1" {{ old("objectives.$index.enabled", $objective->enabled ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label">Habilitado</label>
                    </div>
                </div>

                <div class="col-md-4 d-flex align-items-center justify-content-end">
                    <input type="hidden" name="objectives[{{ $index }}][id]" value="{{ $objective->id ?? '' }}">
                    <button type="button" class="btn btn-danger btn-sm remove-objective-btn" data-objective-id="{{ $objective->id ?? '' }}">
                        <i class="fas fa-trash-alt me-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
