<?php

namespace App\Traits;
use App\Models\Producto;


trait CalculoValores{


    private function validarTotalYDetalles(array $detalles, int $totalEnviado): array
    {
        $totalCalculado = 0;

        foreach ($detalles as $detalle) {
            $producto = Producto::where('nom_producto', $detalle['nom_producto'])->first();
            
            if (!$producto) {
                return [
                    'success' => false,
                    'message' => "El producto {$detalle['nom_producto']} no existe.",
                ];
            }

            if ($producto->precio_producto != $detalle['pre_producto']) {
                return [
                    'success' => false,
                    'message' => "El precio del producto {$detalle['nom_producto']} no es válido.",
                ];
            }

            $subtotalCalculado = $detalle['pre_producto'] * $detalle['cantidad'];
            if ($subtotalCalculado !== $detalle['subtotal']) {
                return [
                    'success' => false,
                    'message' => "El subtotal calculado para el producto {$detalle['nom_producto']} no coincide.",
                ];
            }

            $totalCalculado += $subtotalCalculado;
        }

        if ($totalCalculado !== $totalEnviado) {
            return [
                'success' => false,
                'total_calculado' => $totalCalculado,
                'message' => 'El total calculado no coincide con el total enviado.',
            ];
        }

        return [
            'success' => true,
            'total_calculado' => $totalCalculado,
        ];
    }

    private function validarYCalcularPromociones(array $detalles,int $totalEnviado): array
    {
        $totalCalculado = 0;

        foreach ($detalles as $detalle) {
            $producto = Producto::find($detalle['producto_id']);
            
            if (!$producto) {
                return [
                    'success' => false,
                    'message' => "El producto con ID {$detalle['producto_id']} no existe.",
                ];
            }

            // Verificar el porcentaje de descuento
            if ($detalle['porcentaje'] < 0 || $detalle['porcentaje'] > 100) {
                return [
                    'success' => false,
                    'message' => "El porcentaje de descuento para el producto ID {$detalle['producto_id']} no es válido. Debe estar entre 0 y 100.",
                ];
            }

            // Calcular el descuento y subtotal
            $precioProducto = $producto->precio_producto;
            $totalPrecioProducto= $precioProducto * $detalle['cantidad'];
            $descuentoCalculado = ($totalPrecioProducto * $detalle['porcentaje']) / 100;

            if($descuentoCalculado !== $detalle['descuento']){
                return [
                    'success' => false,
                    'message' => "El descuento calculado para el producto ID {$detalle['producto_id']} no coincide.",
                ];
            }

            $subtotalCalculado = $totalPrecioProducto - $descuentoCalculado;

            if ($subtotalCalculado !== $detalle['subtotal']) {
                return [
                    'success' => false,
                    'message' => "El subtotal calculado para el producto ID {$detalle['producto_id']} no coincide.",
                ];
            }

            $totalCalculado += $subtotalCalculado;
        }

        if ($totalCalculado !== $totalEnviado) {
            return [
                'success' => false,
                'total_calculado' => $totalCalculado,
                'message' => 'El total calculado no coincide con el total enviado.',
            ];
        }

        return [
            'success' => true,
            'total_calculado' => $totalCalculado,
        ];
    }
}
