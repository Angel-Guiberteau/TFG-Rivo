<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black settings-article" id="settings-section" style="display: none;">

    <form class="col-12 col-lg-10 mx-auto mt-4" method="POST" action="{{ route('updateSettingsUser') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="operation_id" id="operation_id"> 
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-3">Datos personales</h2>
        </div>

        <hr class="separator">

        <div class="row justify-content-between align-items-center">

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="username" class="fw-bold mb-2 fs-4">Nombre de usuario <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white custom-input"><i class="fa-solid fa-address-card"></i></span>
                        <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror custom-input"
                                value="{{ old('username', $user->username) }}"
                                placeholder="Nombre de usuario deseado" required>
                        @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="birth_date" class="fw-bold mb-2 fs-4">Fecha de nacimiento <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white custom-input"><i class="fa-solid fa-calendar-days"></i></span>
                        <input type="date" name="birth_date" id="birth_date"
                                class="form-control @error('birth_date') is-invalid @enderror custom-datetime-input"
                                value="{{ old('birth_date', $user->birth_date) }}"
                                placeholder="Selecciona la fecha de nacimiento" required>
                        @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="name" class="fw-bold mb-2 fs-4">Nombre <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white custom-input"><i class="fa-regular fa-user"></i></span>
                        <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror custom-input"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Introduce el nombre" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="last_name" class="fw-bold mb-2 fs-4">Apellidos <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white custom-input"><i class="fa-solid fa-id-badge"></i></span>
                        <input type="text" name="last_name" id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror custom-input"
                                value="{{ old('last_name', $user->last_name) }}"
                                placeholder="Introduce el apellido" required>
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="email" class="fw-bold mb-2 fs-4">Correo electrónico <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-white custom-input"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror custom-input"
                                value="{{ old('email', $user->email) }}"
                                placeholder="ejemplo@correo.com" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="fw-bold mb-2 fs-4">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white custom-input"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror custom-input"
                                placeholder="Introduce una nueva contraseña si deseas cambiarla">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-semibold fs-5 custom-gradient-btn">
                Guardar Cambios
            </button>
        </div>
    </form>
</article>