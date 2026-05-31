@extends('homefinder')

@section('title', 'Editar Imóvel')

@section('content')
<div style="max-width:800px;margin:40px auto;">
    <h1>Editar Imóvel</h1>

    <form action="{{ route('imoveis.update', $imovel) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="titulo"
               value="{{ old('titulo', $imovel->titulo) }}">

        <textarea name="descricao">{{ old('descricao', $imovel->descricao) }}</textarea>

        <input type="text" name="localizacao"
               value="{{ old('localizacao', $imovel->localizacao) }}">

        <input type="number" step="0.01" name="preco"
               value="{{ old('preco', $imovel->preco) }}">

        <input type="number" name="quartos"
               value="{{ old('quartos', $imovel->quartos) }}">

        <input type="number" name="banheiros"
               value="{{ old('banheiros', $imovel->banheiros) }}">

        <input type="number" step="0.01" name="area_m2"
               value="{{ old('area_m2', $imovel->area_m2) }}">

        <button type="submit">Salvar alterações</button>
    </form>
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

@endsection