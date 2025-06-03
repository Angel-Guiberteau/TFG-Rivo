<section id="thirdStep" class="d-none">

    <div id="expensesDisabledMsg" class="alert alert-warning d-none" role="alert">
        ⚠️ Para introducir tus gastos, primero debes indicar al menos un ingreso fijo (paso anterior).
    </div>

    <div id="expensesSumErrorMsg" class="alert alert-warning d-none fs-5 fw-semibold text-center"></div>

    <div class="field-group mb-4">
        <div class="input-group field-group">
            <i class="fas fa-home"></i>
            <input type="number" id="homeExpenses" name="homeExpenses" placeholder="Alquiler, hipoteca..." />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group field-group">
            <i class="fas fa-bolt"></i>
            <input type="number" id="servicesHomeExpenses" name="servicesHomeExpenses" placeholder="Luz, agua, gas" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group field-group">
            <i class="fas fa-utensils"></i>
            <input type="number" id="feedingExpenses" name="feedingExpenses" placeholder="Alimentación" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group field-group">
            <i class="fas fa-bus-alt"></i>
            <input type="number" id="transportationExpenses" name="transportationExpenses" placeholder="Transporte" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 3])
</section>
