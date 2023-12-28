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
                <div class="card-header">Charakterauswahl</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        @php
                        $counter = 0;
                        @endphp
                        @if(count($characters) > 0)
                            @foreach($characters as $data)
                            <div class="card card-primary card-outline mr-3 ml-2">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{$data->screen}}">
                                    </div>
                                    <h3 class="profile-username text-center">
                                        {{$data->name}}</h3>
                                    <p class="text-muted text-center">
                                        {{FunctionsController::getFraktionsName($data->faction)}} -
                                        {{FunctionsController::getRangName($data->rang,$data->faction)}}</p>
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item">
                                            <b>Geld</b> <a class="float-right">{{$data->cash}}$</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Konto</b> <a
                                                class="float-right">{{FunctionsController::getBankValueFromAll($data->id)}}$</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Job</b> <a
                                                class="float-right">{{FunctionsController::getJobName($data->job)}}</a>
                                        </li>
                                    </ul>
                                </div>
                                @if ($counter == Auth::user()->selectedcharacter)
                                <button type="button" class="btn btn-primary mr-2 ml-2 mb-2" disabled>Auswählen</button>
                                @else
                                <button type="button" class="btn btn-primary mr-2 ml-2 mb-2"
                                    onclick="event.preventDefault(); window.location = '{{ '/changeCharacter/'. strval($counter) }}';">Auswählen</button>
                                @endif
                                @php
                                $counter ++;
                                @endphp
                            </div>
                            @endforeach
                            @else
                            <div class="text-center">
                                <h3>Du hast noch keinen Charakter erstellt, du kannst dir ingame auf unserem Gameserver einen erstellen!</h3>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
