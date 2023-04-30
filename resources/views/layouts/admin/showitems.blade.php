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
                <div class="card-header">Items</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div style="display: flex; justify-content: center; align-items: center;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="card card-primary card-outline">
                                    <div class="col-md-12">
                                        @if (count($items))
                                        <label for="inputName" class="mt-3">Items</label>
                                        <div class="input-group mb-3 mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" class="form-control" onkeyup="searchLog()" id="searchtext"
                                                name="searchtext" placeholder="Suche" maxlength="55">
                                        </div>
                                        <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Item-ID</th>
                                                    <th>Besitzer</th>
                                                    <th>Identifizierer</th>
                                                    <th>Itemname</th>
                                                    <th>Menge</th>
                                                    <th>Gewicht</th>
                                                    <th>Position</th>
                                                    <th>Letztes Update</th>
                                                </tr>
                                            </thead>
                                            <tbody id="logtable">
                                                @foreach($items as $data )
                                                @if($data->type != 5 && $data->type != 6)
                                                <tr>
                                                    <td>{{$data->itemid}}</td>
                                                    @if($data->ownerid != -1)
                                                        <td>{{FunctionsController::getCharacterName($data->ownerid)}}</td>
                                                    @else
                                                        <td>Kein Besitzer</td>
                                                    @endif
                                                    @if(str_contains($data->owneridentifier,"evidence"))
                                                    <td>Asservatenkammer</td>
                                                    @else
                                                        <td>{{$data->owneridentifier}}</td>
                                                    @endif
                                                    <td>{{$data->description}} @if($data->props != "n/A" && strlen($data->props) > 5)<br/><span
                                                        class="badge badge-dark">{{$data->props}}</span>@endif</td>
                                                    <td>{{$data->amount}}x</td>
                                                    <td>{{FunctionsController::countItemWeight($data)}}g</td>
                                                    @if($data->posx)
                                                    <td>{{$data->posx}}, {{$data->posy}}, {{$data->posz}}, {{$data->dimension}}</td>
                                                    @else
                                                    <td>Keine Position</td>
                                                    @endif
                                                    <td>{{strftime( '%d %b. %Y',$data->lastupdate)}}</td>
                                                </tr>
                                                @else
                                                <tr style="color:lightblue">
                                                    <td>{{$data->itemid}}</td>
                                                    @if($data->ownerid != -1)
                                                        <td>{{FunctionsController::getCharacterName($data->ownerid)}}</td>
                                                    @else
                                                        <td>Kein Besitzer</td>
                                                    @endif
                                                    @if(str_contains($data->owneridentifier,"Furniture-"))
                                                        <td>Furniture</td>
                                                    @else
                                                        <td>{{$data->owneridentifier}}</td>
                                                    @endif
                                                    <td>{{$data->description}} @if($data->props != "n/A" && strlen($data->props) > 5)<br/><span
                                                        class="badge badge-dark">{{$data->props}}</span>@endif</td>
                                                    <td>{{$data->amount}}x</td>
                                                    <td>{{$data->amount*$data->weight}}g</td>
                                                    @if($data->posx)
                                                    <td>{{$data->posx}}, {{$data->posy}}, {{$data->posz}}, {{$data->dimension}}</td>
                                                    @else
                                                    <td>Keine Position</td>
                                                    @endif
                                                    <td>{{strftime( '%d %b. %Y',$data->lastupdate)}}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        @else
                                        <div class="text-center mt-1">
                                            <h3>Keine Items vorhanden!</h3>
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
