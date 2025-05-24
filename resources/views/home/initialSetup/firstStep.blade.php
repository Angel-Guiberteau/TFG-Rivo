<section id="firstStep">
    <div class="input-group mb-4">
        <i class="fas fa-user"></i>
        <input type="email" id="email" name="email" placeholder="Nombre"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-user"></i>
        <input type="email" id="email" name="email" placeholder="Apellidos"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-user"></i>
        <input type="email" id="email" name="email" placeholder="Nombre de usuario"/>
    </div>
    <div class="input-group mb-4">
        <i class="fas fa-calendar-alt"></i>
        <input type="date" id="date" name="birthday" placeholder="Fecha de nacimiento"/>
    </div>

    @include('components.buttons.initialSetupButton', ['step' => 1,])

</section>