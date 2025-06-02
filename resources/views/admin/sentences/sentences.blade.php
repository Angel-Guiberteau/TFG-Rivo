@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">
                @include('templates.admin.breadCrum', [
                    'breadcrumbs' => [
                        ['name' => 'Inicio', 'url' => '/admin'],
                        ['name' => 'Frases', 'url' => '/admin/sentences'],
                    ]
                ])

                @include('templates.admin.title', ['title' => 'Frases'])

                <div>
                    @include('admin.components.buttons.addButton', [
                        'data' => 'data-bs-toggle="modal" data-bs-target="#addSentence"'
                    ])
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Frase</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Visualizar</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sentences as $sentence)
                            <tr>
                                <td class="text-center align-middle">{{ $sentence->id }}</td>
                                <td>{{ $sentence->text }}</td>
                                <td class="text-center align-middle">
                                    @include('admin.components.buttons.editButton', [
                                        'data' => 'data-id="' . e($sentence->id) . '" 
                                        data-name="' . e($sentence->text) . '" 
                                        data-bs-toggle="modal" data-bs-target="#editSentence"'
                                    ])
                                </td>
                                <td class="text-center align-middle">
                                    @include('admin.components.buttons.preViewButton', [
                                        'onclick' => 'preViewSentence('.e(json_encode($sentence->text)).')',
                                    ])
                                </td>
                                <td class="text-center align-middle">
                                    @include('admin.components.buttons.deleteButton', [
                                        'data' => 'id="'. e($sentence->id) .'" 
                                        onclick="deleteSentence('. e($sentence->id) .')"'
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

    @push('scripts')
        <script src="{{ asset('js/admin/modals/sentences/modalAddSentence.js') }}"></script>
        <script src="{{ asset('js/admin/modals/sentences/modalEditSentence.js') }}"></script>
        <script src="{{ asset('js/admin/sentences/sentences.js') }}"></script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/modals/modal.css') }}">
    @endpush
    @include('sweetAlerts.swal')
    @include('admin.components.modals.sentences.addSentence')
    @include('admin.components.modals.sentences.editSentence')
@endsection