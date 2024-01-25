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
                <div class="card-header">Fraktionsinfos</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Fraktionsinfos</h3>
                                </div>
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">
                                        {{$faction->name}}</h3>
                                    <p class="text-muted text-center">
                                        Gegründet am: {{strftime( '%d %b. %Y - %H:%M:%S',$faction->created)}}</p>
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item ">
                                            <b>Leitung</b> <a
                                                class="float-right">{{FunctionsController::getCharacterName($faction->leader)}}</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Aktuelle Mitglieder</b> <a class="float-right">{{$members}}</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Mitglieder seid Gründung</b> <a
                                                class="float-right">{{$faction->members}}</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Fahrzeuge</b> <a class="float-right">{{$cars}}</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Dienstzeit (Woche)</b> <a class="float-right">{{$dutytime}}h</a>
                                        </li>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive-md">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Name</th>
                                            <th>Mitglied seit</th>
                                            <th>Dienstzeit (Woche)</th>
                                            <th>Rang</th>
                                            @desktop
                                            <th>Verwaltung</th>
                                            @enddesktop
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($characters as $data )
                                        <tr>
                                            <td>{{$data->name}}
                                                @if($data->online) <span class="badge badge-success">Online</span></td>
                                            @else
                                            <span class="badge badge-danger">Offline</span> @if($data->swat == 1)<span
                                                class="badge badge-primary ml-1">SWAT</span>@endif</td>
                                            @endif</td>
                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->faction_since)}}</td>
                                            <td><span class="badge badge-info">{{$data->faction_dutytime}}h</span></td>
                                            <td><span
                                                    class="badge badge-primary">{{ FunctionsController::getRangName($data->rang,$data->faction) }}
                                                    ({{$data->rang}})</span></td>
                                            @desktop
                                            @if(($checkfaction->rang >= 10 && $checkfaction->rang > $data->rang &&
                                            $checkfaction->id != $data->id && $data->id != $faction->leader) ||
                                            $checkfaction->id == $faction->leader)
                                            <td>
                                                <div class="row">
                                                    @if($faction->id == 1)
                                                    <form method="post" class="ml-2"
                                                        action="{{ route('factionSwat') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fa-solid fa-gun"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    <form class="ml-1" method="post"
                                                        action="{{ route('factionUprank') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </form>
                                                    <form class="ml-1" method="post"
                                                        action="{{ route('factionDownrank') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </form>
                                                    <form class="ml-1" method="post"
                                                        action="{{ route('factionKick') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            @else
                                            <td><span class="badge badge-danger">Keine Berechtigung</span></td>
                                            @endif
                                            @enddesktop
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
