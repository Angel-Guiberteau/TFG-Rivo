@extends('admin.layoutAdmin')

@section('title', 'Editar Usuario')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="{{ asset('css/admin/users/usersCommon.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/users/baseCategories.css') }}">
    @endpush

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-4 mt-4 shadow-sm rounded-3">
                @include('templates.admin.title', ['title' => 'Editar Usuario'])

                @include('admin.components.progressLine')

                <div id="personalData" class="mb-4">

                    <form action="{{ route('updateUser') }}" method="POST">
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
                        </div>
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                            <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <div id="personalCategories" class="row mb-4 d-none">
                    <form method="POST" action="{{ route('updatePersonalCategories') }}">
                        @csrf
                        @method('PUT')
                         <input type="hidden" id="deletedCategories" name="deleted" value="[]">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <div id="categoryContainer" class="row mb-4">
                            @foreach($personalCategories as $category)
                                <div class="col-md-6 col-lg-4 mb-4 category-card">

                                    <div class="card h-100 rounded shadow rounded-4 overflow-hidden">
                                        <div class="card-body d-flex flex-column p-4 bg-white">
                                            <input type="hidden" name="categories[{{ $category['id'] }}][id]" value="{{ $category['id'] }}">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-category-btn" data-id="{{ $category['id'] }}" data-existing="true">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="mb-3">
                                                <label class="form-label fw-medium text-muted">Nombre de la categoría</label>
                                                <input type="text" name="categories[{{ $category['id'] }}][name]"
                                                    class="form-control rounded bg-light text-center fs-5 fw-semibold shadow-sm"
                                                    value="{{ old("categories.{$category['id']}.name", $category['name']) }}"
                                                    placeholder="Introduce el nombre de la categoría">
                                            </div>

                                            <div class="text-center mb-3">
                                                <label class="form-label fw-medium text-muted">Icono actual</label>
                                                <div class="fs-2 text-primary">{!! $category['icon'] !!}</div>
                                            </div>
                                            

                                            <div class="mb-3">
                                                <label class="form-label fw-medium text-muted">Seleccionar nuevo icono</label>
                                                <input type="hidden" name="categories[{{ $category['id'] }}][icon]"
                                                    id="icon_{{ $category['id'] }}" value="{{ $category['icon'] }}">

                                                <div class="icon-scroll-wrapper border rounded-4 p-3 bg-white shadow-sm">
                                                    <div class="icon-grid">
                                                        @foreach($allIcons as $icon)
                                                            <div class="icon-option {{ $category['icon'] == $icon->icon ? 'selected' : '' }}"
                                                                data-icon="{{ $icon->icon }}"
                                                                data-target="icon_{{ $category['id'] }}">
                                                                {!! $icon->icon !!}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="text-end">
                            <button type="button" class="btn btn-success btn-sm" id="addCustomCategoryBtn">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                            <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        </div>
                    </form>
                </div>



                <div id="personalAccounts" class="row mb-4 d-none">


                </div>


            </article>
        </section>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
        <script src="{{ asset('js/admin/users/editUser.js') }}"></script>
        <script src="{{ asset('js/admin/users/baseCategories.js') }}"></script>
        <script>
            const allIcons = @json($allIcons);
        </script>
    @endpush

@endsection