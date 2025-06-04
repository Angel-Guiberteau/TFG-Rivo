<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black objective-article" id="objectiveAdd-section" style="display: none;">

    <form class="col-12 col-lg-10 mx-auto mt-4" method="POST" action="">
        @csrf
        <input type="hidden" name="operation_id" id="operation_id"> 
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-3">Añadir objetivo</h2>
            <button class="btn btn-primary fw-bold btn-sm fs-4 custom-gradient-btn w-25 " id="back-historyIncome">
                    <i class="fas fa-arrow-left"></i>
            </button>
        </div>

        <hr class="separator">

        <div class="row justify-content-between align-items-center">
            <div class="col-12 mb-3">
                <p for="subject" class="fw-bold mb-2 fs-4">Nombre del objetivo</p>
                <input type="text" id="objectiveName" name="name" class="form-control mb-3 custom-input" placeholder="Nombre del objetivo" required>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 flex-nowrap g-3">
                <div class="d-flex align-items-center gap-4 mb-4 mb-lg-2">
                    <p for="date" class="fw-bold mb-0 fs-4">Fecha</p>
                    <input type="datetime-local" id="date" name="action_date"
                    class="form-control px-2 py-0 bg-transparent text-muted text-center fs-6 max-w-200 custom-datetime-input"
                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">


                </div>
                <div class="d-flex align-items-center gap-2">
                    <p for="schedule" class="fw-bold mb-0 fs-4">Programar</p>
                    <label class="switch mb-0">
                        <input type="checkbox" id="scheduleIncome" name="schedule">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div class="col-12 recurrence-container-income mb-3 p-2" style="display: none;">
                <div class="d-flex align-items-center justify-content-between gap-4">
                    <p for="recurrence" class="fw-bold mb-0 fs-4">Recurrencia</p>
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