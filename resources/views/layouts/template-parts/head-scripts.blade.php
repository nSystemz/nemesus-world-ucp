<!-- Theme style -->
<link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.css')}}">
<!-- Fontawesome -->
<link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
<!-- Fonts -->
<link rel="stylesheet" href="{{asset('css/fonts.css')}}">
<!-- Preloader -->
@php
setcookie("nemesusworlducp_theme", Auth::user()->theme, time()+3600, "/");
@endphp
@if(Auth::user()->theme == "light")
<div class="preloader flex-column justify-content-center align-items-center" style="background-color: #fff">
    <img class="animation__wobble" src="/images/logoklein.png" alt="AdminLTELogo" height="70" width="70">
</div>
@else
<div class="preloader flex-column justify-content-center align-items-center" style="background-color: #454D55">
    <img class="animation__wobble" src="/images/logoklein.png" alt="AdminLTELogo" height="70" width="70">
</div>
@endif
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
