@extends('adminlte::page')

@section('title', 'Editar Consentimento LGPD')

@section('content_header')
    <h1>Editar Consentimento LGPD</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Consentimento LGPD</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.legal.lgpd_consents.update', $lgpdConsent) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="member_id">Membro</label>
                <select name="member_id" class="form-control" required>
                    @foreach(\App\Models\Member::all() as $member)
                        <option value="{{ $member->id }}" {{ old('member_id', $lgpdConsent->member_id) == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="consent_type">Tipo de Consentimento</label>
                <select name="consent_type" class="form-control" required>
                    <option value="data_processing" {{ old('consent_type', $lgpdConsent->consent_type) == 'data_processing' ? 'selected' : '' }}>Processamento de Dados</option>
                    <option value="marketing" {{ old('consent_type', $lgpdConsent->consent_type) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="communication" {{ old('consent_type', $lgpdConsent->consent_type) == 'communication' ? 'selected' : '' }}>Comunicação</option>
                    <option value="other" {{ old('consent_type', $lgpdConsent->consent_type) == 'other' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="consent_given">Consentimento Dado</label>
                <select name="consent_given" class="form-control" required>
                    <option value="1" {{ old('consent_given', $lgpdConsent->consent_given) ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ !old('consent_given', $lgpdConsent->consent_given) ? 'selected' : '' }}>Não</option>
                </select>
            </div>
            <div class="form-group">
                <label for="consent_date">Data do Consentimento</label>
                <input type="datetime-local" name="consent_date" class="form-control" value="{{ old('consent_date', $lgpdConsent->consent_date->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group">
                <label for="ip_address">Endereço IP</label>
                <input type="text" name="ip_address" class="form-control" value="{{ old('ip_address', $lgpdConsent->ip_address) }}">
            </div>
            <div class="form-group">
                <label for="user_agent">User Agent</label>
                <textarea name="user_agent" class="form-control">{{ old('user_agent', $lgpdConsent->user_agent) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.legal.lgpd_consents.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop