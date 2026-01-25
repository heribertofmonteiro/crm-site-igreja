@extends('adminlte::page')

@section('title', 'Novo Estudante')

@section('content_header')
    <h1>Novo Estudante</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Estudante</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('education.students.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Data de Nascimento</label>
                <input type="date" name="birth_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contact_info">Informações de Contato</label>
                <input type="text" name="contact_info" class="form-control">
            </div>
            <div class="form-group">
                <label for="class_id">Turma</label>
                <select name="class_id" class="form-control" required>
                    <option value="">Selecione uma turma</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="parent_id">Pai/Mãe</label>
                <select name="parent_id" class="form-control">
                    <option value="">Selecione um responsável</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('education.students.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop