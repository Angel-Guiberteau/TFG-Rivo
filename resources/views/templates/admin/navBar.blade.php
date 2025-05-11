@php
    // array de rutas
@endphp
<nav class="navbar navbar-expand-lg below-navbar noPadding ps-2">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === '/admin' ? 'active' : '' }}" href="{{ route('/') }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === '/home' ? 'active' : '' }}" href="{{ route('/') }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === '/home' ? 'active' : '' }}" href="{{ route('/') }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === '/home' ? 'active' : '' }}" href="{{ route('/') }}">Inicio</a>
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