@extends('layout')

@section('title', '¿Olvidaste tu contraseña?')

@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login_register/forgot-reset.css') }}">
@endpush


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
            <h2 class="mt-3 mb-2 auth-title">¿Olvidaste tu contraseña?</h2>
            <p class="auth-subtitle">Introduce tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
        </div>

        @error('email')
            <span class="invalid-feedback fw-bold d-block">{{ $message }}</span>
        @enderror
        
        @if (session('status'))
            <div class="alert alert-success text-center">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" placeholder="Introduce tu correo electrónico" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary w-100">Enviar enlace de recuperación</button>
        </form>

        <div class="mt-3 text-center">
            <a href="{{ route('login') }}" class="auth-link text-decoration-none">Volver al inicio de sesión</a>
        </div>
    </div>
</main>
@endsection
