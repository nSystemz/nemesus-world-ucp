@php
use App\Http\Controllers\FunctionsController as FunctionsController;
setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
@endphp
@extends('layouts.master')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('adminlte/plugins/summernote/summernote-bs4.min.css')}}">
    @if (Auth::user()->theme == 'dark')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/summernote/custom.css')}}">
    @endif
</head>
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="card card-primary card-outline">
                <div class="card-header">Ticket: {{$ticket->title}} ({{$ticket->id}}) | Ersteller:
                    {{FunctionsController::getUserNameTicket($ticket->userid)}}</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                @if (FunctionsController::getUserNameTicket($ticket->admin) != "Warte auf Bearbeitung")
                                <span
                                    class="badge bg-primary float-right">{{FunctionsController::getTicketStatus($ticket->status)}}
                                    | Bearbeiter: {{FunctionsController::getUserNameTicket($ticket->admin)}}</span>
                                @else
                                <span
                                    class="badge bg-primary float-right">{{FunctionsController::getTicketStatus($ticket->status)}}</span>
                                @endif
                            </div>
                            <div class="card card-primary card-outline mt-4">
                                <div class="card-header">
                                    <span
                                        class="float-left">{{FunctionsController::getUserNameTicket($ticket->userid)}}</span>
                                    <span
                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$ticket->timestamp)}}</span>
                                </div>
                                <div class="card-body" style="margin-top: 0.425vw">
                                    {!! $ticket->text !!}
                                </div>
                            </div>
                            @foreach ($answers as $data)
                            <div class="card-body">
                                @if(FunctionsController::getAdminStatus($data->userid))
                                <div class="card card-warning card-outline">
                                    @else
                                    <div class="card card-info card-outline">
                                        @endif
                                        <div class="card-header">
                                            <span
                                                class="float-left">{{FunctionsController::getUserNameTicket($data->userid)}}</span>
                                            <span
                                                class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$data->timestamp)}}</span>
                                        </div>
                                        <div class="card-body" style="margin-top: 0.1vw">
                                            {!! $data->text !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if ($ticket->status != 9)
                        <hr />
                        <div class="card card-success card-outline mt-4">
                            <div class="card-header">
                                Antworten
                            </div>
                            <div class="card-body">
                                @if ($ticket->userid == Auth::user()->id && $ticket->status <= 1) <form
                                    class="form-horizontal" method="POST" action="{{ route('ticketFinish') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" value={{$ticket->id}} id="id" name="id"
                                        maxlength="35" autocomplete="off">
                                    <button type="submit" class="btn btn-block btn-success btn-sm mb-3">Ticket als
                                        'erledigt' markieren</button>
                                    </form>
                                    @endif
                                    <div class="col-md-12">
                                        @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin &&
                                        Auth::user()->adminlevel >= $adminlevel &&
                                        session('nemesusworlducp_adminlogin'))
                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('changeTicketStatus') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <input type="hidden" class="form-control" value={{$ticket->id}} id="id"
                                                    name="id" maxlength="35" autocomplete="off">
                                                <div class="input-group input-group">
                                                    <select class="custom-select" name="status" id="status">
                                                        <option value="1">In Bearbeitung</option>
                                                        <option value="2">Geschlossen</option>
                                                        <option value="9">Archiviert</option>
                                                    </select>
                                                    <span class="input-group-append">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-flat ml-2">Ändern</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                        @if($ticket->status <= 1) <form class="form-horizontal" method="POST"
                                            action="{{ route('addUserToTicket') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="input-group input-group">
                                                    <input type="hidden" class="form-control" value={{$ticket->id}}
                                                        id="id" name="id" maxlength="35" autocomplete="off">
                                                    <input type="text" class="form-control"
                                                        placeholder="Spieler hinzufügen" id="name" name="name"
                                                        maxlength="35" autocomplete="off">
                                                    <span class="input-group-append">
                                                        <button type="submit"
                                                            class="btn btn-primary ml-2">Hinzufügen</button>
                                                    </span>
                                                </div>
                                            </div>
                                            </form>
                                            @endif
                                            @if($ticket->status <= 1) <form class="form-horizontal" method="POST"
                                                action="{{ route('editTicket') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="input-group input-group">
                                                        <input type="hidden" class="form-control" value={{$ticket->id}}
                                                            id="id" name="id" maxlength="35" autocomplete="off">
                                                        <input type="text" class="form-control"
                                                            placeholder="Bearbeiter setzen" id="name" name="name"
                                                            maxlength="35" autocomplete="off">
                                                        <span class="input-group-append">
                                                            <button type="submit"
                                                                class="btn btn-primary ml-2">Setzen</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                </form>
                                                @endif
                                                @endif
                                    </div>
                                    @if($ticket->status == 1) <form class="form-horizontal" method="POST"
                                        action="{{ route('answerTicket') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" value={{$ticket->id}} id="id"
                                                name="id" maxlength="35" autocomplete="off">
                                            <textarea id="answer" name="answer" class="answer form-control"
                                                placeholder="Deine Antwort"
                                                style="width: 100%; height: 200px; max-height: 550px;" maxlength="1300"
                                                value="{!! old('answer') !!}"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="width:100%;"
                                            type="button">Antworten</button>
                                    </form>
                                    @elseif($ticket->status == 2)
                                    <div class="text-center mt-1">
                                        <h3>Das Ticket befindet sich nicht(mehr) in Bearbeitung!</h3>
                                    </div>
                                    @elseif($ticket->status == 9)
                                    <h3 class="text-center">Auf dieses Ticket kann nichtmehr geantwortet
                                        werden!</h3>
                                    @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('scripts')
    <script src="{{asset('adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/summernote/lang/summernote-de-DE.min.js')}}"></script>
    <script>
        // eslint-disable-next-line no-undef
        $('.answer').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'subscript', 'superscript', 'clear']],
                ['para', ['ol', 'ul', 'paragraph']],
                ['color', ['color']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['view', ['codeview', 'help']]
            ],
            height: 450,
            width: "100%",
            minHeight: null,
            maxHeight: null,
            dialogsInBody: true,
            lang: "de-DE",
            disableResizeEditor: false
        }).summernote('lineHeight', 0.5);
        jQuery('.note-video-clip').each(function () {
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html(
                '<div class="embed-responsive embed-responsive-16by9" style="max-width: 600px">' + tmp +
                '</div>');
        });
        $(document).ready(function () {
            $("img").addClass("img-fluid");
        });
        var imageUploadDiv = $('div.note-group-select-from-files');
        if (imageUploadDiv.length) {
            imageUploadDiv.remove();
        }
    </script>
    @endpush
