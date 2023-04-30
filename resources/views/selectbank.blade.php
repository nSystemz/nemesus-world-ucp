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
                <div class="card-header">Onlinebanking</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- /.col -->
                            <div class="col-md-12">
                                @include("layouts.template-parts.alert")
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <label>Kontoauswahl</label>
                                        @php
                                        $defaultkonto =
                                        FunctionsController::GetDefaultKonto(Auth::user()->selectedcharacterintern);
                                        @endphp
                                        @foreach($bank as $data )
                                        <form class="form-horizontal" method="POST" action="{{ route('getBank') }}">
                                            @csrf
                                            @if($data->banknumber == $defaultkonto)
                                            <button type="submit" class="btn btn-block btn-primary mb-3" id="banknumber"
                                                name="banknumber" value="{{$data->banknumber}}">{{$data->banknumber}}
                                                -
                                                {{$data->bankvalue}}$ <span
                                                    class="badge badge-primary">Standardkonto</span></button>
                                            @else
                                            <button type="submit" class="btn btn-block btn-secondary mb-3"
                                                id="banknumber" name="banknumber"
                                                value="{{$data->banknumber}}">{{$data->banknumber}}
                                                -
                                                {{$data->bankvalue}}$</button>
                                            @endif
                                        </form>
                                        @endforeach
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
