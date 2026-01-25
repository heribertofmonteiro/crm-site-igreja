@extends('adminlte::page')

@section('title', 'Detalhes do Consentimento LGPD')

@section('content_header')
    <h1>Detalhes do Consentimento LGPD</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Consentimento LGPD</h3>
        <div class="card-tools">
            @can('lgpd_consents.edit')
            <a href="{{ route('admin.legal.lgpd_consents.edit', $lgpdConsent) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('admin.legal.lgpd_consents.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Membro</dt>
            <dd class="col-sm-9">{{ $lgpdConsent->member->name ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Tipo de Consentimento</dt>
            <dd class="col-sm-9">{{ ucfirst(str_replace('_', ' ', $lgpdConsent->consent_type)) }}</dd>

            <dt class="col-sm-3">Consentimento Dado</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $lgpdConsent->consent_given ? 'success' : 'danger' }}">
                    {{ $lgpdConsent->consent_given ? 'Sim' : 'Não' }}
                </span>
            </dd>

            <dt class="col-sm-3">Data do Consentimento</dt>
            <dd class="col-sm-9">{{ $lgpdConsent->consent_date->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Endereço IP</dt>
            <dd class="col-sm-9">{{ $lgpdConsent->ip_address ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">User Agent</dt>
            <dd class="col-sm-9">{{ $lgpdConsent->user_agent ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $lgpdConsent->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $lgpdConsent->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@stop