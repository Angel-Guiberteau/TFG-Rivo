<section id="secondStep" class="d-none">
    <div class="input-group mb-4">
        <i class="fas fa-money-bill-wave"></i>
        <input type="number" id="salary" name="salary" placeholder="Sueldo" />
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-users"></i>
        <input type="number" id="familyHelp" name="familyHelp" placeholder="Ayudas familiares" />
    </div>

    <div class="input-group mb-4">
        <i class="fas fa-university"></i>
        <input type="number" id="stateHelp" name="stateHelp" placeholder="Ayudas del estado" />
    </div>

    {{-- <select name="" id="" class="mb-4">
        <option value="" selected>➕ Añadir más</option>
        <option value="" >1</option>
        <option value="" >2</option>
    </select> --}}
    
    @include('home.initialSetup.buttonsContainer', ['step' => 2])

</section>