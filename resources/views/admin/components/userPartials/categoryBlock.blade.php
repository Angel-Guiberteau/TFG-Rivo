<div class="col-md-6 col-lg-4 mb-4 category-card" data-index="{{ $index }}" data-id="{{ $category['id'] ?? '' }}">
    <div class="card h-100 rounded shadow rounded-4 overflow-hidden">
        <div class="card-body d-flex flex-column p-4 bg-white">
            <input type="hidden" name="categories[{{ $index }}][id]" value="{{ $category['id'] ?? '' }}">

            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-category-btn"
                data-id="{{ $category['id'] ?? '' }}" data-existing="{{ isset($category['id']) ? 'true' : 'false' }}">
                <i class="fa-solid fa-trash"></i>
            </button>

            <div class="mb-3">
                <label class="form-label fw-medium text-muted">Nombre de la categoría <span class="text-danger">*</span></label>
                <input type="text" name="categories[{{ $index }}][name]"
                    class="form-control rounded bg-light text-center fs-5 fw-semibold shadow-sm"
                    value="{{ old("categories.$index.name", $category['name'] ?? '') }}"
                    placeholder="Introduce el nombre de la categoría">
            </div>

            <div class="text-center mb-3">
                <label class="form-label fw-medium text-muted">Icono actual</label>
                <div class="fs-2 text-custom">{!! $category['icon'] ?? '' !!}</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium text-muted">Seleccionar nuevo icono <span class="text-danger">*</span></label>
                <input type="hidden" name="categories[{{ $index }}][icon]" id="icon_{{ $index }}" value="{{ $category['icon'] ?? '' }}">

                <div class="icon-scroll-wrapper border rounded-4 p-3 bg-white shadow-sm">
                    <div class="icon-grid">
                        @foreach($allIcons as $icon)
                            <div class="icon-option {{ ($category['icon'] ?? '') === $icon->icon ? 'selected' : '' }}"
                                data-icon="{{ $icon->icon }}"
                                data-target="icon_{{ $index }}">
                                {!! $icon->icon !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12">
                <label class="form-label fw-medium text-muted">Tipos de movimiento <span class="text-danger">*</span></label>
                <div class="types d-flex flex-row flex-wrap mb-2">
                    @foreach ($movementTypes as $type)
                        <div class="form-check mb-2 me-2">
                            <input 
                                type="checkbox"
                                class="form-check-input d-none type-checkbox-edit"
                                id="movement_type_{{ $category['id'] }}_{{ $type->id }}"
                                name="data[movement_types][{{ $category['id'] }}][]"
                                value="{{ $type->id }}"
                                @if(in_array($type->id, $category['movement_type_ids'] ?? [])) checked @endif
                            >
                            <label 
                                class="form-check-label"
                                for="movement_type_{{ $category['id'] }}_{{ $type->id }}">
                                {{ $type->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
