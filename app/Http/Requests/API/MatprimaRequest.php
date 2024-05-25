<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MatprimaRequest extends FormRequest
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
            'referencia'=>'required|string|max:50',
            'descripcion'=>'required|string',
            'existencia'=>'required|integer',
            'entrada'=>'required|integer',
            'salida'=>'required|integer',
            'stock'=>'required|integer',
        ];
    }
}
