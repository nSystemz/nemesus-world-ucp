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
                <div class="card-header">Ticketarchiv (Die letzten 50 Tickets)</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            @if (count($mytickets))
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
                                    @if (count($mytickets))
                                    <div class="table-responsive-md mt-2">
                                        <table id="logtable" class="table table-bordered" style="width:100%">
                                            <thead class="table-primary">
                                                <tr id="tablehead" class="tablehead">
                                                    <th>ID</th>
                                                    <th>Titel</th>
                                                    <th>Ersteller</th>
                                                    <th>Bearbeiter</th>
                                                    <th>Status</th>
                                                    <th>Erstellungsdatum</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mytickets as $data )
                                                <tr>
                                                    <td>{{$data->id}}</td>
                                                    @if($data->prio == 'low')
                                                    <td><a href="/showTicket/{{$data->id}}" style="color:rgba(255, 255, 255, 0.685)">{{$data->title}}</a></td>
                                                    @elseif ($data->prio == 'middle')
                                                    <td><a href="/showTicket/{{$data->id}}" style="color:rgba(255, 255, 255, 0.685)">{{$data->title}}</a></td>
                                                    @else
                                                    <td><a href="/showTicket/{{$data->id}}" style="color:rgba(255, 255, 255, 0.685)">{{$data->title}}</a></td>
                                                    @endif
                                                    <td>{{FunctionsController::getUserName($data->userid)}}</td>
                                                    <td>{{FunctionsController::getUserNameTicket($data->admin)}}</td>
                                                    <td><span
                                                            class="badge bg-primary">{{FunctionsController::getTicketStatus($data->status)}}</span>
                                                    </td>
                                                    <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->timestamp)}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center mt-1">
                                        <h3>Keine archivierten Tickets gefunden!</h3>
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
