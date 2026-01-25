@extends('adminlte::page')

@section('title', 'Nova Obrigação de Conformidade')

@section('content_header')
    <h1>Nova Obrigação de Conformidade</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Nova Obrigação de Conformidade</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.legal.compliance_obligations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="obligation_type">Tipo de Obrigação</label>
                <select name="obligation_type" class="form-control" required>
                    <option value="tax">Tributária</option>
                    <option value="legal">Legal</option>
                    <option value="regulatory">Regulatória</option>
                    <option value="financial">Financeira</option>
                    <option value="other">Outra</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Data de Vencimento</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pendente</option>
                    <option value="completed">Concluída</option>
                    <option value="overdue">Vencida</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="responsible_user_id">Responsável</label>
                <select name="responsible_user_id" class="form-control" required>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.legal.compliance_obligations.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop