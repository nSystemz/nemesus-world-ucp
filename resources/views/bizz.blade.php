@php
use App\Http\Controllers\FunctionsController as FunctionsController;
@endphp
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Businessverwaltung</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        @foreach($bizz as $data )
                        <div class="col-md-3 mt-1">
                            <div class="card card-primary card-outline mr-3 ml-2">
                                <div class="card-body box-profile">
                                    <p class="text-muted text-center">
                                        <i class="fas fa-house-user nav-icon" style="font-size: 4vh;color:green"></i>
                                    </p>
                                    <p class="text-muted text-center">
                                        {{$data->name}} - {{$data->id}}</p>
                                    <p class="text-muted text-center">
                                        <strong>Aktueller Preis: {{$data->price}}$</strong></p>
                                    <ul class="list-group list-group-bordered">
                                        <li class="list-group-item">
                                            <b>Besitzer</b> <a class="float-right"> {{$data->owner}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Produkte</b> <a class="float-right"> {{$data->products}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Produktpreis</b> <a class="float-right"> {{$data->prodprice}}$</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Verkäufe</b> <a class="float-right"> {{$data->selled}}x</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Kasseninhalt</b> <a class="float-right"> {{$data->cash}}x</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Steuern</b> <a class="float-right"> {{$data->govcash}}x</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
