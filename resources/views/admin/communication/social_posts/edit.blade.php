@extends('adminlte::page')

@section('title', 'Editar Post Social')

@section('content_header')
    <h1>Editar Post Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Post Social</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('communication.social_posts.update', $socialPost) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="content">Conteúdo</label>
                <textarea name="content" class="form-control" rows="5" required>{{ $socialPost->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="platform">Plataforma</label>
                <select name="platform" class="form-control" required>
                    <option value="facebook" {{ $socialPost->platform === 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="instagram" {{ $socialPost->platform === 'instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="twitter" {{ $socialPost->platform === 'twitter' ? 'selected' : '' }}>Twitter</option>
                    <option value="linkedin" {{ $socialPost->platform === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                </select>
            </div>
            <div class="form-group">
                <label for="scheduled_at">Agendar para</label>
                <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ $socialPost->scheduled_at ? $socialPost->scheduled_at->format('Y-m-d\TH:i') : '' }}">
                <small class="form-text text-muted">Deixe em branco para publicar imediatamente.</small>
            </div>
            <div class="form-group">
                <label for="media_url">URL da Mídia</label>
                <input type="url" name="media_url" class="form-control" value="{{ $socialPost->media_url }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ $socialPost->status === 'draft' ? 'selected' : '' }}>Rascunho</option>
                    <option value="scheduled" {{ $socialPost->status === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                    <option value="published" {{ $socialPost->status === 'published' ? 'selected' : '' }}>Publicado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('communication.social_posts.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection