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
                <div class="card-header">Inaktiv gemeldete Spieler</div>
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
                                        @if (count($inaktiv))
                                        <label for="inputName" class="mt-3">Inaktiv gemeldete Spieler</label>
                                        <div class="table-responsive-md">
                                        <table class="table table-bordered">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Vom</th>
                                                    <th>Bis</th>
                                                    <th>Grund</th>
                                                    @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel > FunctionsController::Administrator)
                                                    <th>Aktion</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($inaktiv as $data )
                                                <tr>
                                                    <td>{{FunctionsController::getUserName($data->userid)}}</td>
                                                    <td>{{strftime( '%d %b. %Y',$data->date1)}}</td>
                                                    <td>{{strftime( '%d %b. %Y',$data->date2)}}</td>
                                                    <td>{{$data->text}}</td>
                                                    @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel >= FunctionsController::Administrator)
                                                    <td>
                                                        <form method="post" action="{{ route('deleteInaktiv') }}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$data->id}}"
                                                                autocomplete="off">
                                                            <button class="btn btn-danger btn-sm" type="submit">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        @else
                                        <div class="text-center mt-1">
                                            <h3>Keine Inaktivitätsmeldungen vorhanden!</h3>
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
