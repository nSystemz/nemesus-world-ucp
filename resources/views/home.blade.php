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
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Charakterinfos</h3>
                                </div>
                                <div class="card-body box-profile">
                                    @if(!empty($characters[Auth::user()->selectedcharacter]->screen))
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" style="height: 60%"
                                            src="{{$characters[Auth::user()->selectedcharacter]->screen}}">
                                    </div>
                                    @endif
                                    <h3 class="profile-username text-center">
                                        {{$characters[Auth::user()->selectedcharacter]->name}}</h3>
                                    <p class="text-muted text-center">
                                        @if($characters[Auth::user()->selectedcharacter]->gender == 1) Männlich @else
                                        Weiblich @endif</p>
                                    <p class="text-muted text-center">
                                        {{ FunctionsController::getFraktionsName($characters[Auth::user()->selectedcharacter]->faction) }}
                                        -
                                        {{ FunctionsController::getRangName($characters[Auth::user()->selectedcharacter]->rang,$characters[Auth::user()->selectedcharacter]->faction) }}
                                    </p>
                                    @if($characters[Auth::user()->selectedcharacter]->ck > 0 &&
                                    $characters[Auth::user()->selectedcharacter]->ck > time())
                                    <p class="text-muted text-center">
                                        <b style="color:green">Aktive CK-Erlaubnis bis:
                                            {{strftime( '%d %b. %Y - %H:%M:%S',$characters[Auth::user()->selectedcharacter]->ck)}}</b>
                                    </p>
                                    @endif
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item ">
                                            <b>Geburtsdatum</b> <a
                                                class="float-right">{{$characters[Auth::user()->selectedcharacter]->birth}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Geld</b> <a
                                                class="float-right">{{$characters[Auth::user()->selectedcharacter]->cash}}$</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Konto</b> <a
                                                class="float-right">{{FunctionsController::getBankValueFromAll($characters[Auth::user()->selectedcharacter]->id)}}$</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Größe</b> <a
                                                class="float-right">{{$characters[Auth::user()->selectedcharacter]->size}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Augenfarbe</b> <a
                                                class="float-right">{{$characters[Auth::user()->selectedcharacter]->eyecolor}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Job</b> <a
                                                class="float-right">{{ FunctionsController::getJobName($characters[Auth::user()->selectedcharacter]->job) }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <div>
                                                <i class="fas fa-truck mr-1"></i>Truckerskill:
                                                {{FunctionsController::getSkillName($characters[Auth::user()->selectedcharacter]->truckerskill/45)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters[Auth::user()->selectedcharacter]->truckerskill/225*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-user-secret mr-1"></i>Diebesskill:
                                                {{FunctionsController::getSkillName($characters[Auth::user()->selectedcharacter]->thiefskill/25)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters[Auth::user()->selectedcharacter]->thiefskill/150*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-fish mr-1"></i>Angelskill:
                                                {{FunctionsController::getSkillName($characters[Auth::user()->selectedcharacter]->fishingskill/35)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters[Auth::user()->selectedcharacter]->fishingskill/175*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-bus mr-1"></i>Busskill:
                                                {{FunctionsController::getSkillName($characters[Auth::user()->selectedcharacter]->busskill/35)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters[Auth::user()->selectedcharacter]->busskill/175*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-solid fa-cow mr-1"></i>Landwirtskill:
                                                {{FunctionsController::getSkillName($characters[Auth::user()->selectedcharacter]->farmingskill/25)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters[Auth::user()->selectedcharacter]->farmingskill/150*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-solid fa-gun mr-1"></i>Craftingskill:
                                                {{FunctionsController::getSkillName($characters[Auth::user()->selectedcharacter]->craftingskill/25)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters[Auth::user()->selectedcharacter]->craftingskill/75*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @php
                                        $licenses = explode("|",
                                        $characters[Auth::user()->selectedcharacter]->licenses);
                                        @endphp
                                        <li class="list-group-item" style="letter-spacing: 5px">
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                <strong class="float-right">
                                                    <i class="fas fa-id-card-alt" style="color:green;font-size: 16px"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Personalausweis"></i>
                                                </strong>
                                                <strong class="float-right">
                                                    @if($licenses[0] == 1)
                                                    <i class="fas fa-car" style="color:green;font-size: 16px"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Führerschein"></i>
                                                </strong>
                                                @elseif($licenses[0] > 1)
                                                <i class="fas fa-credit-card" style="color:b4dd20;font-size: 16px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Führerschein (Sperre bis: {{strftime( '%d %b. %Y - %H:%M:%S',$licenses[0])}})"></i>
                                                </strong>
                                                @else
                                                <i class="fas fa-car" style="color:red;font-size: 16px"
                                                    data-toggle="tooltip" data-placement="top" title="Führerschein"></i>
                                                </strong>
                                                @endif
                                                <strong class="float-right">
                                                    @if($licenses[1] == 1)
                                                    <i class="fas fa-motorcycle" style="color:green;font-size: 16px"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Motorradschein"></i>
                                                </strong>
                                                @elseif($licenses[1] > 1)
                                                <i class="fas fa-credit-card" style="color:b4dd20;font-size: 16px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Mottoradschein (Sperre bis: {{strftime( '%d %b. %Y - %H:%M:%S',$licenses[1])}})"></i>
                                                </strong>
                                                @else
                                                <i class="fas fa-motorcycle" style="color:red;font-size: 16px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Motorradschein"></i>
                                                </strong>
                                                @endif
                                                <strong class="float-right">
                                                    @if($licenses[2] == 1)
                                                    <i class="fas fa-truck" style="color:green;font-size: 15px"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Truckerschein"></i>
                                                </strong>
                                                @elseif($licenses[2] > 3)
                                                <i class="fas fa-truck" style="color:#b4dd20;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Truckerschein (Sperre bis: {{strftime( '%d %b. %Y - %H:%M:%S',$licenses[2])}})"></i>
                                                </strong>
                                                @else
                                                <i class="fas fa-truck" style="color:red;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Truckerschein"></i>
                                                </strong>
                                                @endif
                                                <strong class="float-right">
                                                    @if($licenses[3] == 1)
                                                    <i class="fas fa-ship" style="color:green;font-size: 15px"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Bootsschein"></i>
                                                </strong>
                                                @elseif($licenses[3] > 1)
                                                <i class="fas fa-credit-card" style="color:b4dd20;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Bootsschein (Sperre bis: {{strftime( '%d %b. %Y - %H:%M:%S',$licenses[3])}})"></i>
                                                </strong>
                                                @else
                                                <i class="fas fa-ship" style="color:red;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top" title="Bootsschein"></i>
                                                </strong>
                                                @endif
                                                <strong class="float-right">
                                                    @if($licenses[4] == 1)
                                                    <i class="fas fa-plane" style="color:green;font-size: 15px"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Flugschein"></i>
                                                </strong>
                                                @elseif($licenses[4] > 1)
                                                <i class="fas fa-credit-card" style="color:b4dd20;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Flugschein (Sperre bis: {{strftime( '%d %b. %Y - %H:%M:%S',$licenses[4])}})"></i>
                                                </strong>
                                                @else
                                                <i class="fas fa-plane" style="color:red;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top" title="Flugschein"></i>
                                                </strong>
                                                @endif
                                                <strong class="float-right">
                                                    @if($licenses[5] == 1)
                                                    <i class="fas fa-credit-card" style="color:green;font-size: 15px"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Waffenschein"></i>
                                                </strong>
                                                @elseif($licenses[5] > 3)
                                                <i class="fas fa-credit-card" style="color:#b4dd20;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Waffenschein (Sperre bis: {{strftime( '%d %b. %Y - %H:%M:%S',$licenses[5])}})"></i>
                                                </strong>
                                                @else
                                                <i class="fas fa-credit-card" style="color:red;font-size: 15px"
                                                    data-toggle="tooltip" data-placement="top" title="Waffenschein"></i>
                                                </strong>
                                                @endif
                                            </div>
                                        </li>
                                        @if (count($groups))
                                        <button type="button" class="btn btn-primary float-right mt-2"
                                            data-toggle="modal" data-target=".group-modal-lg">Meine
                                            Gruppierungen</button>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Sonstige Informationen</h3>
                                </div>
                                <div class="card-body">
                                    <strong><i class="fas fa-book mr-1"></i> Abschluss</strong>
                                    <p class="text-muted">
                                        {{$characters[Auth::user()->selectedcharacter]->education}}
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Herkunft</strong>
                                    <p class="text-muted">{{$characters[Auth::user()->selectedcharacter]->origin}}</p>
                                    <hr>
                                    <strong><i class="fas fa-pencil-alt mr-1"></i> Besondere Fähigkeiten</strong>
                                    <p class="text-muted">
                                        <span
                                            class="tag tag-info">{{$characters[Auth::user()->selectedcharacter]->skills}}</span>
                                    </p>
                                    <hr>
                                    <strong><i class="far fa-file-alt mr-1"></i> Aussehen</strong>
                                    <p class="text-muted">{{$characters[Auth::user()->selectedcharacter]->appearance}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                                data-toggle="tab">Weitere Infos</a></li>
                                        @if (count($timeline))
                                        <li class="nav-item"><a class="nav-link" href="#timeline"
                                                data-toggle="tab">Ereignisse</a></li>
                                        @endif
                                        <li class="nav-item"><a class="nav-link" href="#settings"
                                                data-toggle="tab">Einstellungen</a></li>
                                        @php
                                        $items = null;
                                        if(strlen($characters[Auth::user()->selectedcharacter]->items) > 5)
                                        {
                                        $items = json_decode($characters[Auth::user()->selectedcharacter]->items);
                                        }
                                        @endphp
                                        @if ($items != null)
                                        <li class="nav-item"><a class="nav-link" href="#items"
                                                data-toggle="tab">Inventar</a></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if(Auth::user()->prison > 0)
                                                <span class="alert-danger mb-2 ml-2 mr-2 text-center">Du befindest dich
                                                    noch für
                                                    <strong>{{Auth::user()->prison}} Checkpoints</strong> im
                                                    Prison!</span>
                                                </span>
                                                @endif
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if(count($inaktiv) > 0)
                                                @foreach($inaktiv as $data )
                                                <span class="alert-warning mb-2 text-center">Du bist noch vom
                                                    <strong>{{strftime( '%d %b. %Y',$data->date1)}}</strong> bis zum
                                                    <strong>{{strftime( '%d %b. %Y',$data->date2)}}</strong> als inaktiv
                                                    gemeldet, Grund: {{$data->text}}!</span>
                                                @endforeach
                                                @endif
                                            </div>
                                            <ul class="list-group list-group-bordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Account-ID</b> <a class="float-right">
                                                        {{Auth::user()->id}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Accountname</b> <a class="float-right">{{Auth::user()->name}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Status</b>
                                                    @if (Auth::user()->online == 1)
                                                    <a class="float-right" style="color:green">Online</a>
                                                    @else
                                                    <a class="float-right" style="color:red">Offline</a>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Level</b> <a class="float-right"><span
                                                            id="level">{{Auth::user()->level}}</span></a>
                                                    <div class="level-bar progress progress-sm active" id="level-bar">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped"
                                                            role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                            aria-valuemax="100"
                                                            style="width: {{Auth::user()->play_points/((Auth::user()->level+1)*4)*100}}%">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Spielstunden</b> <a
                                                        class="float-right">{{Auth::user()->play_time}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Erfahrungspunkte</b> <a class="float-right"><span
                                                            id="play_points">{{Auth::user()->play_points}}</span></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Kills</b> <a class="float-right">{{Auth::user()->kills}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tode</b> <a class="float-right">{{Auth::user()->deaths}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    @if(Auth::user()->deaths > 0)
                                                    <b>K/D</b> <a
                                                        class="float-right">{{Auth::user()->kills/Auth::user()->deaths}}</a>
                                                    @else
                                                    <b>K/D</b> <a class="float-right">0</a>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Verbrechen</b> <a
                                                        class="float-right">{{Auth::user()->crimes}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    @if(Auth::user()->premium == 1 && Auth::user()->premium_time >
                                                    time())
                                                    <b><span style="color:#bf8970">Premium</span></b>
                                                    <a class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',Auth::user()->premium_time)}}
                                                    </a>
                                                    @elseif(Auth::user()->premium == 2 && Auth::user()->premium_time >
                                                    time())
                                                    <b><span style="color:#c0c0c0">Premium</span></b>
                                                    <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',Auth::user()->premium_time)}}</a>
                                                    @elseif(Auth::user()->premium == 3 && Auth::user()->premium_time >
                                                    time())
                                                    <b><span style="color:#ffd700">Premium</span></b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',Auth::user()->premium_time)}}</a>
                                                    @else
                                                    <b>Premium</b> <a class="float-right">Nein</a>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Coins</b> <a class="float-right">{{Auth::user()->coins}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Loginbonus</b> <a class="float-right">{{Auth::user()->login_bonus}} Tage</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Letzter Login</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',Auth::user()->last_login)}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Registriert seit</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',Auth::user()->account_created)}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Letzte Speicherung</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',Auth::user()->last_saved)}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Namechanges</b> <a
                                                        class="float-right">{{Auth::user()->namechanges}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    @php
                                                    $warns = explode('|', Auth::user()->warns_text);
                                                    @endphp
                                                    <b>Verwarnungen</b> <a class="float-right"><span
                                                            style="color: red">{{Auth::user()->warns}}/5
                                                            @if(Auth::user()->warns > 0) -
                                                            @if($warns[0] != 'n/A') ( {{ $warns[0] }} @endif
                                                            @if($warns[1] != 'n/A'), {{ $warns[1] }} @endif
                                                            @if($warns[2] != 'n/A'), {{ $warns[2] }} @endif
                                                            @if($warns[3] != 'n/A'), {{ $warns[3] }} @endif
                                                            @if($warns[4] != 'n/A'), {{ $warns[4] }} @endif)</span>
                                                        @endif</a>
                                                </li>
                                                <li class="list-group-item mb-2">
                                                    <b>Userakte</b>
                                                    <button type="button" class="btn btn-primary float-right"
                                                        data-toggle="modal"
                                                        data-target=".userakte-modal-lg">Ansehen</button></a>
                                                </li>
                                            </ul>
                                        </div>
                                        @if (count($timeline))
                                        <div class="tab-pane" id="timeline">
                                            <!-- The timeline -->
                                            <div class="timeline timeline-inverse">
                                                <!-- timeline time label -->
                                                @foreach($timeline as $data )
                                                <div class="time-label">
                                                    <span class="bg-primary">
                                                        {{strftime( '%d %b. %Y - %H:%M:%S',$data->timestamp)}}
                                                    </span>
                                                </div>
                                                <div>
                                                    @if($data->icon == 0)
                                                    <i class="fas fa-user bg-primary"></i>
                                                    @elseif ($data->icon == 1)
                                                    <i class="fas fa-clock bg-primary"></i>
                                                    @elseif ($data->icon == 2)
                                                    <i class="fas fa-plus bg-primary"></i>
                                                    @elseif ($data->icon == 3)
                                                    <i class="far fa-gem bg-yellow"></i>
                                                    @elseif ($data->icon == 4)
                                                    <i class="fas fa-user-tie bg-primary"></i>
                                                    @elseif ($data->icon == 5)
                                                    <i class="fas fa-car bg-primary"></i>
                                                    @endif
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i>
                                                            {{strftime( '%H:%M:%S',$data->timestamp)}}</span>
                                                        <h3 class="timeline-header">{{$data->text}}</h3>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div>
                                                    <i class="far fa-clock bg-gray"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($items != null)
                                        <div class="tab-pane" id="items">
                                            <label for="inputName">Inventar</label>
                                            <div class="table-responsive-md">
                                                <table class="table table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Item-ID</th>
                                                            <th>Beschreibung</th>
                                                            <th>Menge</th>
                                                            <th>Gewicht</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($items))
                                                        @foreach($items as $datai)
                                                        @if ($datai->type != 5 && $datai->type != 6)
                                                        <tr>
                                                            <td>{{$datai->itemid}}</td>
                                                            <td>{{$datai->description}} @if($datai->props &&
                                                                $datai->props != "n/A") <span
                                                                    class="badge badge-dark ml-2">{{$datai->props}}</span>
                                                                @endif</td>
                                                            <td>{{$datai->amount}}x</td>
                                                            <td>{{$datai->amount*$datai->weight}}g</td>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        <div class="text-center mt-1">
                                                            <h3>Keine Items vorhanden!</h3>
                                                        </div>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            @php $found = false; @endphp
                                            @foreach($items as $datai)
                                            @if ($datai->type == 5 || $datai->type == 6)
                                            @php $found = true; @endphp
                                            @if($found == true)
                                            @break
                                            @endif
                                            @endif
                                            @endforeach
                                            @if($found == true)
                                            <label for="inputName">Waffen & Munition</label>
                                            <div class="table-responsive-md">
                                                <table class="table table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Item-ID</th>
                                                            <th>Beschreibung</th>
                                                            <th>Menge</th>
                                                            <th>Gewicht</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($items as $datai)
                                                        @if ($datai->type == 5 || $datai->type == 6)
                                                        @php $props = explode(",", $datai->props); @endphp
                                                        @if($datai->type == 6 || $props[1] == 0)
                                                        <tr>
                                                            <td>{{$datai->itemid}}</td>
                                                            <td>{{$datai->description}}@if(isset($props[1]) &&
                                                                !FunctionsController::isAMeeleWeapon($datai->description)
                                                                &&
                                                                $datai->description != "Taser") <span
                                                                    class="badge badge-dark ml-2">{{$props[0]}}</span>
                                                                @endif</td>
                                                            <td>{{$datai->amount}}x</td>
                                                            <td>{{FunctionsController::countItemWeight($datai)}}g</td>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @if($datai->type == 5 && $props[1] == 1)
                                                        <tr style="color:lightblue">
                                                            <td>{{$datai->itemid}}</td>
                                                            <td>{{$datai->description}}@if(isset($props[1]) &&
                                                                !FunctionsController::isAMeeleWeapon($datai->description)
                                                                &&
                                                                $datai->description != "Taser") <span
                                                                    class="badge badge-dark ml-2">{{$props[0]}}</span>
                                                                @endif</td>
                                                            <td>{{$datai->amount}}x</td>
                                                            <td>{{FunctionsController::countItemWeight($datai)}}g</td>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="tab-pane" id="settings">
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('changeName') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName">Accountname ändern</label>
                                                    <div class="input-group input-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Neuer Accountname" id="name" name="name"
                                                            maxlength="35" autocomplete="off">
                                                        <span class="input-group-append">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-flat ml-2">Ändern</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('changePassword') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName">Passwort ändern</label>
                                                    <div class="input-group input-group">
                                                        <input type="password" class="form-control"
                                                            placeholder="Neues Passwort" maxlength="35" id="password"
                                                            name="password" autocomplete="off">
                                                        <span class="input-group-append">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-flat ml-2">Ändern</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('changeTheme') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    @if(Auth::user()->theme == "dark")
                                                    <label for="inputName">Themeauswahl (Aktuell: Darkmode)</label>
                                                    @else
                                                    <label for="inputName">Themeauswahl (Aktuell: Lightmode)</label>
                                                    @endif
                                                    <div class="input-group input-group">
                                                        <select class="custom-select" name="newtheme" id="newtheme">
                                                            @if(Auth::user()->theme == "dark")
                                                            <option value="light">Lightmode</option>
                                                            @else
                                                            <option value="dark">Darkmode</option>
                                                            @endif
                                                        </select>
                                                        <span class="input-group-append">
                                                            <button onclick="switchTheme();" type="submit"
                                                                class="btn btn-primary btn-flat ml-2">Ändern</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('changeUcpStatus') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    @if($characters[Auth::user()->selectedcharacter]->ucp_privat == 0)
                                                    <label for="inputName">UCP Profil (Aktuell: Öffentlich)</label>
                                                    @else
                                                    <label for="inputName">UCP Profil (Aktuell: Privat)</label>
                                                    @endif
                                                    <div class="input-group input-group">
                                                        <select class="custom-select" name="ucpstatus" id="ucpstatus"
                                                            autocomplete="off">
                                                            @if($characters[Auth::user()->selectedcharacter]->ucp_privat
                                                            == 1)
                                                            <option style="background-color:#F08080;" value="0">
                                                                Öffentlich</option>
                                                            @else
                                                            <option style="background-color:#F08080;" value="1">Privat
                                                            </option>
                                                            @endif
                                                        </select>
                                                        <span class="input-group-append">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-flat ml-2">Ändern</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                            @if (count($namechanges))
                                            <label for="inputName" class="mt-3">Namechanges (die letzten 50)</label>
                                            <div class="table-responsive-md">
                                                <table class="table table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Alter Name</th>
                                                            <th>Neuer Name</th>
                                                            <th>Datum</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($namechanges as $data2 )
                                                        <tr>
                                                            <td>{{$data2->oldname}}</td>
                                                            <td>{{$data2->newname}}</td>
                                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data2->timestamp)}}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif
                                            @if (count($userlog))
                                            <label for="inputName" class="mt-3">Benutzerlog (die letzten 50)</label>
                                            <div class="table-responsive-md">
                                                <table class="table table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Aktion</th>
                                                            <th>Datum</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($userlog as $data3 )
                                                        <tr>
                                                            <td>{{$data3->action}}</td>
                                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data3->timestamp)}}
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
            </div>
        </div>
    </div>
</div>
<div class="modal fade userakte-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Userakte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive-md">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                @if (count($userfile))
                                <tr>
                                    <th>Admin</th>
                                    <th>Folge</th>
                                    <th>Grund</th>
                                    <th>Zeit</th>
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if (count($userfile))
                                @foreach($userfile as $data )
                                <tr>
                                    <td>{{$data->admin}}</td>
                                    <td><span class="badge bg-danger">{{$data->penalty}}</span></td>
                                    <td>
                                        {{$data->text}}
                                    </td>
                                    <td>
                                        {{strftime( '%d %b. %Y - %H:%M:%S',$data->timestamp)}}</td>
                                </tr>
                                @endforeach
                                @else
                                <div class="text-center mt-1">
                                    <h3>Keine Einträge vorhanden!</h3>
                                </div>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade group-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Meine Gruppierungen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body text-center">
                    <div class="table-responsive-md">
                        @if ($characters[Auth::user()->selectedcharacter]->mygroup != -1)
                        Aktive Gruppierung:
                        {{FunctionsController::getGroupName($characters[Auth::user()->selectedcharacter]->mygroup)}}
                        @endif
                        <table class="table table-bordered mt-2">
                            <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groups as $data )
                                <tr>
                                    <td>
                                        <a class="users-list-name"
                                            href="/setGroup/{{$data->groupsid}}">{{FunctionsController::getGroupName($data->groupsid)}}</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    var currentTheme = getCookie('nemesusworlducp_theme');

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
</script>
@endpush
