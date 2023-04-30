@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 mt-1">
        <div class="box box-default">
            <div class="box-header with-border">
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">Avatar Generator</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <strong class="text-center">
                                    <h4 id="text" name="text">Dein Avatar wird generiert, bitte warte kurz ...</h4>
                                    <div class="progress" id="progress" name="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                      </div>
                                </strong>
                            </div>
                            <br />
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <canvas id="avatar" name="avatar" width="320px" height="320px"
                                    style="border:1px solid black;visibility:hidden" style="font-family: 'Exo', sans-serif;">
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <button type="button" name="button" id="button"
                                    class="btn btn-primary mr-2 ml-2 mt-4 download" style="visibility:hidden">Download</button>
                            </div>
                            <h4 style="font-family: 'Exo';visibility:hidden">Font laden ...</h4>
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
  elementZ.init();
});
var elementZ = {
    canvas: null,
    ctx: null,
    init: function () {
        elementZ.canvas = $('#avatar');
        elementZ.ctx = elementZ.canvas[0].getContext("2d");

        elementZ.loadElements();
        elementZ.download();

    },
    loadElements: function (type, x = 0, y = 0) {
        setTimeout(function(){
        var background = new Image();
        background.src = "/images/avatar.png";
        var name = '{{Auth::user()->name}}';
        background.onload = function () {
            elementZ.ctx.drawImage(background, 0, 0);
            elementZ.ctx.fillStyle = "White";
            elementZ.ctx.textAlign = "center";
            elementZ.ctx.font = "55px 'Exo'";
            if(name.length <= 10)
            {
                elementZ.ctx.font = "55px 'Exo'";
            }
            else
            {
                if(name.length <= 16)
                {
                    elementZ.ctx.font = "32px 'Exo'"
                }
                else
                {
                    if(name.length <= 21)
                    {
                        elementZ.ctx.font = "25px 'Exo'"
                    }
                    else
                    {
                        if(name.length <= 25)
                        {
                            elementZ.ctx.font = "20px 'Exo'"
                        }
                        else
                        {
                            elementZ.ctx.font = "14px 'Exo'"
                        }
                    }
                }
            }
            elementZ.ctx.fillText(name, 156, 271);
            setTimeout(function(){
                document.getElementById("text").innerHTML = "Dein Avatar wurde erfolgreich generiert, du kannst diesen über den <strong>Download</strong> Button downloaden!";
                document.getElementById("avatar").style.visibility = "visible";
                document.getElementById("button").style.visibility = "visible";
                document.getElementById("progress").style.visibility = "hidden";
            }, 1000);
        };
    }, 4000);
    },
    download: function () {
        $('.download').click(function () {
            this.href = document.getElementById('avatar').toDataURL();
            var a = $("<a>")
                .attr("href", this.href)
                .attr("download", "avatar.png")
                .appendTo("body");
            a[0].click();
            a.remove();
        });
    }
};
</script>
@endpush
