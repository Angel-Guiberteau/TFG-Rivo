@extends('layout')

@section('title', 'Rivo Finanzas')

@section('content')

    @push('styles')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
        
    @endpush

    <main>
        <aside class="sidebar d-flex flex-column align-items-center justify-content-between">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <img id="asideLogo" src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="">
                <h1 class="fs-2 mb-0 align-self-end">Rivo</h1>
            </div>
            <nav class="d-flex flex-column justify-content-start align-items-center gap-3">
                <a class="w-100" href="#">🏠 Inicio</a>
                <a class="w-100" href="#">👥 Amigos</a>
                <a class="w-100" href="#">📊 Estadísticas</a>
                <a class="w-100" href="#">⚙️ Ajustes</a>
            </nav>
        </aside>

        <section class="w-100">
            <article class="balance-bg py-5 px-5 w-100">
                <h2 class="fs-1 fw-bold mb-4">Hola, Ángel!</h2>
                <p class="fs-4 fw-light mb-0">Balance disponible</p>
                <p class="fs-1 fw-bold mt-0 mb-4">€ 1.250,00</p>
                <div id="actionButtons-container" class="mx-auto bg-white d-flex flex-row justify-content-evenly align-items-center p-3">
                    <button class="fs-5 fw-bold">➕<br/><span>Ingreso</span></button>
                    <button class="fs-5 fw-bold">➖<br/><span>Gasto</span></button>
                    <button class="fs-5 fw-bold">🐷<br/><span>Ahorro</span></button>
                    <button class="fs-5 fw-bold">📋<br/><span>Historial</span></button>
                </div>
            </article>
            
            <article class="py-5 px-6 w-100 text-black bg-bottom">
                <div class="info-container py-4 px-4 mb-3 mt-4">
                    <div class="d-flex flex-row justify-content-start align-items-center">
                        <img src="{{ asset('img/logos/purpleRivo.png') }}" alt="">
                        <div class="d-flex flex-column align-items-start gap-0">
                            <h3 class="mb-1 fs-4 fw-bold">Objetivo: Ahorrar los primeros 1000€</h3>
                            <p class="fs-5 mb-0">Progreso: 320€ / 1000€ ahorrado — <strong>33%</strong></p>
                        </div>
                    </div>
                    <div class="progress-bar">
                        <div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 32%; height: 100%;"></div>
                    </div>
                </div>
        
                <div class="info-container py-4 px-4 mb-3">
                    <h3 class="mb-1 fs-4 fw-bold">Resumen de gastos – Mayo 2025</h3>
                    <p class="fs-5">Este mes has gastado <strong>890€</strong></p>
                    <div class="expense-category">🏠 Casa 250€</div>
                    <div class="bar-container"><div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 100%; height: 100%;"></div></div>
                    <div class="expense-category">🍽 Comida 150€</div>
                    <div class="bar-container"><div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 75%; height: 100%;"></div></div>
                    <div class="expense-category">🎉 Ocio 30€</div>
                    <div class="bar-container"><div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 30%; height: 100%;"></div></div>
                </div>
        
                <div class="info-container py-4 px-4">
                    <h3 class="mb-1 fs-4< fw-bold mb-3">Movimientos recientes</h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fs-5">21 abr. Compra semanal</p>
                        <p class="negative fs-5">-50.00€</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fs-5">28 abr. Kit emergencia</p>
                        <p class="negative fs-5">-28.93€</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fs-5">28 abr. Ahorros</p>
                        <p class="positive fs-5">+03.00€</p>
                    </div>
                </div>
            </article>
        </section>
    </main>

@endsection