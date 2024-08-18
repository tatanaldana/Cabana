<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        // Verificar el método de la ruta
       // dd('Current route action method:', $this->route()->getActionMethod());

        switch ($this->route()->getActionMethod()) {
            case 'store':
                return [
                    'imageable_type' => [
                        'required',
                        Rule::in(['productos', 'categorias', 'promociones', 'users']),
                    ],
                    'imageable_id' => [
                        'required',
                        'integer',
                    ],
                    'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:3048|dimensions:min_width=200,min_height=200,max_width=2000,max_height=2000',
                ];

                case 'updateImage':
                    return [
                        'imageable_type' => [
                            'required',
                            Rule::in(['productos', 'categorias', 'promociones', 'users']),
                        ],
                        'imageable_id' => [
                            'required',
                            'integer',
                        ],
                        'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:3048|dimensions:min_width=200,min_height=200,max_width=2000,max_height=2000',
                    ];
                default:
                    return [ ];
        }
    }

}