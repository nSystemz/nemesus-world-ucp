<!-- Nemesus-World User Control Panel -->
<!-- Das UCP wurde von https://nemesus.de für Nemesus-World erstellt -->
<!-- Bei Fragen gerne an info@nemesus.de wenden! -->

@php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');
@endphp
<!DOCTYPE html>
<html lang="de">

<head>
    <title>Nemesus World | User Control Panel by Nemesus.de</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('images/favicon.ico')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('loginassets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('loginassets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('loginassets/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('loginassets/css/main.css')}}">
</head>

<body>
    <div class="limiter"
        style="background-image: url('/images/bg.jpg'); background-repeat: no-repeat; background-size: cover;">
        <div class="container-login100">
            <div class="wrap-login100 p-t-190 mt-5">
                <form class="login100-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="login100-form-avatar">
                        <img src="/images/logo.png" alt="Logo">
                    </div>
                    <div class="wrap-input100 m-b-10 mt-1">
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger text-center" role="alert" style="border-radius: 25px;">
                            <strong>Info: {{$message}}</strong>
                        </div>
                        @endif
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success text-center" role="alert" style="border-radius: 25px;">
                            <strong>Info: {{$message}}</strong>
                        </div>
                        @endif
                        <div class="wrap-input100 mt-2">
                            <input class="input100" type="text" id="name" name="name" placeholder="Benutzername"
                                maxlength="35" autocomplete="off">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="wrap-input100 m-b-10">
                        <input class="input100" type="password" name="password" id="password" placeholder="Passwort"
                            maxlength="35" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn p-t-10">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>
                    <div class="text-center w-full p-t-25 p-b-185">
                        <a href="/passwordForget" class="txt1">
                            Passwort vergessen?
                        </a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
