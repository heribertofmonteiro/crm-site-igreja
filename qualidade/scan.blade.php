@extends('adminlte::page')

@section('title', 'Scan de Qualidade de Código')

@section('content_header')
    <h1>Scan de Qualidade de Código</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Executar Scan de Qualidade</h3>
    </div>
    <div class="card-body">
        <p>Inicie um scan completo da qualidade do código do projeto.</p>
        <form action="{{ route('qualidade.scan') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Iniciar Scan</button>
        </form>
        @if(isset($results))
        <div class="mt-3">
            <h4>Resultados do Scan</h4>
            <pre>{{ $results }}</pre>
        </div>
        @endif
    </div>
</div>
@stop