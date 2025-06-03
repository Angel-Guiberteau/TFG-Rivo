<section id="tenthStep" class="d-none">
    <p>Escoge un nombre para tu cuenta principal</p>
    <div class="field-group mb-4">
        <div class="input-group">
            <i class="fas fa-university"></i>
            <input type="text" id="nombre_cuenta" name="account_name" placeholder="Nombre de la cuenta" maxlength="75" />
        </div>
        <div class="invalid-feedback"></div>
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 10])
</section>
