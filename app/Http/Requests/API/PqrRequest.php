<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PqrRequest extends FormRequest
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
                    'hechos' => 'required|text',
                    'pretensiones' => 'required|text',
                    'tipo_suge' => ['required|string',Rule::in(['Quejas', 'Sugerencia', 'Reclamacion', 'Felicitacion'])],
                    'estado' => 'required|string',
                    'user_id' => 'required|integer|exists:users,id'
                ];

            case 'update':
                return [
                    'estado' => 'required|string',
                   // 'id'=>'required|integer|exists:pqrs,id'
                ];

            default:
                return [];
        }
    }
}
