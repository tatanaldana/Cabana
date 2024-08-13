<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Venta</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        .items { width: 100%; border-collapse: collapse; }
        .items th, .items td { border: 1px solid #ddd; padding: 8px; }
        .items th { background-color: #f2f2f2; }
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
            <p>Venta ID: {{ $venta->id }}</p>
            <p>Usuario: {{ $venta->user->name }}</p>
            <p>Total: ${{ $venta->total }}</p>
        </div>

        <table class="items">
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
            </tbody>
        </table>
    </div>
</body>
</html>