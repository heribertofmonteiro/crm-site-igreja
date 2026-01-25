@extends('adminlte::page')

@section('title', 'Fila de Refatoração - Sistema Kilocode')

@section('content_header')
    <h1>Fila de Refatoração</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tarefas de Refatoração</h3>
    </div>
    <div class="card-body">
        <table id="refactoring-queue-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Arquivo</th>
                    <th>Tipo de Problema</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Atribuído a</th>
                    <th>Criado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->file_path }}</td>
                    <td>{{ $task->issue_type }}</td>
                    <td>{{ Str::limit($task->description, 50) }}</td>
                    <td>
                        <span class="badge badge-{{ match($task->priority) {
                            'low' => 'secondary',
                            'medium' => 'warning',
                            'high' => 'danger',
                            'critical' => 'dark'
                        } }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ match($task->status) {
                            'pending' => 'secondary',
                            'in_progress' => 'info',
                            'completed' => 'success',
                            'cancelled' => 'light'
                        } }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </td>
                    <td>{{ $task->assignedUser ? $task->assignedUser->name : 'Não atribuído' }}</td>
                    <td>{{ $task->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('plugins.Datatables', true)

@section('js')
<script>
    $(function () {
        $("#refactoring-queue-table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#refactoring-queue-table_wrapper .col-md-6:eq(0)');
    });
</script>
@stop