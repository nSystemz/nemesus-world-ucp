<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

//FactionsController für sämtliche Fraktionsfunktionen
class FactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkbanned');
        $this->middleware('2fa')->except('signOut');
    }

    public function getFaction()
    {
        if (Auth::check()) {
            $checkfaction = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
            if ($checkfaction->faction > 0) {
                $characters = DB::table('characters')->where('faction', $checkfaction->faction)->orderBy('rang', 'desc')->orderBy('name', 'asc')->get();
                $members = DB::table('characters')->where('faction', $checkfaction->faction)
                    ->count();
                $dutytime = DB::table('characters')->where('faction', $checkfaction->faction)
                    ->sum('faction_dutytime');
                $faction = DB::table('factions')->where('id', $checkfaction->faction)->first();
                $cars = DB::table('vehicles')->where('owner', 'faction-' . $checkfaction->faction)->count();
                return view('layouts.factions.faction', ['characters' => $characters, 'members' => $members, 'dutytime' => $dutytime, 'faction' => $faction, 'cars' => $cars, 'checkfaction' => $checkfaction]);
            } else {
                return redirect::to('/home')->with('error', 'Du bist in keiner Fraktion!');
            }
        }
    }

    public function factionSwat(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                $faction = DB::table('factions')->where('id', $character->faction)->first();
                if ($character->rang < 10 || !$findcharacter || $findcharacter->faction != $character->faction) return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
                $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                if (($character->id == $faction->leader && $character->id != $findcharacter->id) || ($findcharacter->faction == $character->faction && $character->rang > $findcharacter->rang && $findcharacter->id != $faction->leader)) {
                    $setSwat = 0;
                    if ($findcharacter->swat == 0)
                    {
                        $setSwat = 1;
                        $logtext = $character->name . " hat " . $findcharacter->name . " den SWAT-Status gesetzt!";
                    }
                    else
                    {
                        $setSwat = 0;
                        $logtext = $character->name . " hat " . $findcharacter->name . " den SWAT-Status entzogen!";
                    }
                    DB::table('logs')->insert(array('loglabel' => "faction-" . $character->faction, 'text' => $logtext, 'timestamp' => time()));
                    DB::table('characters')->where('id', $findcharacter->id)
                        ->update(['swat' => $setSwat]);
                    return redirect::to('/faction')->with('success', 'SWAT-Status gesetzt/entzogen!');
                } else {
                    return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function factionUprank(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                $faction = DB::table('factions')->where('id', $character->faction)->first();
                if ($character->rang < 10 || !$findcharacter || $findcharacter->faction != $character->faction) return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
                $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                if (($character->id == $faction->leader && $character->id != $findcharacter->id) || ($findcharacter->faction == $character->faction && $character->rang > $findcharacter->rang && $findcharacter->id != $faction->leader)) {
                    $newrang = $findcharacter->rang + 1;
                    if ($newrang > 12) return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
                    $logtext = $character->name . " hat " . $findcharacter->name . " befördert - (Neuer Rang: " . $newrang . ")!";
                    DB::table('logs')->insert(array('loglabel' => "faction-" . $character->faction, 'text' => $logtext, 'timestamp' => time()));
                    DB::table('characters')->where('id', $findcharacter->id)
                        ->update(['rang' => $newrang]);
                    return redirect::to('/faction')->with('success', 'Der Spieler wurde erfolgreich befördert!');
                } else {
                    return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function factionDownrank(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                $faction = DB::table('factions')->where('id', $character->faction)->first();
                if ($character->rang < 10 || !$findcharacter || $findcharacter->faction != $character->faction) return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
                $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                if (($character->id == $faction->leader && $character->id != $findcharacter->id) || ($findcharacter->faction == $character->faction && $character->rang > $findcharacter->rang && $findcharacter->id != $faction->leader)) {
                    $newrang = $findcharacter->rang - 1;
                    if ($newrang > 12) return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
                    $logtext = $character->name . " hat " . $findcharacter->name . " degradiert - (Neuer Rang: " . $newrang . ")!";
                    DB::table('logs')->insert(array('loglabel' => "faction-" . $character->faction, 'text' => $logtext, 'timestamp' => time()));
                    DB::table('characters')->where('id', $findcharacter->id)
                        ->update(['rang' => $newrang]);
                    return redirect::to('/faction')->with('success', 'Der Spieler wurde erfolgreich degradiert!');
                } else {
                    return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function factionKick(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                $faction = DB::table('factions')->where('id', $character->faction)->first();
                if ($character->rang < 10 || !$findcharacter || $findcharacter->faction != $character->faction) return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
                $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                if ($findcharacter->id == $character->id) return Redirect::back()->with('error', 'Du kannst dich nicht selber rauswerfen!');
                if (($character->id == $faction->leader && $character->id != $findcharacter->id) || ($findcharacter->faction == $character->faction && $character->rang > $findcharacter->rang && $findcharacter->id != $faction->leader)) {
                    $logtext = $character->name . " hat " . $findcharacter->name . " aus der Fraktion geworfen!";
                    DB::table('logs')->insert(array('loglabel' => "faction-" . $character->faction, 'text' => $logtext, 'timestamp' => time()));
                    DB::table('characters')->where('id', $findcharacter->id)
                        ->update(['faction' => 0, 'rang' => 0, 'faction_dutytime' => 0, 'faction_since' => time(), 'swat' => 0]);
                    return redirect::to('/faction')->with('success', 'Der Spieler wurde erfolgreich aus der Fraktion geworfen!');
                } else {
                    return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/faction')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function factionLog()
    {
        if (Auth::check()) {
            $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
            if ($character->faction <= 0 && $character->rang < 10) return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
            $logs = DB::table('logs')->where('loglabel', 'faction-' . $character->faction)->orderBy('timestamp', 'desc')->limit(215)->get();
            return view('layouts.factions.factionlog', ['logs' => $logs,'logname' => 'Fraktionslog']);
        }
    }

    public function weaponLog()
    {
        if (Auth::check()) {
            $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
            if ($character->faction <= 0 && $character->rang < 10) return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
            $logs = DB::table('logs')->where('loglabel', 'weapon-' . $character->faction)->orderBy('timestamp', 'desc')->limit(215)->get();
            $logname = "Waffenkammerlog";
            if ($character->faction > 1) $logname = "Lagerlog";
            return view('layouts.factions.factionlog', ['logs' => $logs,'logname' => $logname]);
        }
    }

    public function govmoneyLog()
    {
        if (Auth::check()) {
            $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
            if ($character->faction != 4 || $character->rang < 10) return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
            $logs = DB::table('logs')->where('loglabel', 'govmoney')->orderBy('timestamp', 'desc')->limit(215)->get();
            return view('layouts.factions.factionlog', ['logs' => $logs,'logname' => 'Staatskassenlog']);
        }
    }

    public function asservatenKammerLog()
    {
        if (Auth::check()) {
            $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
            if ($character->faction <= 0 && $character->rang < 10) return redirect::to('/faction')->with('error', 'Keine Berechtigung!');
            $logs = DB::table('logs')->where('loglabel', 'evidence')->orderBy('timestamp', 'desc')->limit(215)->get();
            return view('layouts.factions.factionlog', ['logs' => $logs,'logname' => 'Asservatenkammerlog']);
        }
    }

    public function factionCars()
    {
        if (Auth::check()) {
            $faction = DB::table('characters')->where('userid', Auth::user()->id)->value('faction');
            if ($faction <= 0) return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            $count = DB::table('vehicles')->where('owner', 'faction-' . $faction)->count();
            if (!$count || $count <= 0) return redirect::to('/faction')->with('error', 'Keine Fraktionsfahrzeuge vorhanden!');
            $vehicles = DB::table('vehicles')->where('owner', 'faction-' . $faction)
                ->get();
            return view('cars', ['vehicles' => $vehicles]);
        }
    }
}
