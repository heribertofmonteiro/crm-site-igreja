@extends('adminlte::page')

@section('title', 'Detalhes da Assistência Social')

@section('content_header')
    <h1>Detalhes da Assistência Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Assistência #{{ $socialAssistance->id }}</h3>
        <div class="card-tools">
            @can('social_assistance.edit')
            <a href="{{ route('admin.social_assistance.edit', $socialAssistance) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.social_assistance.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Projeto Social</dt>
            <dd class="col-sm-9">{{ $socialAssistance->project->name }}</dd>

            <dt class="col-sm-3">Nome do Beneficiário</dt>
            <dd class="col-sm-9">{{ $socialAssistance->beneficiary_name }}</dd>

            <dt class="col-sm-3">Contato do Beneficiário</dt>
            <dd class="col-sm-9">{{ $socialAssistance->beneficiary_contact ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Tipo de Assistência</dt>
            <dd class="col-sm-9">{{ ucfirst($socialAssistance->assistance_type) }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $socialAssistance->description }}</dd>

            <dt class="col-sm-3">Data da Assistência</dt>
            <dd class="col-sm-9">{{ $socialAssistance->date_provided->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Valor</dt>
            <dd class="col-sm-9">R$ {{ number_format($socialAssistance->amount, 2, ',', '.') }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $socialAssistance->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $socialAssistance->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop