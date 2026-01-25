@extends('adminlte::page')

@section('title', 'Novo Post Social')

@section('content_header')
    <h1>Novo Post Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Criar Novo Post Social</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('communication.social_posts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Conteúdo</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="platform">Plataforma</label>
                <select name="platform" class="form-control" required>
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                    <option value="twitter">Twitter</option>
                    <option value="linkedin">LinkedIn</option>
                </select>
            </div>
            <div class="form-group">
                <label for="scheduled_at">Agendar para</label>
                <input type="datetime-local" name="scheduled_at" class="form-control">
                <small class="form-text text-muted">Deixe em branco para publicar imediatamente.</small>
            </div>
            <div class="form-group">
                <label for="media_url">URL da Mídia</label>
                <input type="url" name="media_url" class="form-control" placeholder="https://...">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('communication.social_posts.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection