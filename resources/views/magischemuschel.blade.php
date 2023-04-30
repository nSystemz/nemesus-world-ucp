@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Hier kannst du die Magische Miesmuschel befragen -
                    (Achtung mit Ton)!</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <strong>
                                    <h6>Befrage die magische Miesmuschel</h6>
                                </strong>
                            </div>
                            <br />
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <img src="/images/miesMuschel.jpg"
                                    width="90%" style="max-width: 220px;" />
                            </div>
                            <br />
                            <div class="form-group">
                                <input type="text" class="form-control form-group-lg muschelFrage" id="muschelFrage"
                                    placeholder="Deine Frage" style="text-align: center" maxlength="55" autocomplete="off">
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <b>
                                    <div class="muschelAntwort" id="muschelAntwort" style="text-align: center"></div>
                                </b>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <button type="button" id="frag"
                                    class="btn btn-primary mr-2 ml-2 mt-4 frag">Fragen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {
    muschel.init();
});
var muschel = {
    run: 0,
    init: function () {
        muschel.klick();
    },
    klick: function () {
        $('.frag').click(function () {
            if ($('.muschelFrage').val() !== '') {
                if (muschel.run === 0) {
                    muschel.antworten();
                }
            } else {
                $('.muschelAntwort').html('<h3>Bitte stelle deine Frage!</h3>');
            }
        });
    },
    antworten: function () {
        muschel.run = 1;
        muschel.go("miesMuschel");

        setTimeout(function () {
            var answers = [{
                    'sound': 'garnichts',
                    'antwort': 'Garnichts'
                },
                {
                    'sound': 'ichglaubnicht',
                    'antwort': 'Ich glaube eher nicht!'
                },
                {
                    'sound': 'einestages',
                    'antwort': 'Eines Tages vielleicht'
                },
                {
                    'sound': 'nein',
                    'antwort': 'Nein'
                },
                {
                    'sound': 'ja',
                    'antwort': 'Ja'
                },
                {
                    'sound': 'fragdochnochmal',
                    'antwort': 'Frag doch einfach nochmal!'
                }
            ];
            var random = Math.floor(Math.random() * answers.length);
            muschel.go(answers[random].sound);
            setTimeout(function () {
                $('.muschelAntwort').html('<h3>' + answers[random].antwort + '</h3>');
            }, 400);
            muschel.run = 0;
        }, 3200);
    },
    go: function (sound) {
        var audio = new Audio('/sounds/' + sound + '.mp3');
        audio.play();
    }
};
</script>
@endpush
