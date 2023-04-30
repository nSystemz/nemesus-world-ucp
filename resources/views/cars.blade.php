@php
use App\Http\Controllers\FunctionsController as FunctionsController;
setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');
@endphp
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Fahrzeugverwaltung</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        @foreach($vehicles as $data )
                        <div class="card card-primary card-outline ml-2 mr-4">
                            <div class="card-body box-profile">
                                <h3 class="profile-username text-center">
                                    {{$data->vehiclename}}[{{$data->id}}]</h3>
                                @if(strlen($data->plate) > 3)
                                <p class="text-muted text-center">Kennzeichen: {{$data->plate}} - <span
                                        style="color: green">Zugelassen</span></p>
                                @else
                                <p class="text-muted text-center">Kennzeichen: Nicht vorhanden - <span
                                        style="color: red">Nicht zugelassen</span></p>
                                @endif
                                <ul class="list-group list-group-bordered mb-3">
                                    <li class="list-group-item">
                                        <b>Zustand</b> <a class="float-right" @php $health=explode("|",$data->health);
                                            @endphp
                                            id="health">{{$health[2]/1000*100}}%</a>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-error progress-bar-striped progress-bar1"
                                                role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                aria-valuemax="100" style="width: {{$health[2]/1000*100}}%">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tank </b> <a class="float-right" id="fuel">{{$data->fuel}}l</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Öl</b> <a class="float-right" id="oel">{{$data->oel/100*100}}%</a>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning progress-bar-striped progress-bar3"
                                                role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                aria-valuemax="100" style="width: {{$data->oel/100*100}}%">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Batterie</b> <a class="float-right"
                                            id="battery">{{$data->battery/100*100}}%</a>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning progress-bar-striped progress-bar2"
                                                role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                aria-valuemax="100" style="width: {{$data->battery/100*100}}%">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        @if($data->status == 0)
                                        <b>Status </b> <a style="color:green" class="float-right">Offen</a>
                                        @else
                                        <b>Status </b> <a  style="color:red"class="float-right">Verschlossen</a>
                                        @endif
                                    </li>
                                    <li class="list-group-item">
                                        @if($data->engine == 0)
                                        <b>Motor </b> <a class="float-right">Aus</a>
                                        @else
                                        <b>Motor </b> <a class="float-right">Ab</a>
                                        @endif
                                    </li>
                                    <li class="list-group-item">
                                        <b>Kilometer</b> <a class="float-right">{{$data->kilometre}} KM</a>
                                    </li>
                                    <li class="list-group-item">
                                        @if ($data->tuev > 5)
                                        <b>TÜV </b> <a class="float-right"
                                            style="color:green">{{date("j F, Y - H:i:s",$data->tuev)}}</a>
                                        @elseif ($data->tuev == 2)
                                        <b>TÜV</b> <a class="float-right" style="color:green">Ja</a>
                                        @else
                                        <b>TÜV</b> <a class="float-right" style="color:red">Nein</a>
                                        @endif
                                    </li>
                                    @if(!str_contains($data->owner, 'character'))
                                    <li class="list-group-item">
                                        <b>Ab Rang</b> <a class="float-right">{{$data->rang}}</a>
                                    </li>
                                    @endif
                                </ul>
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
