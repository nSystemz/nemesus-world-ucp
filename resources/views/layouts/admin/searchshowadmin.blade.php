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
            <div class="card">
                <div class="card-header">Spielersuche (Administrativ)</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Charakterinfos</h3>
                                </div>
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="{{$characters->screen}}"
                                            alt="User profile picture">
                                    </div>
                                    <h3 class="profile-username text-center">
                                        {{$characters->name}}</h3>
                                    <p class="text-muted text-center">
                                        @if($characters->gender == 1) Männlich @else
                                        Weiblich @endif</p>
                                    <p class="text-muted text-center">
                                        {{ FunctionsController::getFraktionsName($characters->faction) }}
                                        -
                                        {{ FunctionsController::getRangName($characters->rang,$characters->faction) }}
                                    </p>
                                    <p class="text-muted text-center">
                                        @if($characters->closed == 1)
                                        <b style="color:rgb(235, 65, 65)">Der Charakter wurde zur Löschung markiert!</b>
                                    </p>
                                    @endif
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item ">
                                            <b>Geburtstag</b> <a class="float-right">{{$characters->birth}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Geld</b> <a class="float-right">{{$characters->cash}}$</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Konto</b> <a
                                                class="float-right">{{FunctionsController::getBankValueFromAll($characters->id)}}$</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Größe</b> <a class="float-right">{{$characters->size}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Augenfarbe</b> <a class="float-right">{{$characters->eyecolor}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Job</b> <a
                                                class="float-right">{{ FunctionsController::getJobName($characters->job) }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <div>
                                                <i class="fas fa-truck mr-1"></i>Truckerskill:
                                                {{FunctionsController::getSkillName($characters->truckerskill/45)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters->truckerskill/225*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-user-secret mr-1"></i>Diebesskill:
                                                {{FunctionsController::getSkillName($characters->thiefskill/25)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters->thiefskill/150*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-fish mr-1"></i>Angelskill:
                                                {{FunctionsController::getSkillName($characters->fishingskill/35)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters->fishingskill/175*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-bus mr-1"></i>Busskill:
                                                {{FunctionsController::getSkillName($characters->busskill/35)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters->busskill/175*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-user-cow mr-1"></i>Landwirtskill:
                                                {{FunctionsController::getSkillName($characters->farmingskill/25)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters->farmingskill/150*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-gun mr-1"></i>Craftingskill:
                                                {{FunctionsController::getSkillName($characters->craftingskill/25)}}
                                                <div class="progress progress-sm active mt-1">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        style="width: {{$characters->craftingskill/75*100}}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @php
                                        $licenses = explode("|",
                                        $characters->licenses);
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
                                        <button type="button" class="btn btn-primary float-right mt-2"
                                            data-toggle="modal" data-target=".chars-modal-lg">Weitere
                                            Charaktere</button>
                                        @if (count($groups) && Auth::user()->adminlevel >=
                                        FunctionsController::Administrator)
                                        <button type="button" class="btn btn-primary float-right mt-2"
                                            data-toggle="modal" data-target=".group-modal-lg">Gruppierungen</button>
                                        @endif
                                        @if (count($groups) && Auth::user()->adminlevel >=
                                        FunctionsController::Administrator)
                                        <button type="submit" class="btn btn-primary float-right mt-2"
                                            onclick="event.preventDefault(); window.location = '{{ '/adminCars/'. $characters->id }}';">Fahrzeuge</button>
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
                                        {{$characters->education}}
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Herkunft</strong>
                                    <p class="text-muted">{{$characters->origin}}</p>
                                    <hr>
                                    <strong><i class="fas fa-pencil-alt mr-1"></i> Besondere Fähigkeiten</strong>
                                    <p class="text-muted">
                                        <span class="tag tag-info">{{$characters->skills}}</span>
                                    </p>
                                    <hr>
                                    <strong><i class="far fa-file-alt mr-1"></i> Aussehen</strong>
                                    <p class="text-muted">{{$characters->appearance}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-primary card-outline">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                                data-toggle="tab">Weitere Infos</a></li>
                                        @if (count($timeline))
                                        <li class="nav-item"><a class="nav-link" href="#timeline"
                                                data-toggle="tab">Ereignisse</a></li>
                                        @endif
                                        @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin)
                                        @if (count($namechanges) || count($userlog))
                                        <li class="nav-item"><a class="nav-link" href="#misc"
                                                data-toggle="tab">Sonstiges</a></li>
                                        @endif
                                        @php
                                        $items = null;
                                        if(strlen($characters->items) > 5)
                                        {
                                        $items = json_decode($characters->items);
                                        }
                                        @endphp
                                        @if ($items != null)
                                        <li class="nav-item"><a class="nav-link" href="#items"
                                                data-toggle="tab">Inventar</a></li>
                                        @endif
                                        @endif
                                        @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin)
                                        <li class="nav-item"><a class="nav-link" href="#admin"
                                                data-toggle="tab">Adminaktionen</a></li>
                                        @endif
                                        @if (Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                                        <li class="nav-item"><a class="nav-link" href="#dsgvo"
                                                data-toggle="tab">Forum/DSGVO</a></li>
                                        @endif
                                        @if (Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                                        <li class="nav-item"><a class="nav-link" href="#screen"
                                                data-toggle="tab">Screenshots</a></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if($user->dsgvo_closed == 1)
                                                <span class="alert-warning mb-2 ml-2 mr-2 text-center">Der Spieler
                                                    wurde nach der <strong>DSGVO</strong> gesperrt und alle
                                                    personenbezogenen Daten wurden gelöscht!</span>
                                                </span>
                                                @endif
                                                @if($user->ban != 0)
                                                @if($user->ban != -1)
                                                <span class="alert-danger mb-2 ml-2 mr-2 text-center">Der Spieler
                                                    ist noch bis zum
                                                    <strong>{{strftime( '%d %b. %Y - %H:%M:%S',$user->ban)}}</strong>
                                                    gebannt, Grund: <strong>{{$user->bantext}}</strong>!</span>
                                                </span>
                                                @else
                                                <span class="alert-danger mb-2 ml-2 mr-2 text-center">Der Spieler
                                                    ist permanent gebannt, Grund:
                                                    <strong>{{$user->bantext}}</strong>!</span>
                                                </span>
                                                @endif
                                                @endif
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if($user->prison > 0)
                                                <span class="alert-danger mb-2 ml-2 mr-2 text-center">Der Spieler
                                                    befindet sich noch für
                                                    <strong>{{$user->prison}} Checkpoints</strong> im Prison!</span>
                                                </span>
                                                @endif
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if($inaktiv)
                                                <span class="alert-warning mb-2 text-center">Der Spieler ist noch
                                                    vom <strong>{{strftime( '%d %b. %Y',$inaktiv->date1)}}</strong> bis
                                                    zum <strong>{{strftime( '%d %b. %Y',$inaktiv->date2)}}</strong> als
                                                    inaktiv gemeldet, Grund: {{$inaktiv->text}}!</span>
                                                @endif
                                            </div>
                                            <ul class="list-group list-group-bordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Account-ID</b> <a class="float-right">
                                                        {{$user->id}}</a>
                                                </li>
                                                @if ($user->forumaccount > -1)
                                                <li class="list-group-item">
                                                    <b>Forumaccount-ID</b> <a class="float-right">
                                                        {{$user->forumaccount}}</a>
                                                </li>
                                                @endif
                                                <li class="list-group-item">
                                                    <b>Accountname</b> <a class="float-right">{{$user->name}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Status</b>
                                                    @if ($user->online == 1)
                                                    <a class="float-right" style="color:green">Online</a>
                                                    @else
                                                    <a class="float-right" style="color:red">Offline</a>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Level</b> <a class="float-right"><span
                                                            id="level">{{$user->level}}</span></a>
                                                    <div class="progress progress-sm active level-bar" id="level-bar">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped"
                                                            role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                            aria-valuemax="100"
                                                            style="width: {{$user->play_points/(($user->level+1)*4)*100}}%">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Spielstunden</b> <a class="float-right">{{$user->play_time}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Erfahrungspunkte</b> <a class="float-right"><span
                                                            id="play_points">{{$user->play_points}}</span></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Kills</b> <a class="float-right">{{$user->kills}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tode</b> <a class="float-right">{{$user->deaths}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    @if($user->deaths > 0)
                                                    <b>K/D</b> <a class="float-right">{{$user->kills/$user->deaths}}</a>
                                                    @else
                                                    <b>K/D</b> <a class="float-right">0</a>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Verbrechen</b> <a class="float-right">{{$user->crimes}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    @if($user->premium == 1 && $user->premium_time > time())
                                                    <b><span style="color:#bf8970">Premium</span></b>
                                                    <a class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->premium_time)}}
                                                    </a>
                                                    @elseif($user->premium == 2 && $user->premium_time > time())
                                                    <b><span style="color:#c0c0c0">Premium</span></b>
                                                    <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->premium_time)}}</a>
                                                    @elseif($user->premium == 3 && $user->premium_time > time())
                                                    <b><span style="color:#ffd700">Premium</span></b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->premium_time)}}</a>
                                                    @else
                                                    <b>Premium</b> <a class="float-right">Nein</a>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Coins</b> <a class="float-right">{{$user->coins}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Loginbonus</b> <a class="float-right">{{$user->login_bonus}} Tage</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Letzter Login</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->last_login)}}</a>
                                                </li>
                                                @if(Auth::user()->adminlevel > FunctionsController::High_Administrator)
                                                <li class="list-group-item">
                                                    <b>Letzte IP</b> <a
                                                        class="float-right">{{$user->last_ip}}</a>
                                                </li>
                                                @endif
                                                <li class="list-group-item">
                                                    <b>Registriert seit</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->account_created)}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Letzte Speicherung</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->last_save)}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Namechanges</b> <a class="float-right">{{$user->namechanges}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    @php
                                                    $warns = explode('|', $user->warns_text);
                                                    @endphp
                                                    <b>Verwarnungen</b> <a class="float-right"><span
                                                            style="color: red">{{$user->warns}}/5
                                                            @if($user->warns > 0) -
                                                            @if($warns[0] != 'n/A') ( {{ $warns[0] }} @endif
                                                            @if($warns[1] != 'n/A') , {{ $warns[1] }} @endif
                                                            @if($warns[2] != 'n/A') , {{ $warns[2] }} @endif
                                                            @if($warns[3] != 'n/A') , {{ $warns[3] }} @endif
                                                            @if($warns[4] != 'n/A') , {{ $warns[4] }} @endif)</span>
                                                        @endif</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Erledigte Tickets (letzte 21 Tage)</b> <a
                                                        class="float-right">{{$tickets}}</a>
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
                                            <div class="timeline timeline-inverse">
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
                                                    <i class="fas fa-user-car bg-primary"></i>
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
                                        <div class="tab-pane" id="misc">
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
                                        @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin)
                                        <div class="tab-pane" id="admin">
                                            @if (Auth::user()->adminlevel >= FunctionsController::Administrator)
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('adminChangeName') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName">Accountname ändern</label>
                                                    <div class="input-group input-group">
                                                        <input type="hidden" class="form-control" id="id" name="id"
                                                            value="{{$characters->userid}}" maxlength="11"
                                                            autocomplete="off">
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
                                            @endif
                                            @if ($user->namechanges < 5 && Auth::user()->adminlevel >=
                                                FunctionsController::Administrator)
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('adminSetNameChange') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" id="id" name="id"
                                                            value="{{$characters->userid}}" maxlength="11"
                                                            autocomplete="off">
                                                        <div class="input-group input-group">
                                                            <button type="submit" class="btn btn-block btn-primary">+1
                                                                Namechange setzen</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @endif
                                                @if (Auth::user()->adminlevel >= FunctionsController::Supporter)
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('adminChangeCharName') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="inputName">Charaktername ändern</label>
                                                        <div class="input-group input-group">
                                                            <input type="hidden" class="form-control" id="id" name="id"
                                                                value="{{$characters->userid}}" maxlength="11"
                                                                autocomplete="off">
                                                            <input type="hidden" class="form-control" id="cid"
                                                                name="cid" value="{{$characters->id}}" maxlength="11"
                                                                autocomplete="off">
                                                            <input type="text" class="form-control"
                                                                placeholder="Neuer Charaktername" id="name" name="name"
                                                                maxlength="35" autocomplete="off">
                                                            <span class="input-group-append">
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-flat ml-2">Ändern</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </form>
                                                @endif
                                                @if (Auth::user()->adminlevel >= FunctionsController::Administrator)
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('adminGeneratePassword') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="inputName">Neues Passwort</label>
                                                        <input type="hidden" class="form-control" id="id" name="id"
                                                            value="{{$characters->userid}}" maxlength="11"
                                                            autocomplete="off">
                                                        <div class="input-group input-group">
                                                            <button type="submit"
                                                                class="btn btn-block btn-primary">Passwort
                                                                generieren</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @endif
                                                @if ($user->prison == 0 && Auth::user()->adminlevel >=
                                                FunctionsController::Probe_Moderator)
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('adminSetPrison') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="inputName">Ins Prison setzen</label>
                                                        <div class="input-group input-group">
                                                            <input type="hidden" class="form-control" id="id" name="id"
                                                                value="{{$characters->userid}}" maxlength="11"
                                                                autocomplete="off">
                                                            <input type="text" class="form-control" placeholder="Grund"
                                                                id="grund" name="grund" maxlength="35"
                                                                autocomplete="off">
                                                        </div>
                                                        <div class="input-group input-group">
                                                            <input type="text" class="form-control mt-2"
                                                                placeholder="Anzahl der Checkpoints" id="checkpoints"
                                                                name="checkpoints" maxlength="6" autocomplete="off">
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-block btn-primary mt-2">Aktion
                                                            ausführen</button>
                                                    </div>
                                                </form>
                                                @endif
                                                @if ($user->prison != 0 && Auth::user()->adminlevel >=
                                                FunctionsController::Probe_Moderator)
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('adminUnsetPrison') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="inputName">Aus dem Prison holen</label>
                                                        <div class="input-group input-group">
                                                            <input type="hidden" class="form-control" id="id" name="id"
                                                                value="{{$characters->userid}}" maxlength="11"
                                                                autocomplete="off">
                                                            <input type="text" class="form-control" placeholder="Grund"
                                                                id="grund" name="grund" maxlength="35"
                                                                autocomplete="off">
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-block btn-primary mt-2">Aktion
                                                            ausführen</button>
                                                    </div>
                                                </form>
                                                @endif
                                                @if ($user->ban == 0 && Auth::user()->adminlevel >=
                                                FunctionsController::Supporter)
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('adminBanUser') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="inputName">Spieler bannen</label>
                                                        <div class="input-group input-group">
                                                            <input type="hidden" class="form-control" id="id" name="id"
                                                                value="{{$characters->userid}}" maxlength="11"
                                                                autocomplete="off">
                                                            <input type="text" class="form-control" placeholder="Grund"
                                                                id="grund" name="grund" maxlength="35"
                                                                autocomplete="off">
                                                        </div>
                                                        <div class="input-group input-group">
                                                            <input type="text" class="form-control mt-2"
                                                                placeholder="Banzeit in Minuten | Für Permanent = -1 eingeben"
                                                                id="zeit" name="zeit" maxlength="6" autocomplete="off">
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-block btn-danger mt-2">Aktion
                                                            ausführen</button>
                                                    </div>
                                                </form>
                                                @endif
                                                @if ($user->ban != 0 && Auth::user()->adminlevel >=
                                                FunctionsController::Administrator)
                                                <form class="form-horizontal" method="POST"
                                                    action="{{ route('adminUnbanUser') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="inputName">Spieler entbannen</label>
                                                        <div class="input-group input-group">
                                                            <input type="hidden" class="form-control" id="id" name="id"
                                                                value="{{$characters->userid}}" maxlength="11"
                                                                autocomplete="off">
                                                            <input type="text" class="form-control" placeholder="Grund"
                                                                id="grund" name="grund" maxlength="35"
                                                                autocomplete="off">
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-block btn-danger mt-2">Aktion
                                                            ausführen</button>
                                                    </div>
                                                </form>
                                                @endif
                                                @if ($user->warns < 5 && Auth::user()->adminlevel >=
                                                    FunctionsController::Supporter)
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('adminWarnUser') }}">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label for="inputName">Spieler verwarnen</label>
                                                            <div class="input-group input-group">
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{$characters->userid}}"
                                                                    maxlength="11" autocomplete="off">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Grund" id="grund" name="grund"
                                                                    maxlength="35" autocomplete="off">
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-block btn-danger mt-2">Aktion
                                                                ausführen</button>
                                                        </div>
                                                    </form>
                                                    @endif
                                                    @if ($user->warns > 0 && Auth::user()->adminlevel >=
                                                    FunctionsController::High_Administrator)
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('adminUnwarnUser') }}">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label for="inputName">Letzte Verwarnung vom Spieler
                                                                löschen</label>
                                                            <div class="input-group input-group">
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{$characters->userid}}"
                                                                    maxlength="11" autocomplete="off">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Grund" id="grund" name="grund"
                                                                    maxlength="35" autocomplete="off">
                                                                <button type="submit"
                                                                    class="btn btn-block btn-danger mt-2">Letzte
                                                                    Verwarnung löschen</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    @endif
                                                    @if (Auth::user()->adminlevel >=
                                                    FunctionsController::High_Administrator && $user->adminlevel >
                                                    FunctionsController::Kein_Admin &&
                                                    Auth::user()->adminlevel>=$user->adminlevel)
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('adminRemoveAdmin') }}">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label for="inputName">Adminrechte entfernen</label>
                                                            <div class="input-group input-group">
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{$characters->userid}}"
                                                                    maxlength="11" autocomplete="off">
                                                                <button type="submit"
                                                                    class="btn btn-block btn-danger mt-2">Aktion
                                                                    durchführen</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    @endif
                                                    @if (Auth::user()->adminlevel >= FunctionsController::Administrator)
                                                    @if ($characters->faction > 0)
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('adminRemoveFaction') }}">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label for="inputName">Fraktionsrechte entfernen</label>
                                                            <div class="input-group input-group">
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{$characters->id}}" maxlength="11"
                                                                    autocomplete="off">
                                                                <button type="submit"
                                                                    class="btn btn-block btn-danger mt-2">Aktion
                                                                    durchführen</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    @endif
                                                    @endif
                                                    @if (Auth::user()->adminlevel >=
                                                    FunctionsController::High_Administrator && $user->google2fa_secret
                                                    != null)
                                                    <form class="form-horizontal" method="POST"
                                                        action="{{ route('removeTwoFactor') }}">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label for="inputName">Zwei-Faktor-Authentisierung
                                                                deaktivieren</label>
                                                            <div class="input-group input-group">
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{$characters->userid}}"
                                                                    maxlength="11" autocomplete="off">
                                                                <button type="submit"
                                                                    class="btn btn-block btn-warning mt-2">Aktion
                                                                    durchführen</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    @endif
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
                                                            <th>Seriennummer</th>
                                                            <th>Herkunft</th>
                                                            <th>Registriert auf</th>
                                                            <th>Gewicht</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($items as $datai)
                                                        @if ($datai->type == 5 || $datai->type == 6)
                                                        @php $props = explode(",", $datai->props);@endphp
                                                        @if(isset($props[4]))
                                                        @php $weaponprops = explode("|", $props[4]); @endphp
                                                        @endif
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
                                                            <td>@if(isset($props[3]))WEPN-{{$props[3]}}@else / @endif
                                                            </td>
                                                            <td>@if(isset($weaponprops[0])){{$weaponprops[0]}}@else /
                                                                @endif</td>
                                                            <td>@if(isset($weaponprops[1])){{$weaponprops[1]}}@else /
                                                                @endif</td>
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
                                                            <td>@if(isset($props[3]))WEPN-{{$props[3]}}@else / @endif
                                                            </td>
                                                            <td>@if(isset($weaponprops[0])){{$weaponprops[0]}}@else /
                                                                @endif</td>
                                                            <td>@if(isset($weaponprops[1])){{$weaponprops[1]}}@else /
                                                                @endif</td>
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
                                        @if (Auth::user()->adminlevel > FunctionsController::High_Administrator)
                                        <div class="tab-pane" id="dsgvo">
                                            @if (Auth::user()->adminlevel >= FunctionsController::High_Administrator &&
                                            $user->forumaccount > -1)
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('deleteForum') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName">Forumaccount Verifizierung aufheben</label>
                                                    <div class="input-group input-group">
                                                        <input type="hidden" class="form-control" id="id" name="id"
                                                            value="{{$characters->userid}}" maxlength="11"
                                                            autocomplete="off">
                                                        <button type="submit"
                                                            class="btn btn-block btn-danger mt-2">Aktion
                                                            durchführen</button>
                                                    </div>
                                                </div>
                                            </form>
                                            @endif
                                            @if (Auth::user()->adminlevel >= FunctionsController::High_Administrator &&
                                            $user->dsgvo_closed == 0)
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('closeToDSGVO') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName">Sperre nach DSGVO</label>
                                                    <div class="input-group input-group">
                                                        <input type="hidden" class="form-control" id="id" name="id"
                                                            value="{{$characters->userid}}" maxlength="11"
                                                            autocomplete="off">
                                                        <button type="submit"
                                                            class="btn btn-block btn-danger mt-2">Aktion
                                                            durchführen</button>
                                                    </div>
                                                </div>
                                            </form>
                                            @endif
                                            @if (Auth::user()->adminlevel >= FunctionsController::High_Administrator &&
                                            $user->dsgvo_closed == 1)
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('unCloseToDSGVO') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName">Sperre nach DSGVO aufheben</label>
                                                    <div class="input-group input-group">
                                                        <input type="hidden" class="form-control" id="id" name="id"
                                                            value="{{$characters->userid}}" maxlength="11"
                                                            autocomplete="off">
                                                        <button type="submit"
                                                            class="btn btn-block btn-warning mt-2">Aktion
                                                            durchführen</button>
                                                    </div>
                                                </div>
                                            </form>
                                            @endif
                                        </div>
                                        @endif
                                        @if (Auth::user()->adminlevel > FunctionsController::High_Administrator)
                                        <div class="tab-pane" id="screen">
                                            @if(count($screens))
                                            @foreach($screens as $data )
                                            <a target="_blank" href="{{$data->screenshot}}"><img data-toggle="tooltip"
                                                    title="{{$data->screenname}} | {{strftime( '%d %b. %Y - %H:%M:%S',$data->timestamp)}}"
                                                    class="img-fluid" style="width: 35vh; padding: 10px 10px 10px 10px;"
                                                    src="{{$data->screenshot}}"></a>
                                            @endforeach
                                            @else
                                            <div class="text-center mt-1">
                                                <h3>Keine Screenshots vorhanden!</h3>
                                            </div>
                                            @endif
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
                                    @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin &&
                                    Auth::user()->adminlevel >= $user->adminlevel)
                                    <th>Aktion</th>
                                    @endif
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
                                    @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin &&
                                    Auth::user()->adminlevel >= $user->adminlevel)
                                    <td>
                                        <form method="post" action="{{ route('deleteUserakte') }}">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{$data->id}}">
                                            <button class="btn btn-danger btn-sm" type="submit">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
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
<div class="modal fade chars-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Weitere Charaktere</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body text-center">
                    <div class="table-responsive-md">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chars as $data )
                                <tr>
                                    <td>
                                        <a class="users-list-name"
                                            href="/search/showAdmin/{{$data->id}}">{{$data->name}}</a>
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
                                            href="/adminGroups/{{$data->groupsid}}">{{FunctionsController::getGroupName($data->groupsid)}}</a>
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
