<section id="fifthStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="dinero_libre" name="dinero_libre" placeholder="Dinero libre" value="500" disabled />
    </div>
    <p class="mb-2">Este es tu dinero libre, ¿qué porcentaje de ahorro quieres tener sobre este dinero?</p>
    <p>Recomendaciones:</p>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="porcentaje_ahorro" id="porcentaje_10" value="10">
        <label class="form-check-label" for="porcentaje_10">
            10% - 50€
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="porcentaje_ahorro" id="porcentaje_15" value="15">        
        <label class="form-check-label" for="porcentaje_15">
            15% - 75€
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="porcentaje_ahorro" id="porcentaje_20" value="20"> 
        <label class="form-check-label" for="porcentaje_20">
            20% - 100€
        </label>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-percent"></i>
        <input type="number" id="porcentaje_personalizado" name="porcentaje_personalizado" placeholder="Otro porcentaje" />
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 5])

</section>