@extends('homefinder')

@section('title', 'Publicar Imóvel — HomeFinder')

@section('head')
<style>
    .publish-wrap {
        background: var(--gray-100);
        min-height: calc(100vh - 68px);
        padding: 48px 16px 80px;
    }
    .publish-header {
        max-width: 760px;
        margin: 0 auto 32px;
        text-align: center;
    }
    .section-block {
        background: var(--charcoal);
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        padding: 30px 32px;
        margin-bottom: 18px;
    }
    .section-block-title {
        font-family: var(--font-h);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-block-title span {
        width: 28px;
        height: 28px;
        background: var(--brand-light);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--brand);
        font-size: .75rem;
        font-weight: 800;
        font-family: var(--font-b);
        flex-shrink: 0;
    }
    .input-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }
    .upload-zone {
        border: 2px dashed var(--gray-200);
        border-radius: var(--radius-sm);
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color .18s, background .18s;
        background: var(--gray-100);
    }
    .upload-zone:hover {
        border-color: var(--brand);
        background: var(--brand-light);
    }
    .upload-zone input[type="file"] {
        display: none;
    }
    .upload-zone p { font-size: .83rem; color: var(--gray-600); margin-top: 8px; }
    .upload-zone strong { font-size: .9rem; color: var(--ink); }
    .publish-actions {
        max-width: 760px;
        margin: 0 auto;
        display: flex;
        gap: 12px;
    }
    .publish-actions .btn { margin-top: 0; }
    @media (max-width: 600px) {
        .input-row-3 { grid-template-columns: 1fr; }
        .section-block { padding: 22px 18px; }
        .publish-actions { flex-direction: column; }
    }
</style>
@endsection

@section('content')

<div class="publish-wrap">

    <div class="publish-header">
        <span class="card-eyebrow" style="display:block; margin-bottom:6px;">Publicação de imóvel</span>
        <h1 style="font-family:var(--font-h); font-size:1.9rem; font-weight:900; color:var(--charcoal); margin-bottom:8px;">
            Publicar o seu imóvel
        </h1>
        <p style="font-size:.88rem; color:var(--gray-600);">
            Preencha os dados abaixo. O seu anúncio ficará visível no feed imediatamente.
        </p>
    </div>

    <form action="{{ route('imoveis.store') }}" method="POST" enctype="multipart/form-data" style="max-width:760px; margin:0 auto;" novalidate>
        @csrf

        {{-- Informações básicas ─────────────────────────── --}}
        <div class="section-block">
            <h3 class="section-block-title">
                <span>1</span> Informações Básicas
            </h3>

            <div class="form-group">
                <label class="form-label" for="titulo">Título do anúncio</label>
                <input id="titulo" type="text" name="titulo"
                       value="{{ old('titulo') }}"
                       placeholder="Ex: Moradia T3 no Talatona com garagem"
                       required>
            </div>

            <div class="input-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="tipo">Tipo de imóvel</label>
                    <select id="tipo" name="tipo" required>
                        <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>Selecionar</option>
                        <option value="casa"        {{ old('tipo') == 'casa'        ? 'selected' : '' }}>Casa / Moradia</option>
                        <option value="apartamento" {{ old('tipo') == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                        <option value="terreno"     {{ old('tipo') == 'terreno'     ? 'selected' : '' }}>Terreno</option>
                        <option value="quintal"     {{ old('tipo') == 'quintal'     ? 'selected' : '' }}>Quintal</option>
                        <option value="comercial"   {{ old('tipo') == 'comercial'   ? 'selected' : '' }}>Espaço Comercial</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="localizacao">Localização / Bairro</label>
                    <input id="localizacao" type="text" name="localizacao"
                           value="{{ old('localizacao') }}"
                           placeholder="Ex: Talatona, Luanda"
                           required>
                </div>
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label class="form-label" for="descricao">Descrição detalhada</label>
                <textarea id="descricao" name="descricao"
                          placeholder="Descreva o imóvel: características, estado de conservação, proximidades, etc."
                          rows="4"
                          required>{{ old('descricao') }}</textarea>
            </div>
        </div>

        {{-- Preço e dimensões ───────────────────────────── --}}
        <div class="section-block">
            <h3 class="section-block-title">
                <span>2</span> Preço e Características
            </h3>

            <div class="input-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="preco">Preço (Kz)</label>
                    <input id="preco" type="number" name="preco"
                           value="{{ old('preco') }}"
                           placeholder="Ex: 12000000"
                           min="1000"
                           required>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="area_m2">Área (m²)</label>
                    <input id="area_m2" type="number" name="area_m2"
                           value="{{ old('area_m2') }}"
                           placeholder="Ex: 120"
                           min="10">
                </div>
            </div>

            <div class="input-row" style="margin-top:16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="quartos">Nº de Quartos</label>
                    <select id="quartos" name="quartos">
                        <option value="">— Não se aplica</option>
                        @for($i = 0; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ old('quartos') == $i ? 'selected' : '' }}>
                                {{ $i == 0 ? 'Estúdio' : $i . ($i == 1 ? ' quarto' : ' quartos') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="banheiros">Nº de Casas de Banho</label>
                    <select id="banheiros" name="banheiros">
                        <option value="">— Não se aplica</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ old('banheiros') == $i ? 'selected' : '' }}>
                                {{ $i . ($i == 1 ? ' casa de banho' : ' casas de banho') }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        {{-- Imagens ─────────────────────────────────────── --}}
        <div class="section-block">
            <h3 class="section-block-title">
                <span>3</span> Fotografias do Imóvel
            </h3>

            <div class="upload-zone" onclick="document.getElementById('imagens').click()">
                <input id="imagens" type="file" name="imagens[]" multiple accept="image/jpeg,image/png,image/webp">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="1.5" style="margin:0 auto;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <p style="margin-top:10px;"><strong>Clique para selecionar imagens</strong></p>
                <p>JPEG, PNG, WebP — máx. 5MB por imagem</p>
                <p id="file-names" style="margin-top:8px; color:var(--brand); font-weight:600; font-size:.82rem;"></p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert" style="margin-bottom:18px;">
                <p class="alert-title">Corrija os seguintes erros</p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Actions ─────────────────────────────────────── --}}
        <div class="publish-actions">
            <a href="{{ route('HomeFinder') }}" class="btn btn-ghost" style="width:auto; padding:13px 28px; margin-top:0;">
                Cancelar
            </a>
            <button type="submit" class="btn btn-brand" style="flex:1;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 2 11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Publicar Imóvel
            </button>
        </div>

    </form>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('imagens').addEventListener('change', function () {
        const names = Array.from(this.files).map(f => f.name).join(', ');
        const count = this.files.length;
        document.getElementById('file-names').textContent =
            count > 0 ? `${count} ficheiro(s) selecionado(s)` : '';
    });
</script>
@endsection
