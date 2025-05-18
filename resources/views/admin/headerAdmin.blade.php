<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

<title> @yield('title') </title>

<link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/datatable/datatables.min.css') }}" rel="stylesheet"/>
{{-- <link href="{{ asset('css/fontAwesome/fontawesome.min.css') }}" rel="stylesheet"/> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="{{ asset('css/admin/commonAdmin.css') }}" rel="stylesheet"/>

@stack('styles')

@include('projectCSS')

<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/datatable/datatables.min.js') }}"></script>

@stack('scripts')

@include('projectJS')