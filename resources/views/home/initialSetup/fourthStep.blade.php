<section id="fourthStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-heartbeat"></i>
        <input type="number" id="gasto_salud" name="gasto_salud" placeholder="Salud"/>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-wifi"></i>
        <input type="number" id="gasto_comunicaciones" name="gasto_comunicaciones" placeholder="Telefonía"/>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-graduation-cap"></i>
        <input type="number" id="gasto_educacion" name="gasto_educacion" placeholder="Educación" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-coins"></i>
        <input type="number" id="gasto_otros" name="gasto_otros" placeholder="Otros gastos fijos"/>
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 4])

</section>