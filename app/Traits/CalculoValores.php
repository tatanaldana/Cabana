<?php

namespace App\Traits;

use App\Models\Detpromocione;
use App\Models\Producto;
use App\Models\Promocione;

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
    
            // Inicializar subtotal calculado
            $subtotalCalculado = $detalle['pre_producto'] * $detalle['cantidad'];
    
            // Verificar si hay un ID de promoción
            $promocionId = $detalle['promocione_id'] ?? null;
            if ($promocionId) {
                $promocion = Promocione::find($promocionId);
    
                if (!$promocion) {
                    return [
                        'success' => false,
                        'message' => "La promoción con ID {$promocionId} no existe.",
                    ];
                }
    
                $detpromocion = Detpromocione::where('promocione_id', $promocionId)
                                             ->where('producto_id', $producto->id)
                                             ->first();
    
                if (!$detpromocion) {
                    return [
                        'success' => false,
                        'message' => "El detalle de promoción para el producto {$detalle['nom_producto']} no existe.",
                    ];
                }
    
                $descuentoPromocional = $detpromocion->descuento ?? 0;
            $porcentajePromocional = $detpromocion->porcentaje ?? 0;

            // Verificar que el porcentaje y descuento aplicados coincidan con los datos proporcionados
            if ($porcentajePromocional !== ($detalle['porcentaje'] ?? 0)) {
                return [
                    'success' => false,
                    'message' => "El porcentaje de descuento aplicado para el producto {$detalle['nom_producto']} no coincide.",
                ];
            }

            if ($descuentoPromocional !== ($detalle['descuento'] ?? 0)) {
                return [
                    'success' => false,
                    'message' => "El descuento aplicado para el producto {$detalle['nom_producto']} no coincide.",
                ];
            }

            // Aplicar el descuento y porcentaje de la promoción
            $subtotalCalculado -= ($subtotalCalculado * $porcentajePromocional) / 100;

            //dd($subtotalCalculado," ++++++ ",$detalle['subtotal']);
    
                if ($subtotalCalculado !== $detalle['subtotal']) {
                    return [
                        'success' => false,
                        'message' => "El subtotal calculado para el producto {$detalle['nom_producto']} con la promoción aplicada no coincide.",
                        'subtotal_calculado' => $subtotalCalculado,
                    ];
                }
            } else {
                // Productos sin promoción, validar el subtotal normal
                if ($subtotalCalculado !== $detalle['subtotal']) {
                    return [
                        'success' => false,
                        'message' => "El subtotal calculado para el producto {$detalle['nom_producto']} sin promoción no coincide.",
                        'subtotal_calculado' => $subtotalCalculado,
                    ];
                }
            }
    
            // Acumulando el total calculado
            $totalCalculado += $subtotalCalculado;
        }
    
        // Verificar si el total calculado coincide con el total enviado
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
