<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

    <title> @yield('title') </title>

    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/datatable/datatables.min.css') }}" rel="stylesheet"/>

    @stack('styles')

    @include('admin.adminCSS')

    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatable/datatables.min.js') }}"></script>

    @stack('scripts')

    @include('admin.adminJS')
</head>
<body>
    <header class="mb-3">
        <div class="d-flex align-items-center" id="header">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <img id="asideLogo" src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="">
                <h1 class="fs-2 mb-0 align-self-end">Rivo</h1>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg no-export below-navbar notIframe noPadding">
            <div class="collapse navbar-collapse marginSubMenu" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminIni') }}">
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminUsers') }}">
                            Usuarios
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('adminSentences') }}">
                            Frases
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminCategories') }}">
                            Categorias
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section class="container-custom p-3 pb-5">
            <article class="p-3">
                <table id="sentencesTable" class="table-custom table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titulo</th>
                            <th>Sentence</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm search-column" placeholder="Buscar ID"></th>
                            <th><input type="text" class="form-control form-control-sm search-column" placeholder="Buscar Nombre"></th>
                            <th><input type="text" class="form-control form-control-sm search-column" placeholder="Buscar Hexadecimal"></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i=0; $i < 20; $i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>Bienvenido a Rivo</td>
                                <td>Start saving, organize your income and expenses, and reach your goals with Rivo.</td>
                                <td>
                                    <button class="btn btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEdit"
                                        data-id=""
                                        data-name=""
                                        data-hex="">
                                        Editar
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" 
                                        onclick="deleteSentence()"">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                
                <div class="d-flex justify-content-between mt-3">
                    <div id="tableInfo"></div>
                    <div id="tablePagination" class="d-flex"></div>
                </div>
            </article>
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>