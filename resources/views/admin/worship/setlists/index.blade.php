@extends('adminlte::page')

@section('title', 'Setlists')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Setlists</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Setlists</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Setlists</h3>
        <div class="card-tools">
            <a href="{{ route('admin.worship.setlists.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Setlist
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filtros -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="year" class="form-control">
                        <option value="">Todos Anos</option>
                        @for($i = date('Y'); $i >= date('Y')-5; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="month" class="form-control">
                        <option value="">Todos Meses</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i> Filtrar</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tema</th>
                        <th>Evento</th>
                        <th>Músicas</th>
                        <th>Criado por</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($setlists as $setlist)
                        <tr>
                            <td>{{ $setlist->date->format('d/m/Y') }}</td>
                            <td>{{ $setlist->theme ?? '--' }}</td>
                            <td>{{ $setlist->event?->title ?? '--' }}</td>
                            <td><span class="badge badge-info">{{ $setlist->song_count }}</span></td>
                            <td>{{ $setlist->creator?->name ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.worship.setlists.show', $setlist) }}" class="btn btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.worship.setlists.duplicate', $setlist) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-default" title="Duplicar">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.worship.setlists.edit', $setlist) }}" class="btn btn-warning" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma setlist encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $setlists->links() }}
    </div>
</div>
@stop
