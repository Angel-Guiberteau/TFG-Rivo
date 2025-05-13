<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

    <title> @yield('title') </title>

    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/datatable/datatables.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/admin/commonAdmin.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/admin/modals/modal.css') }}">

    @stack('styles')

    @include('projectCSS')

    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('js/admin/modals/modalAddSentence.js') }}"></script>
    <script src="{{ asset('js/admin/modals/modalEditSentence.js') }}"></script>
    <script src="{{ asset('js/admin/sentences.js') }}"></script>
    @stack('scripts')

    @include('projectJS')
</head>
<body>
    <header class="mb-3">
        <div class="navbar navbar-custom corporativeColor notIframe">
            <div class="ps-2">
                <a href="/admin">
                    <img src="{{ asset('img/logos/whiteRivoPng.png') }}" id="logoRivo" alt="Logo">
                </a>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg below-navbar noPadding ps-2">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('homeAdmin') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('users') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('categories') }}">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('sentences') }}">Frases</a>
                    </li>
                </ul>
            </div>
            <div>
                <form action="/logout" method="post">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            </div>
        </nav>
    </header>
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
        @include('admin.components.modals.addSentence')
        @include('admin.components.modals.editSentence')
    </main>
    <footer>

    </footer>
</body>
</html>