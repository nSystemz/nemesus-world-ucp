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
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Ticket erstellen</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST" action="{{ route('postCreateTicket') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Titel deines Tickets</label>
                                    <input class="form-control title" placeholder="Titel" name="title" id="title"
                                        type="text">
                                </div>
                                <div class="form-group">
                                    <label>Priorität</label>
                                    <div class="input-group input-group">
                                        <select class="custom-select" name="prio" id="prio">
                                            <option value="low">Niedrig</option>
                                            <option value="middle">Mittel</option>
                                            <option value="high">Hoch</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Beschreibung</label>
                                        <textarea id="summernote" name="summernote" class="summernote form-control"
                                            placeholder="Inhalt deines Tickets" value="{!! old('summernote') !!}"
                                            style="width: 100%; height: 200px; max-height: 550px;"
                                            maxlength="1300"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="width:100%;"
                                        type="button">Ticket
                                        erstellen</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
    $('.summernote').summernote({
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
    var imageUploadDiv = $('div.note-group-select-from-files');
    if (imageUploadDiv.length) {
        imageUploadDiv.remove();
    }
</script>
@endpush
