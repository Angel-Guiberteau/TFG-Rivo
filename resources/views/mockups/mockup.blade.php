<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fondo Diagonal con Formulario</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <section class="row justify-content-center align-items-center py-3 gx-0 gx-lg-5">
            <article class="col-12 col-lg-6 row text-white mt-4 mt-lg-0">
                <h1 class="w-100 fs-1 fw-bold text-center text-lg-start">Bienvenido a Rivo</h1>
                <p class="w-100 fs-4 subtitle-mobile">
                    Start saving, organize your income and expenses, and reach your goals with Rivo.
                </p>
            </article>
        
            <article class="row col-12 col-lg-6 mt-4 mt-lg-0">
                <div class="login-container register-container mx-auto">
                    <h2 class="fw-bold fs-2">Iniciar sesión</h2>
                    <form id="login-form" class="fade-toggle active" action="">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <div class="input-group mb-4">
                            <i class="fas fa-user"></i>
                            <input type="email" id="email" placeholder="Correo electrónico"/>
                        </div>
                        <label for="password">Contraseña</label>
                        <div class="input-group mb-2">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" placeholder="Contraseña" />
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-eye-slash d-none"></i>
                        </div>
                        
                        <div class="d-flex flex-column flex-lg-row justify-content-start justify-content-lg-between align-items-start align-items-lg-center w-100 p-1 mb-3 text-start">
                            <div class="d-flex align-items-center gap-1">
                                <input type="checkbox" id="rememberMe" />
                                <label for="rememberMe" class="fs-6 m-0">Recordarme</label>
                            </div>
                            <a href="#" class="fs-6 link-login">¿Has olvidado tu contraseña?</a>
                            </div>
        
                        <div class="register mb-2">
                            <p  class="fs-6">¿No registrado? <a href="#">Regístrate aquí</a></p>
                        </div>
        
                        <button class="login-btn w-100 fs-4 fw-bold">Iniciar sesión</button>
                        <hr class="my-4" />
                        <button class="google-btn w-100 fs-4 fw-bold">
                            <img class="google-logo" src="{{ asset('img/googleLogo.png') }}" alt="Google logo">
                            <span>Login with Google</span>
                        </button>
                    </form>
                    <form id="register-form" class="fade-toggle" action="" aria-hidden="true">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <div class="input-group mb-4">
                            <i class="fas fa-user"></i>
                            <input type="email" id="email" placeholder="Correo electrónico"/>
                        </div>
                        <label for="password">Contraseña</label>
                        <div class="input-group mb-4">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" placeholder="Contraseña" />
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-eye-slash d-none"></i>
                        </div>
                        <label for="password">Repetir contraseña</label>
                        <div class="input-group mb-4">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" placeholder="Repetir la contraseña" />
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-eye-slash d-none"></i>
                        </div>
                        
                        <div class="register mb-4">
                            <p  class="fs-6">Ya tienes cuenta? <a href="#">Inicia sesión</a></p>
                        </div>
        
                        <button class="login-btn w-100 fs-4 fw-bold">Registrarse</button>
                        <hr class="my-4" />
                        <button class="google-btn w-100 fs-4 fw-bold">
                            <img class="google-logo" src="{{ asset('img/googleLogo.png') }}" alt="Google logo">
                            <span>Registrarse con Google</span>
                        </button>
                    </form>
                </div>
            </article>
        </section>
    </div>
    <script src="js/login.js"></script>
</body>
</html>
