@extends('adminlte::page')

@section('title', 'Detalhes do Missionário')

@section('content_header')
    <h1>Detalhes do Missionário</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $missionary->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('missions.missionaries.edit', $missionary) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('missions.missionaries.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $missionary->name }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $missionary->email }}</dd>

            <dt class="col-sm-3">Telefone</dt>
            <dd class="col-sm-9">{{ $missionary->phone ?: 'N/A' }}</dd>

            <dt class="col-sm-3">País</dt>
            <dd class="col-sm-9">{{ $missionary->country }}</dd>

            <dt class="col-sm-3">Região</dt>
            <dd class="col-sm-9">{{ $missionary->region ?: 'N/A' }}</dd>

            <dt class="col-sm-3">Data de Início</dt>
            <dd class="col-sm-9">{{ $missionary->start_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Data de Fim</dt>
            <dd class="col-sm-9">{{ $missionary->end_date ? $missionary->end_date->format('d/m/Y') : 'N/A' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $missionary->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($missionary->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Biografia</dt>
            <dd class="col-sm-9">{{ $missionary->bio ?: 'N/A' }}</dd>
        </dl>
    </div>
</div>

@if($missionary->projects->count() > 0)
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Projetos Missionários</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Localização</th>
                    <th>Status</th>
                    <th>Data Início</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missionary->projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->location }}</td>
                    <td>
                        <span class="badge badge-{{ $project->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td>{{ $project->start_date->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('missions.projects.show', $project) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if($missionary->supports->count() > 0)
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Apoiadores</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Apoiador</th>
                    <th>Valor</th>
                    <th>Frequência</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missionary->supports as $support)
                <tr>
                    <td>{{ $support->supporter->name }}</td>
                    <td>R$ {{ number_format($support->amount, 2, ',', '.') }}</td>
                    <td>{{ ucfirst($support->frequency) }}</td>
                    <td>
                        <span class="badge badge-{{ $support->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($support->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('missions.supports.show', $support) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@stop