@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">

                @include('templates.admin.title', ['title' => 'Usuarios'])

                <div>
                    <button class="btn btn-primary btn-sm" onclick="addUser()">Añadir</button>
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Fecha Nacimiento</th>
                                <th>Rol ID</th>
                                <th>Google ID</th>
                                <th>Email</th>
                                <th>Nombre Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->last_name ?? '-' }}</td>
                                    <td>{{ $user->birth_date ?? '—' }}</td>
                                    <td>
                                        {{ $user->rol_id == 1 ? 'Admin' : ($user->rol_id == 2 ? 'User' : ($user->rol_id == 3 ? 'Premium' : 'Desconocido')) }}
                                    </td>
                                    <td>{{ $user->google_id ?? '—' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username ?? '—' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Editar</button>
                                        <button class="btn btn-info btn-sm">Ver</button>
                                        <button class="btn btn-danger btn-sm">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </main>

    @push('scripts')
        <script src="{{ asset('js/admin/users.js') }}"></script>
    @endpush

@endsection