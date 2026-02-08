@extends('adminlte::page')

@section('title', 'Calendário de Eventos')

@section('content_header')
    <h1>Calendário de Eventos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Visualização de Calendário</h3>
        <div class="card-tools">
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-list"></i> Lista de Eventos
            </a>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Evento
            </a>
        </div>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }
    .fc-event {
        cursor: pointer;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/pt-br.global.min.js"></script>
<script>
/* eslint-disable */
// @ts-nocheck
(function() {
    var calendarEl = document.getElementById('calendar');
    var eventsDataEl = document.getElementById('events-data');
    var eventsData = eventsDataEl ? JSON.parse(eventsDataEl.textContent) : [];

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia',
            list: 'Lista'
        },
        events: eventsData,
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            if (info.event.url) {
                window.location.href = info.event.url;
            }
        },
        eventDidMount: function(info) {
            // Add tooltip with event details
            var tooltip = 'Tipo: ' + info.event.extendedProps.eventType;
            if (info.event.extendedProps.venue) {
                tooltip += '\nLocal: ' + info.event.extendedProps.venue;
            }
            tooltip += '\nStatus: ' + info.event.extendedProps.status;

            info.el.setAttribute('title', tooltip);
        },
        height: 'auto',
        navLinks: true,
        editable: false,
        dayMaxEvents: true,
        displayEventTime: true,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        }
    });

    calendar.render();
})();
</script>
<script type="application/json" id="events-data">{!! json_encode($events ?? []) !!}</script>
@stop
