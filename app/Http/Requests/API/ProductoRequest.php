<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use SebastianBergmann\Type\TrueType;

class ProductoRequest extends FormRequest
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
                    'nom_producto' => 'required|string|max:50',
                    'precio_producto' => 'required|integer',
                    'detalle' => 'required|integer',
                    'codigo' => 'required|string|max:10',
                    'categoria_id' => 'required|integer|exists:catgorias,id'
                ];

            case 'update':
                return [
                    'nom_producto' => 'required|string|max:50',
                    'precio_producto' => 'required|integer',
                    'detalle' => 'required|integer',
                    'codigo' => 'required|string|max:10'
                ];

            default:
                return [];
        }
    }
}
