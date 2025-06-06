@extends('layout')

@section('title', 'Rivo Finanzas')

@section('content')

    @push('styles')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
        <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
    <style>

    </style>
    @endpush

    <div id="loader">
        <img src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="Cargando Rivo" class="loader-logo" />
    </div>

    <main>

        @include('templates.home.mobileNav')
        <aside class="sidebar d-flex flex-column align-items-center justify-content-between" role="complementary">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <img id="asideLogo" src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="">
                <h1 class="fs-2 mb-0 align-self-end">Rivo</h1>
            </div>
            <nav class="asideNav d-flex flex-column justify-content-center align-items-center gap-2" aria-label="Menú lateral">
                <button class="addCategoryButton w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-layer-group"></i> Categorías
                </button>
                <button class="showObjectiveButton w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-bullseye"></i> Objetivos
                </button>
                {{-- <button class="w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-user-friends"></i> Amigos
                </button> --}}
                <button class="showAllHistoryButton w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-clipboard-list"></i> Historial
                </button>
                {{-- <button class="w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-chart-bar"></i> Estadísticas
                </button> --}}
                <button id="showSettingsButton" class="w-100 d-flex align-items-center gap-2" href="#">
                    <i class="fas fa-cog"></i> Ajustes
                </button>
                <form action="/logout" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <button type="submit" class="bg-transparent border-0 text-white d-flex align-items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="text-white">Cerrar sesión</span>
                    </button>
                </form>
            </nav>
        </aside>
        <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const menuToggle = document.getElementById('menuToggle');
                const sidebar = document.querySelector('aside.sidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                const body = document.body;

                function toggleSidebar() {
                    const isVisible = sidebar.classList.contains('sidebar-visible');
                    sidebar.classList.toggle('sidebar-visible', !isVisible);
                    backdrop.classList.toggle('active', !isVisible);
                    body.classList.toggle('no-scroll', !isVisible);
                }

                menuToggle.addEventListener('click', toggleSidebar);
                backdrop.addEventListener('click', toggleSidebar);
            });
        </script>

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
                    <h2 class="fs-2 fs-lg-1 fw-bold mb-4">Hola, {{ $user->username }}!</h2>
                    <div class="d-flex flex-lg-row justify-content-center justify-content-lg-start align-items-center gap-5 gap-lg-5 mt-2">
                        <div>
                            <p class="fs-4 fw-light mb-0">Balance disponible</p>
                            <p class="fs-2 fw-bold mt-0 mb-lg-4">{{ $account->balance }}€</p>
                        </div>
                        <div>
                            <p class="fs-4 fw-light mb-0">Total ahorrado</p>
                            <p class="fs-2 fw-bold mt-0 mb-lg-4">{{ $account->total_saved }}€</p>
                        </div>
                    </div>

                    <div id="actionButtons-container" class="mx-auto bg-white d-flex flex-row justify-content-evenly align-items-center p-3">
                        <button id="showHome" class="action-button fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-home fs-3 text-secondary"></i>
                            <span class="fs-6">Inicio</span>
                        </button>
                        <button id="showIncomeForm" class="action-button fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-plus fs-3 text-success"></i>
                            <span class="fs-6">Ingreso</span>
                        </button>
                        <button id="showExpenseForm" class="action-button fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-minus fs-3 text-danger" style="text-shadow: 0 0 1px currentColor;"></i>
                            <span class="fs-6">Gasto</span>
                        </button>
                        <button id="showSaveForm" class="action-button fw-bold d-flex flex-column align-items-center border-0 bg-transparent">
                            <i class="fas fa-piggy-bank fs-3 text-warning"></i>
                            <span class="fs-6">Ahorro</span>
                        </button>
                    </div>
                </div>
            </article>

            {{-- HOME SECTION --}}
            <article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black home-article" id="home-section">
                @if (isset($objectives))
                    @foreach ($objectives as $objective)
                        @include('templates.home.objective')
                    @endforeach
                @endif
                @include('templates.home.addObjectiveButton')

                @if (isset($sixOperations) && !is_null($sixOperations))
                    @include('templates.home.recentMovements')
                @endif

                @include('templates.home.thisMonthIncomesExpenses')

            </article>

            @include('templates.home.operations.history', ['type' => 'income', 'title' => 'ingresos'])
            @include('templates.home.operations.history', ['type' => 'expense', 'title' => 'egresos'])
            @include('templates.home.operations.history', ['type' => 'save', 'title' => 'ahorro'])
            @include('templates.home.createObjective')
            @include('templates.home.settings')
            @include('templates.home.createCategory')
            @include('templates.home.allHistory')

            @include('templates.home.operations.addOperation')
        </section>
        @include('templates.home.transactionInfo')
    </main>
    @if (session('success'))
        <div class="rivo-alert alert-success">
            <span class="rivo-alert-icon succes"><i class="fas fa-check-circle"></i></span>
            <span class="rivo-alert-text">{{ session('success') }}</span>
            <button type="button" class="rivo-alert-close" onclick="this.parentElement.remove();">&times;</button>
        </div>
    @else
        @if (session('error'))
            <div class="rivo-alert alert-error">
                <span class="rivo-alert-icon error"><i class="fas fa-times-circle"></i></span>
                <span class="rivo-alert-text">{{ session('error') }}</span>
                <button type="button" class="rivo-alert-close" onclick="this.parentElement.remove();">&times;</button>
            </div>
        @endif
    @endif
    @push('scripts')
    <script>
        window.chartData = {
            incomes: @json($thisMonthIncomes),
            expenses: @json($thisMonthExpenses)
        };
    </script>

        <script src="{{ asset('js/chart/chart.umd.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/home/income.js') }}"></script>
        <script src="{{ asset('js/home/navMobile.js') }}"></script>
        {{-- <script src="{{ asset('js/home/stats.js') }}"></script> --}}
        <script src="{{ asset('js/home/income/history.js') }}"></script>
        <script src="{{ asset('js/home/objectives.js') }}"></script>
        <script src="{{ asset('js/home/category.js') }}"></script>
        <script src="{{ asset('js/home/allHistory.js') }}"></script>

        <script type="module" src="{{ asset('js/home/homeValidations/addOperationValidations.js') }}"></script>

        <script type="module" src="{{ asset('js/home/app.js') }}"></script>
    @endpush



@endsection
