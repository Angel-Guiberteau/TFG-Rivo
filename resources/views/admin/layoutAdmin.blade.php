<!DOCTYPE html>
<html lang="es">
    <head>
        @include('admin.headerAdmin')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        
        @yield('content')

        {{-- @include('footer') --}}
    </body>
    <script src="{{ asset('js/admin/datatableComponent.js') }}"></script>
</html>