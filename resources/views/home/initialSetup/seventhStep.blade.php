<section id="seventhStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-gamepad"></i>
        <input type="number" id="ocio" name="ocio" placeholder="Ocio (Incluye Streaming, Suscripciones...)" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-tools"></i>
        <input type="number" id="imprevistos" name="imprevistos" placeholder="Imprevistos (En salud, reparaciones...)" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-spa"></i>
        <input type="number" id="cuidado_personal" name="cuidado_personal" placeholder="Cuidado personal" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-shopping-bag"></i>
        <input type="number" id="compras" name="compras" placeholder="Compras (ropa, tecnología...)" />
    </div>

    @include('home.initialSetup.buttonsContainer', ['step' => 7])

</section>