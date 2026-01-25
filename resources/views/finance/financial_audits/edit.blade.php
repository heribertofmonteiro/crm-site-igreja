@extends('adminlte::page')

@section('title', 'Editar Auditoria Financeira')

@section('content_header')
    <h1>Editar Auditoria Financeira</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Auditoria</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('financial-audits.update', $financialAudit) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="audit_date">Data da Auditoria</label>
                <input type="date" name="audit_date" class="form-control" value="{{ $financialAudit->audit_date->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="period_start">Período Início</label>
                <input type="date" name="period_start" class="form-control" value="{{ $financialAudit->period_start->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="period_end">Período Fim</label>
                <input type="date" name="period_end" class="form-control" value="{{ $financialAudit->period_end->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label for="findings">Achados</label>
                <textarea name="findings" class="form-control" rows="3">{{ $financialAudit->findings }}</textarea>
            </div>
            <div class="form-group">
                <label for="recommendations">Recomendações</label>
                <textarea name="recommendations" class="form-control" rows="3">{{ $financialAudit->recommendations }}</textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $financialAudit->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="in_progress" {{ $financialAudit->status == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="completed" {{ $financialAudit->status == 'completed' ? 'selected' : '' }}>Concluída</option>
                </select>
            </div>
            <div class="form-group">
                <label for="auditor">Auditor</label>
                <input type="text" name="auditor" class="form-control" value="{{ $financialAudit->auditor }}">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('financial-audits.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop