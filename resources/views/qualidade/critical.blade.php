@extends('adminlte::page')

@section('title', 'Arquivos Críticos - Sistema Kilocode')

@section('content_header')
    <h1>Arquivos Críticos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Arquivos com Notas D ou F</h3>
    </div>
    <div class="card-body">
        <table id="critical-files-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Arquivo</th>
                    <th>Nota</th>
                    <th>Complexidade</th>
                    <th>Linhas</th>
                    <th>Índice de Manutenibilidade</th>
                    <th>Problemas</th>
                    <th>Última Análise</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                <tr>
                    <td>{{ $file->file_path }}</td>
                    <td>
                        <span class="badge badge-{{ $file->grade == 'F' ? 'danger' : 'warning' }}">
                            {{ $file->grade }}
                        </span>
                    </td>
                    <td>{{ $file->complexity }}</td>
                    <td>{{ $file->lines_of_code }}</td>
                    <td>{{ number_format($file->maintainability_index, 2) }}</td>
                    <td>{{ $file->issues_count }}</td>
                    <td>{{ $file->last_analyzed->format('d/m/Y H:i') }}</td>
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
        $("#critical-files-table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#critical-files-table_wrapper .col-md-6:eq(0)');
    });
</script>
@stop