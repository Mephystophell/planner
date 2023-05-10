<style>
    .col-6{
        padding-top: 15px;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title">{{ $event->name }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
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
                <input id="event_upd_name" name="name" type="text" value="{{ $event->name }}" class="form-control" placeholder="Event Title">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group">
                <input type="text" class="form-control"  id="from_to_upd" name="daterange_modal"
                       value="{{ \Carbon\Carbon::parse($event->start_date)->format('m/d/y') }} - {{ \Carbon\Carbon::parse($event->ebd_date)->format('m/d/y') }}"
                />
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" onclick="deleteEventApi({{$event->id}})" class="btn btn-default" data-dismiss="modal">Delete event</button>
    <button type="button" onclick="updateEventApi({{$event->id}})" class="btn btn-default" data-dismiss="modal">Update event</button>
</div>

@section('plugins.Daterangepicker', true)
<script>

    $(function() {
        $('input[name="daterange_modal"]').daterangepicker();
    });

    function updateEventApi(id) {
        const url = '{{ route('api.event.update') }}';
        let accessToken = $('#session_token').val()
        let name = $('#event_upd_name').val()
        let fromTo = $('#from_to_upd').val()
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: url,
            data: {
                id: id,
                name: name,
                from_to: fromTo
            },
            success: function (response) {
                alert('Success, event has been updated!');
                location.reload()
            },
            beforeSend: function (xhr, settings) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + accessToken);
            }
        });
    }

    function deleteEventApi(id) {
        const url = '{{ route('api.event.delete') }}';
        let accessToken = $('#session_token').val()
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: url,
            data: {
                id: id
            },
            success: function (response) {
                alert('Success, event has been deleted!');
                location.reload()
            },
            beforeSend: function (xhr, settings) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + accessToken);
            }
        });
    }

</script>
