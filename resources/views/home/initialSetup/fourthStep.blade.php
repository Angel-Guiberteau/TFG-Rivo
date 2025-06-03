<section id="fourthStep" class="d-none">

    <div id="otherExpensesDisabledMsg" class="alert alert-warning fw-bold d-none" role="alert">
        ⚠️ Para introducir tus gastos, primero debes indicar al menos un ingreso fijo (2º paso).
    </div>

    <div id="otherExpensesSumErrorMsg" class="alert alert-warning d-none fs-5 fw-semibold text-center"></div>

    <div class="field-group mb-4">
        <div class="input-group">
            <i class="fas fa-heartbeat"></i>
            <input type="number" id="healthExpenses" name="healthExpenses" placeholder="Salud"/>
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group field-group">
            <i class="fas fa-wifi"></i>
            <input type="number" id="telephoneExpenses" name="telephoneExpenses" placeholder="Telefonía"/>
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group field-group">
            <i class="fas fa-graduation-cap"></i>
            <input type="number" id="educationExpenses" name="educationExpenses" placeholder="Educación" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group field-group">
            <i class="fas fa-coins"></i>
            <input type="number" id="otherExpenses" name="otherExpenses" placeholder="Otros gastos fijos"/>
        </div>
        <div class="invalid-feedback"></div>
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 4])
</section>
