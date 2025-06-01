<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black income-article" id="incomeAddForm-section" style="display: none;">

    <form class="col-12 col-lg-10 mx-auto mt-4">

        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-1">Añadir un ingreso</h2>
            <button class="btn btn-primary fw-bold btn-sm fs-4 custom-gradient-btn w-25 " id="back-historyIncome">
                    <i class="fas fa-arrow-left"></i>
            </button>
        </div>

        <hr class="separator">

        <div class="d-flex flex-row justify-content-between align-items-center">
            
                <div class="d-flex flex-column mb-3">
                    <label class="fw-bold mb-0 fs-4">Categorías</label>
                    <div class="d-flex flex-wrap mt-2">
                        @foreach([
                            ['Trabajo', 'fa-briefcase', 'Trabajo'],
                            ['Freelance', 'fa-laptop-code', 'Freelance'],
                            ['Regalo', 'fa-gift', 'Regalo'],
                            ['Premio', 'fa-trophy', 'Premio'],
                            ['Venta', 'fa-tags', 'Venta'],
                            ['Renta', 'fa-home', 'Renta'],
                            ['Intereses', 'fa-coins', 'Intereses'],
                            ['Otros', 'fa-ellipsis-h', 'Otros'],
                            ['Trabajo', 'fa-briefcase', 'Trabajo'],
                            ['Freelance', 'fa-laptop-code', 'Freelance'],
                            ['Nueva', 'fa-plus', 'Nueva']
                        ] as [$value, $icon, $label])
                            <div class="me-2 mb-2">
                                <label class="d-block text-center">
                                    <input type="radio" name="category" value="{{ $value }}" class="d-none">
                                    <div class="category-option">
                                        <i class="fas {{ $icon }} text-secondary fs-6"></i>
                                        <span class="mt-1 text-muted fw-semibold small">{{ $label }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        <div class="row">
            <div class="">
                <div class="mb-3">
                    <label for="subject" class="fw-bold mb-0 fs-4">Asunto</label>
                    <input type="text" id="subject" name="subject" class="form-control mb-3" placeholder="Asunto" required>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description"></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 flex-nowrap">
                    <div class="d-flex align-items-center gap-4">
                        <label for="date" class="fw-bold mb-0 fs-4">Fecha</label>
                        <input type="date" id="date" name="date" class="form-control border-0 p-0 bg-transparent text-muted text-center" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label for="schedule" class="fw-bold mb-0 fs-4">Programar</label>
                        <label class="switch mb-0">
                            <input type="checkbox" id="scheduleIncome" name="schedule">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="recurrence-container-income mb-3" style="display: none;">
                    <div class="d-flex align-items-center justify-content-between gap-4">
                        <label for="recurrence" class="fw-bold mb-0 fs-4">Recurrencia</label>
                        <div class="custom-select-wrapper">
                            <select id="recurrence" name="recurrence" class="form-select border-0 bg-transparent">
                                <option>Una vez</option>
                                <option>Semanal</option>
                                <option>Mensual</option>
                                <option>Bisemanal</option>
                            </select>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between w-100 mt-3">
                        <label for="expiration_date" class="fw-bold mb-0 fs-4">Fecha de expiración</label>
                        <input type="date" id="expiration_date" name="expiration_date" 
                            class="form-control border-0 p-0 bg-transparent text-muted text-center max-w-200"
                            value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="">
                    <div class="input-group">
                        <input type="number" class="form-control fs-5" id="amount" name="amount" placeholder="€ Cantidad" min="0" step="0.01">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-semibold fs-5 custom-gradient-btn">
                    Añadir ingreso
                </button>
            </div>
        </div>
    </form>
</article>