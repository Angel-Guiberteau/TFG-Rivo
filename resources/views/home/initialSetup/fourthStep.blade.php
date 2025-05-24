<section id="fourthStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-heartbeat"></i>
        <input type="number" id="healthExpenses" name="healthExpenses" placeholder="Salud"/>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-wifi"></i>
        <input type="number" id="telephoneExpenses" name="telephoneExpenses" placeholder="Telefonía"/>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-graduation-cap"></i>
        <input type="number" id="educationExpenses" name="educationExpenses" placeholder="Educación" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-coins"></i>
        <input type="number" id="otherExpenses" name="otherExpenses" placeholder="Otros gastos fijos"/>
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 4])

</section>