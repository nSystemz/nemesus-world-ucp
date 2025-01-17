@php
use App\Http\Controllers\FunctionsController as FunctionsController;
@endphp
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Admineinstellungen</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST" action="{{ route('adminAccountSearchUser') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName">Nach einem Accountnamen/Account-ID suchen</label>
                                    <div class="input-group input-group">
                                        <input type="text" class="form-control" placeholder="Accountname/Account-ID"
                                            id="search" name="search" maxlength="35" autocomplete="off">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-flat ml-2">Suchen</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            @if (Auth::user()->adminlevel > FunctionsController::Moderator)
                            <form class="form-horizontal" method="POST"
                                action="{{ route('adminAccountSearchUserOld') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName">Nach einem alten Account/Charakternamen in den Namechanges
                                        suchen</label>
                                    <div class="input-group input-group">
                                        <input type="text" class="form-control" placeholder="Account/Charaktername"
                                            id="search" name="search" maxlength="35" autocomplete="off">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-flat ml-2">Suchen</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            @endif
                            @if (Auth::user()->adminlevel > FunctionsController::High_Administrator)
                            <form class="form-horizontal" method="POST" action="{{ route('adminChangePassword') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName">Neues Adminpasswort (Der Gameserver muss offline sein!)</label>
                                    <div class="input-group input-group">
                                        <input type="password" class="form-control" placeholder="Neues Adminpasswort"
                                            id="password" name="password" maxlength="35" autocomplete="off">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-flat ml-2">Ändern</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            @endif
                            @if (Auth::user()->adminlevel > FunctionsController::Administrator)
                            <form class="form-horizontal" method="POST" action="{{ route('adminGetPayday') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName">Nach Payday suchen</label>
                                    <div class="input-group input-group">
                                        <input type="text" class="form-control" placeholder="Payday ID"
                                            id="payday" name="payday" maxlength="11" autocomplete="off">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-flat ml-2">Suchen</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function searchLog() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchtext");
    filter = input.value.toUpperCase();
    table = document.getElementById("logtable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
@endpush
