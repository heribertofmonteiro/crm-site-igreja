@extends('adminlte::page')

@section('title', 'Trilha de Auditoria')

@section('content_header')
    <h1>Trilha de Auditoria</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Histórico de Atividades</h3>
    </div>
    <div class="card-body">
        <table id="audits-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>Modelo</th>
                    <th>Descrição</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr>
                    <td>{{ $activity->id }}</td>
                    <td>{{ $activity->causer ? $activity->causer->name : 'Sistema' }}</td>
                    <td>{{ $activity->event }}</td>
                    <td>{{ $activity->subject_type }} #{{ $activity->subject_id }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
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
        $('#audits-table').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#audits-table_wrapper .col-md-6:eq(0)');
    });
</script>
@stop