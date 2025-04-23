<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Fondo Diagonal con Formulario</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mockup.css') }}">
</head>
<body>
  <div class="fondo">
    <div class="corte-purpura"></div>
    <div class="linea-blanca"></div>
    <div class="d-flex flex-row">
        <div class="left-content d-flex flex-column align-items-center justify-content-center text-start ps-6rem">
            <h1 class="w-100 fs-title fw-bold">Take control of your finances</h1>
            <p class="w-100 fs-2">
                Start saving, organize your income and expenses, and reach your goals with Rivo.
            </p>
        </div>
      
        <div class="w-100 d-flex flex-column aling-items-center justify-content-center">
            <div class="login-container w-75 mx-auto">
                <h2 class="fs-1">Iniciar sesión</h2>
                <form action="">
                    <label for="email">Correo electrónico</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="email" id="email" placeholder="Correo electrónico" />
                    </div>

                    <label for="password">Contraseña</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" placeholder="Contraseña" />
                        <i class="fas fa-eye"></i>
                    </div>

                    <div class="options">
                        <label><input type="checkbox" /> Remember Me</label>
                        <a href="#">Forgot Me ?</a>
                    </div>

                    <div class="register">
                        Not register? <a href="#">Register here</a>
                    </div>

                    <button class="login-btn">Login</button>
                    <hr />
                    <button class="google-btn">
                        <i class="fab fa-google"></i> Login with google
                    </button>
                </form>
            
            </div>

        </div>
    </div>
    
  </div>
</body>
</html>
