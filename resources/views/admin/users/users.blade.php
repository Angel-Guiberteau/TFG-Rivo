@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom-lg p-3 pb-5">
            <article class="bg-light p-3">

                @include('templates.admin.title', ['title' => 'Usuarios'])

                <div>
                    @include('admin.components.buttons.addButton', [
                        'onclick' => 'addUser()'
                    ])
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Apellido</th>
                                <th class="text-center">Fecha Nacimiento</th>
                                <th class="text-center">Rol ID</th>
                                <th class="text-center">Google ID</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Nombre Usuario</th>
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
                                    <td class="text-center">{{ $user->birth_date ?? '—' }}</td>
                                    <td class="text-center">
                                        {{ $user->rol_id == 1 ? 'Admin' : ($user->rol_id == 2 ? 'User' : ($user->rol_id == 3 ? 'Premium' : 'Desconocido')) }}
                                    </td>
                                    <td>{{ $user->google_id ?? '—' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td  class="text-center">{{ $user->username ?? '—' }}</td>
                                    <td class="text-center">
                                        @include('admin.components.buttons.editButton', [
                                            'onclick' => 'editUser(' . $user->id . ')'
                                        ])                                       
                                    </td>
                                    <td class="text-center">
                                        @include('admin.components.buttons.preViewButton', [
                                            'onclick' => "viewUser('" . $user->id . "')"
                                        ])
                                    </td>
                                    <td class="text-center">
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