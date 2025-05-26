<section id="seventhStep" class="d-none">
    <p class="fw-bold">Dinero disponible: <span class="avaibleMoneyToVariableExpenses"></span></p>
    <div class="input-group mb-4">
    <i class="fas fa-gamepad"></i>
    <input type="number" id="gasto_ocio" name="variable_freeTime" placeholder="Ocio (Incluye Streaming, Suscripciones...)" class='variableExpense' oninput="updateAvaibleMoney()"/>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-tools"></i>
        <input type="number" id="variable_unexpected" name="variable_unexpected" placeholder="Imprevistos (En salud, reparaciones...)" class='variableExpense' oninput="updateAvaibleMoney()"/>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-spa"></i>
        <input type="number" id="variable_personalCare" name="variable_personalCare" placeholder="Cuidado personal" class='variableExpense' oninput="updateAvaibleMoney()"/>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-shopping-bag"></i>
        <input type="number" id="variable_purchases" name="variable_purchases" placeholder="Compras (ropa, tecnología...)" class='variableExpense' oninput="updateAvaibleMoney()"/>
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 7])

</section>