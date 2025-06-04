<section id="secondStep" class="d-none">
    <div class="field-group mb-4">
        <div class="input-group">
            <i class="fas fa-money-bill-wave"></i>
            <input type="number" id="salary" name="salary" placeholder="Sueldo" step="0.01" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group">
            <i class="fas fa-users"></i>
            <input type="number" id="familyHelp" name="familyHelp" placeholder="Ayudas familiares" step="0.01" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="field-group mb-4">
        <div class="input-group">
            <i class="fas fa-university"></i>
            <input type="number" id="stateHelp" name="stateHelp" placeholder="Ayudas del estado" step="0.01" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 2])
</section>
