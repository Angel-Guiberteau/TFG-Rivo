<section id="fourthStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-heartbeat"></i>
        <input type="number" id="salud" name="salud" placeholder="Salud"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-wifi"></i>
        <input type="number" id="comunicaciones" name="comunicaciones" placeholder="Telefonía"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-graduation-cap"></i>
        <input type="number" id="educacion" name="educacion" placeholder="Educación" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-coins"></i>
        <input type="number" id="otros" name="otros" placeholder="Otros gastos fijos"/>
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 4])

</section>