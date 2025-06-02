<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black income-article" id="incomeAddForm-section" style="display: none;">

    <form class="col-12 col-lg-10 mx-auto mt-4" method="POST" action="{{ route('addOperationUser') }}">
        @csrf
        <input type="hidden" name="account_id" value="{{ $account->id }}">
        <input type="hidden" name="movement_type" value="income">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-3">Añadir ingreso</h2>
            <button class="btn btn-primary fw-bold btn-sm fs-4 custom-gradient-btn w-25 " id="back-historyIncome">
                    <i class="fas fa-arrow-left"></i>
            </button>
        </div>

        <hr class="separator">

        <div class="row justify-content-between align-items-center">
            <div class="col-12 d-flex flex-column mb-3">
                <label class="fw-bold mb-0 fs-4">Categorías</label>
                <div class="categories-grid mt-2">
                    @foreach ($baseCategories as $category)
                        @if(in_array(1, $category['movement_type_ids']))
                            <label class="d-block text-center">
                                <input type="radio" name="category_id" value="{{ $category['id'] }}" class="d-none">
                                <div class="category-option">
                                    {!! $category['icon_html'] !!}
                                    <span class="text-muted fw-semibold">{{ $category['category_name'] }}</span>
                                </div>
                            </label>
                        @endif
                    @endforeach
                    @foreach ($personalCategories as $category)
                        @if(in_array(1, $category['movement_type_ids']))
                            <label class="d-block text-center">
                                <input type="radio" name="category_id" value="{{ $category['id'] }}" class="d-none">
                                <div class="category-option">
                                    {!! $category['icon_html'] !!}
                                    <span class="text-muted fw-semibold">{{ $category['category_name'] }}</span>
                                </div>
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="subject" class="fw-bold mb-0 fs-4">Asunto</label>
                <input type="text" id="subject" name="subject" class="form-control mb-3 custom-input" placeholder="Asunto" required>
                <textarea id="description" name="description" class="form-control custom-input" rows="3" placeholder="Description"></textarea>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 flex-nowrap g-3">
                <div class="d-flex align-items-center gap-4 mb-4 mb-lg-2">
                    <label for="date" class="fw-bold mb-0 fs-4">Fecha</label>
                    <input type="datetime-local" id="date" name="action_date"
                    class="form-control px-2 py-0 bg-transparent text-muted text-center fs-6 max-w-200 custom-datetime-input"
                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">


                </div>
                <div class="d-flex align-items-center gap-2">
                    <label for="schedule" class="fw-bold mb-0 fs-4">Programar</label>
                    <label class="switch mb-0">
                        <input type="checkbox" id="scheduleIncome" name="schedule">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div class="col-12 recurrence-container-income mb-3 p-2" style="display: none;">
                <div class="d-flex align-items-center justify-content-between gap-4">
                    <label for="recurrence" class="fw-bold mb-0 fs-4">Recurrencia</label>
                    <div class="custom-select-wrapper">
                        <select id="period" name="period" class="form-select  bg-transparent custom-input">
                            <option value="m">Mensual</option>
                            <option value="w">Semanal</option>
                            <option value="d">Diario</option>
                        </select>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>

                <div class="col-12 d-flex align-items-center justify-content-between w-100 mt-3">
                    <label for="start_date" class="fw-bold mb-0 fs-4">Fecha de comienzo</label>
                    <input type="datetime-local" id="start_date" name="start_date" 
                    class="form-control px-2 py-0  bg-transparent text-muted text-center max-w-200 fs-6 custom-datetime-input"
                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                </div>
                <div class="col-12 d-flex align-items-center justify-content-between w-100 mt-3">
                    <label for="expiration_date" class="fw-bold mb-0 fs-4">Fecha de expiración</label>
                    <input type="datetime-local" id="expiration_date" name="expiration_date" 
                    class="form-control px-2 py-0  bg-transparent text-muted text-center max-w-200 fs-6 custom-datetime-input"
                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                    
                </div>
            </div>
            <div class="col-12">
                <div class="input-group">
                    <input type="number" class="form-control fs-5 custom-input" id="amount" name="amount" placeholder="€ Cantidad" min="0" step="0.01">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-semibold fs-5 custom-gradient-btn">
                Añadir ingreso
            </button>
        </div>
    </form>
</article>