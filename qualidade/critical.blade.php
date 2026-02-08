@extends('adminlte::page')

@section('title', 'Problemas Críticos de Qualidade')

@section('content_header')
    <h1>Problemas Críticos de Qualidade</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Problemas Críticos</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Arquivo</th>
                    <th>Linha</th>
                    <th>Problema</th>
                    <th>Severidade</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($criticalIssues ?? [] as $issue)
                <tr>
                    <td>{{ $issue->id }}</td>
                    <td>{{ $issue->file }}</td>
                    <td>{{ $issue->line }}</td>
                    <td>{{ $issue->message }}</td>
                    <td><span class="badge badge-danger">{{ $issue->severity }}</span></td>
                    <td>{{ $issue->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum problema crítico encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop