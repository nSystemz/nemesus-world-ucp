@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Logout</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <h5 class="text-center">Möchtest du dich wirklich ausloggen? Damit werden alle
                                        temporär gespeicherten Interaktionen gelöscht!</h5>
                                </div>
                                <div class="input-group input-group">
                                    <button type="submit" class="btn btn-block btn-danger mt-3">Logout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
