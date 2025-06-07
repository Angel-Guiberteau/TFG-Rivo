<form method="POST" action="{{ route('updatePersonalCategories') }}">
@csrf
@method('PUT')
    <input type="hidden" id="deletedCategories" name="deleted" value="[]">
<input type="hidden" name="user_id" value="{{ $user->id }}">

<div id="categoryContainer" class="row mb-4">
    @foreach($personalCategories as $category)
        <div class="col-md-6 col-lg-4 mb-4 category-card">

            <div class="card h-100 rounded shadow rounded-4 overflow-hidden">
                <div class="card-body d-flex flex-column p-4 bg-white">
                    <input type="hidden" name="categories[{{ $category['id'] }}][id]" value="{{ $category['id'] }}">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-category-btn" data-id="{{ $category['id'] }}" data-existing="true">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted">Nombre de la categoría <span class="text-danger">*</span></label>
                        <input type="text" name="categories[{{ $category['id'] }}][name]"
                            class="form-control rounded bg-light text-center fs-5 fw-semibold shadow-sm"
                            value="{{ old("categories.{$category['id']}.name", $category['name']) }}"
                            placeholder="Introduce el nombre de la categoría">
                    </div>

                    <div class="text-center mb-3">
                        <label class="form-label fw-medium text-muted">Icono actual</label>
                        <div class="fs-2 text-custom">{!! $category['icon'] !!}</div>
                    </div>
                    

                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted">Seleccionar nuevo icono <span class="text-danger">*</span></label>
                        <input type="hidden" name="categories[{{ $category['id'] }}][icon]"
                            id="icon_{{ $category['id'] }}" value="{{ $category['icon'] }}">

                        <div class="icon-scroll-wrapper border rounded-4 p-3 bg-white shadow-sm">
                            <div class="icon-grid">
                                @foreach($allIcons as $icon)
                                    <div class="icon-option {{ $category['icon'] == $icon->icon ? 'selected' : '' }}"
                                        data-icon="{{ $icon->icon }}"
                                        data-target="icon_{{ $category['id'] }}">
                                        {!! $icon->icon !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-medium text-muted">Tipos de movimiento <span class="text-danger">*</span></label>
                        <div class="types d-flex flex-row flex-wrap mb-2 ">
                            @foreach ($movementTypes as $type)
                                <div class="form-check mb-2 me-2">
                                    <input
                                        class="form-check-input type-checkbox-edit"
                                        id="movement_type_{{ $category['id'] }}_{{ $type->id }}"
                                        type="checkbox"
                                        name="movement_types[{{ $category['id'] }}][]"
                                        value="{{ $type->id }}"
                                        @if(in_array($type->id, $category['movement_type_ids'])) checked @endif
                                    >
                                    <label
                                        class="form-check-label"
                                        for="movement_type_{{ $category['id'] }}_{{ $type->id }}"
                                    >
                                        {{ $type->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="text-end">
    <button type="button" class="btn btn-success btn-sm" id="addCustomCategoryBtn">
        <i class="fa-solid fa-plus"></i>
    </button>
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-floppy-disk"></i>
    </button>
    <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>
</form>