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
                <div class="card-header">Spielersuche</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Charakterinfos</h3>
                                </div>
                                <div class="card-body box-profile">
                                    @if(!empty($characters->screen))
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" style="height: 60%"
                                            src="{{$characters->screen}}">
                                    </div>
                                    @endif
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
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item ">

                                            <b>Alter</b> <a class="float-right">{{$characters->birth}}
                                                J.</a>
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
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if($user->ban != 0)
                                                <span class="alert-danger mb-2 text-center">Dieser Spieler ist
                                                    <strong>gebannt</strong>!</span>
                                                @endif
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center;">
                                                @if($inaktiv)
                                                <span class="alert-warning mb-2 text-center">Dieser Spieler ist noch vom
                                                    <strong>{{strftime( '%d %b. %Y',$inaktiv->date1)}}</strong> bis zum
                                                    <strong>{{strftime( '%d %b. %Y',$inaktiv->date2)}}</strong> als
                                                    inaktiv gemeldet!</span>
                                                @endif
                                            </div>
                                            <ul class="list-group list-group-bordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Account-ID</b> <a class="float-right">
                                                        {{$user->id}}</a>
                                                </li>
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
                                                            aria-valuemax="100">
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
                                                    <b>Letzter Login</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->last_login)}}</a>
                                                </li>
                                                @if($user->last_ip && $user->last_ip != null && strlen($user->last_ip) >
                                                5 && Auth::user()->adminlevel >=
                                                FunctionsController::High_Administrator)
                                                <li class="list-group-item">
                                                    <b>Letzte IP</b> <a class="float-right">{{$user->last_ip}}</a>
                                                </li>
                                                @endif
                                                <li class="list-group-item">
                                                    <b>Registriert seit</b> <a
                                                        class="float-right">{{strftime( '%d %b. %Y - %H:%M:%S',$user->last_login)}}</a>
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
    $(document).ready(function () {
        var level_exp = (parseInt(document.getElementById('level').innerHTML) + 1) * 4;
        var play_points = parseInt(document.getElementById('play_points').innerHTML);
        var valeur = 0;
        if (play_points > 0) valeur = play_points / level_exp * 100;
        $('input:checked').each(function () {
            if ($(this).attr('value') > valeur) {
                valeur = $(this).attr('value');
            }
        });
        $('.progress-bar').css('width', valeur + '%').attr('aria-valuenow', valeur);
    });
</script>
@endpush
