<!-- resources/views/emails/password_reset.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Restablecimiento de Contraseña</title>
</head>
<body>
    <h1>Hola {{ $user->name }}</h1>
    <p>Hemos recibido una solicitud para restablecer tu contraseña. Puedes hacerlo haciendo clic en el siguiente enlace:</p>
    <a href="{{ url('http://localhost:5173/CodeEmailConfirmation/?token=' . $token) }}">Restablecer Contraseña</a>
    <p>Si no solicitaste este restablecimiento, ignora este mensaje.</p>
</body>
</html>
