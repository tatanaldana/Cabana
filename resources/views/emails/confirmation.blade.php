<!-- resources/views/emails/confirmation.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Registro</title>
</head>
<body>
    <h1>Hola {{ $user->name }}</h1>
    <p>Gracias por registrarte. Por favor, confirma tu correo electrónico haciendo clic en el siguiente enlace:</p>
    <a href="{{ url('api/V1/confirm-email/' . $token) }}">Confirmar Correo</a>
    <p>Si no solicitaste este registro, ignora este mensaje.</p>
</body>
</html>
