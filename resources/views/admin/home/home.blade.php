@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">

                @include('templates.admin.title', ['title' => 'Panel de Administración'])

                <div>
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Juan Pérez</td>
                                <td>juan.perez@example.com</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Editar</button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>María López</td>
                                <td>maria.lopez@example.com</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Editar</button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </main>


@endsection