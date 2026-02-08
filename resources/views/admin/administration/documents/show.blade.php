@extends('adminlte::page')

@section('title', 'Detalhes do Documento')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalhes do Documento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.administration.documents.index') }}">Documentos</a></li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="{{ $document->icon }} fa-5x text-secondary"></i>
                </div>

                <h3 class="profile-username text-center mt-3">{{ $document->title }}</h3>

                <p class="text-muted text-center">{{ $document->type_label }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status</b> <span class="float-right">{!! $document->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Versão</b> <span class="float-right">{{ $document->version ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Tamanho</b> <span class="float-right">{{ $document->formatted_file_size }}</span>
                    </li>
                </ul>

                @if($document->file_path)
                    <a href="{{ $document->file_url }}" target="_blank" class="btn btn-primary btn-block">
                        <i class="fas fa-download"></i> Baixar Arquivo
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Detalhes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#metadata" data-toggle="tab">Metadados</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="details">
                        <strong><i class="fas fa-book mr-1"></i> Descrição</strong>
                        <p class="text-muted">
                            {{ $document->description ?? 'Nenhuma descrição fornecida.' }}
                        </p>

                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-building mr-1"></i> Departamento</strong>
                                <p class="text-muted">{{ $document->department?->name ?? 'Geral' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-tag mr-1"></i> Categoria</strong>
                                <p class="text-muted">{{ $document->category?->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="far fa-calendar-alt mr-1"></i> Vigência</strong>
                                <p class="text-muted">
                                    {{ optional($document->effective_date)->format('d/m/Y') ?? '--' }}
                                     até 
                                    {{ optional($document->expiration_date)->format('d/m/Y') ?? '--' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="metadata">
                        <dl class="row">
                            <dt class="col-sm-4">Criado por</dt>
                            <dd class="col-sm-8">{{ $document->creator?->name ?? 'Sistema' }} em {{ $document->created_at->format('d/m/Y H:i') }}</dd>

                            <dt class="col-sm-4">Aprovado por</dt>
                            <dd class="col-sm-8">
                                @if($document->approved_by)
                                    {{ $document->approver?->name ?? $document->approved_by }} em {{ optional($document->approved_at)->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-warning">Não aprovado</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Última atualização</dt>
                            <dd class="col-sm-8">{{ $document->updated_at->format('d/m/Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.administration.documents.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <a href="{{ route('admin.administration.documents.edit', $document) }}" class="btn btn-warning float-right">
                    <i class="fas fa-pencil-alt"></i> Editar
                </a>
            </div>
        </div>
    </div>
</div>
@stop
