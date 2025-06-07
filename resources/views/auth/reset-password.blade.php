@extends('layout')

@section('title', 'Restablecer contraseña')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login_register/forgot-reset.css') }}">
@endpush

@section('content')

<div class="bg-gradient">
    <div class="bubble bubble1"></div>
    <div class="bubble bubble2"></div>
    <div class="bubble bubble3"></div>
    <div class="bubble bubble4"></div>
    <div class="bubble bubble5"></div>
    <div class="bubble bubble6"></div>
    <div class="bubble bubble7"></div>
    <div class="bubble bubble8"></div>
</div>

<main class="container d-flex justify-content-center align-items-center min-vh-100" style="position: relative; z-index: 2;">

    <div class="auth-card">

        <div class="text-center w-100">
            <img src="{{ asset('img/logos/purpleRivo.png') }}" alt="Logo" class="auth-logo">
            <h2 class="mt-3 mb-2 auth-title">Restablecer contraseña</h2>
            <p class="auth-subtitle">Introduce tu nueva contraseña para actualizar tu acceso.</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success text-center">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <p>Token: {{ $request->route('token') }}</p>
            <p>Email: {{ $request->query('email') }}</p>

            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ $request->query('email') }}">


            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autofocus>
                @error('password')
                    <span class="invalid-feedback d-block fw-bold">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" class="form-control" 
                       name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Restablecer contraseña</button>
        </form>

        <div class="mt-3 text-center">
            <a href="{{ route('login') }}" class="auth-link text-decoration-none">Volver al inicio de sesión</a>
        </div>
    </div>
</main>

@endsection
