<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'                  => 'required|string|min:3|max:255',
            'genero'                => 'required|in:masculino,feminino,outro',
            'telefone'              => 'required|string|min:9|max:20|unique:clientes,telefone',
            'email'                 => 'required|email|unique:clientes,email|max:255',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'          => 'O nome é obrigatório.',
            'nome.min'               => 'O nome deve ter pelo menos 3 caracteres.',
            'genero.required'        => 'O género é obrigatório.',
            'genero.in'              => 'Selecione um género válido.',
            'telefone.required'      => 'O telefone é obrigatório.',
            'telefone.min'           => 'O telefone deve ter pelo menos 9 dígitos.',
            'telefone.unique'        => 'Este telefone já está registado.',
            'email.required'         => 'O email é obrigatório.',
            'email.email'            => 'Insira um email válido.',
            'email.unique'           => 'Este email já está registado.',
            'password.required'      => 'A palavra-passe é obrigatória.',
            'password.min'           => 'A palavra-passe deve ter no mínimo 8 caracteres.',
            'password.confirmed'     => 'A confirmação de palavra-passe não coincide.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->telefone) {
            $this->merge([
                'telefone' => preg_replace('/\D/', '', $this->telefone),
            ]);
        }
    }
}
