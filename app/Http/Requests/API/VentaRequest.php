<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
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
                    'metodo_pago' => 'required|string|max:20',
                    'address_ventas'=>'nullable|string|max:50',
                    'user_id' => 'required|integer|exists:users,id',
                ];

            case 'update':
                return [
                    'estado' => 'required|string|in:Completado',
                ];

            default:
                return [];
        }
    }
}
