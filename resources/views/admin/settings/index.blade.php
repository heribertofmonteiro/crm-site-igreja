@extends('adminlte::page')

@section('title', 'Configurações do Sistema')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Configurações do Sistema</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Configurações</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- General Settings -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cog mr-2"></i>
                        Configurações Gerais
                    </h3>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="system_name">Nome do Sistema</label>
                            <input type="text"
                                   class="form-control @error('system_name') is-invalid @enderror"
                                   id="system_name"
                                   name="system_name"
                                   value="{{ old('system_name', $settings['system_name'] ?? 'Igreja On Line') }}"
                                   placeholder="Digite o nome do sistema">
                            @error('system_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="church_name">Nome da Igreja</label>
                            <input type="text"
                                   class="form-control @error('church_name') is-invalid @enderror"
                                   id="church_name"
                                   name="church_name"
                                   value="{{ old('church_name', $settings['church_name'] ?? '') }}"
                                   placeholder="Digite o nome da igreja">
                            @error('church_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sidebar_text">Texto da Sidebar</label>
                            <input type="text"
                                   class="form-control @error('sidebar_text') is-invalid @enderror"
                                   id="sidebar_text"
                                   name="sidebar_text"
                                   value="{{ old('sidebar_text', $settings['sidebar_text'] ?? 'Igreja On Line') }}"
                                   placeholder="Texto exibido na sidebar">
                            @error('sidebar_text')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact_email">E-mail de Contato</label>
                            <input type="email"
                                   class="form-control @error('contact_email') is-invalid @enderror"
                                   id="contact_email"
                                   name="contact_email"
                                   value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                   placeholder="email@igreja.com.br">
                            @error('contact_email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact_phone">Telefone de Contato</label>
                            <input type="text"
                                   class="form-control @error('contact_phone') is-invalid @enderror"
                                   id="contact_phone"
                                   name="contact_phone"
                                   value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                                   placeholder="(00) 00000-0000">
                            @error('contact_phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Endereço</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      name="address"
                                      rows="3"
                                      placeholder="Endereço da igreja">{{ old('address', $settings['address'] ?? '') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Salvar Configurações
                        </button>
                    </div>
                </form>
            </div>

            <!-- Logo Upload -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-image mr-2"></i>
                        Logo do Sistema
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="position-relative">
                                @if(isset($settings['logo_url']) && $settings['logo_url'])
                                    <img src="{{ $settings['logo_url'] }}"
                                         alt="Logo da Igreja"
                                         class="img-thumbnail"
                                         style="max-width: 100%; max-height: 150px;">
                                @else
                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                         style="height: 150px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ route('admin.settings.upload-logo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')

                                <div class="form-group">
                                    <label for="logo">Enviar Nova Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                   class="custom-file-input @error('logo') is-invalid @enderror"
                                                   id="logo"
                                                   name="logo"
                                                   accept="image/*">
                                            <label class="custom-file-label" for="logo">Escolher arquivo...</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-info">
                                                <i class="fas fa-upload mr-2"></i>
                                                Enviar
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Formatos aceitos: JPEG, PNG, JPG, GIF, SVG, WEBP. Tamanho máximo: 2MB.
                                    </small>
                                    @error('logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </form>

                            @if(isset($settings['logo_path']) && $settings['logo_path'])
                                <form action="{{ route('admin.settings.delete-logo') }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover a logo?')">
                                        <i class="fas fa-trash mr-2"></i>
                                        Remover Logo
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Preview -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>
                        Visualização
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if(isset($settings['logo_url']) && $settings['logo_url'])
                            <img src="{{ $settings['logo_url'] }}"
                                 alt="Logo Preview"
                                 style="max-width: 80%; max-height: 80px;"
                                 class="mb-3">
                        @else
                            <div class="bg-primary rounded d-inline-block px-4 py-2 mb-3">
                                <i class="fas fa-church fa-2x text-white"></i>
                            </div>
                        @endif
                        <h5 class="font-weight-bold">
                            {{ $settings['system_name'] ?? 'Igreja On Line' }}
                        </h5>
                        <small class="text-muted">{{ $settings['church_name'] ?? '' }}</small>
                    </div>

                    <div class="border rounded p-3 bg-light">
                        <small class="text-muted d-block mb-2">Texto da Sidebar:</small>
                        <strong>{{ $settings['sidebar_text'] ?? 'Igreja On Line' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Reset Settings -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-redo mr-2"></i>
                        Restaurar Padrões
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Restaurar todas as configurações para os valores padrão do sistema.
                    </p>
                    <form action="{{ route('admin.settings.reset') }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Tem certeza que deseja restaurar as configurações padrão? Esta ação não pode ser desfeita.')">
                            <i class="fas fa-redo mr-2"></i>
                            Restaurar Padrões
                        </button>
                    </form>
                </div>
            </div>

            <!-- System Info -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informações do Sistema
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-code mr-2 text-muted"></i>
                            <strong>Laravel:</strong> {{ app()->version() }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-server mr-2 text-muted"></i>
                            <strong>PHP:</strong> {{ PHP_VERSION }}
                        </li>
                        <li>
                            <i class="fas fa-database mr-2 text-muted"></i>
                            <strong>驱动:</strong> MySQL
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .card {
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@push('js')
    <script>
        // Update file input label
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });

        // Initialize with select2 if available
        @if(config('adminlte.layout.topnav'))
            $(function() {
                // Add select2 for select elements if needed
            });
        @endif
    </script>
@endpush
