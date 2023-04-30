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
                <div class="card-header">Adminlogs (die letzten 150 Einträge)</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            <label>Logauswahl:</label>
                            <form class="form-horizontal" method="POST" action="{{ route('searchAdminLogs') }}">
                                @csrf
                                <select class="custom-select" id="log" name="log">
                                    @foreach($alllogs as $data )
                                    @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel >=
                                    FunctionsController::getAdminLogRang($data->loglabel))
                                    <option value="{{$data->loglabel}}">
                                        {{FunctionsController::getAdminLogName($data->loglabel)}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="btn btn-primary btn-sm float-right mt-2 mb-2">Laden</button>
                            </form>
                            @if($logs != null)
                            <div class="input-group mb-3 mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" onkeyup="searchLog()" id="searchtext"
                                    name="searchtext" placeholder="Suche" maxlength="55">
                            </div>
                            <div class="card card-primary card-outline">
                                <div class="col-md-12">
                            <div class="table-responsive-md mt-2">
                                <label>Aktueller Log: {{$logname}}</label>
                                <table id="logtable" class="table table-bordered" style="width:100%">
                                    <thead class="table-primary">
                                        <tr id="tablehead" class="tablehead">
                                            <th>Eintrag</th>
                                            @if($checkip == 1 && Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                                            <th>IP</th>
                                            @endif
                                            @if($miscellaneous == 1 && Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                                            <th>Sonstiges</th>
                                            @endif
                                            <th>Datum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $data )
                                        <tr>
                                            <td>{{$data->text}}</td>
                                            @if($checkip == 1 && Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                                            <td>{{$data->ip}}</td>
                                            @endif
                                            @if($miscellaneous == 1 && Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                                            <td>{{$data->miscellaneous}}</td>
                                            @endif
                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->timestamp)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                                </div>
                            </div>
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
function searchLog()
{
    const trs = document.querySelectorAll('#logtable tr:not(.tablehead)');
    const filter = document.querySelector('#searchtext').value;
    const regex = new RegExp(filter, 'i');
    const isFoundInTds = (td) => regex.test(td.innerHTML);
    const isFound = (childrenArr) => childrenArr.some(isFoundInTds);
    const setTrStyleDisplay = ({ style, children }) => {
    style.display = isFound([...children]) ? '' : 'none';
  };
  trs.forEach(setTrStyleDisplay);
}
</script>
@endpush
