<section id="thirdStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-home"></i>
        <input type="number" id="homeExpenses" name="homeExpenses" placeholder="Alquiler, hipoteca..." />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-bolt"></i>
        <input type="number" id="servicesHomeExpenses" name="servicesHomeExpenses" placeholder="Luz, agua, gas" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-utensils"></i>
        <input type="number" id="feedingExpenses" name="feedingExpenses" placeholder="Alimentación" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-bus-alt"></i>
        <input type="number" id="transportationExpenses" name="transportationExpenses" placeholder="Transporte" />
    </div>
    
    
    @include('home.initialSetup.buttonsContainer', ['step' => 3])

</section>