@extends('adminlte::page')

@section('title', 'Detalhes do Post Social')

@section('content_header')
    <h1>Detalhes do Post Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Post Social #{{ $socialPost->id }}</h3>
        <div class="card-tools">
            @can('social_posts.edit')
            <a href="{{ route('communication.social_posts.edit', $socialPost) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            <a href="{{ route('communication.social_posts.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Conteúdo</dt>
            <dd class="col-sm-9">{{ $socialPost->content }}</dd>

            <dt class="col-sm-3">Plataforma</dt>
            <dd class="col-sm-9">{{ ucfirst($socialPost->platform) }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $socialPost->status === 'published' ? 'success' : ($socialPost->status === 'scheduled' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($socialPost->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Agendado para</dt>
            <dd class="col-sm-9">{{ $socialPost->scheduled_at ? $socialPost->scheduled_at->format('d/m/Y H:i') : '-' }}</dd>

            <dt class="col-sm-3">Publicado em</dt>
            <dd class="col-sm-9">{{ $socialPost->published_at ? $socialPost->published_at->format('d/m/Y H:i') : '-' }}</dd>

            <dt class="col-sm-3">URL da Mídia</dt>
            <dd class="col-sm-9">{{ $socialPost->media_url ? '<a href="' . $socialPost->media_url . '" target="_blank">' . $socialPost->media_url . '</a>' : '-' }}</dd>

            <dt class="col-sm-3">Criado por</dt>
            <dd class="col-sm-9">{{ $socialPost->user->name }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $socialPost->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $socialPost->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@endsection