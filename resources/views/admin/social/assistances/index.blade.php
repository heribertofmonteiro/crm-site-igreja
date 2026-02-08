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
            <a href="{{ route('social.assistances.create') }}" class="btn btn-primary btn-sm">
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
                @foreach($assistances as $assistance)
                <tr>
                    <td>{{ $assistance->id }}</td>
                    <td>{{ $assistance->socialProject->name ?? 'N/A' }}</td>
                    <td>{{ $assistance->beneficiary_name }}</td>
                    <td>{{ ucfirst($assistance->assistance_type) }}</td>
                    <td>{{ $assistance->date_provided->format('d/m/Y') }}</td>
                    <td>{{ $assistance->amount ? 'R$ ' . number_format($assistance->amount, 2, ',', '.') : 'N/A' }}</td>
                    <td>
                        @can('social_assistance.view')
                        <a href="{{ route('social.assistances.show', $assistance) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('social_assistance.edit')
                        <a href="{{ route('social.assistances.edit', $assistance) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('social_assistance.delete')
                        <form action="{{ route('social.assistances.destroy', $assistance) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $assistances->links() }}
    </div>
</div>
@stop