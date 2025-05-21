<section id="thirdStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-home"></i>
        <input type="number" id="gasto_vivienda" name="gasto_vivienda" placeholder="Alquiler, hipoteca..." />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-bolt"></i>
        <input type="number" id="gasto_servicios" name="gasto_servicios" placeholder="Luz, agua, gas" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-utensils"></i>
        <input type="number" id="gasto_alimentacion" name="gasto_alimentacion" placeholder="Alimentación" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-bus-alt"></i>
        <input type="number" id="gasto_transporte" name="gasto_transporte" placeholder="Transporte" />
    </div>
    
    
    @include('home.initialSetup.buttonsContainer', ['step' => 3])

</section>