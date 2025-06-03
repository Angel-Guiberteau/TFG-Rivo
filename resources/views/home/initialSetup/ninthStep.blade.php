<section id="ninthStep" class="d-none">

    <div id="noObjectiveAlert" class="alert alert-danger fw-bold d-none mb-3" role="alert">
        ⚠️ Al no elegir objetivo se guardará como operación y no progresará ningún objetivo.
    </div>

    <div class="field-group mb-2">
        <div class="input-group">
            <i class="fas fa-piggy-bank"></i>
            <input type="number" id="ahorro_actual" name="actually_save" placeholder="Ahorro actual" step="0.01" />
        </div>
        <div class="invalid-feedback"></div>
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 9])
</section>
