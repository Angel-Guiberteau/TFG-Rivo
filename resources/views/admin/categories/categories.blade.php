@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">

                @include('templates.admin.title', ['title' => 'Categorías base'])

                <div>
                    @include('admin.components.buttons.addButton', [
                        'data' => 'data-bs-toggle="modal" data-bs-target="#addCategory"'
                    ])
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icono</th>
                                <th>Categoria</th>
                                <th>Tipo</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Visualizar</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category['id'] }}</td>
                                <td>
                                    <label class="icons">
                                        {!! $category['icon_html'] !!}
                                    </label>
                                </td>
                                <td>{{ $category['category_name'] }}</td>
                                <td>{{ $category['movement_type_names'] }}</td>
                                <td>
                                    @include('admin.components.buttons.editButton', [
                                        'data' =>
                                            'data-id="' . e($category['id']) . '" ' .
                                            'data-name="' . e($category['category_name']) . '" ' .
                                            'data-types=\'' . e(json_encode($category['movement_type_ids'])) . '\' ' .
                                            'data-icon="' . e($category['icon_id']) . 
                                            '" data-bs-toggle="modal" data-bs-target="#editCategory"'
                                    ])
                                </td>
                                <td>
                                    @include('admin.components.buttons.preViewButton', [
                                        'data' => 'disabled',
                                        'onclick' => 'preViewCategory('.e(json_encode($category['category_name'])).')'
                                    ])
                                </td>
                                <td>   
                                    @include('admin.components.buttons.deleteButton', [
                                        'data' => 'id="'. e($category['id']) .'"',
                                        'onclick' => 'deleteCategory('. e($category['id']) .')'
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

    @include('admin.components.modals.categories.addCategory')
    @include('admin.components.modals.categories.editCategory')

    @push('scripts')
        <script src="{{ asset('js/admin/modals/categories/modalAddCategory.js') }}"></script>
        <script src="{{ asset('js/admin/modals/categories/modalEditCategory.js') }}"></script>
        <script src="{{ asset('js/admin/categories/categories.js') }}"></script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/modals/modal.css') }}">
    @endpush
@endsection