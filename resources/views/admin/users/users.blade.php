@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="w-100 p-3 pb-5">
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
                                <th class="text-center">Editar</th>
                                <th class="text-center">Visualizar</th>
                                <th class="text-center">Eliminar</th>
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
                                        @include('admin.components.buttons.editButton', [
                                            'onclick' => 'editUser(' . $user->id . ')'
                                        ])                                       
                                    </td>
                                    <td>
                                        @include('admin.components.buttons.preViewButton', [
                                            
                                        ])
                                    </td>
                                    <td>
                                        @include('admin.components.buttons.deleteButton', [
                                            'data' => 'id="'. e($user->id) .'" onclick="deleteUser('. e($user->id) .')"'
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </main>

    @include('sweetAlerts.swal')

    @push('scripts')
        <script src="{{ asset('js/admin/users/users.js') }}"></script>
    @endpush

@endsection