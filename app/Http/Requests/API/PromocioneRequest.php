<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PromocioneRequest extends FormRequest
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
                    'nom_promo'=>'required|string|max:50',
                    'categoria_id'=>'required|integer|exists:categorias,id'
                 ];
 
             case 'update':
                 return [
                    'nom_promo'=>'required|string|max:50',
                 ];
 
             default:
                 return [];
         }
     }
   
}
