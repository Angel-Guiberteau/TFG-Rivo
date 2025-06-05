<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black category-article" id="categoryAdd-section" style="display: none;">

    @if (isset($personalCategories) && count($personalCategories))
        <h2 class="mt-4 fw-bold mb-4">Categorías personales actuales</h2>
        <div class="scroll-wrapper categories-grid mb-2">
            @foreach ($personalCategories as $category)
                <div class="position-relative category-label-personal d-flex flex-column align-items-center text-center p-2 border rounded" data-id="{{ $category['id'] }}">
                    <input type="radio" value="{{ $category['id'] }}" disabled class="d-none">
                    <div class="category-option mb-2">
                        {!! $category['icon_html'] !!}
                        <span class="text-muted fw-semibold d-block">{{ $category['category_name'] }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit-category" data-id="{{ $category['id'] }}">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-category" data-id="{{ $category['id'] }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <hr class="mt-4 separator">
    @endif


    <form class="col-12 col-lg-10 mx-auto mt-4" method="POST" action="{{ route('addOrEditCategory') }}">
        @csrf
        <input type="hidden" name="id">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-3">Añadir categoría</h2>
        </div>

        <hr class="separator">

        <div class="row justify-content-between align-items-center">
            <div class="col-12 mb-3">
                <p for="subject" class="fw-bold mb-2 fs-4">Icono <span class="text-danger">*</span></p>
                <div class="mb-3">
                    <input type="hidden" name="icon" id="icon" value="">
                    <div class="icon-scroll-wrapper border rounded-4 p-3 bg-white shadow-sm">
                        <div class="icon-grid"></div>
                    </div>
                    <div id="icon-feedback" class="invalid-feedback d-none mt-1">⚠️ Debes seleccionar un icono.</div>
                </div>

                <div class="col-12 mb-3">
                    <p for="subject" class="fw-bold mb-2 fs-4">Nombre de la categoría <span class="text-danger">*</span></p>
                    <input type="text" id="categoryName" name="name" class="form-control mb-3 custom-input" placeholder="Nombre del objetivo" required>
                    <div class="invalid-feedback d-none">⚠️ No se permiten caracteres especiales ni más de 30 caracteres.</div>
                </div>
                <div class="col-12 mb-3">
                    <p class="fw-bold mb-2 fs-4">Tipo de operación <span class="text-danger">*</span></p>
                    <div class="categories-grid operation-types">
                        <input type="checkbox" name="types[]" value="income" id="cat-op-income" class="type-radio">
                        <label for="cat-op-income">Ingreso</label>

                        <input type="checkbox" name="types[]" value="expense" id="cat-op-expense" class="type-radio">
                        <label for="cat-op-expense">Gasto</label>

                        <input type="checkbox" name="types[]" value="save" id="cat-op-save" class="type-radio">
                        <label for="cat-op-save">Ahorro</label>
                        
                    </div>
                    <div id="types-feedback" class="invalid-feedback d-none mt-1">⚠️ Debes seleccionar al menos un tipo de operación.</div>
                </div>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <button id="submitCategories" type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-semibold fs-5 custom-gradient-btn">
                    Añadir categoría
                </button>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <button type="button" id="resetCategoryButton" class="d-none btn btn-secondary w-100 py-2 fw-semibold fs-5">
                    Nueva categoría
                </button>
            </div>
        </div>
    </form>
</article>
