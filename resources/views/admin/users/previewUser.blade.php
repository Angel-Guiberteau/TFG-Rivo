@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="{{ asset('css/admin/users/usersCommon.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/users/previewUser.css') }}">
    @endpush

    <main>
        <section class="container-custom-lg p-3 pb-5">
            <article class="rounded-article mt-4">
                @include('templates.admin.title', ['title' => 'Preview del usuario: ' . $user->name])

                <div class="row mt-4 gy-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-dark text-white fs-5">
                                <i class="fas fa-user me-2"></i>Información del Usuario
                            </div>
                            <div class="card-body card-user-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>ID:</strong> {{ $user->id }}</p>
                                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                                        <p><strong>Apellido:</strong> {{ $user->last_name }}</p>
                                        <p><strong>Usuario:</strong> {{ $user->username }}</p>
                                        <p><strong>Correo:</strong> {{ $user->email }}</p>
                                        <p><strong>Google ID:</strong> {{ $user->google_id ?? 'No vinculado' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Fecha Nacimiento:</strong> {{ $user->birth_date }}</p>
                                        <p><strong>Rol:</strong> {{ $user->rol_id }}</p>
                                        <p>
                                            <strong>Estado:</strong>
                                            <span class="badge bg-{{ $user->enabled ? 'success' : 'danger' }} badge-status">
                                                {{ $user->enabled ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </p>
                                        <p>
                                            <strong>Usuario Nuevo:</strong>
                                            <span class="badge bg-{{ $user->isNewUser ? 'info' : 'secondary' }} badge-status">
                                                {{ $user->isNewUser ? 'Sí' : 'No' }}
                                            </span>
                                        </p>
                                        <p><strong>Creado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                                        <p><strong>Actualizado:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header text-white bg-secondary fs-5">
                                <i class="fas fa-layer-group me-2"></i>Categorías Personales
                            </div>
                            <div class="card-body">
                                @forelse($personalCategories as $category)
                                    <div class="d-flex flex-column mb-3 category-item">
                                        <div class="d-flex align-items-center">
                                            <span class="category-icon">{!! $category['icon'] !!}</span>
                                            <span class="fw-semibold">{{ $category['name'] }}</span>
                                        </div>
                                        @if(!empty($category['movement_type_ids']))
                                            <div class="ms-4 mt-1">
                                                <small class="text-muted">Tipos de movimiento:</small>
                                                <ul class="mb-0 ps-3">
                                                    @foreach($category['movement_type_ids'] as $typeId)
                                                        @foreach($movementTypes as $type)
                                                            @if($type['id'] == $typeId)
                                                                <li>{{ $type['name'] }}</li>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-muted">No hay categorías personales asignadas.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm h-100 mt-4">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-wallet me-2"></i>Cuentas del Usuario
                            </div>
                            <div class="card-body">
                                <div class="row gy-4">
                                    @forelse($personalAccounts as $account)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card border-0 shadow-sm h-100 account-card">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-2">
                                                        <i class="fas fa-university me-2 text-primary"></i>{{ $account->name }}
                                                    </h5>
                                                    <p class="mb-1"><strong>ID:</strong> {{ $account->id }}</p>
                                                    <p class="mb-1"><strong>Saldo:</strong> 
                                                        <span class="fw-semibold">{{ number_format($account->balance, 2) }} {{ $account->currency }}</span>
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Estado:</strong>
                                                        <span class="badge bg-{{ $account->enabled ? 'success' : 'danger' }}">
                                                            {{ $account->enabled ? 'Activo' : 'Inactivo' }}
                                                        </span>
                                                    </p>
                                                    <p class="mb-1"><strong>Creada:</strong> {{ \Carbon\Carbon::parse($account->created_at)->format('d/m/Y H:i') }}</p>
                                                    <p class="mb-0"><strong>Actualizada:</strong> {{ \Carbon\Carbon::parse($account->updated_at)->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted">No hay cuentas personales asociadas.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-5">
                    <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </article>
        </section>
    </main>

@endsection
