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
                <div class="card-header">Namechanges (Die letzten 125 Einträge)</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            @if (count($namechanges))
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" onkeyup="searchLog()" id="searchtext" name="searchtext" placeholder="Suche" maxlength="55">
                              </div>
                              @endif
                              <div class="card card-primary card-outline">
                                <div class="col-md-12">
                                    @if (count($namechanges))
                            <div class="table-responsive-md mt-2">
                            <table id="logtable" class="table table-bordered" style="width:100%">
                                <thead class="table-primary">
                                    <tr id="tablehead" class="tablehead">
                                        <th>Account-ID</th>
                                        <th>Alter Name</th>
                                        <th>Neuer Name</th>
                                        <th>Datum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($namechanges as $data )

                                        <tr>
                                            <td>{{$data->userid+99}}</td>
                                            <td>{{$data->oldname}}</td>
                                            <td>{{$data->newname}}</td>
                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->timestamp)}}</td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            @else
                            <div class="text-center mt-1">
                                <h3>Keine Namechanges vorhanden!</h3>
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
