@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard do Sistema de Gestão Eclesiástica</h1>
@endsection

@section('sidebar')
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">GOVERNANÇA E DIREÇÃO</li>
        <li class="nav-item">
            <a href="{{ url('pastoral/councils') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Conselho Pastoral</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>Conselho Administrativo</p>
            </a>
        </li>
        <li class="nav-header">ADMINISTRAÇÃO GERAL</li>
        <li class="nav-item">
            <a href="{{ url('admin/members') }}" class="nav-link">
                <i class="nav-icon fas fa-clipboard"></i>
                <p>Secretaria Geral</p>
            </a>
        </li>
        <li class="nav-header">GESTÃO DE PESSOAS</li>
        <li class="nav-item">
            <a href="{{ url('volunteer/roles') }}" class="nav-link">
                <i class="nav-icon fas fa-handshake"></i>
                <p>Coordenação de Voluntariado</p>
            </a>
        </li>
        <li class="nav-header">GESTÃO DE MEMBROS</li>
        <li class="nav-item">
            <a href="{{ url('admin/members') }}" class="nav-link">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>Integração e Discipulado</p>
            </a>
        </li>
        <li class="nav-header">MINISTÉRIOS</li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-music"></i>
                <p>Louvor e Adoração</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('education/classes') }}" class="nav-link">
                <i class="nav-icon fas fa-child"></i>
                <p>Infantil e Ensino</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('education/students') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Jovens e Adolescentes</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('missions/missionaries') }}" class="nav-link">
                <i class="nav-icon fas fa-globe"></i>
                <p>Missões</p>
            </a>
        </li>
        <li class="nav-header">COMUNICAÇÃO</li>
        <li class="nav-item">
            <a href="{{ url('communication/social_posts') }}" class="nav-link">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>Hub de Comunicação</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('communication/social_posts') }}" class="nav-link">
                <i class="nav-icon fas fa-cross"></i>
                <p>Evangelismo</p>
            </a>
        </li>
        <li class="nav-header">FINANCEIRO</li>
        <li class="nav-item">
            <a href="{{ url('finance/financial_accounts') }}" class="nav-link">
                <i class="nav-icon fas fa-dollar-sign"></i>
                <p>Tesouraria</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('finance/fiscal_council_meetings') }}" class="nav-link">
                <i class="nav-icon fas fa-balance-scale"></i>
                <p>Conselho Fiscal</p>
            </a>
        </li>
        <li class="nav-header">PATRIMÔNIO</li>
        <li class="nav-item">
            <a href="{{ url('patrimony/assets') }}" class="nav-link">
                <i class="nav-icon fas fa-tools"></i>
                <p>Zeladoria e Manutenção</p>
            </a>
        </li>
        <li class="nav-header">AÇÃO SOCIAL</li>
        <li class="nav-item">
            <a href="{{ url('social/assistances') }}" class="nav-link">
                <i class="nav-icon fas fa-heart"></i>
                <p>Assistência Social</p>
            </a>
        </li>
        <li class="nav-header">TECNOLOGIA</li>
        <li class="nav-item">
            <a href="{{ url('logs') }}" class="nav-link">
                <i class="nav-icon fas fa-server"></i>
                <p>Suporte de TI</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('qualidade') }}" class="nav-link">
                <i class="nav-icon fas fa-code"></i>
                <p>Qualidade de Código</p>
            </a>
        </li>
        <li class="nav-header">JURÍDICO</li>
        <li class="nav-item">
            <a href="{{ url('admin/documents') }}" class="nav-link">
                <i class="nav-icon fas fa-gavel"></i>
                <p>Assessoria Jurídica</p>
            </a>
        </li>
        <li class="nav-header">EVENTOS</li>
        <li class="nav-item">
            <a href="{{ url('admin/church_events') }}" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Gestão de Eventos</p>
            </a>
        </li>
        <li class="nav-header">CONTA</li>
        <li class="nav-item">
            <a href="{{ url('account') }}" class="nav-link">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>Conta</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('profile') }}" class="nav-link">
                <i class="nav-icon fas fa-fw fa-user"></i>
                <p>Perfil</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('password/edit') }}" class="nav-link">
                <i class="nav-icon fas fa-fw fa-lock"></i>
                <p>Alterar Senha</p>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>
                    <p>Membros</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ url('admin/members') }}" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53</h3>
                    <p>Eventos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ url('admin/church_events') }}" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>
                    <p>Contribuições</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{ url('finance/transactions') }}" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>
                    <p>Visitantes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ url('admin/members') }}" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Atividades Recentes</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Culto de Domingo realizado</li>
                        <li class="list-group-item">Novo membro batizado</li>
                        <li class="list-group-item">Reunião de Conselho Pastoral</li>
                        <li class="list-group-item">Campanha de Evangelismo lançada</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Próximos Eventos</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Estudo Bíblico - Quinta-feira, 20h</li>
                        <li class="list-group-item">Culto de Celebração - Domingo, 19h</li>
                        <li class="list-group-item">Reunião de Jovens - Sábado, 14h</li>
                        <li class="list-group-item">Batismo - Próximo Domingo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!-- CSS adicional se necessário -->
@endsection

@section('js')
    <!-- JS adicional se necessário -->
@endsection
