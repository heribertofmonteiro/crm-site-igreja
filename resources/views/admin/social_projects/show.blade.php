@extends('adminlte::page')

@section('title', 'Detalhes do Projeto Social')

@section('content_header')
    <h1>Detalhes do Projeto Social</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $social->name }}</h3>
        <div class="card-tools">
            <a href="{{ route('social.edit', $social) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('social.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $social->name }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $social->description ?: 'Não informado' }}</dd>

            <dt class="col-sm-3">Data de Início</dt>
            <dd class="col-sm-9">{{ $social->start_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Data de Fim</dt>
            <dd class="col-sm-9">{{ $social->end_date ? $social->end_date->format('d/m/Y') : 'Não definido' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge badge-{{ $social->status === 'active' ? 'success' : ($social->status === 'completed' ? 'primary' : 'secondary') }}">
                    {{ ucfirst($social->status) }}
                </span>
            </dd>

            <dt class="col-sm-3">Orçamento</dt>
            <dd class="col-sm-9">{{ $social->budget ? 'R$ ' . number_format($social->budget, 2, ',', '.') : 'Não definido' }}</dd>

            <dt class="col-sm-3">Criado em</dt>
            <dd class="col-sm-9">{{ $social->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Atualizado em</dt>
            <dd class="col-sm-9">{{ $social->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Assistências Sociais</h3>
    </div>
    <div class="card-body">
        @if($social->assistances->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Beneficiário</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($social->assistances as $assistance)
                <tr>
                    <td>{{ $assistance->beneficiary_name }}</td>
                    <td>{{ ucfirst($assistance->assistance_type) }}</td>
                    <td>{{ $assistance->date_provided->format('d/m/Y') }}</td>
                    <td>{{ $assistance->amount ? 'R$ ' . number_format($assistance->amount, 2, ',', '.') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Nenhuma assistência registrada.</p>
        @endif
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Voluntários</h3>
    </div>
    <div class="card-body">
        @if($social->volunteers->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Função</th>
                    <th>Data de Entrada</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($social->volunteers as $volunteer)
                <tr>
                    <td>{{ $volunteer->user->name }}</td>
                    <td>{{ $volunteer->role }}</td>
                    <td>{{ $volunteer->joined_at->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($volunteer->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Nenhum voluntário registrado.</p>
        @endif
    </div>
</div>
@stop