<section id="sixthStep" class="d-none">
    <p class="mb-2">Ahorro objetivo mensual</p>
    <div class="input-group mb-4 text-center">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="ahorro" name="compras"  value="100" disabled />
    </div>
    <p class="mb-2">Elijamos un objetivo</p>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentaje">
        <label class="form-check-label" for="rememberCheck">
            Fondo de emergencia
        </label>
    </div>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentaje">        
        <label class="form-check-label" for="rememberCheck">
            Salir de deudas
        </label>
    </div>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentaje"> 
        <label class="form-check-label" for="rememberCheck">
            Ahorros a futuro
        </label>
    </div>
    <div class="input-group mb-4 text-center">
        <i class="fas fa-flag-checkered"></i>
        <input type="number" id="compras" name="compras" placeholder="Otro objetivo" />
    </div>
    
    @include('home.initialSetup.buttonsContainer', ['step' => 6])

</section>