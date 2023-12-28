@php
use App\Http\Controllers\HomeController as HomeController;
setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
@endphp
@extends('layouts.master')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
</head>
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Inaktiv melden</div>
                <div class="card-body">
                    <div style="display: flex; justify-content: center; align-items: center;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.col -->
                            <div class="col-md-12">
                                @include("layouts.template-parts.alert")
                                <div class="card card-primary card-outline">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                <img src="/images/urlaub.png" class="mt-2" width="90%"
                                                    style="max-width: 100px;max-height: 95px" />
                                            </div>
                                            @if(count($inaktiv) == 0)
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                <h6 class="mt-3 text-center">Info: Hier kannst du dich inaktiv melden
                                                    damit du keine
                                                    begrenzten Ressourcen ingame wie z.B Häuser verlierst, wenn du
                                                    keinen Grund angeben möchtest kannst du auch <strong>Privat</strong>
                                                    reinschreiben.</h6>
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                <h6 class="mt-3 text-center">Andere Spieler können deine
                                                    Inaktiviätsmeldung
                                                    einsehen, sofern dein UCP Profil auf <strong>öffentlich</strong>
                                                    steht, beim Gameserver Login, wird die Inaktivitätsmeldung
                                                    automatisch gelöscht!</h6>
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('setInaktiv') }}">
                                                    @csrf
                                                    <label class="mt-4">Grund</label>
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                <input class="form-control text-center" placeholder="z.B Urlaub"
                                                    type="text" name="grund" id="grund" maxlength="35"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <label class="mt-2">Zeitraum</label><br />
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control text-center" name="daterange" type="text"
                                                    maxlength="23" id="daterange" autocomplete="off">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-block btn-primary mb-2 mt-3">Inaktiv
                                            melden</button>
                                        </form>
                                        @else
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <h6 class="mt-3">Info: Du bist noch vom <strong
                                                    style="color:green">{{strftime( '%d %b. %Y',$data->date1)}}</strong>
                                                bis zum
                                                <strong
                                                    style="color:green">{{strftime( '%d %b. %Y',$data->date2)}}</strong>
                                                als
                                                inaktiv gemeldet, benutze den Button unten um deine Inaktivitätsmeldung
                                                aufzuheben!
                                            </h6>
                                        </div>
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('unsetInaktiv') }}">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-block btn-primary mb-2 mt-3">Inaktivitätsmeldung
                                                aufheben</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script>
var date1 = moment();
var date2 = moment().add('days', 14);
$('input[name="daterange"]').daterangepicker({
    startDate: moment(),
    endDate: moment().add('days', 14),
    minDate: moment(),
    maxDate: moment().add('months', 6),
    showDropdowns: true,
    showWeekNumbers: true,
    timePicker: false,
    timePickerIncrement: 1,
    timePicker12Hour: false,
    ranges: {
        'Heute': [moment(), moment()],
        'Gestern': [moment().subtract('days', 1), moment().subtract('days', 1)],
        'Letzten 7 Tage': [moment().subtract('days', 6), moment()],
        'Letzten 30 Tage': [moment().subtract('days', 29), moment()],
        'Dieser Monat': [moment().startOf('month'), moment().endOf('month')],
        'Letzter Monat': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1)
        .endOf('month')]
        },
        opens: 'left',
        format: 'DD.MM.YYYY',
        separator: ' to ',
        locale: {
        format: 'DD.MM.YYYY',
        applyLabel: 'Bestätigen',
        cancelLabel: 'Abbrechen',
        fromLabel: 'Von',
        toLabel: 'Bis',
        customRangeLabel: 'Benutzerdefiniert',
        daysOfWeek: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September','Oktober', 'November', 'Dezember'],
        firstDay: 1
        },
    },
    function (start, end) {
        date1 = start;
        date2 = end;
        console.log(start.format('DD.MM.YYYY'));
    }
);
function postInactiv() {
    window.location.href = "{{URL::to('setInactiv')}}" + "/" + date1 + "/" + date2;
}
</script>
@endpush
