@extends('adminlte::page' )

{{--<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>--}}
{{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">--}}
{{--<link rel="stylesheet" href="../dist/css/adminlte.min.css?v=3.2.0">--}}

@section('content')
    @php
        $tokenSession = Illuminate\Support\Facades\Storage::get('token');
    @endphp
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" id="session_token" value="{{ $tokenSession }}" />
    <div class="row">
        <div class="col-md-3">
            <div class="card card-solid">
                <div class="card-header with-border">
                    <h3 class="card-title">Create Event</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                <ul class="fc-color-picker" id="color-chooser">
                                    <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group">
                                <input id="event_name" name="name" type="text" class="form-control" placeholder="Event Title">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" class="form-control" id="from_to" name="daterange" value="05/09/2023 - 05/16/2023" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group-btn">
                                <button type="submit" form="create_form" onclick="createEventApi({{$user->id}})" class="btn btn-default" data-dismiss="modal">Create event</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body no-padding">
                    <div id="calendar"></div>
                </div>

            </div>

        </div>

    </div>
    <div class="modal fade" id="eventModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="eventModalContent">

            </div>

        </div>

    </div>
@endsection
@section('plugins.Fullcalendar', true)
@section('plugins.Daterangepicker', true)
@section('js')

    <script>

        document.addEventListener('DOMContentLoaded', function() {

            var eventsArray = {!! json_encode($jsEvents) !!};
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: function(info, successCallback, failureCallback) {
                successCallback(eventsArray);
            },
            eventClick: function(info) {
                console.log(info.event.id);
                let id = info.event.id;
                const url = '{{ route('admin.show_event') }}';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        id: id
                    },
                    success: function(result) {
                        $('#eventModalContent').html(result);
                        $('#eventModal').modal('show');
                    }
                });
            },
        });
            calendar.render();
        });

        $(function() {
            $('input[name="daterange"]').daterangepicker();
        });

        function createEventApi(user){
            const url = '{{ route('api.event.create') }}';
            let accessToken = $('#session_token').val()
            let name = $('#event_name').val()
            let fromTo = $('#from_to').val()
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: url,
                data: {
                    user_id: user,
                    name: name,
                    from_to: fromTo,
                },
                success: function(response) {
                    alert('Success, event has been created!');
                    location.reload()
                },
                beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer ' + accessToken ); }
            });
        }

    </script>

@stop
