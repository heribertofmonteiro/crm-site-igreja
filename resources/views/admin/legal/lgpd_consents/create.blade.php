@extends('adminlte::page')

@section('title', 'Novo Consentimento LGPD')

@section('content_header')
    <h1>Novo Consentimento LGPD</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Consentimento LGPD</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.legal.lgpd_consents.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="member_id">Membro</label>
                <select name="member_id" class="form-control" required>
                    @foreach(\App\Models\Member::all() as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="consent_type">Tipo de Consentimento</label>
                <select name="consent_type" class="form-control" required>
                    <option value="data_processing">Processamento de Dados</option>
                    <option value="marketing">Marketing</option>
                    <option value="communication">Comunicação</option>
                    <option value="other">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="consent_given">Consentimento Dado</label>
                <select name="consent_given" class="form-control" required>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>
            <div class="form-group">
                <label for="consent_date">Data do Consentimento</label>
                <input type="datetime-local" name="consent_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ip_address">Endereço IP</label>
                <input type="text" name="ip_address" class="form-control">
            </div>
            <div class="form-group">
                <label for="user_agent">User Agent</label>
                <textarea name="user_agent" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.legal.lgpd_consents.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop