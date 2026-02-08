@extends('adminlte::page')

@section('title', 'Novo Evento')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Novo Evento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Eventos</a></li>
                    <li class="breadcrumb-item active">Novo</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações do Evento</h3>
                    </div>
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="title">Título do Evento <span class="text-danger">*</span></label>
                                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                                               value="{{ old('title') }}" required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="event_type_id">Tipo de Evento <span class="text-danger">*</span></label>
                                        <select id="event_type_id" name="event_type_id" class="form-control @error('event_type_id') is-invalid @enderror" required>
                                            <option value="">Selecione...</option>
                                            @foreach($eventTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('event_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('event_type_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_id">Local</label>
                                        <select id="venue_id" name="venue_id" class="form-control @error('venue_id') is-invalid @enderror">
                                            <option value="">Selecione...</option>
                                            @foreach($venues as $venue)
                                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                                    {{ $venue->name }} ({{ $venue->formatted_capacity }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('venue_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Imagem do Evento</label>
                                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" 
                                               accept="image/*">
                                        <small class="form-text text-muted">Formatos: JPEG, PNG, JPG, GIF (máx. 2MB)</small>
                                        @error('image')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_time">Data/Hora Início <span class="text-danger">*</span></label>
                                        <input type="datetime-local" id="start_time" name="start_time" 
                                               class="form-control @error('start_time') is-invalid @enderror" required>
                                        @error('start_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_time">Data/Hora Fim <span class="text-danger">*</span></label>
                                        <input type="datetime-local" id="end_time" name="end_time" 
                                               class="form-control @error('end_time') is-invalid @enderror" required>
                                        @error('end_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch mt-4">
                                            <input type="checkbox" id="is_all_day" name="is_all_day" 
                                                   class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="is_all_day">
                                                Evento dia todo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ticket_price">Preço do Ingresso</label>
                                        <input type="number" id="ticket_price" name="ticket_price" 
                                               class="form-control @error('ticket_price') is-invalid @enderror" 
                                               step="0.01" min="0" placeholder="0.00">
                                        <small class="form-text text-muted">Deixe em branco para gratuito</small>
                                        @error('ticket_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="max_participants">Máximo de Participantes</label>
                                        <input type="number" id="max_participants" name="max_participants" 
                                               class="form-control @error('max_participants') is-invalid @enderror" 
                                               min="1">
                                        <small class="form-text text-muted">Deixe em branco para ilimitado</small>
                                        @error('max_participants')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="registration_deadline">Prazo de Inscrição</label>
                                        <input type="datetime-local" id="registration_deadline" name="registration_deadline" 
                                               class="form-control @error('registration_deadline') is-invalid @enderror">
                                        @error('registration_deadline')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" id="is_public" name="is_public" 
                                                   class="custom-control-input" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_public">
                                                Evento público
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" id="requires_registration" name="requires_registration" 
                                                   class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="requires_registration">
                                                Requer inscrição
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações de Contato</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="contact_info_phone">Telefone</label>
                            <input type="text" id="contact_info_phone" name="contact_info[phone]" 
                                   class="form-control" placeholder="(00) 00000-0000">
                        </div>
                        <div class="form-group">
                            <label for="contact_info_email">E-mail</label>
                            <input type="email" id="contact_info_email" name="contact_info[email]" 
                                   class="form-control" placeholder="contato@exemplo.com">
                        </div>
                        <div class="form-group">
                            <label for="contact_info_website">Website</label>
                            <input type="url" id="contact_info_website" name="contact_info[website]" 
                                   class="form-control" placeholder="https://exemplo.com">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dicas de Preenchimento</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-info-circle text-primary"></i>
                                <small>Eventos públicos aparecem no calendário geral</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-users text-success"></i>
                                <small>Defina limite máximo para controlar vagas</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-clock text-warning"></i>
                                <small>Prazo de inscrição limita o período de cadastro</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-ticket-alt text-info"></i>
                                <small>Preço 0 significa evento gratuito</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isAllDayCheckbox = document.getElementById('is_all_day');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const requiresRegistrationCheckbox = document.getElementById('requires_registration');
    const maxParticipantsInput = document.getElementById('max_participants');
    const registrationDeadlineInput = document.getElementById('registration_deadline');

    // Toggle time inputs for all-day events
    isAllDayCheckbox.addEventListener('change', function() {
        if (this.checked) {
            startTimeInput.type = 'date';
            endTimeInput.type = 'date';
            startTimeInput.required = false;
            endTimeInput.required = false;
        } else {
            startTimeInput.type = 'datetime-local';
            endTimeInput.type = 'datetime-local';
            startTimeInput.required = true;
            endTimeInput.required = true;
        }
    });

    // Toggle registration fields
    requiresRegistrationCheckbox.addEventListener('change', function() {
        if (this.checked) {
            maxParticipantsInput.disabled = false;
            registrationDeadlineInput.disabled = false;
        } else {
            maxParticipantsInput.disabled = true;
            registrationDeadlineInput.disabled = true;
        }
    });

    // Initialize state
    requiresRegistrationCheckbox.dispatchEvent(new Event('change'));
});
</script>
@endpush
