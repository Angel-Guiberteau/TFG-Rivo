<form action="{{ route('updateUser') }}" method="POST" id="form-user-edit">
@csrf
@method('PUT')

<div class="row mb-4">
    <div class="col-md-6">
        <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa-regular fa-user"></i></span>
            <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Introduce el nombre" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="last_name" class="form-label">Apellido <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa-solid fa-id-badge"></i></span>
            <input type="text" name="last_name" id="last_name"
                    class="form-control @error('last_name') is-invalid @enderror"
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
        <label for="birth_date" class="form-label">Fecha de nacimiento <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa-solid fa-calendar-days"></i></span>
            <input type="text" name="birth_date" id="birth_date"
                    class="form-control @error('birth_date') is-invalid @enderror"
                    value="{{ old('birth_date', $user->birth_date) }}"
                    placeholder="Selecciona la fecha de nacimiento" required>
            @error('birth_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="rol_id" class="form-label">Rol <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa-solid fa-user-gear"></i></span>
            <select name="rol_id" id="rol_id"
                    class="form-select @error('rol_id') is-invalid @enderror" required>
                <option value="" hidden disabled>Seleccionar rol</option>
                <option value="1" {{ old('rol_id', $user->rol_id) == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ old('rol_id', $user->rol_id) == 2 ? 'selected' : '' }}>User</option>
                <option value="3" {{ old('rol_id', $user->rol_id) == 3 ? 'selected' : '' }}>Premium</option>
            </select>
            @error('rol_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <label for="email" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}"
                    placeholder="ejemplo@correo.com" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="username" class="form-label">Nombre de usuario <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa-solid fa-address-card"></i></span>
            <input type="text" name="username" id="username"
                    class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username', $user->username) }}"
                    placeholder="Nombre de usuario deseado" required>
            @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>


<div class="row mb-4">
    <div class="col-md-6">
        <label for="password" class="form-label">Contraseña</label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa-solid fa-lock"></i></span>
            <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Introduce una nueva contraseña si deseas cambiarla">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="is_new_user" class="form-label">¿Es nuevo usuario?</label>
        <div class="input-group align-items-center">
            <span class="input-group-text bg-white"><i class="fa-solid fa-user-plus"></i></span>
            <div class="form-check form-switch ms-2">
                <input class="form-check-input @error('is_new_user') is-invalid @enderror"
                    type="checkbox"
                    name="is_new_user"
                    id="is_new_user"
                    value="1"
                    @if(old('is_new_user') === '1' || (old('is_new_user') === null && $user->isNewUser)) checked @endif>
                <label class="form-check-label ms-2" for="is_new_user">Sí</label>
            </div>
            @error('is_new_user')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<input type="hidden" name="id" value="{{ $user->id }}">
<div class="text-end mt-4">
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-floppy-disk"></i>
    </button>
    <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>
</form>