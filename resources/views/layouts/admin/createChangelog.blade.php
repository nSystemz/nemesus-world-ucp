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
                <div class="card-header">Changelog erstellen</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST" action="{{ route('postChangelog') }}">
                                @csrf
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Inhalt vom Changelog</label>
                                        <textarea id="summernote" name="summernote" class="summernote form-control"
                                            placeholder="<b>[MAPS]</b><br>- Map1<br>- Map2<br><br><br><b>[NEU]</b><br>- Neu1<br>- Neu2<br><br><br><b>[EDITIERT/ANGEPASST/OPTIMIERT]</b><br>- Optimierung 1<br>- Optimierung 2<br><br><br><b>[FEHLER BEHOBEN]</b><br>- Fehler 1<br>- Fehler 2"
                                            value="{!! old('summernote') !!}"
                                            style="width: 100%; height: 200px; max-height: 550px;"
                                            maxlength="1300"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="width:100%;"
                                        type="button">Changelog erstellen</button>
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
    $(".summernote").summernote("code",
        "<b>[MAPS]</b><br>- Map1<br>- Map2<br><br><br><b>[NEU]</b><br>- Neu1<br>- Neu2<br><br><br><b>[EDITIERT/ANGEPASST/OPTIMIERT]</b><br>- Optimierung 1<br>- Optimierung 2<br><br><br><b>[FEHLER BEHOBEN]</b><br>- Fehler 1<br>- Fehler 2"
    );
</script>
@endpush
