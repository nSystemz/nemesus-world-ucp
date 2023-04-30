@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Zwei-Faktor-Authentisierung</div>
                <div class="card-body">
                    @include("layouts.template-parts.alert")
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if (Auth::user()->google2fa_secret == null)
                            <div style="display: flex; justify-content: center; align-items: center;">
                                Aktiviere die Zwei-Faktor-Authentisierung für das UCP und den Gameserver, indem du den
                                unteren QR-Code scannst. Alternativ kannst du auch diesen Code verwenden: &nbsp;
                                <strong>{{ $secret }}</strong>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                Bitte nutze dafür eine Authentisierung App über dein Smartphone wie z.B den &nbsp; <a
                                    href="https://praxistipps.chip.de/google-authenticator-einrichten-so-gehts_33201">Google
                                    Authenticator</a>, bitte sichere deine App in regelmäßigen Abständen, ohne diese
                                kannst du dich &nbsp;<strong>nichtmehr</strong>&nbsp; einloggen!
                            </div>
                            <div class="mt-3" style="display: flex; justify-content: center; align-items: center;">
                                {!! $QR_Image !!}
                            </div>
                            <form class="form-horizontal text-center" method="POST"
                                action="{{ route('postTwoFactor') }}">
                                @csrf
                                <input id="one_time_password" name="one_time_password" type="hidden"
                                    class="form-control mt-4 text-center" value="{{ $secret }}" maxlength="6"
                                    name="one_time_password" autocomplete="off">
                                <button type="submit" class="btn btn-primary mt-4">Ich habe den QR Code
                                    gescannt!</button>
                            </form>
                        </div>
                        </form>
                        @else
                        <form class="form-horizontal text-center" method="POST"
                            action="{{ route('postDeleteTwoFactor') }}">
                            @csrf
                            Du hast die Zwei-Faktor-Authentisierung aktiviert und kannst diese unten deaktivieren, bitte
                            beachte das somit deine Accountsicherheit vermindert wird!</strong>
                            <div class="mt-3" style="display: flex; justify-content: center; align-items: center;">
                                <button type="submit" class="btn btn-danger mt-4">Zwei-Faktor-Authentisierung
                                    deaktivieren</button>
                            </div>
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
