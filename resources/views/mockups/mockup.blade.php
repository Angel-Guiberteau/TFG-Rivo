<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Fondo Diagonal con Formulario</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="fondo">
    
    <div class="corte-purpura"></div>
    <div class="linea-blanca"></div>
    <div class="d-flex flex-row justify-content-center align-items-center">
    </div>

    <div class="left-content d-flex flex-column align-items-center justify-content-center text-start ps-6rem">
        <h1 class="w-100 fs-title fw-bold">Take control of your finances</h1>
        <p class="w-100 fs-2">
            Start saving, organize your income and expenses, and reach your goals with Rivo.
        </p>
    </div>

    <div class="w-100 d-flex flex-column aling-items-center justify-content-center">
        <div class="login-container mx-auto">
            <h2 class="fs-1">Iniciar sesión</h2>
            <form action="">
                <label for="email">Correo electrónico</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="email" id="email" placeholder="Correo electrónico"/>
                </div>
                <label for="password">Contraseña</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" placeholder="Contraseña" />
                    <i class="fas fa-eye"></i>
                    <i class="fas fa-eye-slash d-none"></i>

                </div>

                <div class="options">
                    <label><input type="checkbox" /> Remember Me</label>
                    <a href="#">¿Has olvidado tu contraseña?</a>
                </div>

                <div class="register">
                    <p>¿No registrado? <a href="#">Regístrate aquí</a></p>
                </div>

                <button class="login-btn w-100">Iniciar sesion</button>
                <hr/>
                <button class="google-btn w-100">
                    <img class="google-logo" src="{{ asset('img/googleLogo.png') }}" alt="">Login with google
                </button>
            </form>
        
        </div>

    </div>

</body>
</html>
