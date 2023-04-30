@php
use App\Http\Controllers\FunctionsController as FunctionsController;
setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
@endphp
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="box box-default mt-1">
            <div class="card card-primary card-outline">
                <div class="card-header">Admindashboard</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Registrierte Accounts</span>
                                    <span class="info-box-number">
                                        {{$users}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Erstellte Charaktere</span>
                                    <span class="info-box-number">{{$characters}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Gebannte Spieler</span>
                                    <span class="info-box-number">{{$bans}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sanktionierte Spieler</span>
                                    <span class="info-box-number">{{$punishments}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-car"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Fahrzeuge</span>
                                    <span class="info-box-number">{{$cars}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Adminlogseinträge</span>
                                    <span class="info-box-number">{{$logs}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Vergangene Zeit seit Serverstart</span>
                                    <span class="info-box-text">{{FunctionsController::timeAgo($server_created)}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Geöffnete Tickets / Beabeitete Tickets</span>
                                    <span class="info-box-number">{{$ticket1}} / {{$ticket2}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Teammitglieder</h3>
                                <div class="card-tools">
                                    <span class="badge badge-danger">{{$admincount}} Teammitglied/er</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="users-list clearfix">
                                    @foreach ($admins as $data)
                                    <li>
                                        <strong><a class="users-list-name"
                                                href="/search/showAdmin/{{$data->id+99}}">{{$data->name}}</a></strong>
                                        <span
                                            class="users-list-date mt-1">{{strftime( '%d %b. %Y',$data->admin_since)}}</span>
                                        <span
                                            class="users-list-name"><span>{{FunctionsController::getAdminRangName($data->adminlevel,$data->id)}}</span></span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('adminLogout') }}">
                            @csrf
                            <button type="submit" class="btn btn-block btn-danger mt-3">Adminlogout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
