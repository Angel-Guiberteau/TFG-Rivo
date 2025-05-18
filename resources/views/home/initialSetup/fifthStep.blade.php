<section id="fifthStep" class="d-none">
    <div class="input-group mb-4 text-center">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="compras" name="compras" placeholder="Dinero libre" value="500" disabled />
    </div>
    <p class="mb-2">Este es tu dinero libre, ¿qué porcentaje de ahorro quieres tener sobre este dinero?</p>
    <p>Recomendaciones:</p>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentaje">
        <label class="form-check-label" for="rememberCheck">
            10% - 50€
        </label>
    </div>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentaje">        
        <label class="form-check-label" for="rememberCheck">
            15% - 75€
        </label>
    </div>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentaje"> 
        <label class="form-check-label" for="rememberCheck">
            20% - 100€
        </label>
    </div>
    <div class="input-group mb-4 text-center">
        <i class="fas fa-percent"></i>
        <input type="number" id="compras" name="compras" placeholder="Otro porcentaje" />
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 5])

</section>