@extends('adminlte::page')

@section('title', 'Logs de Acesso ao Sistema')

@section('content_header')
    <h1>Logs de Acesso ao Sistema</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Histórico de Acessos</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>IP</th>
                    <th>User Agent</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\SystemAccessLog::with('user')->latest()->limit(100)->get() as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user->name ?? 'Usuário não encontrado' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>
                        <small>{{ Str::limit($log->user_agent, 50) }}</small>
                        @if(strlen($log->user_agent) > 50)
                            <button class="btn btn-xs btn-info" onclick="alert('{{ $log->user_agent }}')">Ver completo</button>
                        @endif
                    </td>
                    <td>{{ $log->accessed_at->format('d/m/Y H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum log de acesso encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <small class="text-muted">Mostrando os últimos 100 acessos. Para mais detalhes, consulte o banco de dados diretamente.</small>
    </div>
</div>
@stop