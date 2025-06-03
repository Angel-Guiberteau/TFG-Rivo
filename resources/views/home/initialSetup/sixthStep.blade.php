<section id="sixthStep" class="d-none">
    <p class="mb-2">Ahorro objetivo mensual</p>
    <div class="input-group mb-4">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="avaibleSaveMoney" name="avaibleSaveMoney" value="100" disabled />
    </div>

    <p class="mb-2">Elijamos un objetivo</p>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="objective" onchange="clearPersonalizeObj()" id="objEmergency" value="1">
        <label class="form-check-label" for="objetivo_emergencia">
            Fondo de emergencia
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="objective" onchange="clearPersonalizeObj()" id="objDebt" value="2">        
        <label class="form-check-label" for="objDebt">
            Salir de deudas
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="objective" onchange="clearPersonalizeObj()" id="objSave" value="3"> 
        <label class="form-check-label" for="objSave">
            Ahorros a futuro
        </label>
    </div>

    <div class="field-group mb-4">
        <div class="input-group">
            <i class="fas fa-flag-checkered"></i>
            <input type="text" id="objPersonalize" name="personalize_objective" placeholder="Otro objetivo" oninput="clearRadiosS6()" maxlength="75" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 6])
</section>
