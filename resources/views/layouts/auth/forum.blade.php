@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Forenaccount Verifizierung</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if (Auth::user()->forumaccount == -1)
                            <div style="display: flex; justify-content: center; align-items: center;">
                                Damit deine Rechte automatisch aktualisiert werden und du z.B deine Fraktionsrechte
                                zugeordnet bekommst oder du im Forum schreiben kannst, benötigst
                                eine Verbindung zu unserem Gameserver. Bitte klicke unten auf den Button um dein
                                Forenaccount zu verifizieren!
                            </div>
                            @if ($forumcheck != -1)
                            <br />
                            <div style="display: flex; justify-content: center; align-items: center;">
                                Gefundener Forenaccount: &nbsp; <strong>{{Auth::user()->name}}
                                    ({{$forumcheck}})</strong>
                            </div>
                            <form class="form-horizontal text-center" method="POST" action="{{ route('postForum') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary mt-4">Forenaccount verbinden</button>
                            </form>
                            @else
                            <br />
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <h4 style="color: red">Es konnte kein Forenaccount gefunden werden, bitte erstelle dir
                                    einen oder passe deinen
                                    Namen im Forum an!</h4>
                            </div>
                            @endif
                        </div>
                        </form>
                        @elseif (Auth::user()->forumaccount == -2)
                        <div style="display: flex; justify-content: center; align-items: center;">
                            Dir wurde im Forum eine Konversation mit einem Code geschickt, bitte gebe diesen Code unten
                            ein:
                        </div>
                        <br />
                        <form class="form-horizontal text-center" method="POST" action="{{ route('postForum') }}">
                            @csrf
                            <input class="form-control text-center" placeholder="Code" type="text" name="code" id="code"
                                maxlength="4" autocomplete="off">
                            <button type="submit" class="btn btn-primary mt-4">Weiter</button>
                        </form>
                        @else
                        <form class="form-horizontal text-center" method="POST" action="{{ route('updateForum') }}">
                            @csrf
                            <div style="display: flex; justify-content: center; align-items: center;">
                                Du hast deinen Forenaccount erfolgreich verbunden, deine Rechte werden absofort
                                automatisch
                                synchronisiert! Sofern du deine Verifizerung aufheben möchtest, melde dich bitte bei
                                einem
                                Admin!
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <button type="submit" class="btn btn-primary mt-4">Forumrechte updaten</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
