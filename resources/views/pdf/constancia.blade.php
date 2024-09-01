<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia PQRS</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Usar una fuente estándar compatible con DomPDF */
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            max-width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 20px;
            color: #f1440f;
        }

        header p {
            font-size: 12px;
            color: #555;
        }

        .sugerencia {
            margin-bottom: 20px;
        }

        .sugerencia h2 {
            font-size: 18px;
            border-bottom: 1px dashed #0077b6;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .sugerencia p {
            margin: 5px 0;
            font-size: 14px;
        }

        .sugerencia p strong {
            color: #333;
        }

        .divider {
            border-top: 1px dashed #0077b6;
            margin: 15px 0;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <img src="{{ public_path('images/img/logo.png') }}" alt="Logo" class="logo">
            <div>
                <h1>Constancia</h1>
                <p>Fecha de Generación: {{ now()->format('d/m/Y')  }}</p>
            </div>
        </header>
        <!-- Campos con sus valores -->
        <section class="sugerencia">
            <p><strong>Documento:</strong> {{ $pqr->user_id }}</p>
            <p><strong>Nombre:</strong> {{ $pqr->user->name }}</p>
            <p><strong>Teléfono:</strong> {{ $pqr->user->tel }}</p>
            <p><strong>Correo:</strong> {{ $pqr->user->email }}</p>

            <div class="divider"></div>

            <p><strong>Tipo de Sugerencia:</strong> {{ $pqr->tipo_suge }}</p>
            <p><strong>ID de la PQR:</strong> {{ $pqr->id }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $pqr->created_at }}</p>

            <div class="divider"></div>

            <p><strong>Hechos:</strong></p>
            <p style="border: 1px dashed #ccc; padding: 10px; border-radius: 5px; background-color: #f0f8ff;">{{ $pqr->hechos }}</p>
            <p><strong>Pretensiones:</strong></p>
            <p style="border: 1px dashed #ccc; padding: 10px; border-radius: 5px; background-color: #f0f8ff;">{{ $pqr->pretensiones }}</p>
        </section>

        <footer>
            <p>Generado por: [La Cabaña]</p>
            <p>&copy; 2024 - Todos los derechos reservados</p>
        </footer>
    </div>
</body>

</html>
