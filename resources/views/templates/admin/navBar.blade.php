@php
    // array de rutas
@endphp
<nav class="navbar navbar-expand-lg below-navbar noPadding ps-2">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'homeAdmin' ? 'active' : '' }}" href="{{ route('homeAdmin') }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'users' ? 'active' : '' }}" href="{{ route('users') }}">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'categories' ? 'active' : '' }}" href="{{ route('categories') }}">Categorias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'sentences' ? 'active' : '' }}" href="{{ route('sentences') }}">Frases</a>
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