<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PDFRequest extends FormRequest
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
            case 'generatePdf':
                return [
                    'id' => 'required|integer|exists:ventas,id',
                ];  

            case 'generatePdf2':
                return [
                    'id' => 'required|integer|exists:pqrs,id',
                ];  

            default:
                return [];
        }
    }
}
