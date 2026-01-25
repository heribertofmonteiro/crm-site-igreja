@extends('adminlte::page')

@section('title', 'Detalhes do Documento Legal')

@section('content_header')
    <h1>Detalhes do Documento Legal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $legalDocument->title }}</h3>
        <div class="card-tools">
            @can('legal_documents.edit')
            <a href="{{ route('admin.legal.legal_documents.edit', $legalDocument) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.legal.legal_documents.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9">{{ $legalDocument->title }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $legalDocument->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Tipo de Documento</dt>
            <dd class="col-sm-9">{{ ucfirst($legalDocument->document_type) }}</dd>

            <dt class="col-sm-3">Caminho do Arquivo</dt>
            <dd class="col-sm-9">{{ $legalDocument->file_path ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Data de Expiração</dt>
            <dd class="col-sm-9">{{ $legalDocument->expiration_date ? $legalDocument->expiration_date->format('d/m/Y') : 'Não informado' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $legalDocument->status == 'active' ? 'success' : ($legalDocument->status == 'expired' ? 'danger' : 'warning') }}">
                    {{ ucfirst($legalDocument->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Criado por</dt>
            <dd class="col-sm-9">{{ $legalDocument->creator->name ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $legalDocument->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $legalDocument->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop