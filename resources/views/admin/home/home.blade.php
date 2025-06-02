@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/homeAdmin.css') }}">
    @endpush

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">
                @include('templates.admin.breadCrum', [
                    'breadcrumbs' => [
                        ['name' => 'Inicio', 'url' => '/admin'],
                    ]
                ])

                @include('templates.admin.title', ['title' => 'Panel de Administración de Rivo Finanzas'])

                {{-- Contenedor central con Flexbox --}}
                <div class="container d-flex flex-column justify-content-center" style="min-height: calc(70vh - 4rem);">
                    <div class="row g-4 justify-content-center">

                        {{-- Tarjeta horizontal: Usuarios --}}
                        <div class="col-12">
                            <a href="{{ route('users') }}" class="text-decoration-none">
                                <div class="card card-custom bg-users d-flex flex-row align-items-center p-4">
                                    <div class="card-icon-circle me-4">
                                        <i class="fa-solid fa-users fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="card-title mb-1">Gestión de Usuarios</h4>
                                        <p class="card-text mb-1">Administra todos los usuarios del sistema, activa o bloquea cuentas y controla accesos.</p>
                                        <small><i class="fa-regular fa-clock me-1"></i>Última actualización: hoy</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-light text-dark">+52 usuarios</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('icons') }}" class="text-decoration-none">
                                <div class="card card-custom bg-icons h-100 text-center p-4">
                                    <div class="card-icon-circle mx-auto">
                                        <i class="fa-solid fa-icons fa-2x"></i>
                                    </div>
                                    <h5 class="card-title">Iconos</h5>
                                    <p class="card-text">Gestiona la biblioteca de iconos que se usa en todo el sistema.</p>
                                    <small><i class="fa-solid fa-layer-group me-1"></i>32 iconos disponibles</small>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('categories') }}" class="text-decoration-none">
                                <div class="card card-custom bg-categories h-100 text-center p-4">
                                    <div class="card-icon-circle mx-auto">
                                        <i class="fa-solid fa-tags fa-2x"></i>
                                    </div>
                                    <h5 class="card-title">Categorías</h5>
                                    <p class="card-text">Crea y organiza categorías para ingresos, gastos y más.</p>
                                    <small><i class="fa-solid fa-bookmark me-1"></i>15 categorías en uso</small>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('sentences') }}" class="text-decoration-none">
                                <div class="card card-custom bg-sentences h-100 text-center p-4">
                                    <div class="card-icon-circle mx-auto">
                                        <i class="fa-solid fa-quote-left fa-2x"></i>
                                    </div>
                                    <h5 class="card-title">Frases LogIn</h5>
                                    <p class="card-text">Edita las oraciones que se muestran al usuario en nuestro LogIn.</p>
                                    <small><i class="fa-regular fa-comment me-1"></i>12 oraciones activas</small>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

            </article>
        </section>
    </main>

@endsection
