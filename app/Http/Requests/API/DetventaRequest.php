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
            '*.nom_producto'=>'required|string|max:50',
            '*.pre_producto'=>'required|integer',
            '*.cantidad'=>'required|integer',
            '*.subtotal'=>'required|integer',
            '*.venta_id'=>'required|integer|exists:ventas,id'
        ];
    }
}
