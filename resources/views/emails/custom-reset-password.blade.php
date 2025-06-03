<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f5; padding: 40px; color: #1f2937;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
        <div style="background-color: #3C7EFC; padding: 30px 20px; text-align: center;">
            <img src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="RIVO" style="height: 60px;">
        </div>

        <div style="padding: 30px 20px;">
            <h2 style="margin-top: 0; color: #111827;">Restablece tu contraseña</h2>
            <p>Has recibido este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $url }}"
                style="background-color: #3C7EFC; color: #fff; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                    Restablecer contraseña
                </a>
            </div>

            <p>Este enlace caducará en 60 minutos.</p>
            <p>Si no solicitaste este restablecimiento, no es necesario realizar ninguna acción.</p>

            <p style="margin-top: 30px;">— El equipo de <strong>RIVO</strong></p>
        </div>
    </div>

</body>
</html>
