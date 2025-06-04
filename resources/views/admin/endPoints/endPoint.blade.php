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
                        ['name' => 'Endpoints', 'url' => '/admin/endPoints'],
                    ]
                ])

                @include('templates.admin.title', ['title' => 'Endpoints'])

                <div>
                    @include('admin.components.buttons.addButton', [
                        'onclick' => 'addEndPoint()'
                    ])
                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">URL</th>
                                <th class="text-center">Metodo</th>
                                <th class="text-center">Parametros</th>
                                <th class="text-center">Retorno</th>
                                <th class="text-center">Datos de retorno</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($endPoints as $endPoint)
                            <tr>
                                <td  class="text-center">{{ $endPoint['name'] }}</td>
                                <td class="text-center">{{ $endPoint['description'] }}</td>
                                <td class="text-center">{{ $endPoint['url'] }}</td>
                                <td class="text-center">{{ $endPoint['method'] }}</td>
                                <td class="text-center">{{ $endPoint['parameters'] }}</td>
                                <td class="text-center">{{ $endPoint['return'] }}</td>
                                <td class="text-center align-middle">{{ $endPoint['return_data'] }}</td>
                                <td class="text-center align-middle">
                                    @include('admin.components.buttons.editButton', [
                                        'onclick' => 'editEndPoint('. e($endPoint['id']) .')'
                                    ])
                                </td>
                                <td class="text-center align-middle">   
                                    @include('admin.components.buttons.deleteButton', [
                                        'onclick' => 'deleteEndPoint('. e($endPoint['id']) .')'
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
        <script src="{{ asset('js/admin/endPoints/endPoints.js') }}"></script>
    @endpush
    
@endsection