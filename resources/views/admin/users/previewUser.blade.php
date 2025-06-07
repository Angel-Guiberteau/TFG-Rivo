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
        <section class="container-custom p-3 pb-5">
            <article class="rounded-article mt-4">
                @include('templates.admin.breadCrum', [
                    'breadcrumbs' => [
                        ['name' => 'Inicio', 'url' => '/admin'],
                        ['name' => 'Usuarios', 'url' => '/admin/users'],
                        ['name' => 'Editar Usuario', 'url' => '']
                    ]
                ])

                @include('templates.admin.title', ['title' => 'Preview del usuario: ' . $user->name])

                <div class="row mt-2 gy-4">
                    <!-- Información del Usuario -->
                    <div class="col-lg-8  border-custom-blue p-3">
                        @include('admin.components.userPartials.userData', ['user' => $user])
                    </div>

                    <div class="col-lg-4 border-custom-grey p-3">
                        @include('admin.components.userPartials.categoriesPreview', ['user' => $user])
                    </div>

                    <div class="col-lg-12 border-custom">
                        @include('admin.components.userPartials.accountsPreview', ['user' => $user])
                    </div>
                </div>

                <div class="card bg-accounts mb-4">
                    @include('admin.components.userPartials.objetivesPreview', ['user' => $user])
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

