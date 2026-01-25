@extends('adminlte::page')

@section('title', 'Explorador de Logs')

@section('content_header')
    <h1>Explorador de Logs</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Arquivos de Log</h3>
    </div>
    <div class="card-body">
        <p>Visualização básica de logs. Para uma interface completa, considere integrar com ferramentas externas.</p>
        <ul>
            @foreach(glob(storage_path('logs/*.log')) as $file)
            <li>{{ basename($file) }} - {{ date('Y-m-d H:i:s', filemtime($file)) }}</li>
            @endforeach
        </ul>
    </div>
</div>
@stop