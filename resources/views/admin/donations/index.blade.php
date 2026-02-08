@extends('adminlte::page')

@section('title', 'Doações')

@section('content_header')
    <h1>Doações</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Doações</h3>
        @can('donation.create')
        <div class="card-tools">
            <a href="{{ route('admin.donations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Doação
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Doador</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Método</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                <tr>
                    <td>{{ $donation->id }}</td>
                    <td>{{ $donation->donor_name }}</td>
                    <td>{{ $donation->donor_email }}</td>
                    <td>{{ ucfirst($donation->donation_type) }}</td>
                    <td>R$ {{ number_format($donation->amount, 2, ',', '.') }}</td>
                    <td>{{ $donation->date->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($donation->payment_method) }}</td>
                    <td>
                        @can('donation.view')
                        <a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('donation.edit')
                        <a href="{{ route('admin.donations.edit', $donation) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('donation.delete')
                        <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta doação?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop