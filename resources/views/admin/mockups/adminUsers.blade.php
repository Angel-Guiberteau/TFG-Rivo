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

    @stack('styles')

    @include('admin.adminCSS')

    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>

    @stack('scripts')

    @include('admin.adminJS')
</head>
<body>
    <header>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('adminUsers') }}">
                            Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
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
        
    </main>
    <footer>

    </footer>
</body>
</html>