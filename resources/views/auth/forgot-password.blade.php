@extends('layout')

@section('title', '¿Olvidaste tu contraseña?')

@section('content')
    <main class="container py-5">
        <h2 class="mb-4">¿Olvidaste tu contraseña?</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Enviar enlace de recuperación</button>
        </form>
    </main>
@endsection
