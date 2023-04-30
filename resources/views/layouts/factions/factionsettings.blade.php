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
                <div class="card-header">Fraktionseinstellungen</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive-md mt-2">
                                <label>Rangnameneinstellungen:</label>
                                <form class="form-horizontal" method="POST" action="{{ route('factionRangs') }}">
                                    @csrf
                                    <table id="logtable" class="table table-bordered" style="width:100%">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Alter Rangname</th>
                                                <th>Neuer Rangname</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$rangs->rang1}}</td>
                                                <td><input type="text" class="form-control" id="rang1" name="rang1"
                                                        value="{!! old('rang1', $rangs->rang1) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang2}}</td>
                                                <td><input type="text" class="form-control" id="rang2" name="rang2"
                                                        value="{!! old('rang2', $rangs->rang2) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang3}}</td>
                                                <td><input type="text" class="form-control" id="rang3" name="rang3"
                                                        value="{!! old('rang3', $rangs->rang3) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang4}}</td>
                                                <td><input type="text" class="form-control" id="rang4" name="rang4"
                                                        value="{!! old('rang4', $rangs->rang4) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang5}}</td>
                                                <td><input type="text" class="form-control" id="rang5" name="rang5"
                                                        value="{!! old('rang5', $rangs->rang5) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang6}}</td>
                                                <td><input type="text" class="form-control" id="rang6" name="rang6"
                                                        value="{!! old('rang6', $rangs->rang6) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang7}}</td>
                                                <td><input type="text" class="form-control" id="rang7" name="rang7"
                                                        value="{!! old('rang7', $rangs->rang7) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang8}}</td>
                                                <td><input type="text" class="form-control" id="rang8" name="rang8"
                                                        value="{!! old('rang8', $rangs->rang8) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang9}}</td>
                                                <td><input type="text" class="form-control" id="rang9" name="rang9"
                                                        value="{!! old('rang9', $rangs->rang9) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang10}}</td>
                                                <td><input type="text" class="form-control" id="rang10" name="rang10"
                                                        value="{!! old('rang10', $rangs->rang10) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang11}}</td>
                                                <td><input type="text" class="form-control" id="rang11" name="rang11"
                                                        value="{!! old('rang11', $rangs->rang11) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang12}}</td>
                                                <td><input type="text" class="form-control" id="rang12" name="rang12"
                                                        value="{!! old('rang12', $rangs->rang12) !!}" maxlength="50"
                                                        autocomplete="off"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-block btn-primary mb-2 mt-3">Rangnamen
                                        aktualisieren</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive-md mt-2">
                                <label>Lohneinstellungen: (Verf. Lohnbudget: {{$budget->budget}}$)</label>
                                <form class="form-horizontal" method="POST" action="{{ route('factionSalary') }}">
                                    @csrf
                                    <table id="logtable" class="table table-bordered" style="width:100%">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Rangname</th>
                                                <th>Lohn</th>
                                                <th>Neuer Lohn</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$rangs->rang1}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang1}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl1" name="rangl1"
                                                        value="{!! old('rangl1', $salary->rang1) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang2}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang2}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl2" name="rangl2"
                                                        value="{!! old('rangl2', $salary->rang2) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang3}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang3}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl3" name="rangl3"
                                                        value="{!! old('rangl3', $salary->rang3) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang4}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang4}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl4" name="rangl4"
                                                        value="{!! old('rangl4', $salary->rang4) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang5}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang5}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl5" name="rangl5"
                                                        value="{!! old('rangl5', $salary->rang5) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang6}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang6}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl6" name="rangl6"
                                                        value="{!! old('rangl6', $salary->rang6) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang7}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang7}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl7" name="rangl7"
                                                        value="{!! old('rangl7', $salary->rang7) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang8}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang8}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl8" name="rangl8"
                                                        value="{!! old('rangl8', $salary->rang8) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang9}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang9}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl9" name="rangl9"
                                                        value="{!! old('rangl9', $salary->rang9) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang10}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang10}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl10" name="rangl10"
                                                        value="{!! old('rangl10', $salary->rang10) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang11}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang11}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl11" name="rangl11"
                                                        value="{!! old('rangl11', $salary->rang11) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td>{{$rangs->rang12}}</td>
                                                <td><span class="badge badge-info">{{$salary->rang12}}$</span></td>
                                                <td><input type="text" class="form-control" id="rangl12" name="rangl12"
                                                        value="{!! old('rangl12', $salary->rang12) !!}" maxlength="6"
                                                        autocomplete="off"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-block btn-primary mb-2 mt-3">Lohneinstellungen
                                        aktualisieren</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
