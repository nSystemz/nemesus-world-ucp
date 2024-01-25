@php
use App\Http\Controllers\FunctionsController as FunctionsController;
setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
@endphp
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
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
                                        <li class="list-group-item ">
                                            <b>Fraktionslog</b> <a class="float-right"
                                                href="/setLog/faction-{{$faction->id}}">Einsehen</a>
                                        </li>
                                        @if($faction->id == 1)
                                        <li class="list-group-item ">
                                            <b>Waffenkammerlog</b> <a class="float-right"
                                                href="/setLog/weapon-{{$faction->id}}">Einsehen</a>
                                        </li>
                                        @elseif($faction->id != 1 && $faction->id != 4)
                                        <li class="list-group-item">
                                            <b>Lagerlog</b> <a class="float-right"
                                                href="/setLog/weapon-{{$faction->id}}">Einsehen</a>
                                        </li>
                                        @else
                                        <li class="list-group-item">
                                            <b>Staatskassenlog</b> <a class="float-right"
                                                href="/setLog/govmoney">Einsehen</a>
                                        </li>
                                        @endif
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
                                            <th>Verwaltung</th>
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
                                            </td>
                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->faction_since)}}</td>
                                            <td><span class="badge badge-info">{{$data->faction_dutytime}}h</span></td>
                                            <td><span
                                                    class="badge badge-primary">{{ FunctionsController::getRangName($data->rang,$data->faction) }}
                                                    ({{$data->rang}})</span></td>
                                            <td>
                                                <div class="row">
                                                    <form class="ml-2" method="post"
                                                        action="{{ route('adminFactionKick') }}">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="factionid"
                                                            name="factionid" value="{{$faction->id}}" maxlength="11"
                                                            autocomplete="off">
                                                        <input type="hidden" name="id" id="id" value="{{$data->id}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                    <form class="ml-1" method="post"
                                                        action="{{ route('adminFactionLeader') }}">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="factionid"
                                                            name="factionid" value="{{$faction->id}}" maxlength="11"
                                                            autocomplete="off">
                                                        <input type="hidden" name="id" id="id" value="{{$data->id}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-user-tie"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
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
