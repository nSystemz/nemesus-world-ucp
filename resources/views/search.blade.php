@php
    use App\Http\Controllers\FunctionsController as FunctionsController;
@endphp
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="card card-primary card-outline">
                <div class="card-header">Suchanfrage</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include("layouts.template-parts.alert")
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Gefundene Charaktere:</h3>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="users-list clearfix">
                                        @if ($characters)
                                        @foreach ($characters as $data)
                                        @if((FunctionsController::getDSGVOClosed($data->userid) == 0 && $data->closed == 0) || (Auth::user()->adminlevel > FunctionsController::High_Administrator && session('nemesusworlducp_adminlogin')))
                                        <li>
                                            @if(!empty($data->screen) && ($data->ucp_privat == 0 || (Auth::user()->adminlevel > FunctionsController::High_Administrator && session('nemesusworlducp_adminlogin'))))
                                            <img src="{{$data->screen}}"
                                                style="max-weight: 15px;max-height: 176px;border-radius: 10%;border: 1px solid #adb5bd; width: 300px;" data-toggle="tooltip"
                                                data-placement="top" title="{{$data->name}}">
                                            @endif
                                            @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin && session('nemesusworlducp_adminlogin'))
                                            <a class="users-list-name"
                                                href="/search/showAdmin/{{$data->id}}">{{$data->name}}</a>
                                            @else
                                            <a class="users-list-name"
                                                href="/search/show/{{$data->id}}">{{$data->name}}</a>
                                            @endif
                                            @if ($data->ucp_privat == 1)
                                            <a class="users-list-name" href="#"><span
                                                    class="badge badge-danger">Privat</span></a>
                                            @else
                                            <a class="users-list-name" href="#"><span
                                                    class="badge badge-primary">Öffentlich</span></a>
                                            @endif
                                        </li>
                                        @endif
                                        @endforeach
                                        @else
                                        <div class="col-md-12 mt-2 text-center">
                                            <h3 class="mt-2">Keine Suchergebnisse gefunden!</h3>
                                        </div>
                                        @endif
                                    </ul>
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
