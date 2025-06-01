@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">

                @include('templates.admin.title', ['title' => 'Iconos'])

                <div>
                    @include('admin.components.buttons.addButton', [
                        'data' => 'data-bs-toggle="modal" data-bs-target="#addIcon"'
                    ])
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icono</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Visualizar</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($icons as $icon)
                            <tr>
                                <td>{{ $icon['id'] }}</td>
                                <td>
                                    <label class="icons">
                                        {!! $icon['icon'] !!}
                                    </label>
                                </td>
                                <td>
                                    @include('admin.components.buttons.editButton', [
                                        'data' =>
                                            'data-id="' . e($icon['id']) . '" ' .
                                            'data-name="' . e($icon['icon']) . '" ' .
                                            'data-icon="' . e($icon['id']) . 
                                            '" data-bs-toggle="modal" data-bs-target="#editIcon"'
                                    ])
                                </td>
                                <td>
                                    @include('admin.components.buttons.preViewButton', [
                                    ])
                                </td>
                                <td>   
                                    @include('admin.components.buttons.deleteButton', [
                                        'data' => 'id="'. e($icon['id']) .'"',
                                        'onclick' => 'deleteIcon('. e($icon['id']) .')'
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

    @include('admin.components.modals.icons.addIcon')
    @include('admin.components.modals.icons.editIcon')

    @push('scripts')
        <script src="{{ asset('js/admin/modals/icons/modalAddIcon.js') }}"></script>
        <script src="{{ asset('js/admin/modals/icons/modalEditIcon.js') }}"></script>
        <script src="{{ asset('js/admin/icons/icons.js') }}"></script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/modals/modal.css') }}">
    @endpush
@endsection