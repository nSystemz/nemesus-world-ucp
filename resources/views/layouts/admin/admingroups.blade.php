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
                <div class="card-header">Gruppierungsinfos</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Gruppierungsinfo</h3>
                                </div>
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">
                                        {{$group->name}}[{{$group->id}}]</h3>
                                    <p class="text-muted text-center">
                                        Gegründet am: {{strftime( '%d %b. %Y - %H:%M:%S',$group->created)}}</p>
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item ">
                                            <b>Leitung</b> <a
                                                class="float-right">{{FunctionsController::getCharacterNameByID($group->leader)}}</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Aktuelle Mitglieder</b> <a class="float-right">{{$members}}</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Mitglieder seid Gründung</b> <a
                                                class="float-right">{{$group->members}}</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Fahrzeuge</b> <a href="/adminGroupCars/{{$group->id}}" class="float-right">{{$cars}}</a>
                                        </li>
                                        @if($group->banknumber != "n/A")
                                        <li class="list-group-item ">
                                            <b>Konto</b> <a class="float-right">{{FunctionsController::getBankValue($group->banknumber)}}</a>
                                        </li>
                                        @endif
                                        <li class="list-group-item ">
                                            <b>Provision</b> <a class="float-right">{{$group->provision}}%</a>
                                        </li>
                                        <li class="list-group-item ">
                                            <b>Status</b> <a
                                                class="float-right">{{FunctionsController::getGroupStatus($group->status)}}</a>
                                        </li>
                                        @php
                                        $licenses = explode('|', $group->licenses);
                                        @endphp
                                        @if ($licenses[0] == 1 || $licenses[1] == 1 || $licenses[2] == 1 || $licenses[3]
                                        == 1 || $licenses[4] == 1 || $licenses[5] == 1 || $licenses[6] == 1 ||
                                        $licenses[7] == 1 || $licenses[8] == 1)
                                        <li class="list-group-item ">
                                            <b>Lizensen</b> <a class="float-right">
                                                @if($licenses[0] == 1)
                                                <i class="fas fa-truck" style="color:green;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Speditionslizenz"></i>
                                                @endif
                                                @if($licenses[1] == 1)
                                                <i class="fas fa-wrench" style="color:green;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Tuninglizenz"></i>
                                                @endif
                                                @if($licenses[2] == 1)
                                                <i class="fas fa-car" style="color:green;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Mechatronikerlizenz"></i>
                                                @endif
                                                @if($licenses[3] == 1)
                                                <i class="fas fa-bus" style="color:green;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Personenbeförderungslizenz"></i>
                                                @endif
                                                @if($licenses[4] == 1)
                                                <i class="fa-solid fa-file-shield" style="color:green;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Sicherheitslizenz"></i>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Gruppierungslog</b> <a class="float-right"
                                                href="/setLog/group-{{$group->id}}">Einsehen</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Wirtschaftslog</b> <a class="float-right"
                                                href="/setLog/groupmoney-{{$group->id}}">Einsehen</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if(count($characters))
                            <div class="table-responsive-sm">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Name</th>
                                            <th>Mitglied seit</th>
                                            <th>Onlinezeit (Woche)</th>
                                            <th>Rang</th>
                                            <th>Lohn</th>
                                            @desktop
                                            <th>Verwaltung</th>
                                            @enddesktop
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($characters as $data )
                                        @php
                                        $online = FunctionsController::getOnlineStatus($data->charid);
                                        @endphp
                                        <tr>
                                            <td>{{ FunctionsController::getCharacterNameByID($data->charid)}}
                                                @if($online == 1) <span class="badge badge-success">Online</span></td>
                                            @else
                                            <span class="badge badge-danger">Offline</span></td>
                                            @endif</td>
                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->since)}}</td>
                                            <td><span class="badge badge-info">{{$data->duty_time}}h</span></td>
                                            <td><span
                                                    class="badge badge-primary">{{ FunctionsController::getRangNameGroup($data->rang,$data->groupsid) }}
                                                    ({{$data->rang}})</span></td>
                                            @if($data->payday > 0 && $data->payday_day > 0)
                                            <td><a data-toggle="modal" data-book-id="{{$data->charid}}"
                                                    data-target=".money-modal-lg"><span
                                                        class="badge badge-primary">{{$data->payday}}$ jeden
                                                        {{$data->payday_day}}ten Payday</span></a></td>
                                            @else
                                            <td><span class="badge badge-primary">0$</span></td>
                                            @endif
                                            <td>
                                                <div class="row">
                                                    <form class="ml-2" method="post"
                                                        action="{{ route('adminGroupKick') }}">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="groupid"
                                                            name="groupid" value="{{$group->id}}" maxlength="11"
                                                            autocomplete="off">
                                                        <input type="hidden" name="id" value="{{$data->charid}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                    <form class="ml-1" method="post"
                                                        action="{{ route('adminGroupLeader') }}">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="groupid"
                                                            name="groupid" value="{{$group->id}}" maxlength="11"
                                                            autocomplete="off">
                                                        <input type="hidden" name="id" value="{{$data->charid}}"
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
