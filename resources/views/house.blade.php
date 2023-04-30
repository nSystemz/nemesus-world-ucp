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
                <div class="card-header">Hausverwaltung</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        @foreach($houses as $data )
                        <div class="col-md-3 mt-1">
                            <div class="card card-primary card-outline mr-3 ml-2">
                                <div class="card-body box-profile">
                                    <p class="text-muted text-center">
                                        <i class="fas fa-house-user nav-icon" style="font-size: 4vh;color:green"></i>
                                    </p>
                                    <p class="text-muted text-center">
                                        {{$data->streetname}} - {{$data->id}}</p>
                                    @if($data->housegroup > -1)<strong><p class="text-muted text-center">
                                        {{FunctionsController::getGroupName($data->housegroup)}}</p></strong>@endif
                                    <p class="text-muted text-center">
                                        <strong>Aktueller Preis: {{$data->price}}$</strong></p>
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item">
                                            <b>Besitzer</b> <a class="float-right"> {{$data->owner}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Türen</b> <a class="float-right"> @if($data->locked == 0) <span
                                                    style="color:green">Offen</span> @endif @if($data->locked == 1)
                                                <span style="color:red">Geschlossen</span> @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Klingelschild</b> <a class="float-right"> @if($data->noshield == 0) <span
                                                    style="color:green">Ja</span> @endif @if($data->noshield == 1)
                                                <span style="color:red">Nein</span> @endif</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Straße</b> <a class="float-right"> {{$data->streetname}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Hausnummer</b> <a class="float-right"> {{$data->id}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Mieter</b> <a class="float-right"> {{$data->tenants}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Mietpreis</b> <a class="float-right"> {{$data->rental}}$</a>
                                        </li>
                                        @php
                                        $classify = DB::table('houseinteriors')->where('id', $data->interior)
                                        ->value('classify');
                                        $classCheck = "Klein";
                                        if($classify == 0)
                                        {
                                            $classCheck = "Klein";
                                        }
                                        else if($classify == 1)
                                        {
                                            $classCheck = "Mittel";
                                        }
                                        else if($classify == 2)
                                        {
                                            $classCheck = "Gross";
                                        }
                                        else if($classify == 3)
                                        {
                                            $classCheck = "Villa";
                                        }
                                        else if($classify >= 4)
                                        {
                                            $classCheck = "Individuell";
                                        }
                                        @endphp
                                        <li class="list-group-item">
                                            <b>Interior</b> <a class="float-right">{{$classCheck}} - {{$data->interior}}</a>
                                        </li>
                                        @if($data->housegroup > -1)
                                        <li class="list-group-item">
                                            <b>Produkte</b> <a class="float-right">{{$data->stock}}/3500</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Produktpreis</b> <a class="float-right">{{$data->stockprice}}$</a>
                                        </li>
                                        @endif
                                    </ul>
                                    <button type="submit" class="btn btn-block btn-primary btn-sm mt-2" onclick="event.preventDefault(); window.location = '{{ '/furniture/'. strval($data->id) }}';">Möbelverwaltung</button>
                                    <button type="submit" class="btn btn-block btn-primary btn-sm mt-2" onclick="event.preventDefault(); window.location = '{{ '/tenants/'. strval($data->id) }}';">Mieterverwaltung</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('.furniture-modal-lg').on('show.bs.modal', function (e) {
    var bookId = $(e.relatedTarget).data('book-id');
});
</script>
@endpush
