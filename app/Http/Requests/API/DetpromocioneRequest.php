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
                    '*.cantidad' => 'required|integer',
                    '*.descuento' => 'required|integer',
                    '*.subtotal' => 'required|integer',
                    '*.promocione_id' => 'required|integer|exists:promociones,id',
                    '*.producto_id' => 'required|integer|exists:productos,id'
                ];

            case 'update':
                return [
                    '*.cantidad' => 'required|integer',
                    '*.descuento' => 'required|integer',
                    '*.subtotal' => 'required|integer',
                    '*.producto_id' => 'required|integer|exists:productos,id'
                ];

            default:
                return [];
        }
    }
}

