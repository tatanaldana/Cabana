<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
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
            'id'=>'required|integer|unique:users,id',
            'name'=> 'required|string|max:50',
            'tipo_doc'=>'required|string|max:10',
            'tel'=>'required|string|max:11',
            'fecha_naci'=>'required|date',
            'genero'=>'required|string|max:50',
            'direccion'=>'required|string|max:50',
            'email'=>'required|email|unique:users,email|max:50',
            'password'=>'required|string|min:8|max:50|regex:/[0-9]/|regex:/[a-zA-Z]/|confirmed',
        ];
    }
}
