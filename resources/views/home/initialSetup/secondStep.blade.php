<section id="secondStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="sueldo" name="sueldo" placeholder="Sueldo" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-users"></i>
        <input type="number" id="ayuda_familiar" name="ayuda_familiar" placeholder="Ayudas familiares" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-university"></i>
        <input type="number" id="ayuda_estado" name="ayuda_estado" placeholder="Ayudas del estado" />
    </div>

    {{-- <select name="" id="" class="mb-4">
        <option value="" selected>➕ Añadir más</option>
        <option value="" >1</option>
        <option value="" >2</option>
    </select> --}}
    
    @include('home.initialSetup.buttonsContainer', ['step' => 2])

</section>