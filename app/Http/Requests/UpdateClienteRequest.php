<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('cliente')?->id;

        return [
            'primeiro_nome' => ['sometimes', 'required', 'string', 'max:100'],
            'ultimo_nome'   => ['sometimes', 'required', 'string', 'max:100'],
            'genero'        => ['sometimes', 'required', Rule::in(['masculino', 'feminino', 'outro'])],
            'email'         => ['sometimes', 'required', 'email', Rule::unique('clientes', 'email')->ignore($id)],
            'telefone'      => ['nullable', 'string', 'max:20'],
            'ativo'         => ['sometimes', 'boolean'],
        ];
    }
}
