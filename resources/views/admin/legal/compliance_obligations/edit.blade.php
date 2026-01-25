@extends('adminlte::page')

@section('title', 'Editar Obrigação de Conformidade')

@section('content_header')
    <h1>Editar Obrigação de Conformidade</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Obrigação de Conformidade</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.legal.compliance_obligations.update', $complianceObligation) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $complianceObligation->title) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $complianceObligation->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="obligation_type">Tipo de Obrigação</label>
                <select name="obligation_type" class="form-control" required>
                    <option value="tax" {{ old('obligation_type', $complianceObligation->obligation_type) == 'tax' ? 'selected' : '' }}>Tributária</option>
                    <option value="legal" {{ old('obligation_type', $complianceObligation->obligation_type) == 'legal' ? 'selected' : '' }}>Legal</option>
                    <option value="regulatory" {{ old('obligation_type', $complianceObligation->obligation_type) == 'regulatory' ? 'selected' : '' }}>Regulatória</option>
                    <option value="financial" {{ old('obligation_type', $complianceObligation->obligation_type) == 'financial' ? 'selected' : '' }}>Financeira</option>
                    <option value="other" {{ old('obligation_type', $complianceObligation->obligation_type) == 'other' ? 'selected' : '' }}>Outra</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Data de Vencimento</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $complianceObligation->due_date->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ old('status', $complianceObligation->status) == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="completed" {{ old('status', $complianceObligation->status) == 'completed' ? 'selected' : '' }}>Concluída</option>
                    <option value="overdue" {{ old('status', $complianceObligation->status) == 'overdue' ? 'selected' : '' }}>Vencida</option>
                    <option value="cancelled" {{ old('status', $complianceObligation->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="responsible_user_id">Responsável</label>
                <select name="responsible_user_id" class="form-control" required>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" {{ old('responsible_user_id', $complianceObligation->responsible_user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control">{{ old('notes', $complianceObligation->notes) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.legal.compliance_obligations.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop