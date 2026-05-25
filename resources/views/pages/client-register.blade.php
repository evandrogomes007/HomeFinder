@extends('homefinder')

@section('title', 'Criar Conta — HomeFinder')

@section('content')

<div style="padding:52px 16px 80px; background:var(--gray-100);">
    <div style="max-width:520px; margin:0 auto;">

        {{-- Header ─────────────────────────────────────── --}}
        <div style="text-align:center; margin-bottom:32px;">
            <span class="card-eyebrow" style="display:block;">Registo gratuito</span>
            <h1 style="font-family:var(--font-h); font-size:2rem; font-weight:900; color:var(--charcoal); margin-bottom:8px;">
                Crie a sua conta
            </h1>
            <p style="font-size:.88rem; color:var(--gray-600);">
                Aceda a milhares de imóveis ou publique o seu.
            </p>
        </div>

        <div class="card">

            <form action="{{ route('clientes.store') }}" method="POST" novalidate>
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nome">Nome completo</label>
                    <input id="nome" type="text" name="nome"
                           value="{{ old('nome') }}"
                           placeholder="Ex: Maria da Silva"
                           autocomplete="name"
                           required>
                </div>

                <div class="input-row">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="genero">Género</label>
                        <select id="genero" name="genero" required>
                            <option value="" disabled {{ old('genero') ? '' : 'selected' }}>Selecionar</option>
                            <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="feminino"  {{ old('genero') == 'feminino'  ? 'selected' : '' }}>Feminino</option>
                            <option value="outro"     {{ old('genero') == 'outro'     ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="telefone">Telefone</label>
                        <input id="telefone" type="tel" name="telefone"
                               value="{{ old('telefone') }}"
                               placeholder="9XX XXX XXX"
                               autocomplete="tel"
                               required>
                    </div>
                </div>

                <div class="form-group" style="margin-top:16px;">
                    <label class="form-label" for="email">Endereço de email</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="o_seu@email.com"
                           autocomplete="email"
                           required>
                </div>

                <div class="input-row">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="password">Palavra-passe</label>
                        <input id="password" type="password" name="password"
                               placeholder="Mín. 8 caracteres"
                               autocomplete="new-password"
                               required>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="password_confirmation">Confirmar</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               placeholder="Repita a senha"
                               autocomplete="new-password"
                               required>
                    </div>
                </div>

                <button type="submit" class="btn btn-brand" style="margin-top:26px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Criar conta grátis
                </button>
            </form>

            @if($errors->any())
                <div class="alert" style="margin-top:16px;">
                    <p class="alert-title">Corrija os seguintes erros</p>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <hr class="divider">

            <p class="link-row">
                Já tem conta? <a href="{{ route('login') }}">Entrar →</a>
            </p>
        </div>

    </div>
</div>

@endsection
