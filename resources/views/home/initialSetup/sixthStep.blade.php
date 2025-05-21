<section id="sixthStep" class="d-none">
    <p class="mb-2">Ahorro objetivo mensual</p>
    <div class="input-group mb-4">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="ahorro_disponible" name="ahorro_disponible" value="100" readonly />
    </div>

    <p class="mb-2">Elijamos un objetivo</p>


    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="objetivo_ahorro" id="objetivo_emergencia" value="emergencia">
        <label class="form-check-label" for="objetivo_emergencia">
            Fondo de emergencia
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="objetivo_ahorro" id="objetivo_deudas" value="deudas">        
        <label class="form-check-label" for="objetivo_deudas">
            Salir de deudas
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="objetivo_ahorro" id="objetivo_futuro" value="futuro"> 
        <label class="form-check-label" for="objetivo_futuro">
            Ahorros a futuro
        </label>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-flag-checkered"></i>
        <input type="text" id="objetivo_personalizado" name="objetivo_personalizado" placeholder="Otro objetivo" />
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 6])

</section>