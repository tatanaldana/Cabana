<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ProveedoreRequest extends FormRequest
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
            'codigo'=>'required|integer|unique:proveedores,codigo',
            'nombre'=>'required|string|max:50',
            'telefono'=>'required|string|max:50',
            'direccion'=>'required|string|max:50',
        ];
    }
}
