@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">

                @include('templates.admin.title', ['title' => 'Frases'])

                <div>
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Frase</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Start saving, organize your income and expenses, and reach your goals with Rivo.</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Editar</button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Start saving, organize your income and expenses, and reach your goals with Rivo.</td>
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