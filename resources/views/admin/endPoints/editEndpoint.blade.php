@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

@include('templates.admin.logo')
@include('templates.admin.navBar')
<main>
    <section class="container-custom p-3 pb-5">
        <article class="bg-light p-3 endPoint">

            @include('templates.admin.breadCrum', [
                'breadcrumbs' => [
                    ['name' => 'Inicio', 'url' => '/admin'],
                    ['name' => 'Endpoints', 'url' => '/admin/endPoints'],
                    ['name' => 'Editar Endpoint', 'url' => '/admin/endpoints/edit'],
                ]
            ])

            @include('templates.admin.title', ['title' => 'Editar Endpoint'])

            <form action="{{ route('safeEditEndPoints') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="id" name="id" value="{{ $endPoint['id'] }}">
                <div class="row g-3 p-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" maxlength="75" value="{{ $endPoint['name'] }}">
                    </div>

                    <div class="col-md-6">
                        <label for="url" class="form-label">URL <span class="text-danger">*</span></label>
                        <input type="text" name="url" id="url" class="form-control" maxlength="255" value="{{ $endPoint['url'] }}">
                    </div>

                    <div class="col-md-6">
                        <label for="method" class="form-label">Método <span class="text-danger">*</span></label>
                        <input type="text" name="method" id="method" class="form-control" maxlength="7" value="{{ $endPoint['method'] }}">
                    </div>

                    <div class="col-md-6">
                        <label for="parameters" class="form-label">Parámetros</label>
                        <input type="text" name="parameters" id="parameters" class="form-control" maxlength="75" value="{{ $endPoint['parameters'] ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label for="return" class="form-label">Retorno <span class="text-danger">*</span></label>
                        <input type="text" name="return" id="return" class="form-control mb-3" maxlength="15" value="{{ $endPoint['return'] }}">
                    </div>

                    <div class="col">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea name="description" id="description" class="form-control" maxlength="255" value="{{ $endPoint['description'] ?? '' }}"></textarea>
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
