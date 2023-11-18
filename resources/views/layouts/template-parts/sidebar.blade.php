@php
use App\Http\Controllers\FunctionsController as FunctionsController;
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #1E282C">
    <a href="/home/" class="brand-link" style="background-color: #1A2226">
        <img src="/images/logoklein.png" alt="Nemesus-World Logo" class="brand-image"
            style="opacity: .8;color:white">
        <strong><span class="brand-text font-weight" style="font-family: 'Exo', sans-serif;">Nemesus World</span></strong>
        <span class="text-muted float-right mb-1" style="font-size: 10px; font-family: 'Exo', sans-serif;">{{FunctionsController::getSideBarCP()}}</span></span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <span class="d-block" style="color:white; font-family: 'Exo', sans-serif;">{{Auth::user()->name}} @if (Auth::user()->online == 1) <span
                        class="badge badge-success right ml-1">Online</span>@else<span
                        class="badge badge-danger right ml-1">Offline</span> @endif
                    <br />
                    @if (Auth::user()->selectedcharacter > -1)
                    <span class="text-muted" style="font-size: 12px">{{FunctionsController::getCharacterName(Auth::user()->selectedcharacterintern)}}</span></span>
                    @endif
            </div>
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('searchUser') }}">
            @csrf
            <div class="form-inline">
                <div class="input-group">
                    <input class="form-control form-control-sidebar" name="search" id="search" type="search"
                        placeholder="Suche" aria-label="Search" style="background-color: #1A2226" maxlength="35"
                        autocomplete="off">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-sidebar" style="background-color: #1A2226">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">ALLGEMEIN</li>
                <li class="nav-item">
                    <a href="/home/" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Account/Charakter
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/selectCharacter/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Charakter wechseln</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/home/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/advertised/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Geworbene Spieler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/twoFactor/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Zwei-Faktor Login</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/forum/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Forumaccount</p>
                            </a>
                        </li>
                        <li class="nav-item">
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/cars/" class="nav-link">
                        <i class="fas fa-car nav-icon"></i>
                        <p>Fahrzeuge</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/selectBank/" class="nav-link">
                        <i class="fas fa-money-bill-alt nav-icon"></i>
                        <p>Onlinebanking</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/house/" class="nav-link">
                        <i class="fas fa-house-user nav-icon"></i>
                        <p>Meine Häuser</p>
                    </a>
                </li>
                @if(FunctionsController::getFaction('faction') > 0)
                <li class="nav-item">
                    <a href="/faction/" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Meine Fraktion
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/faction/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fraktionsinfos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/factionCars/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fraktionsfahrzeuge</p>
                            </a>
                        </li>
                        @if(FunctionsController::getFaction('rang') >= 10)
                        <li class="nav-item">
                            <a href="/factionLog/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fraktionslog</p>
                            </a>
                        </li>
                        @endif
                        @if(FunctionsController::getFaction('faction') == 1 && FunctionsController::getFaction('rang') >= 10)
                        <li class="nav-item">
                            <a href="/weaponLog/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Waffenkammerlog</p>
                            </a>
                        </li>
                        @endif
                        @if(FunctionsController::getFaction('faction') == 1 || FunctionsController::getFaction('faction') == 2 || FunctionsController::getFaction('faction') == 3 && FunctionsController::getFaction('rang') >= 10)
                        <li class="nav-item">
                            <a href="/weaponLog/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lagerlog</p>
                            </a>
                        </li>
                        @endif
                        @if(FunctionsController::getFaction('faction') == 4 && FunctionsController::getFaction('rang') >= 10)
                        <li class="nav-item">
                            <a href="/govmoneyLog/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Staatskassenlog</p>
                            </a>
                        </li>
                        @endif
                        @if(FunctionsController::getFaction('faction') == 1 && FunctionsController::getFaction('rang') >= 10)
                        <li class="nav-item">
                            <a href="/asservatenKammerLog/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Asservatenkammerlog</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(FunctionsController::getGroup('group') > 0)
                <li class="nav-item">
                    <a href="/groups/" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Meine Gruppierung
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/groups/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gruppierungsinfos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/groupCars/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fahrzeuge</p>
                            </a>
                        </li>
                        @if(FunctionsController::getGroup('rang') >= 10)
                        <li class="nav-item">
                            <a href="/groupLogs/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gruppierungslog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/groupMoneyLog/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Wirtschaftslog</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                    <a href="/inaktiv/" class="nav-link">
                        <i class="fas fa-plane nav-icon"></i>
                        <p>Inaktiv melden</p>
                    </a>
                </li>
                <li class="nav-header">SONSTIGES</li>
                <li class="nav-item">
                    <a href="/magischeMuschel/" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                            Magische Miesmuschel
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/getStatistic/" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Statistiken
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/avatar/" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Avatar Generator
                        </p>
                    </a>
                </li>
                <li class="nav-header">Tickets</li>
                <li class="nav-item">
                    <a href="/createTicket/" class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            Ticket erstellen
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/myTickets/" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Meine Tickets
                            <span
                                class="badge badge-info right">{{FunctionsController::countTickets(Auth::user()->id)}}</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/archivTicketsPlayer/" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>
                            Ticketarchiv
                        </p>
                    </a>
                </li>
                @if (Auth::user()->adminlevel > FunctionsController::Kein_Admin)
                <li class="nav-header">ADMINBEREICH</li>
                @if (!session('nemesusworlducp_adminlogin'))
                <li class="nav-item">
                    <a href="/adminLogin/" class="nav-link">
                        <i class="nav-icon fas fa-wifi"></i>
                        <p>
                            Adminlogin
                        </p>
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="/adminDashboard/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Admindashboard
                        </p>
                    </a>
                </li>
                @if (Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                <li class="nav-item">
                    <a href="/adminSettings/" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Admineinstellungen
                        </p>
                    </a>
                </li>
                @endif
                @if (Auth::user()->adminlevel >= FunctionsController::Administrator)
                <li class="nav-item">
                    <a href="/selectGroups/" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Gruppierungen
                        </p>
                    </a>
                </li>
                @endif
                @if (Auth::user()->adminlevel >= FunctionsController::Administrator)
                <li class="nav-item">
                    <a href="/selectFactions/" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Fraktionen
                        </p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="/adminLogs/" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Adminlogs
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/showInaktiv/" class="nav-link">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>
                            Sonstiges
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (Auth::user()->adminlevel >= FunctionsController::Manager)
                        <li class="nav-item">
                            <a href="/createChangelog/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Changelog erstellen
                                </p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="/showItems/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Items
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/showItemList/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Itemliste
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/showAnimationList/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Animationsliste
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/showFurniture/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Möbelliste
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/showInaktiv/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Inaktivmeldungen
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/getNameChanges/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Namechanges
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/archivTickets/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Ticketarchiv (Allgemein)
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
            @endif
        </nav>
    </div>
</aside>
