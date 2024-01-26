@php
use App\Http\Controllers\HomeController as HomeController;
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
                <div class="card-header">Statistik</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div style="display: flex; justify-content: center; align-items: center;">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Allgemeine Statistiken</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Statistikname</th>
                                                    <th>Statistik</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Erstellte Accounts</td>
                                                    <td><span class="badge bg-info">{{$accounts}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Erstellte Charaktere</td>
                                                    <td><span class="badge bg-info">{{$charaktere}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Fahrzeuge</td>
                                                    <td><span class="badge bg-info">{{$cars}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Häuser</td>
                                                    <td><span class="badge bg-info">{{$houses}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Teammitglieder</td>
                                                    <td><span class="badge bg-info">{{$team}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Die meisten Verbrechen</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>Verbrechen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $counter = 1
                                                @endphp
                                                @foreach ($crimes as $data)
                                                <tr>
                                                    <td>{{$counter ++}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge bg-success">
                                                            {{$data->login_bonus}} Verbrechen</span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Die meisten Spielstunden</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>Spielstunden</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $counter = 1
                                                @endphp
                                                @foreach ($play_time as $data)
                                                <tr>
                                                    <td>{{$counter ++}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge bg-dark">Spielstunden:
                                                            {{$data->play_time}}h</span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if (count($shootingrange) > 0)
                            <div class="card card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Shootingrange</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>Sekunden</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $counter = 1
                                                @endphp
                                                @foreach ($shootingrange as $data)
                                                <tr>
                                                    <td>{{$counter ++}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge bg-dark">
                                                            {{$data->shootingrange}} Sekunden</span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="card card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Den höchsten Loginbonus</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>Tage in Folge</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $counter = 1
                                                @endphp
                                                @foreach ($login_bonus as $data)
                                                <tr>
                                                    <td>{{$counter ++}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge bg-danger">Loginbonus:
                                                            {{$data->login_bonus}} Tage</span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Die meisten Tode</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>Tode</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $counter = 1
                                                @endphp
                                                @foreach ($tode as $data)
                                                <tr>
                                                    <td>{{$counter ++}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge bg-warning">Tode: {{$data->deaths}}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Das höchste Level</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>Level</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $counter = 1
                                                @endphp
                                                @foreach ($level as $data)
                                                <tr>
                                                    <td>{{$counter ++}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge bg-primary">Level: {{$data->level}}</span>
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
    </div>
</div>
@endsection
