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
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSentence">Añadir</button>
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
                                    <button class="btn btn-primary btn-sm"
                                            data-id="1"
                                            data-name="Start saving, organize your income and expenses, and reach your goals with Rivo."
                                            data-bs-toggle="modal"
                                            data-bs-target="#editSentence">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Start saving, organize your income and expenses, and reach your goals with Rivo.</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                            data-id="2"
                                            data-name="Start saving, organize your income and expenses, and reach your goals with Rivo."
                                            data-bs-toggle="modal"
                                            data-bs-target="#editSentence">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </main>

    @push('scripts')
        <script src="{{ asset('js/admin/modals/modalAddSentence.js') }}"></script>
        <script src="{{ asset('js/admin/modals/modalEditSentence.js') }}"></script>
        <script src="{{ asset('js/admin/sentences.js') }}"></script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/modals/modal.css') }}">
    @endpush

    @include('admin.components.modals.addSentence')
    @include('admin.components.modals.editSentence')
@endsection