<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateImovelRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo'       => 'sometimes|required|string|max:255',
            'descricao'    => 'sometimes|required|string|min:10',
            'localizacao'  => 'sometimes|required|string|max:255',
            'preco'        => 'sometimes|required|numeric|min:1000',
            'tipo'         => 'sometimes|required|in:casa,apartamento,terreno,quintal,comercial',
            'quartos'      => 'nullable|integer|min:0',
            'banheiros'    => 'nullable|integer|min:0',
            'area_m2'      => 'nullable|integer|min:10',
        ];
    }
}
