@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="box box-default mt-1">
            <div class="card card-primary card-outline">
                <div class="card-header">Adminlogin</div>
                <div class="card-body">
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <h1>Adminlogin</h1>
                    </div>
                    <div class="mt-2" style="display: flex; justify-content: center; align-items: center;">
                        <img src="/images/schloss.png" width="90%" style="max-width: 65px;" />
                    </div>
                    <div class="mt-3" style="display: flex; justify-content: center; align-items: center;">
                        Dein Name: {{Auth::user()->name}}
                    </div>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        Deine IP: {{$_SERVER["REMOTE_ADDR"]}}
                    </div>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <div class="col-md-6 mt-4">
                            @include("layouts.template-parts.alert")
                            <form class="form-horizontal" method="POST" action="{{ route('setAdminLogin') }}">
                                @csrf
                                <input type="password" class="form-control text-center" placeholder="Adminpasswort"
                                    id="adminpassword" name="adminpassword" maxlength="35" autocomplete="off">
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-md mt-2">Verifizieren</button>
                                </div>
                            </form>
                            <div class="mt-3 text-center text-muted"
                                style="display: flex; justify-content: center; align-items: center;">
                                Nachdem Login werden sämtliche Interaktionen inkl. deiner IP geloggt.
                                Solltest du damit nicht einverstanden sein, so verlasse bitte diese Seite!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
