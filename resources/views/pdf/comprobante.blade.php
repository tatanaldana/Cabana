<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Venta</title>
    <style>
      @page {
            margin: 1in; /* Ajusta el margen de la página */
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 0;
        }
        .header, .footer {
            margin-bottom: 10px; /* Separación entre los componentes */
        }
        .header {
            text-align: center;
        }
        .details {
            border: 1px solid #ddd; /* Añade borde para mejor separación */
            padding: 10px; /* Espaciado interno para mayor claridad */
            margin-bottom: 20px; /* Espacio debajo del contenedor de detalles */
        }
        .user-info, .items {
            width: 100%; /* Hace que las tablas se adapten al ancho del contenedor */
            border-collapse: collapse;
            margin: 0 auto; /* Centra la tabla horizontalmente */
        }
        .user-info td, .items th, .items td {
            padding: 8px;
            text-align: center; /* Centra el texto en las celdas */
            border: 1px solid #ddd; /* Añade borde a las celdas */
        }
        .items th {
            background-color: #f2f2f2;
        }
        .details p, .footer p {
            margin: 0;
        }
        /* Asegura que las tablas ocupen el ancho completo disponible */
        .table-container {
            width: 100%; /* Asegura que el contenedor de la tabla ocupe el 100% del ancho */
            overflow-x: auto; /* Permite el desplazamiento horizontal si es necesario */
        }
        h2{
            text-align: center;
            width: 100%; 
        }
       
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Comprobante de Venta</h1>
            <p>Fecha: {{ now()->format('d/m/Y') }}</p>
        </div>

        <div class="details">
            <h2>Detalles de la Venta</h2>
            <div class="table-container">
                <table class="user-info">
                    <tr>
                        <td><strong>Venta ID:</strong></td>
                        <td>{{ $venta->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Usuario:</strong></td>
                        <td>{{ $venta->user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono:</strong></td>
                        <td>{{ $venta->user->tel }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dirección:</strong></td>
                        <td>{{ $venta->user->direccion }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="details">
            <h2>Detalles de Productos</h2>
            <div class="table-container">
                <table class="user-info">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venta->detventas as $detalle)
                            <tr>
                                <td>{{ $detalle->nom_producto }}</td>
                                <td>${{ $detalle->pre_producto }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>${{ $detalle->subtotal }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><strong>Total:</strong> ${{ $venta->total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
