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
                <div class="card-header">Payday Übersicht</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div style="display: flex; justify-content: center; align-items: center;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="card card-primary card-outline">
                                    <div class="col-md-12">
                                        @if (count($paydaylist))
                                        <label for="inputName" class="mt-3">Payday vom {{strftime( '%d %b. %Y - %H:%M:%S',$payday->timestamp)}}</label>
                                        <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Beschreibung</th>
                                                    <th>Summe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($paydaylist as $data )
                                                <tr>
                                                    <td>{{$data->modus}}</td>
                                                    <td>{{$data->setting}}</td>
                                                    @if ($data->value > 0)
                                                    <td style="color:green">+{{$data->value}}$</td>
                                                    @else
                                                    <td style="color:red">{{$data->value}}$</td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row float-right mt-2 mr-5">
                                            <div class="col-xs-6">
                                               <div class="table-responsive">
                                                  <table class="table">
                                                     <tr>
                                                        <th>Total:</th>
                                                        @if ($payday->total > 0)
                                                        <td style="color:green">+{{$payday->total}}$</td>
                                                        @else
                                                        <td style="color:red">{{$payday->total}}$</td>
                                                        @endif
                                                     </tr>
                                                  </table>
                                               </div>
                                            </div>
                                         </div>
                                        </div>
                                        @else
                                        <div class="text-center mt-1">
                                            <h3>Keine Payday Informationen vorhanden!</h3>
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
