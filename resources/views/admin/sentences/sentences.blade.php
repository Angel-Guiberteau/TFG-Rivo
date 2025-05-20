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
                    @include('admin.components.buttons.addButton', [
                        'data' => 'data-bs-toggle="modal" data-bs-target="#addSentence"'
                    ])
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Frase</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sentences as $sentence)
                            <tr>
                                <td>{{ $sentence->id }}</td>
                                <td>{{ $sentence->text }}</td>
                                <td>
                                    @include('admin.components.buttons.editButton', [
                                        'data' => 'data-id="' . e($sentence->id) . '" data-name="' . e($sentence->text) . '" data-bs-toggle="modal" data-bs-target="#editSentence"'
                                    ])
                                    @include('admin.components.buttons.preViewButton', [
                                        'data' => 'onclick=" preViewSentence('.e(json_encode($sentence->text)).')"'
                                    ])
                                    @include('admin.components.buttons.deleteButton', [
                                        'data' => 'id="'. e($sentence->id) .'" onclick="deleteSentence('. e($sentence->id) .')"'
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