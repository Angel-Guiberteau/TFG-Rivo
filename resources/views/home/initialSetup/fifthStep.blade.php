<section id="fifthStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="freeMoney" name="dinero_libre" placeholder="Dinero libre" value="500" disabled />
    </div>
    <p class="mb-2">Este es tu dinero libre, ¿qué porcentaje de ahorro quieres tener sobre este dinero?</p>
    <p>Recomendaciones:</p>
    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentage" id="percentage1" value="10" onchange="whatPercentage(1)">
        <label id="labelPercentage1" class="form-check-label" for="porcentaje_10">
            
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentage" id="percentage2" value="15" onchange="whatPercentage(2)">        
        <label id="labelPercentage2" class="form-check-label" for="porcentaje_15">
            
        </label>
    </div>

    <div class="form-check custom-checkbox-container mb-4">
        <input class="custom-checkbox" type="radio" name="percentage" id="percentage3" value="20" onchange="whatPercentage(3)"> 
        <label id="labelPercentage3" class="form-check-label" for="porcentaje_20">
        
        </label>
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-percent"></i>
        <input type="number" id="personalizePercentage" name="personalizePercentage" placeholder="Otro porcentaje" oninput="clearRadios(); whatPercentage(4)" />
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 5])

</section>