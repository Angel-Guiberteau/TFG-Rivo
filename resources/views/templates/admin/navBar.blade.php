@php
    $usersRoutes = ['users', 'addUser', 'editUser', 'previewUser'];
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-3">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'homeAdmin' ? 'active' : '' }}" href="{{ route('homeAdmin') }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ in_array(Route::currentRouteName(), $usersRoutes) ? 'active' : '' }}" href="{{ route('users') }}">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'icons' ? 'active' : '' }}" href="{{ route('icons') }}">Iconos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'categories' ? 'active' : '' }}" href="{{ route('categories') }}">Categorías</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'sentences' ? 'active' : '' }}" href="{{ route('sentences') }}">Frases</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() === 'endPoints' ? 'active' : '' }}" href="{{ route('endPoints') }}">Endpoints</a>
            </li>
        </ul>
        <form action="/logout" method="POST" class="d-flex">
            @csrf
            <button type="submit" class="btn btn-danger-custom btn-sm">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </form>
    </div>
</nav>
