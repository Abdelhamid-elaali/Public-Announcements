@extends('layouts.app')

@section('title', 'Event Calendar')

@section('styles')
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<style>
    .calendar-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    .fc {
        background: #fff;
    }
    .fc-toolbar {
        padding: 10px;
    }
    .fc-toolbar h2 {
        font-size: 1.4rem;
        margin: 0;
    }
    .fc-toolbar button {
        background: #25cffe !important;
        border-color: #25cffe !important;
        box-shadow: none !important;
        padding: 5px 10px;
        height: auto;
        font-size: 0.9rem;
    }
    .fc-toolbar button:hover {
        background: #1bb8e7 !important;
        border-color: #1bb8e7 !important;
    }
    .fc-day-header {
        padding: 8px 0 !important;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .fc-day-number {
        padding: 5px !important;
        font-size: 0.9rem;
    }
    .fc-event {
        padding: 2px 4px;
        font-size: 0.85rem;
    }
    .fc-time {
        font-size: 0.8rem;
    }
    .fc-title {
        font-size: 0.85rem;
    }
        --fc-button-active-bg-color: #1bb8e7;
        --fc-button-active-border-color: #1bb8e7;
    }
    .calendar-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    .fc-event {
        cursor: pointer;
        margin: 2px 0;
    }
    .fc-daygrid-event {
        border-radius: 4px;
    }
    .fc-header-toolbar {
        margin-bottom: 1.5em !important;
    }
    .fc-toolbar-title {
        font-size: 1.5em !important;
        color: #333;
    }
    .fc-day-today {
        background-color: rgba(37, 207, 254, 0.1) !important;
    }
</style>
@endsection

@section('content')
<div class="container py-3">
    <div class="calendar-container">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                <h5 class="mb-0 fs-6">Event Calendar</h5>
            </div>
            <div class="card-body p-2">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        events: {!! json_encode($events) !!},
        timeFormat: 'H:mm',
        height: 550,
        firstDay: 0,
        navLinks: true,
        editable: false,
        eventLimit: true,
        minTime: '08:00:00',
        maxTime: '20:00:00',
        nowIndicator: true,
        eventClick: function(event) {
            if (event.url) {
                window.location.href = event.url;
                return false;
            }
        },
        eventDidMount: function(info) {
            info.el.setAttribute('title', info.event.title);
        },
        views: {
            dayGridMonth: {
                titleFormat: { year: 'numeric', month: 'long' }
            },
            timeGridWeek: {
                titleFormat: { year: 'numeric', month: 'long', day: 'numeric' }
            },
            listWeek: {
                titleFormat: { year: 'numeric', month: 'long', day: 'numeric' }
            }
        }
    });
    calendar.render();
});
</script>
@endsection
