    @extends('admin.layoutAdmin')

    @section('title', 'Admin Rivo Finanzas')

    @section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    @push('style')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @endpush

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3 endPoint">

                @include('templates.admin.breadCrum', [
                    'breadcrumbs' => [
                        ['name' => 'Inicio', 'url' => '/admin'],
                        ['name' => 'Endpoints', 'url' => '/admin/endPoints'],
                        ['name' => 'Añadir Endpoints', 'url' => '/admin/endpoints/add'],
                    ]
                ])

                @include('templates.admin.title', ['title' => 'Añadir Endpoints'])

                <form action="{{ route('safeEditEndPoints') }}" method="POST" id="form-safeEditEndPoint">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="id" name="id" value="{{ $endPoint['id'] }}">
                    <div class="row g-3 p-3">
                        <div class="col">
                            <div class="col">
                                <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" maxlength="75" required value="{{ $endPoint['name'] }}">
                            </div>

                            <div class="col">
                                <label for="url" class="form-label">URL <span class="text-danger">*</span></label>
                                <input type="text" name="url" id="url" class="form-control" maxlength="255" required value="{{ $endPoint['url'] }}">
                            </div>

                            <div class="col">
                                <label for="method" class="form-label">Método <span class="text-danger">*</span></label>
                                <input type="text" name="method" id="method" class="form-control" maxlength="7" required value="{{ $endPoint['method'] }}">
                            </div>

                            <div class="col">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea name="description" id="description" class="form-control" maxlength="255"  value="{{ $endPoint['description'] ?? '' }}"></textarea>
                            </div>
                        </div>

                        <div class="col">
                            <div class="col">
                                <label for="parameters" class="form-label">Parámetros</label>
                                <input type="text" name="parameters" id="parameters" class="form-control" maxlength="75" value="{{ $endPoint['parameters'] ?? '' }}">
                            </div>

                            <div class="col">
                                <label for="return" class="form-label">Retorno <span class="text-danger">*</span></label>
                                <input type="text" name="return" id="return" class="form-control mb-3" maxlength="50" required value="{{ $endPoint['return'] }}">
                            </div>

                            <div class="col" id="return-container">
                                <label class="form-label">Datos de retorno <span class="text-danger">*</span></label>

                                <div class="return-row row g-2 mb-2">
                                @for ($i=0; $i < count($endPoint['return_data_name']); $i++)                                    
                                    @if ($i==0)
                                    <div class="col-6">
                                        <input type="text" name="returnName[]" class="form-control return-data" placeholder="Dato (ej. usuario_id)" maxlength="15" required value="{{ $endPoint['return_data_name'][$i] }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="type[]" class="form-control return-type" placeholder="Tipo (ej. integer)" maxlength="15" required value="{{ $endPoint['return_data_types'][$i] }}">
                                    </div>
                                    @else
                                    <div class="col-5">
                                        <input type="text" name="returnName[]" class="form-control" placeholder="Dato" maxlength="15" required value="{{ $endPoint['return_data_name'][$i] }}">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="type[]"   class="form-control" placeholder="Tipo" maxlength="15" required value="{{ $endPoint['return_data_types'][$i] }}">
                                    </div>
                                    <div class="col-2 d-flex align-items-start">
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    @endif
                                @endfor
                                </div>

                                <button type="button" class="btn btn-success btn-sm" id="add-return-row">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button id="submit-endPoint" type="submit" class="btn btn-primary btn-sm" disabled>
                            <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                        <a href="{{ route('endPoints') }}" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </a>
                    </div>
                </form>

            </article>
        </section>
    </main>

    @include('sweetAlerts.swal')

    @push('scripts')
        <script src="{{ asset('js/admin/endPoints/editEndPoint.js') }}"></script>
    @endpush

    @endsection
