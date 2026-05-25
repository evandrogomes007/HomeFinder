<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAssinaturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ── Atributos do enunciado ────────────────────────────────
            'data_inicio'          => ['required', 'date', 'after_or_equal:today'],
            'data_fim'             => ['required', 'date', 'after:data_inicio'],
            'valor'                => ['required', 'numeric', 'min:0'],
            // ── Campos de suporte ─────────────────────────────────────
            'cliente_id'           => ['required', 'exists:clientes,id'],
            'plano_id'             => ['required', 'exists:planos,id'],
            'metodo_pagamento'     => ['required', Rule::in([
                'transferencia_bancaria', 'multicaixa_express',
                'internet_banking', 'cartao_credito', 'cartao_debito', 'outro',
            ])],
            'renovacao_automatica' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'data_inicio.required'      => 'A data de início é obrigatória.',
            'data_inicio.after_or_equal'=> 'A data de início não pode ser no passado.',
            'data_fim.required'         => 'A data de fim é obrigatória.',
            'data_fim.after'            => 'A data de fim deve ser posterior à data de início.',
            'valor.required'            => 'O valor da assinatura é obrigatório.',
            'plano_id.required'         => 'Seleccione um plano.',
            'metodo_pagamento.required' => 'Seleccione o método de pagamento.',
        ];
    }
}
