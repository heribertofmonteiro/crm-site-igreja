@extends('adminlte::page')

@section('title', 'Posts Sociais')

@section('content_header')
    <h1>Posts Sociais</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Posts Sociais</h3>
        @can('social_posts.create')
        <div class="card-tools">
            <a href="{{ route('communication.social_posts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Post
            </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Conteúdo</th>
                    <th>Plataforma</th>
                    <th>Status</th>
                    <th>Agendado para</th>
                    <th>Criado por</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($socialPosts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ Str::limit($post->content, 50) }}</td>
                    <td>{{ ucfirst($post->platform) }}</td>
                    <td>
                        <span class="badge badge-{{ $post->status === 'published' ? 'success' : ($post->status === 'scheduled' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </td>
                    <td>{{ $post->scheduled_at ? $post->scheduled_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    <td>
                        @can('social_posts.view')
                        <a href="{{ route('communication.social_posts.show', $post) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('social_posts.edit')
                        <a href="{{ route('communication.social_posts.edit', $post) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('social_posts.delete')
                        <form action="{{ route('communication.social_posts.destroy', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $socialPosts->links() }}
    </div>
</div>
@endsection