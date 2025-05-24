<section id="eighthStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-plane-departure"></i>
        <input type="number" id="viajes" name="viajes" placeholder="Viajes" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-paw"></i>
        <input type="number" id="mascota" name="mascota" placeholder="Mascota" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-file-invoice-dollar"></i>
        <input type="number" id="deudas" name="deudas" placeholder="Deudas" />
    </div>
    @include('home.initialSetup.buttonsContainer', ['step' => 8])
</section>