<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DetventaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'detalles.*.nom_producto'=>'required|string|max:50|exists:productos,nom_producto',
            'detalles.*.pre_producto'=>'required|integer|min:1',
            'detalles.*.cantidad' => 'required|integer|min:1', // Asegurarse de que la cantidad sea al menos 1
            'detalles.*.subtotal' => 'required|integer|min:0', // Subtotal no puede ser negativo
            'detalles.*.venta_id' => 'required|integer|exists:ventas,id',
            'detalles.*.descuento' => 'nullable|integer|min:0',
            'detalles.*.porcentaje' => 'nullable|integer|min:0|max:100',
            'detalles.*.promocione_id' => 'nullable|integer|exists:promociones,id',
            'total' => 'required|integer|min:1', // Total debe ser mayor que 0
        ];
    }
}
