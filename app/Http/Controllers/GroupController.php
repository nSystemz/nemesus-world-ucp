<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

//FactionsController für sämtliche Fraktionsfunktionen
class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkbanned');
        $this->middleware('2fa')->except('signOut');
    }

    public function getGroups()
    {
        if (Auth::check()) {
            $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
            if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
            $mygroup = DB::table('groups_members')->where('groupsid', $group_id)->where('charid', Auth::user()->selectedcharacterintern)->first();
            if ($mygroup) {
                $characters = DB::table('groups_members')->where('groupsid', $group_id)->orderBy('rang', 'desc')->get();
                $members = DB::table('groups_members')->where('groupsid', $group_id)
                    ->count();
                $dutytime = DB::table('groups_members')->where('groupsid', $group_id)
                    ->sum('duty_time');
                $group = DB::table('groups')->where('id', $group_id)->first();
                $cars = DB::table('vehicles')->where('owner', 'group-' . $group_id)->count();
                return view('layouts.groups.groups', ['characters' => $characters, 'members' => $members, 'dutytime' => $dutytime, 'group' => $group, 'cars' => $cars, 'mygroup' => $mygroup]);
            } else {
                return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung!');
            }
        }
    }

    public function groupCars()
    {
        if (Auth::check()) {
            $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
            if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
            $count = DB::table('vehicles')->where('owner', 'group-' . $group_id)->count();
            if (!$count || $count <= 0) return redirect::to('/groups')->with('error', 'Keine Gruppierungsfahrzeuge vorhanden!');
            $vehicles = DB::table('vehicles')->where('owner', 'group-' . $group_id)
                ->get();
            return view('cars', ['vehicles' => $vehicles]);
        }
    }

    public function groupLogs()
    {
        if (Auth::check()) {
            $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
            if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
            $group = DB::table('groups_members')
                ->where('groupsid', '=', $group_id)
                ->where('charid', '=', Auth::user()->selectedcharacterintern)
                ->first();
            if (!$group || $group->rang < 10) return redirect::to('/groups')->with('error', 'Keine Berechtigung!' . $group_id);
            $logs = DB::table('logs')->where('loglabel', 'group-' . $group_id)->orderBy('timestamp', 'desc')->limit(215)->get();
            return view('layouts.groups.grouplogs', ['logs' => $logs]);
        }
    }

    public function groupMoneyLog()
    {
        if (Auth::check()) {
            $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
            if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
            $group = DB::table('groups_members')
                ->where('groupsid', '=', $group_id)
                ->where('charid', '=', Auth::user()->selectedcharacterintern)
                ->first();
            if (!$group || $group->rang < 10) return redirect::to('/groups')->with('error', 'Keine Berechtigung!' . $group_id);
            $logs = DB::table('logs')->where('loglabel', 'groupmoney-' . $group_id)->orderBy('timestamp', 'desc')->limit(215)->get();
            return view('layouts.groups.grouplogs', ['logs' => $logs]);
        }
    }

    public function groupMoney(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->bookId) && is_numeric($request->payday) && $request->payday >= 0 && $request->payday <= 9999 && $request->money >= 0 && $request->money <= 999999 && is_numeric($request->money)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->bookId)->first();
                if (!$character || !$findcharacter) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
                if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
                if ($request->money < 0 || $request->payday < 0) return redirect::to('/home')->with('error', 'Ungültige Eingabe!');
                $groupleader = DB::table('groups')
                    ->where('id', '=', $group_id)
                    ->value('leader');
                $group = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', Auth::user()->selectedcharacterintern)
                    ->first();
                $group2 = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', $request->bookId)
                    ->first();
                if (!$group2) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!' . $findcharacter->name);
                if (!$group || $group->rang < 10) return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                if (($group->rang > $group2->rang && $group->rang != $groupleader) || $group->charid == $groupleader) {
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    $logtext = $character->name . " hat den Lohn von " . $findcharacter->name . " auf " . $request->money . "$ für jeden " . $request->payday . "ten Payday gesetzt!";
                    DB::table('logs')->insert(array('loglabel' => "group-" . $group_id, 'text' => $logtext, 'timestamp' => time()));
                    DB::table('groups_members')->where('groupsid', '=', $group_id)
                        ->where('charid', '=', $findcharacter->id)
                        ->where('groupsid', '=', $group_id)
                        ->update(['payday' => $request->money, 'payday_day' => $request->payday]);
                    return redirect::to('/groups')->with('success', 'Der Lohn für den Spieler wurde erfolgreich eingestellt!');
                } else {
                    return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function groupUpRank(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                if (!$character || !$findcharacter) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
                if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
                $groupleader = DB::table('groups')
                    ->where('id', '=', $group_id)
                    ->value('leader');
                $group = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', Auth::user()->selectedcharacterintern)
                    ->first();
                $group2 = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', $request->id)
                    ->first();
                if (!$group2) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!' . $findcharacter->name);
                if (!$group || $group->rang < 10) return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                if (($group->rang > $group2->rang && $group->rang != $groupleader) || $group->charid == $groupleader) {
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    $newrang = $group2->rang + 1;
                    if ($newrang > 12) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                    $logtext = $character->name . " hat " . $findcharacter->name . " befördert - (Neuer Rang: " . $newrang . ")!";
                    DB::table('logs')->insert(array('loglabel' => "group-" . $group_id, 'text' => $logtext, 'timestamp' => time()));
                    DB::table('groups_members')->where('groupsid', '=', $group_id)
                        ->where('charid', '=', $findcharacter->id)
                        ->where('groupsid', '=', $group_id)
                        ->update(['rang' => $newrang]);
                    return redirect::to('/groups')->with('success', 'Der Spieler wurde erfolgreich befördert!');
                } else {
                    return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function groupDownRank(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                if (!$character || !$findcharacter) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
                if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
                $groupleader = DB::table('groups')
                    ->where('id', '=', $group_id)
                    ->value('leader');
                $group = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', Auth::user()->selectedcharacterintern)
                    ->first();
                $group2 = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', $request->id)
                    ->first();
                if (!$group2) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                if (!$group || $group->rang < 10) return redirect::to('/groups')->with('error', 'Keine Berechtigung!' . $group_id);
                if (($group->rang > $group2->rang && $group->rang != $groupleader) || $group->charid == $groupleader) {
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    $newrang = $group2->rang - 1;
                    if ($newrang <= 0) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                    $logtext = $character->name . " hat " . $findcharacter->name . " degradiert - (Neuer Rang: " . $newrang . ")!";
                    DB::table('logs')->insert(array('loglabel' => "group-" . $group_id, 'text' => $logtext, 'timestamp' => time()));
                    DB::table('groups_members')->where('groupsid', '=', $group_id)
                        ->where('charid', '=', $findcharacter->id)
                        ->where('groupsid', '=', $group_id)
                        ->update(['rang' => $newrang]);
                    return redirect::to('/groups')->with('success', 'Der Spieler wurde erfolgreich degradiert!');
                } else {
                    return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function groupKick(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                if (!$character || !$findcharacter) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
                if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
                $groupleader = DB::table('groups')
                    ->where('id', '=', $group_id)
                    ->value('leader');
                $group = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', Auth::user()->selectedcharacterintern)
                    ->first();
                $group2 = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', $request->id)
                    ->first();
                if (!$group2) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                if (!$group || $group->rang < 10) return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                if (($group->rang > $group2->rang && $group->rang != $groupleader) || $group->charid == $groupleader) {
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    if ($group->charid == $groupleader) return Redirect::back()->with('error', 'Der Leader kann nicht rausgeworfen werden!');
                    $logtext = $character->name . " hat " . $findcharacter->name . " aus der Gruppierung rausgeworfen!";
                    DB::table('logs')->insert(array('loglabel' => "group-" . $group_id, 'text' => $logtext, 'timestamp' => time()));
                    $text = "Gruppierung ".$group->name. "verlassen";
                    DB::table('timeline')->insert(array('userid' => $findcharacter->userid, 'charid' => $findcharacter->id, 'text' => $text, 'icon' => 4, 'timestamp' => time()));
                    DB::table('groups_members')->where('groupsid', '=', $group_id)
                        ->where('charid', '=', $findcharacter->id)
                        ->where('groupsid', '=', $group_id)
                        ->delete();
                    DB::table('characters')->where('mygroup', '=', $group_id)
                        ->where('id', '=', $findcharacter->id)
                        ->update(['mygroup' => -1]);
                    return redirect::to('/groups')->with('success', 'Der Spieler wurde erfolgreich aus der Gruppierung geworfen!');
                } else {
                    return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                }
            }
            return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function groupLeader(Request $request)
    {
        if (Auth::check()) {
            if (is_numeric($request->id)) {
                $character = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->first();
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                if (!$character || !$findcharacter) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                $group_id = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('mygroup');
                if (!$group_id || $group_id <= 0) return redirect::to('/home')->with('error', 'Du bist in keiner Gruppierung oder hast keine aktiv ausgewählt!');
                $groupleader = DB::table('groups')
                    ->where('id', '=', $group_id)
                    ->value('leader');
                $group = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', Auth::user()->selectedcharacterintern)
                    ->first();
                $group2 = DB::table('groups_members')
                    ->where('groupsid', '=', $group_id)
                    ->where('charid', '=', $request->id)
                    ->first();
                if (!$group2) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                if (!$group || $group->charid != $groupleader) return redirect::to('/groups')->with('error', 'Keine Berechtigung!');
                $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                if ($findcharacter->id == $groupleader) return Redirect::back()->with('error', 'Der Spieler ist schon Leader der Gruppierung!');
                $logtext = $character->name . " hat " . $findcharacter->name . " zum Leader der Gruppierung gemacht!";
                DB::table('logs')->insert(array('loglabel' => "group-" . $group_id, 'text' => $logtext, 'timestamp' => time()));
                DB::table('groups_members')->where('groupsid', '=', $group_id)
                    ->where('charid', '=', $findcharacter->id)
                    ->where('groupsid', '=', $group_id)
                    ->update(['rang' => 12]);
                DB::table('groups')->where('id', '=', $group_id)
                    ->update(['leader' => $findcharacter->id]);
                return redirect::to('/groups')->with('success', 'Der Spieler wurde erfolgreich zum Leader der Gruppierung gemacht!');
            }
            return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function setGroup($groupid = null)
    {
        if (Auth::check()) {
            if (!$groupid || !is_numeric($groupid) || $groupid == -1) return Redirect::back()->with('error', 'Ungültige Interaktion!');

            $check = DB::table('groups_members')->where('charid', Auth::user()
                ->selectedcharacterintern)->where('groupsid', $groupid)
                ->first();

            $character = DB::table('characters')->where('id', Auth::user()
                ->selectedcharacterintern)->first();

            if($character && $character->mygroup == $groupid) return Redirect::back()->with('error', 'Du hast diese Gruppierung bereits ausgewählt!');

            if (!$check || !$character) return Redirect::back()->with('error', 'Ungültige Interaktion!');

            if (Auth::user()->online == 1) return Redirect::back()->with('error', 'Du bist nicht offline!');

            DB::table('characters')->where('id', Auth::user()
                ->selectedcharacterintern)
                ->update(['mygroup' => $groupid]);

            return Redirect::back()->with('success', 'Gruppierungswechsel erfolgreich!');
        }
    }
}
