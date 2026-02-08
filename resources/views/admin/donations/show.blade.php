@extends('adminlte::page')

@section('title', 'Detalhes da Doação')

@section('content_header')
    <h1>Detalhes da Doação</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalhes da Doação</h3>
        <div class="card-tools">
            @can('donation.edit')
            <a href="{{ route('admin.donations.edit', $donation) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $donation->id }}</dd>

            <dt class="col-sm-3">Nome do Doador</dt>
            <dd class="col-sm-9">{{ $donation->donor_name }}</dd>

            <dt class="col-sm-3">Email do Doador</dt>
            <dd class="col-sm-9">{{ $donation->donor_email ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Tipo de Doação</dt>
            <dd class="col-sm-9">{{ ucfirst($donation->donation_type) }}</dd>

            <dt class="col-sm-3">Valor</dt>
            <dd class="col-sm-9">R$ {{ number_format($donation->amount, 2, ',', '.') }}</dd>

            <dt class="col-sm-3">Data</dt>
            <dd class="col-sm-9">{{ $donation->date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Método de Pagamento</dt>
            <dd class="col-sm-9">{{ ucfirst($donation->payment_method) }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $donation->description ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $donation->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $donation->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop