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
                <div class="card-header">Möbelinfos</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div style="display: flex; justify-content: center; align-items: center;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="card card-primary card-outline">
                                    <div class="col-md-12">
                                        @if (count($categories))
                                        <label for="inputName" class="mt-3">Möbelkategorien</label>
                                        <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($categories as $data )
                                                <tr>
                                                    <td>{{$data->id}}</td>
                                                    <td>{{$data->name}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        @else
                                        <div class="text-center mt-1">
                                            <h3>Keine Möbelkategorien vorhanden!</h3>
                                        </div>
                                        @endif
                                        @if (count($furniture))
                                        <label for="inputName" class="mt-3">Möbel</label>
                                        <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Hash</th>
                                                    <th>Name</th>
                                                    <th>Extra</th>
                                                    <th>Kategorie</th>
                                                    <th>Preis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($furniture as $data )
                                                <tr>
                                                    <td>{{$data->id}}</td>
                                                    <td>{{$data->hash}}</td>
                                                    <td>{{ucfirst($data->name)}}</td>
                                                    <td>{{$data->extra}}</td>
                                                    <td>{{$data->categorie}}</td>
                                                    <td>{{$data->price}}$</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        @else
                                        <div class="text-center mt-1">
                                            <h3>Keine Möbel vorhanden!</h3>
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
