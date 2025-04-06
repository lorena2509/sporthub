<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reserva</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <tr style="background-color: #4CAF50;">
            <td style="padding: 20px; text-align: center; color: white;">
                <h1 style="margin: 0;">¡Reserva Confirmada!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <h2 style="color: #333;">Hola {{ $reserva->user->name }},</h2>
                <p style="font-size: 16px; color: #555;">Nos complace informarte que tu reserva ha sido confirmada con éxito. Aquí tienes los detalles:</p>

                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                    <tr>
                        <td style="padding: 10px 0; color: #333;"><strong>Cancha:</strong></td>
                        <td style="padding: 10px 0; color: #555;">{{ $reserva->cancha->nombre }}</td>
                    </tr>
                    <tr style="background-color: #f9f9f9;">
                        <td style="padding: 10px 0; color: #333;"><strong>Fecha:</strong></td>
                        <td style="padding: 10px 0; color: #555;">{{ $reserva->fecha }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #333;"><strong>Hora:</strong></td>
                        <td style="padding: 10px 0; color: #555;">{{ $reserva->start_time }} - {{ $reserva->end_time }}</td>
                    </tr>
                </table>

                <p style="font-size: 16px; color: #555; margin-top: 30px;">Gracias por utilizar nuestro sistema de reservas. ¡Te esperamos!</p>

                <p style="text-align: center; margin-top: 40px;">
                    <a href="{{ url('/') }}" style="display: inline-block; background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">Ir al sitio</a>
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #eeeeee; padding: 20px; text-align: center; font-size: 12px; color: #999;">
                © {{ now()->year }} Reservas Deportivas. Todos los derechos reservados.
            </td>
        </tr>
    </table>
</body>
</html>
