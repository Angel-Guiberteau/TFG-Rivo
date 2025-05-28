@extends('layout')

@section('title', 'Rivo Finanzas')

@section('content')

    @push('styles')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
        <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">

    @endpush

    <div id="loader">
        <img src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="Cargando Rivo" class="loader-logo" />
    </div>

    <main>
        
        <nav class="mobile-nav">
            <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                <i class="fas fa-plus fs-3 text-success"></i>
                <span class="fs-6">Ingreso</span>
            </button>
            <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                <i class="fas fa-minus fs-3 text-danger" style="text-shadow: 0 0 1px currentColor;"></i>
                <span class="fs-6">Gasto</span>
            </button>
            <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                <i class="fas fa-piggy-bank fs-3 text-warning"></i>
                <span class="fs-6">Ahorro</span>
            </button>
            <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                <i class="fas fa-clipboard-list fs-3 text-secondary"></i>
                <span class="fs-6">Historial</span>
            </button>
        </nav>
        <aside class="sidebar d-flex flex-column align-items-center justify-content-between" role="complementary">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <img id="asideLogo" src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="">
                <h1 class="fs-2 mb-0 align-self-end">Rivo</h1>
            </div>
            <nav class="d-flex flex-column justify-content-start align-items-center gap-3" aria-label="Menú lateral">
                <a class="w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-user-friends"></i> Amigos
                </a>
                <a class="w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-chart-bar"></i> Estadísticas
                </a>
                <a class="w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-cog"></i> Ajustes
                </a>
                <form action="/logout" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <button type="submit" class="bg-transparent border-0 text-white d-flex align-items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="text-white">Cerrar sesión</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- MAIN CONTENT --}}
        <section class="w-100">
        
            <article class="balance-bg  w-100">
                <header class="mobile-header">
                    <div>
                        <img src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="">
                    </div>
                    <button id="menuToggle" class="btn border-0 bg-transparent p-2 d-lg-none" aria-label="Abrir menú">
                        <i class="fas fa-bars fs-2" style="color: #fff; text-shadow: 0 0 1px #000;"></i>
                    </button>
                </header>
                <div class="balance-info pt-3 pt-lg-5 pb-3 pb-lg-5 px-3 px-lg-5 text-center text-lg-start">
                    <h2 class="fs-1 fw-bold mb-4">Hola, Angel!</h2>
                    <p class="fs-4 fw-light mb-0">Balance disponible</p>
                    <p class="fs-1 fw-bold mt-0 mb-lg-4">€ 1.250,00</p>
                    <div id="actionButtons-container" class="mx-auto bg-white d-flex flex-row justify-content-evenly align-items-center p-3">
                        <button id="showIncomeForm" class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-plus fs-3 text-success"></i>
                            <span class="fs-6">Ingreso</span>
                        </button>
                        <button id="showEgressFrom" class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-minus fs-3 text-danger" style="text-shadow: 0 0 1px currentColor;"></i>
                            <span class="fs-6">Gasto</span>
                        </button>
                        <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-piggy-bank fs-3 text-warning"></i>
                            <span class="fs-6">Ahorro</span>
                        </button>
                        <button class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-clipboard-list fs-3 text-secondary"></i>
                            <span class="fs-6">Historial</span>
                        </button>
                    </div>
                </div>
            </article>
     
            {{-- HISTORY --}}

            <article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black home-article" id="home-section">
                <div class="col-12">
                    <h5 class="fw-bold">Hoy <i class="fas fa-chevron-down ms-2"></i></h5>
                    <div class="card my-2 p-3 d-flex flex-row justify-content-between align-items-center">
                    <div><i class="fas fa-briefcase me-2 text-primary"></i><strong>Sueldo</strong><br><small class="text-muted">09:30</small></div>
                    <div class="text-success fw-bold">+ 1.200,00</div>
                    </div>
                    <div class="card my-2 p-3 d-flex flex-row justify-content-between align-items-center">
                    <div><i class="fas fa-store me-2 text-success"></i><strong>Venta</strong><br><small class="text-muted">15:30</small></div>
                    <div class="text-success fw-bold">+ 50,00</div>
                    </div>

                    <h5 class="fw-bold mt-4">Ayer <i class="fas fa-chevron-down ms-2"></i></h5>
                    <div class="card my-2 p-3 d-flex flex-row justify-content-between align-items-center">
                    <div><i class="fas fa-gift me-2 text-danger"></i><strong>Regalo</strong><br><small class="text-muted">09:30</small></div>
                    <div class="text-success fw-bold">+ 100,00</div>
                    </div>

                    <h5 class="fw-bold mt-4">21 diciembre <i class="fas fa-chevron-down ms-2"></i></h5>
                    <div class="card my-2 p-3 d-flex flex-row justify-content-between align-items-center">
                    <div><i class="fas fa-laptop-code me-2 text-info"></i><strong>WebFrelaance</strong><br><small class="text-muted">09:30</small></div>
                    <div class="text-success fw-bold">+ 100,00</div>
                    </div>
                </div>

                <!-- Pie de resumen fijo -->
                <div class="fixed-bottom bg-white border-top shadow p-3">
                    <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Total este mes</strong>
                        <div class="text-muted">Categoría principal</div>
                        <div class="text-success small"><i class="fas fa-arrow-up"></i> 8% vs el mes pasado</div>
                    </div>
                    <div class="fw-bold fs-4">1250€</div>
                    </div>
                </div>
                </article>
ç
        </article>

        </section>
    </main>

    @push('scripts')
        <script src="{{ asset('js/home/home.js') }}"></script>
        <script src="{{ asset('js/home/income.js') }}"></script>
        <script src="{{ asset('js/home/articleManager.js') }}"></script> 
    @endpush

@endsection