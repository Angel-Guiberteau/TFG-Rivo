<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black category-article" id="categoryAdd-section" style="display: none;">

    @if (isset($personalCategories))
        <h2 class="mt-4 fw-bold mb-4">Categorias personales actuales</h2>
        <div class="categories-grid mb-2">
            @foreach ($personalCategories as $category)
                <label class="d-block text-center category-label">
                    <input type="radio" name="category_id" value="{{ $category['id'] }}" disabled class="d-none">
                    <div class="category-option">
                        {!! $category['icon_html'] !!}
                        <span class="text-muted fw-semibold">{{ $category['category_name'] }}</span>
                    </div>
                </label>
            @endforeach
        </div>
        

        <hr class="mt-4 separator">
    @endif    
    <form class="col-12 col-lg-10 mx-auto mt-4" method="POST" action="{{ route('addCategoryUser') }}">
        @csrf
        <input type="hidden" name="operation_id" id="operation_id"> 
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
                </div>

                <div class="col-12 mb-3">
                    <p for="subject" class="fw-bold mb-2 fs-4">Nombre de la categoría <span class="text-danger">*</span></p>
                    <input type="text" id="objectiveName" name="name" class="form-control mb-3 custom-input" placeholder="Nombre del objetivo" required>
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
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button id="submitCategories" type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-semibold fs-5 custom-gradient-btn">
                    Añadir categoría
                </button>
            </div>
        </div>
    </form>
</article>