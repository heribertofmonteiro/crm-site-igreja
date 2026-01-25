@extends('adminlte::page')

@section('title', 'Centro de Incidentes')

@section('content_header')
    <h1>Centro de Incidentes</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Incidentes</h3>
        <div class="card-tools">
            <a href="{{ route('logs.export') }}" class="btn btn-primary btn-sm">Exportar Logs</a>
            <a href="{{ route('logs.cleanup') }}" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Limpar Logs Antigos</a>
        </div>
    </div>
    <div class="card-body">
        <table id="incidents-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Nível</th>
                    <th>Mensagem</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $incident)
                <tr>
                    <td>{{ $incident->id }}</td>
                    <td>{{ $incident->user ? $incident->user->name : 'N/A' }}</td>
                    <td>
                        <span class="badge badge-{{ $incident->level == 'error' ? 'danger' : ($incident->level == 'warning' ? 'warning' : 'info') }}">
                            {{ ucfirst($incident->level) }}
                        </span>
                    </td>
                    <td>{{ Str::limit($incident->message, 50) }}</td>
                    <td>
                        <form method="POST" action="{{ route('logs.incident.update', $incident) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-control form-control-sm">
                                <option value="open" {{ $incident->status == 'open' ? 'selected' : '' }}>Aberto</option>
                                <option value="investigating" {{ $incident->status == 'investigating' ? 'selected' : '' }}>Investigando</option>
                                <option value="resolved" {{ $incident->status == 'resolved' ? 'selected' : '' }}>Resolvido</option>
                                <option value="closed" {{ $incident->status == 'closed' ? 'selected' : '' }}>Fechado</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $incident->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#incidentModal{{ $incident->id }}">Ver Detalhes</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach($incidents as $incident)
<div class="modal fade" id="incidentModal{{ $incident->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalhes do Incidente #{{ $incident->id }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Mensagem:</strong> {{ $incident->message }}</p>
                <p><strong>Stack Trace:</strong></p>
                <pre>{{ $incident->stack_trace }}</pre>
            </div>
        </div>
    </div>
</div>
@endforeach
@stop

@section('plugins.Datatables', true)

@section('js')
<script>
    $(function () {
        $('#incidents-table').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#incidents-table_wrapper .col-md-6:eq(0)');
    });
</script>
@stop