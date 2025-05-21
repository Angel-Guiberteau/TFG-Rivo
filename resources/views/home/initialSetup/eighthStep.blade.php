<section id="eighthStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-plane-departure"></i>
        <input type="number" id="gasto_viajes" name="gasto_viajes" placeholder="Viajes" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-paw"></i>
        <input type="number" id="gasto_mascota" name="gasto_mascota" placeholder="Mascota" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-file-invoice-dollar"></i>
        <input type="number" id="gasto_deudas" name="gasto_deudas" placeholder="Deudas" />
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 8])
</section>