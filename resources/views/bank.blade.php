@php
use App\Http\Controllers\HomeController as HomeController;
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
                <div class="card-header">Onlinebanking - <span
                        class="badge badge-info right">{{$bank->banknumber}}</span> <span
                        class="badge badge-info right">{{$bank->bankvalue}}$</span></div>
                <div class="card-body">
                    <div style="display: flex; justify-content: center; align-items: center;">
                        @if($bank->banktype == 0)
                        <img src="/images/maze.png" style="max-width: 220px;max-height: 120px" class="mb-4" />
                        @else
                        <img src="/images/fleeca.png" style="max-width: 220px;max-height: 120px" class="mb-4" />
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.col -->
                            <div class="col-md-12">
                                @include("layouts.template-parts.alert")
                                <div class="card card-primary card-outline">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#bankpost"
                                                    data-toggle="tab">Überweisung</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#standingorder"
                                                    data-toggle="tab">Daueraufträge</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#bankfile"
                                                    data-toggle="tab">Kontoauszug</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="bankpost">
                                                <form method="POST" action="{{ route('transfer') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Empfängerkonto</label>
                                                        <input type="hidden" class="form-control" name="von"
                                                        id="von" value="{{$bank->banknumber}}"
                                                        maxlength="20" autocomplete="off">
                                                        <input type="text" class="form-control" name="empfänger"
                                                            id="empfänger" value="SA3701-" placeholder="Kontonummer"
                                                            maxlength="20" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Betrag in $</label>
                                                        <input type="text" class="form-control" name="betrag"
                                                            name="betrag" id="betrag" placeholder="500" maxlength="10"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Verwendungszweck</label>
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            name="verwendungszweck" id="verwendungszweck"
                                                            placeholder="Hausverkauf" maxlength="64">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bankpin</label>
                                                        <input type="password" autocomplete="off" class="form-control"
                                                            name="bankpin" id="bankpin" placeholder="Pin" maxlength="4">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Dauerauftrag? (Für einen Dauerauftrag, die Anzahl der
                                                            Tage in das Feld schreiben!)</label>
                                                        <input type="text" class="form-control" name="tage" id="tage"
                                                            placeholder="0" maxlength="3" autocomplete="off">
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-block btn-primary btn-lg">Überweisung
                                                        tätigen</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="standingorder">
                                                <div class="card card-primary card-outline">
                                                    <div class="card-body">
                                                @if (count($standingorder))
                                                <label>Daueraufträge:</label>
                                                <div class="table-responsive-md">
                                                    <table class="table table-bordered">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th>Sender</th>
                                                                <th>Empfänger</th>
                                                                <th>Verwendungszweck</th>
                                                                <th>Betrag</th>
                                                                <th>Alle x Tage</th>
                                                                <th>Datum</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                @foreach($standingorder as $dataso )
                                                                <td>{{$dataso->bankfrom}}
                                                                </td>
                                                                <td>{{$dataso->bankto}}
                                                                </td>
                                                                <td>{{$dataso->banktext}}</td>
                                                                <td><span
                                                                    class="badge badge-success right">{{$dataso->bankvalue}}$</span></td>
                                                                <td>{{$dataso->days}} Tage/e</td>
                                                                <td>{{strftime( '%d %b. %Y - %H:%M:%S',$dataso->timestamp)}}
                                                                </td>
                                                                @endforeach
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                <div class="text-center mt-1">
                                                    <h3>Keine Daueraufträge vorhanden!</h3>
                                                </div>
                                                @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="bankfile">
                                                <div class="card card-primary card-outline">
                                                    <div class="card-body">
                                                        <div class="tab-content">
                                                            @if (count($bankfiles) || count($banksettings))
                                                            @if(count($bankfiles))
                                                            <label>Kontoauszüge:</label>
                                                            <div class="table-responsive-md">
                                                                <table class="table table-bordered">
                                                                    <thead class="table-primary">
                                                                        <tr>
                                                                            <th>Sender</th>
                                                                            <th>Empfänger</th>
                                                                            <th>Verwendungszweck</th>
                                                                            <th>Betrag</th>
                                                                            <th>Datum</th>
                                                                            <th>Aktion</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($bankfiles as $data2 )
                                                                        <tr>
                                                                            <td>{{$data2->bankfrom}}</td>
                                                                            <td>{{$data2->bankto}}</td>
                                                                            <td>{{$data2->banktext}}</td>
                                                                            <td><span
                                                                                    class="badge badge-success right">{{$data2->bankvalue}}$</span>
                                                                            </td>
                                                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data2->banktime)}}
                                                                            </td>
                                                                            @if($data2->bankto != $bank->banknumber)
                                                                            <td><span
                                                                                class="badge badge-info right">Gesendet</span>
                                                                        </td>
                                                                            @else
                                                                            <td><span
                                                                                class="badge badge-info right">Empfangen</span>
                                                                        </td>
                                                                            @endif
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            @endif
                                                            @if(count($banksettings))
                                                            <label>Bankaktionen:</label>
                                                            <div class="table-responsive-md">
                                                                <table class="table table-bordered">
                                                                    <thead class="table-primary">
                                                                        <tr>
                                                                            <th>Aktion</th>
                                                                            <th>Betrag</th>
                                                                            <th>Name</th>
                                                                            <th>Datum</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($banksettings as $data3 )
                                                                        <tr>
                                                                            <td>{{$data3->setting}}</td>
                                                                            <td><span
                                                                                    class="badge badge-success right">{{$data3->value}}$</span>
                                                                            </td>
                                                                            <td>{{$data3->name}}</td>
                                                                            <td>{{strftime( '%d %b. %Y - %H:%M:%S',$data3->timestamp)}}
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            @endif
                                                            @else
                                                            <div class="text-center mt-1">
                                                                <h3>Keine Kontoauszüge vorhanden!</h3>
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
            </div>
        </div>
    </div>
</div>
@endsection
