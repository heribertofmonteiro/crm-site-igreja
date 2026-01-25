@extends('adminlte::page')

@section('title', 'Consentimentos LGPD')

@section('content_header')
    <h1>Consentimentos LGPD</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Consentimentos LGPD</h3>
        @can('lgpd_consents.create')
        <div class="card-tools">
            <a href="{{ route('admin.legal.lgpd_consents.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Consentimento
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Membro</th>
                    <th>Tipo de Consentimento</th>
                    <th>Consentimento Dado</th>
                    <th>Data do Consentimento</th>
                    <th>IP</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lgpdConsents as $consent)
                <tr>
                    <td>{{ $consent->id }}</td>
                    <td>{{ $consent->member->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $consent->consent_type)) }}</td>
                    <td>
                        <span class="badge badge-{{ $consent->consent_given ? 'success' : 'danger' }}">
                            {{ $consent->consent_given ? 'Sim' : 'Não' }}
                        </span>
                    </td>
                    <td>{{ $consent->consent_date->format('d/m/Y H:i') }}</td>
                    <td>{{ $consent->ip_address ?: 'N/A' }}</td>
                    <td>{{ $consent->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('lgpd_consents.view')
                        <a href="{{ route('admin.legal.lgpd_consents.show', $consent) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('lgpd_consents.edit')
                        <a href="{{ route('admin.legal.lgpd_consents.edit', $consent) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('lgpd_consents.delete')
                        <form action="{{ route('admin.legal.lgpd_consents.destroy', $consent) }}" method="POST" style="display: inline;">
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
        {{ $lgpdConsents->links() }}
    </div>
</div>
@stop