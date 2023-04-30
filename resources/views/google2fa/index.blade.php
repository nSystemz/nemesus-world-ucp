@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Zwei-Faktor-Authentisierung</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div style="display: flex; justify-content: center; align-items: center;">
                                Du hast die Zwei-Faktor-Authentisierung aktiviert, bitte gebe unten den Code aus deiner App ein:
                            </div>
                            <form class="form-horizontal text-center" method="POST"
                                action="{{ route('2fa') }}">
                                @csrf
                                <input id="one_time_password" name="one_time_password" type="text"
                                    class="form-control mt-4 text-center" maxlength="6"
                                    name="one_time_password" placeholder="Code" autocomplete="off" required autofocus>
                                <button type="submit" class="btn btn-primary mt-4">Weiter</button>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
