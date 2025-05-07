<!DOCTYPE html>
<html lang="es">
    <head>
        @include('admin.header')
    </head>
    <body>
        @include('admin.components.nav')
        @yield('content')

        {{-- @include('footer') --}}
    </body>
</html>