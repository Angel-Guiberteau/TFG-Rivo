@extends('admin.layoutAdmin')

@section('title', 'Editar Usuario')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="{{ asset('css/admin/users/usersCommon.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/users/personalData.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/users/personalCategories.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/users/personalAccounts.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/users/personalObjetives.css') }}">
    @endpush

    <main>
        <section class="container-custom-lg p-3 pb-5">
            <article class="bg-light p-4 mt-4 shadow-sm rounded-3">
                @include('templates.admin.breadCrum', [
                    'breadcrumbs' => [
                        ['name' => 'Inicio', 'url' => '/admin'],
                        ['name' => 'Usuarios', 'url' => '/admin/users'],
                        ['name' => 'Editar Usuario', 'url' => '']
                    ]
                ])

                @include('templates.admin.title', ['title' => 'Editar Usuario'])

                @include('admin.components.progressLine')

                <div id="personalData" class="mb-4">

                    @include('admin.components.usersSections.personalData')
                    
                </div>

                <div id="personalCategories" class="row mb-4 d-none">
                    
                    @include('admin.components.usersSections.personalCategories')

                </div>

                <div id="personalAccounts" class="row mb-4 d-none">

                    @include('admin.components.usersSections.personalAccounts')

                </div>

                <div id="personalObjetives" class="row mb-4 d-none">

                    @include('admin.components.usersSections.personalObjetives')

                </div>

            </article>
        </section>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
        <script src="{{ asset('js/admin/users/editUser.js') }}"></script>
        <script src="{{ asset('js/admin/users/personalCategories.js') }}"></script>
        <script src="{{ asset('js/admin/users/personalAccounts.js') }}"></script>
        <script src="{{ asset('js/admin/users/personalObjetives.js') }}"></script>
        <script>
            const movementTypes = @json($movementTypes);
            const allIcons = @json($allIcons);
            let objectiveIndex = {{ count($objectives) }}
        </script>
    @endpush

@endsection