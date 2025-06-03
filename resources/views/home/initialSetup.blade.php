@extends('layout')

@section('title', 'Configuración inicial')

    
@section('content')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
        <link rel="stylesheet" href="{{ asset('css/login_register/login.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home/initialSetup.css') }}">

    @endpush

    <main class="container min-vh-100 d-flex align-items-center justify-content-center">
        <section class="row justify-content-center align-items-center py-3 gx-0 gx-lg-5">
            <article class="col-12 col-lg-6 row text-white mt-4 mt-lg-0">
                <h1 id="infoTitle" class="w-100 fs-1 fw-bold text-center text-lg-start">Configuración inicial</h1>
                <p id="description" class="w-100 fs-4 subtitle-mobile">
                    Un poco de información sobre ti para poder conocerte mejor.
                </p>
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif
            
            </article>
            
            
            <article class="row col-12 col-lg-6 mt-4 mt-lg-0">
                <div class="login-container register-container mx-auto">
                    
                    <h2 id="title" class="fw-bold fs-2 mb-2">¡Empecemos!</h2>
                    <p id="subtitle" class="fs-5 w-100 text-center fw-light mb-4">Cuéntanos un poco sobre ti...</p>
                    <form class="fade-toggle active" action="/updateUserInfoFromInitialSetup" method="POST">
                        @csrf
                        
                        @include('home.initialSetup.firstStep')
                        @include('home.initialSetup.secondStep')
                        @include('home.initialSetup.thirdStep')
                        @include('home.initialSetup.fourthStep')
                        @include('home.initialSetup.fifthStep')
                        @include('home.initialSetup.sixthStep')
                        @include('home.initialSetup.seventhStep')
                        @include('home.initialSetup.eighthStep')
                        @include('home.initialSetup.ninthStep')
                        @include('home.initialSetup.tenthStep')

                        <div class="progress w-100" role="progressbar" aria-label="Animated striped example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
                        </div>
                    </form>
                </div>
            </article>
        </section>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
        <script src="{{ asset('js/home/initialSetup.js') }}"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/home/initialSetUpValidations/fistStepValidations.js') }}"></script>
        <script src="{{ asset('js/home/initialSetUpValidations/secondStepValidations.js') }}"></script>
        <script src="{{ asset('js/home/initialSetUpValidations/thirdYfourthStepValidations.js') }}"></script>
    @endpush
@endsection
    

