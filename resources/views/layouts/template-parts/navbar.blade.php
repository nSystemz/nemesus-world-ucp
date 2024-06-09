<?php
    $updateCheck = FunctionsController::checkForUCPUpdate();
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-primary" style="color:white">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    @if ($updateCheck == false)
        <marquee><span class="ml-2">Viel Spass mit dem UCP - Nemesus.de -
                {{ strftime('%d %b. %Y - %H:%M:%S', time()) }}</span></marquee>
    @else
        <marquee><span class="ml-2">Es steht ein neues <a
                    href="https://github.com/nSystemz/nemesus-world-ucp/releases">UCP Update</a zur Verfügung, bitte
                    updaten!</span></marquee>
    @endif
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/signOut" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
