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
            'detalles.*.pre_producto'=>'required|integer',
            'detalles.*.cantidad'=>'required|integer',
            'detalles.*.subtotal'=>'required|integer',
            'detalles.*.venta_id'=>'required|integer|exists:ventas,id'
        ];
    }
}
