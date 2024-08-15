<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DetpromocioneRequest extends FormRequest
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
        switch ($this->route()->getActionMethod()) {
            case 'store':
                return [
                    'detalles.*.cantidad' => 'required|integer',
                    'detalles.*.descuento' => 'required|integer',
                    'detalles.*.subtotal' => 'required|integer',
                    'detalles.*.promocione_id' => 'required|integer|exists:promociones,id',
                    'detalles.*.producto_id' => 'required|integer|exists:productos,id'
                ];

            case 'update':
                return [
                    'detalles.*.id' => 'required|integer|exists:detpromociones,id',
                    'detalles.*.cantidad' => 'required|integer',
                    'detalles.*.descuento' => 'required|integer',
                    'detalles.*.subtotal' => 'required|integer',
                    'detalles.*.producto_id' => 'required|integer|exists:productos,id'
                ];

            default:
                return [];
        }
    }
}

