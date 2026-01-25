@extends('adminlte::page')

@section('title', 'Nova Auditoria Financeira')

@section('content_header')
    <h1>Nova Auditoria Financeira</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Auditoria</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('financial-audits.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="audit_date">Data da Auditoria</label>
                <input type="date" name="audit_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="period_start">Período Início</label>
                <input type="date" name="period_start" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="period_end">Período Fim</label>
                <input type="date" name="period_end" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="findings">Achados</label>
                <textarea name="findings" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="recommendations">Recomendações</label>
                <textarea name="recommendations" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pendente</option>
                    <option value="in_progress">Em Andamento</option>
                    <option value="completed">Concluída</option>
                </select>
            </div>
            <div class="form-group">
                <label for="auditor">Auditor</label>
                <input type="text" name="auditor" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('financial-audits.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop