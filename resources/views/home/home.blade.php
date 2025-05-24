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
                    <h2 class="fs-1 fw-bold mb-4">Hola, {{ $user->username }}!</h2>
                    <p class="fs-4 fw-light mb-0">Balance disponible</p>
                    <p class="fs-1 fw-bold mt-0 mb-lg-4">€ 1.250,00</p>
                    <div id="actionButtons-container" class="mx-auto bg-white d-flex flex-row justify-content-evenly align-items-center p-3">
                        <button id="showIncomeForm" class="fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
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
                    </div>
                </div>
            </article>
            
            {{-- HOME ARTICLE --}}

            <article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black home-article" id="home-section">
                <div class="col-12 col-lg-6 mt-2 mt-lg-4">
                    <div class="w-100 info-container py-4 px-3">
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
                </div>
                <div class="col-12 col-lg-6 mt-4">
                    <div class="w-100 info-container py-4 px-3">
                        <div class="d-flex flex-row justify-content-start align-items-center">
                            <img src="{{ asset('img/logos/purpleRivo.png') }}" alt="">
                            <div class="d-flex flex-column align-items-start gap-0">
                                <h3 class="mb-1 fs-4 fw-bold">Objetivo: Comprar PC para GTA VI</h3>
                                <p class="fs-5 mb-0">Progreso: 120€ / 1500€ ahorrado — <strong>33%</strong></p>
                            </div>
                        </div>
                        <div class="progress-bar">
                            <div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 32%; height: 100%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 info-container mt-4 py-4 px-4">
                    <h3 class="mb-1 fs-4 fw-bold">Resumen de gastos – Mayo 2025</h3>
                    <p class="fs-5">Este mes has gastado <strong>890€</strong></p>
                    <div class="expense-category">🏠 Casa 250€</div>
                    <div class="bar-container"><div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 100%; height: 100%;"></div></div>
                    <div class="expense-category">🍽 Comida 150€</div>
                    <div class="bar-container"><div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 75%; height: 100%;"></div></div>
                    <div class="expense-category">🎉 Ocio 30€</div>
                    <div class="bar-container"><div style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-color: #6b00e5; width: 30%; height: 100%;"></div></div>
                </div>
        
                <div class="col-12 info-container mt-4 py-4 px-4">
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

            {{-- INCOME ARTICLE --}}

            <article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black income-article" id="income-section" style="display: none;">

                <form class="col-12 col-lg-10 mx-auto mt-4">
                    <div class="row">
                        <div class="col-md-8 divider-right">
                            <div class="mb-3">
                                <label for="subject" class="fw-bold mb-0 fs-4">Asunto</label>
                                <input type="text" id="subject" name="subject" class="form-control mb-3" placeholder="Asunto" required>
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description"></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3 flex-nowrap">
                                <div class="d-flex align-items-center gap-4">
                                    <label for="date" class="fw-bold mb-0 fs-4">Fecha</label>
                                    <input type="date" id="date" name="date" class="form-control border-0 p-0 bg-transparent text-muted text-center" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <label for="schedule" class="fw-bold mb-0 fs-4">Programar</label>
                                    <label class="switch mb-0">
                                        <input type="checkbox" id="schedule" name="schedule" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3 gap-4">
                                <label for="recurrence" class="fw-bold mb-0 fs-4">Recurrencia</label>
                                <div class="custom-select-wrapper">
                                    <select id="recurrence" name="recurrence" class="form-select border-0 bg-transparent">
                                        <option>Una vez</option>
                                        <option>Semanal</option>
                                        <option>Mensual</option>
                                        <option>Bisemanal</option>
                                    </select>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                <label for="expiration_date" class="fw-bold mb-0 fs-4">Fecha de expiración</label>
                                <input type="date" id="expiration_date" name="expiration_date" 
                                    class="form-control border-0 p-0 bg-transparent text-muted text-center max-w-200"
                                    value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="number" class="form-control fs-5" id="amount" name="amount" placeholder="€ Cantidad" min="0" step="0.01">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="d-flex flex-column mb-3">
                                <label class="fw-bold mb-0 fs-4">Categorías</label>
                                <div class="d-flex flex-wrap mt-2">
                                    @foreach([
                                        ['Trabajo', 'fa-briefcase', 'Trabajo'],
                                        ['Freelance', 'fa-laptop-code', 'Freelance'],
                                        ['Regalo', 'fa-gift', 'Regalo'],
                                        ['Premio', 'fa-trophy', 'Premio'],
                                        ['Venta', 'fa-tags', 'Venta'],
                                        ['Renta', 'fa-home', 'Renta'],
                                        ['Intereses', 'fa-coins', 'Intereses'],
                                        ['Otros', 'fa-ellipsis-h', 'Otros'],
                                        ['Trabajo', 'fa-briefcase', 'Trabajo'],
                                        ['Freelance', 'fa-laptop-code', 'Freelance'],
                                        ['Nueva', 'fa-plus', 'Nueva']
                                    ] as [$value, $icon, $label])
                                        <div class="me-2 mb-2">
                                            <label class="d-block text-center">
                                                <input type="radio" name="category" value="{{ $value }}" class="d-none">
                                                <div class="category-option">
                                                    <i class="fas {{ $icon }} text-secondary fs-6"></i>
                                                    <span class="mt-1 text-muted fw-semibold small">{{ $label }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-semibold fs-5 custom-gradient-btn">
                                Añadir ingreso
                            </button>
                        </div>
                    </div>
                </form>
            </article>

            
        </section>
    </main>

    @push('scripts')
        <script src="{{ asset('js/home/home.js') }}"></script>
    @endpush

@endsection