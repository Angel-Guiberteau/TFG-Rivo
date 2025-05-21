<section id="firstStep">
    <div class="input-group mb-4">
        <i class="fas fa-user"></i>
        <input type="text" id="name" name="name" placeholder="Nombre"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-user"></i>
        <input type="text" id="last_name" name="last_name" placeholder="Apellidos"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-user"></i>
        <input type="text" id="username" name="username" placeholder="Nombre de usuario"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-calendar-alt"></i>
        <input type="text" id="birth_date" name="birth_date" placeholder="Selecciona la fecha de nacimiento"/>
    </div>

    @include('components.buttons.initialSetupButton', ['step' => 1,])

</section>