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
                <div class="card-header">Möbelverwaltung</div>
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
                                    <label for="inputName" class="mt-3">Meine Möbelstücke</label>
                                    @if(count($furniture))
                                        <table class="table table-bordered">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Preis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($furniture as $data )
                                                <tr>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{str_replace(',','.',$data->position)}}</td>
                                                    <td>{{$data->price}}$</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
