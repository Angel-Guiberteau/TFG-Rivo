<!DOCTYPE html>
<html lang="es">
    <head>
        @include('header')
        <link href="{{ asset('css/common.css') }}" rel="stylesheet"/>

    </head>
    <body>
        <div id="loader">
            <img src="{{ asset('img/logos/whiteRivoPng.png') }}" class="loader-logo" />
        </div>

        @yield('content')
        <script>
            const loader = document.getElementById('loader');
            let loaderVisible = false;
            let loaderTimeout;
        
            const hideLoader = () => {
                clearTimeout(loaderTimeout);
                if (loaderVisible) {
                    loader.style.animation = 'fadeOut 0.6s ease-in-out forwards';
                    setTimeout(() => loader.remove(), 600);
                }
            };
        
            loaderTimeout = setTimeout(() => {
                loader.style.display = 'flex';
                loaderVisible = true;
        
                if (document.readyState === 'complete') {
                    hideLoader();
                }
            }, 1500);
        
            if (document.readyState !== 'complete') {
                window.addEventListener('load', hideLoader);
            } else {
                hideLoader();
            }
        </script>
        
        {{-- @include('footer') --}}
    </body>
</html>