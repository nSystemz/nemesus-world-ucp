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
                                        {{$group->name}}</h3>
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
                                            <b>Fahrzeuge</b> <a class="float-right">{{$cars}}</a>
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
                                        == 1 || $licenses[4] == 1)
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
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
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
                                            @endif
                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data->since)}}</td>
                                            <td><span class="badge badge-info">{{$data->duty_time}}h</span></td>
                                            <td><span
                                                    class="badge badge-primary">{{ FunctionsController::getRangNameGroup($data->rang,$data->groupsid) }}
                                                    ({{$data->rang}})</span></td>
                                            @if(($mygroup->rang >= 10 && $mygroup->rang > $data->rang && $data->charid
                                            != $group->leader) || $mygroup->charid == $group->leader || $data->charid == Auth::user()->selectedcharacterintern)
                                            @if($data->payday > 0 && $data->payday_day > 0)
                                            <td><a data-toggle="modal" data-book-id="{{$data->charid}}"
                                                    data-target=".money-modal-lg" style="cursor:pointer"><span
                                                        class="badge badge-primary">{{$data->payday}}$ jeden
                                                        {{$data->payday_day}}ten Payday</span></a></td>
                                            @else
                                            <td><a data-toggle="modal" data-book-id="{{$data->charid}}"
                                                    data-target=".money-modal-lg"><span class="badge badge-primary"
                                                        style="cursor:pointer">0$</span></a></td>
                                            @endif
                                            @else
                                            <td><span class="badge badge-danger">Keine Berechtigung</span></td>
                                            @endif
                                            @desktop
                                            @if(($mygroup->rang >= 10 && $mygroup->rang > $data->rang && $data->charid
                                            != $group->leader) || $mygroup->charid == $group->leader)
                                            <td>
                                                <div class="row">
                                                    <form class="ml-2" method="post"
                                                        action="{{ route('groupUprank') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->charid}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </form>
                                                    <form class="ml-1" method="post"
                                                        action="{{ route('groupDownrank') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->charid}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </form>
                                                    @if ($data->charid != $group->leader)
                                                    <form class="ml-1" method="post" action="{{ route('groupKick') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->charid}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @if ($mygroup->charid == $group->leader)
                                                    <form class="ml-1" method="post"
                                                        action="{{ route('groupLeader') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->charid}}"
                                                            autocomplete="off">
                                                        <button class="btn btn-info btn-sm" type="submit">
                                                            <i class="fas fa-user-tie"></i>
                                                        </button>
                                                    </form>
                                                    @endif
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
<div class="modal fade money-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lohn setzen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="{{ route('groupMoney') }}">
                            @csrf
                            <label for="inputName">Lohn setzen</label>
                            <div class="input-group input-group">
                                <input type="hidden" name="bookId" name="bookId" autocomplete="off">
                                <input type="text" class="form-control" placeholder="Lohn" id="money" name="money"
                                    maxlength="6" autocomplete="off">
                                <input type="text" class="form-control ml-2" placeholder="Paydays" id="payday"
                                    name="payday" maxlength="3" autocomplete="off">
                                <button type="submit" class="btn btn-primary btn-flat ml-2">Weiter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('.money-modal-lg').on('show.bs.modal', function (e) {
    var bookId = $(e.relatedTarget).data('book-id');
    $(e.currentTarget).find('input[name="bookId"]').val(bookId);
});
</script>
@endpush
