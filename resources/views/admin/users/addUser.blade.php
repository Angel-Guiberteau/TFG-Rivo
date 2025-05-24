@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="{{ asset('css/admin/users/usersCommon.css') }}">
    @endpush

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-4 mt-4 shadow-sm rounded-3">
                @include('templates.admin.title', ['title' => 'Añadir Usuario'])

                <form action="{{ route('storeUser') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa-regular fa-user"></i></span>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
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
                                    value="{{ old('last_name') }}"
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
                                    value="{{ old('birth_date') }}"
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
                                    <option value="">Seleccionar rol</option>
                                    <option value="1" {{ old('rol_id') == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ old('rol_id') == 2 ? 'selected' : '' }}>User</option>
                                    <option value="3" {{ old('rol_id') == 3 ? 'selected' : '' }}>Premium</option>
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
                                    value="{{ old('email') }}"
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
                                    value="{{ old('username') }}"
                                    placeholder="Nombre de usuario deseado" required>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Introduce una contraseña segura" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar
                        </button>
                        <a href="{{ route('users') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-circle-xmark"></i> Cancelar
                        </a>
                    </div>
                </form>
            </article>
        </section>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
        <script src="{{ asset('js/admin/users/adduser.js') }}"></script>
    @endpush

@endsection
