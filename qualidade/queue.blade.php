@extends('adminlte::page')

@section('title', 'Fila de Análise de Qualidade')

@section('content_header')
    <h1>Fila de Análise de Qualidade</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Análises em Fila</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($queueItems ?? [] as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->type }}</td>
                    <td>
                        @if($item->status == 'pending')
                            <span class="badge badge-warning">Pendente</span>
                        @elseif($item->status == 'processing')
                            <span class="badge badge-info">Processando</span>
                        @elseif($item->status == 'completed')
                            <span class="badge badge-success">Concluído</span>
                        @else
                            <span class="badge badge-danger">Falhou</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($item->status == 'pending')
                        <form action="{{ route('qualidade.process', $item) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Processar</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum item na fila.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop