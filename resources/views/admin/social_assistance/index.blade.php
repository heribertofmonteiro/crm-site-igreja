@extends('adminlte::page')

@section('title', 'Assistências Sociais')

@section('content_header')
    <h1>Assistências Sociais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Assistências Sociais</h3>
        @can('social_assistance.create')
        <div class="card-tools">
            <a href="{{ route('admin.social_assistance.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Assistência
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Projeto</th>
                    <th>Beneficiário</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($socialAssistances as $assistance)
                <tr>
                    <td>{{ $assistance->id }}</td>
                    <td>{{ $assistance->project->name }}</td>
                    <td>{{ $assistance->beneficiary_name }}</td>
                    <td>{{ ucfirst($assistance->assistance_type) }}</td>
                    <td>{{ $assistance->date_provided->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($assistance->amount, 2, ',', '.') }}</td>
                    <td>
                        @can('social_assistance.view')
                        <a href="{{ route('admin.social_assistance.show', $assistance) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('social_assistance.edit')
                        <a href="{{ route('admin.social_assistance.edit', $assistance) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop