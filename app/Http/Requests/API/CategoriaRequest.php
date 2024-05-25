<?php

namespace App\Http\Requests\API;

use App\Models\Categoria;
use Illuminate\Foundation\Http\FormRequest;


class CategoriaRequest extends FormRequest
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
                    'nombre_cat' => 'required|string',
                ];  

            case 'update':
                return [
                    'nombre_cat' => 'required|string',
                ];

            default:
                return [];
        }
    }
}
