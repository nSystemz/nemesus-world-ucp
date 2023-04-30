@php
use App\Http\Controllers\FunctionsController as FunctionsController;
setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
@endphp
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Fraktionen</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            @if (count($factions))
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" onkeyup="searchLog()" id="searchtext"
                                    name="searchtext" placeholder="Suche" maxlength="55">
                            </div>
                            @endif
                            <div class="card card-primary card-outline">
                                <div class="col-md-12">
                                    @if (count($factions))
                                    <div class="table-responsive-md mt-2">
                                        <table id="logtable" class="table table-bordered" style="width:100%">
                                            <thead class="table-primary">
                                                <tr id="tablehead" class="tablehead">
                                                    <th>Name</th>
                                                    <th>Kürzel</th>
                                                    <th>Mitglieder</th>
                                                    <th>Gründung</th>
                                                    <th>Verwaltung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($factions as $data )
                                                <tr>
                                                    <td><a style="color:rgba(255, 255, 255, 0.685)" href="/adminFactions/{{$data->id}}">{{$data->name}}</a></td>
                                                    <td>{{$data->tag}}</td>
                                                    <td>{{FunctionsController::getFactionMembers($data->id)}}</td>
                                                    <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->created)}}</td>
                                                    <td>
                                                        <a data-toggle="modal" data-book-id="{{$data->id}}"
                                                            data-target=".name-modal-lg" style="cursor:pointer">Fraktionsname anpassen</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center mt-1">
                                        <h3>Keine Fraktionen gefunden!</h3>
                                    </div>
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
<div class="modal fade name-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fraktionsnamen anpassen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="{{ route('adminFactionName') }}">
                            @csrf
                            <label for="inputName">Neuer Fraktionsname</label>
                            <div class="input-group input-group">
                                <input type="hidden" name="bookId" name="bookId" autocomplete="off">
                                <input type="text" class="form-control" placeholder="Fraktionsname" id="name" name="name"
                                    maxlength="128" autocomplete="off">
                                <input type="text" class="form-control ml-2" placeholder="Kürzel ohne Klammern" id="tag"
                                    name="tag" maxlength="10" autocomplete="off">
                                <button type="submit" class="btn btn-primary btn-flat ml-2">Weiter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function searchLog() {
    const trs = document.querySelectorAll('#logtable tr:not(.tablehead)');
    const filter = document.querySelector('#searchtext').value;
    const regex = new RegExp(filter, 'i');
    const isFoundInTds = (td) => regex.test(td.innerHTML);
    const isFound = (childrenArr) => childrenArr.some(isFoundInTds);
    const setTrStyleDisplay = ({
        style,
        children
    }) => {
        style.display = isFound([...children]) ? '' : 'none';
    };
    trs.forEach(setTrStyleDisplay);
}
$('.name-modal-lg').on('show.bs.modal', function (e) {
    var bookId = $(e.relatedTarget).data('book-id');
    $(e.currentTarget).find('input[name="bookId"]').val(bookId);
});
</script>
@endpush
