<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Restablecer contraseña</title>
</head>
<body style="
  margin:0; padding:40px 10px; 
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
  background: #260442; color: #f0e9ff;">

  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; margin:auto; background: linear-gradient(120deg, rgba(255, 255, 255, 0.15) 10%, rgba(255, 255, 255, 0.08) 70%); border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(145, 88, 193, 0.4);">
    <tr>
      <td align="center" style="padding-bottom: 20px;">
        <img src="{{ asset('img/logos/whiteRivoPng.png') }}" alt="RIVO" width="70" style="filter: drop-shadow(0 2px 6px rgba(255,255,255,0.5));" />
      </td>
    </tr>
    <tr>
      <td style="text-align:center;">
        <h2 style="margin: 0 0 15px; font-size: 28px; font-weight: 700; text-shadow: 0 2px 5px rgba(0, 0, 0, 0.4);">
          Restablece tu contraseña
        </h2>
        <p style="margin: 0 0 20px; font-size: 16px; color: #cfc2eb;">
          Has recibido este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.
        </p>
        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
          style="
            display: inline-block; 
            background: linear-gradient(135deg, #8d2e9b, #7c28b0);
            color: #fff !important; 
            padding: 14px 28px; 
            border-radius: 24px; 
            font-weight: 700; 
            font-size: 16px; 
            text-decoration: none; 
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(93, 28, 143, 0.7);
            transition: background 0.3s ease;
          "
          onmouseover="this.style.background='linear-gradient(135deg, #a433b6, #8326bd)';"
          onmouseout="this.style.background='linear-gradient(135deg, #8d2e9b, #7c28b0)';"
        >
          Restablecer contraseña
        </a>
        <p style="margin: 30px 0 0; font-size: 14px; color: #dcd6f7;">
          Este enlace caducará en 60 minutos.<br />
          Si no solicitaste este restablecimiento, no es necesario realizar ninguna acción.
        </p>
        <p style="margin-top: 40px; font-size: 14px; color: #cfc2eb;">
          — El equipo de <strong style="color:#f0e9ff;">RIVO</strong> —
        </p>
      </td>
    </tr>
  </table>

</body>
</html>
