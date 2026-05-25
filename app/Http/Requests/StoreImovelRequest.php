<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImovelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'       => 'required|string|max:255',
            'descricao'    => 'required|string|min:10',
            'localizacao'  => 'required|string|max:255',
            'preco'        => 'required|numeric|min:1000',
            'tipo'         => 'required|in:casa,apartamento,terreno,quintal,comercial',
            'quartos'      => 'nullable|integer|min:0',
            'banheiros'    => 'nullable|integer|min:0',
            'area_m2'      => 'nullable|integer|min:10',
            'imagens.*'    => 'image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB por imagem
        ];
    }

    public function messages(): array
    {
        return [
            'imagens.*.image' => 'Apenas imagens são permitidas.',
            'imagens.*.max'   => 'Cada imagem não pode ter mais de 5MB.',
        ];
    }
}