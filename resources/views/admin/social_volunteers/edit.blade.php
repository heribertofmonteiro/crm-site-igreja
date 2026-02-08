@extends('adminlte::page')

@section('title', 'Editar Voluntário Social')

@section('content_header')
    <h1>Editar Voluntário Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Voluntário Social</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.social_volunteers.update', $socialVolunteer) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="social_project_id">Projeto Social</label>
                <select name="social_project_id" class="form-control" required>
                    @foreach($socialProjects as $project)
                        <option value="{{ $project->id }}" {{ old('social_project_id', $socialVolunteer->social_project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('social_project_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="user_id">Usuário</label>
                <select name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $socialVolunteer->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="role">Função</label>
                <input type="text" name="role" class="form-control" value="{{ old('role', $socialVolunteer->role) }}" required>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="joined_at">Data de Ingresso</label>
                <input type="date" name="joined_at" class="form-control" value="{{ old('joined_at', $socialVolunteer->joined_at->format('Y-m-d')) }}" required>
                @error('joined_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $socialVolunteer->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="inactive" {{ old('status', $socialVolunteer->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
                    <option value="suspended" {{ old('status', $socialVolunteer->status) == 'suspended' ? 'selected' : '' }}>Suspenso</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('admin.social_volunteers.show', $socialVolunteer) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@stop