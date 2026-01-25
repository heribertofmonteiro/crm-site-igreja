@extends('adminlte::page')

@section('title', 'Reuniões do Conselho Fiscal')

@section('content_header')
    <h1>Reuniões do Conselho Fiscal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Reuniões</h3>
        <div class="card-tools">
            <a href="{{ route('fiscal-council-meetings.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Reunião
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data da Reunião</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->id }}</td>
                    <td>{{ $meeting->meeting_date->format('d/m/Y') }}</td>
                    <td>
                        @if($meeting->status == 'scheduled')
                            <span class="badge badge-info">Agendada</span>
                        @elseif($meeting->status == 'held')
                            <span class="badge badge-success">Realizada</span>
                        @else
                            <span class="badge badge-danger">Cancelada</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('fiscal-council-meetings.show', $meeting) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('fiscal-council-meetings.edit', $meeting) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('fiscal-council-meetings.destroy', $meeting) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $meetings->links() }}
    </div>
</div>
@stop