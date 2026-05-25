<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePagamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ── Atributos do enunciado ────────────────────────────────
            'data_pagamento' => ['required', 'date'],
            'valor'          => ['required', 'numeric', 'min:0.01'],
            // ── Campos de suporte ─────────────────────────────────────
            'assinatura_id'  => ['required', 'exists:assinaturas,id'],
            'metodo'         => ['required', Rule::in([
                'transferencia_bancaria', 'multicaixa_express',
                'internet_banking', 'cartao_credito', 'cartao_debito', 'outro',
            ])],
            'comprovativo'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'observacoes'    => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'data_pagamento.required' => 'A data de pagamento é obrigatória.',
            'valor.required'          => 'O valor é obrigatório.',
            'valor.min'               => 'O valor deve ser maior que zero.',
            'assinatura_id.required'  => 'Indique a assinatura associada.',
            'metodo.required'         => 'Seleccione o método de pagamento.',
            'comprovativo.mimes'      => 'O comprovativo deve ser PDF, JPG ou PNG.',
            'comprovativo.max'        => 'O comprovativo não pode ultrapassar 5MB.',
        ];
    }
}
