<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\HTMLToMarkdown\HtmlConverter;

setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

//AdminController für alle Adminfunktionen
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkbanned');
        $this->middleware('2fa')->except('signOut');
    }

    public static function checkAdminLogin()
    {
        if (!session('nemesusworlducp_adminlogin') || !Hash::check('tWL<Z,(Us45mVZ,Ef{Lm$PbS:', session('nemesusworlducp_adminlogin')) || Auth::user()->adminlevel <= FunctionsController::Kein_Admin /*|| Auth::user()->google2fa_secret == null*/) {
            session()->forget('nemesusworlducp_adminlogin');
            session()->forget('google2fa');
            return false;
        }
        return true;
    }

    public function adminGroups($groupid = -1)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (!empty($groupid) && is_numeric($groupid) && strlen($groupid) >= 1 && strlen($groupid) <= 11 && $groupid != -1) {
                    $checkgroup = DB::table('groups')->where('id', $groupid)->first();
                    if ($checkgroup) {
                        $characters = DB::table('groups_members')->where('groupsid', $groupid)->orderBy('rang', 'desc')->get();
                        $members = DB::table('groups_members')->where('groupsid', $groupid)
                            ->count();
                        $dutytime = DB::table('groups_members')->where('groupsid', $groupid)
                            ->sum('duty_time');
                        $cars = DB::table('vehicles')->where('owner', 'group-' . $groupid)->count();
                        return view('layouts.admin.admingroups', ['characters' => $characters, 'members' => $members, 'dutytime' => $dutytime, 'group' => $checkgroup, 'cars' => $cars]);
                    } else {
                        return redirect::to('/home')->with('error', 'Ungültige Gruppierung!');
                    }
                } else {
                    return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
                }
            }
        }
    }

    public function selectGroups()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $group = DB::table('groups')->get();
                return view('layouts.admin.selectGroups', ['group' => $group]);
            }
        }
    }

    public function adminGroupCars($id)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $group_id = DB::table('groups')->where('id', $id)->value('id');
                if (!$group_id || $group_id <= 0) return redirect::to('/selectGroups')->with('error', 'Ungültige Interaktion!');
                $count = DB::table('vehicles')->where('owner', 'group-' . $group_id)->count();
                if (!$count || $count <= 0) return redirect::to('/selectGroups')->with('error', 'Keine Gruppierungsfahrzeuge vorhanden!');
                $vehicles = DB::table('vehicles')->where('owner', 'group-' . $group_id)
                    ->get();
                return view('cars', ['vehicles' => $vehicles]);
            }
        }
    }

    public function adminCars($id=-1)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!is_numeric($id) || $id == -1) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $count = DB::table('vehicles')->where('owner', 'character-' . $id)
                    ->count();
                if (!$count || $count <= 0) return redirect::to('/home')->with('error', 'Keine Fahrzeuge vorhanden!');
                $vehicles = DB::table('vehicles')->where('owner', 'character-' . $id)
                    ->get();
                return view('cars', ['vehicles' => $vehicles]);
            }
        }
    }

    public function adminFactions($factionid = -1)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (!empty($factionid) && is_numeric($factionid) && strlen($factionid) >= 1 && strlen($factionid) <= 11 && $factionid != -1) {
                    $factions = DB::table('factions')->where('id', $factionid)->first();
                    if(!$factions) return redirect::to('/home')->with('error', 'Ungültige Fraktion!');
                    $characters = DB::table('characters')->where('faction', $factionid)->orderBy('rang', 'desc')->get();
                    $members = DB::table('characters')->where('faction', $factionid)
                        ->count();
                    $dutytime = DB::table('characters')->where('faction', $factionid)
                        ->sum('faction_dutytime');
                    $faction = DB::table('factions')->where('id', $factionid)->first();
                    $cars = DB::table('vehicles')->where('owner', 'faction-' . $factionid)->count();
                    return view('layouts.admin.adminFactions', ['characters' => $characters, 'members' => $members, 'dutytime' => $dutytime, 'faction' => $faction, 'cars' => $cars, 'checkfaction' => $factionid]);
                }
                else
                {
                    return redirect::to('/home')->with('error', 'Ungültige Fraktion!');
                }
            }
        }
    }

    public function adminFactionLeader(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (is_numeric($request->id) && is_numeric($request->factionid)) {
                    if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                    $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                    if (!$findcharacter) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $factionid = $request->factionid;
                    if (!$factionid || $factionid <= 0 || empty($factionid)) return redirect::to('/home')->with('error', 'Ungültige Fraktion!');
                    $faction = DB::table('factions')
                        ->where('id', '=', $factionid)
                        ->first();
                    if (!$faction || $findcharacter->faction != $faction->id) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    if ($faction->leader == $findcharacter->id) return Redirect::back()->with('error', 'Der Spieler ist schon Leader der Gruppierung!');
                    $logtext = Auth::user()->name . " hat " . $findcharacter->name . " administrativ zum Leader der Fraktion gemacht!";
                    DB::table('logs')->insert(array('loglabel' => "faction-" . $factionid, 'text' => $logtext, 'timestamp' => time()));
                    $logtext = Auth::user()->name . " hat " . $findcharacter->name . " administrativ aus zum Leader der Fraktion " . $faction->name . " gemacht!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    DB::table('characters')->where('id', '=', $request->id)
                        ->update(['rang' => 12]);
                    DB::table('factions')->where('id', '=', $factionid)
                        ->update(['leader' => $findcharacter->id]);
                    return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich administrativ zum Leader der Fraktion gemacht!');
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!' . $request->id);
            }
        }
    }

    public function adminFactionName(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                $id = $request->bookId;
                $name = $request->name;
                $tag = $request->tag;
                if (!empty($name) && !is_numeric($name) && strlen($name) >= 5 && strlen($name) <= 128 && !empty($tag) && !is_numeric($tag) && strlen($tag) >= 2 && strlen($tag) <= 10 && !empty($id) && is_numeric($id) && strlen($id) >= 1 && strlen($id) <= 11) {
                    if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                    $faction = DB::table('factions')->where('id', $id)->first();
                    if(!$faction) return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
                    $factionnamecheck = DB::table('factions')->where('name', $name)->orwhere('tag', $tag)->first();
                    if($factionnamecheck && $factionnamecheck->id != $faction->id) return Redirect::back()->with('success', 'Der Fraktionsname oder das Kürzel sind bereits in Benutzung!');
                    $logtext = "Der Fraktionsname wurde administrativ auf " . $name ." geändert!";
                    DB::table('logs')->insert(array('loglabel' => "faction-" . $faction->id, 'text' => $logtext, 'timestamp' => time()));
                    $logtext = Auth::user()->name . " hat den Fraktionsnamen der Fraktion " . $faction->name . " auf " . $name ." geändert!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    DB::table('factions')->where('id', '=', $faction->id)
                        ->update(['name' => $name,'tag' => $tag]);
                    return Redirect::back()->with('success', 'Der Fraktionsname wurde erfolgreich angepasst!');
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!' . $request->id);
            }
        }
    }

    public function adminFactionKick(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (is_numeric($request->id) && is_numeric($request->factionid)) {
                    if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                    $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                    if (!$findcharacter) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $factionid = $request->factionid;
                    if (!$factionid || $factionid <= 0 || empty($factionid)) return redirect::to('/home')->with('error', 'Ungültige Fraktion!');
                    $faction = DB::table('factions')
                        ->where('id', '=', $factionid)
                        ->first();
                    if (!$faction || $findcharacter->faction != $faction->id) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    $logtext = Auth::user()->name . " hat " . $findcharacter->name . " administrativ aus der Fraktion rausgeworfen!";
                    DB::table('logs')->insert(array('loglabel' => "faction-" . $factionid, 'text' => $logtext, 'timestamp' => time()));
                    $logtext = Auth::user()->name . " hat " . $findcharacter->name . " administrativ aus der Fraktion " . $faction->name . " rausgeworfen!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    DB::table('characters')->where('faction', '=', $factionid)
                        ->where('id', '=', $findcharacter->id)
                        ->update(['faction' => 0,'rang' => 0,'faction_dutytime' => 0,'faction_since' => time(),'swat' => 0]);
                    if ($faction->leader == $findcharacter->id) {
                        DB::table('factions')
                            ->where('id', '=', $factionid)
                            ->update(['leader' => -1]);
                    }
                    return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich administrativ aus der Fraktion geworfen!');
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!');
            }
        }
    }

    public function selectFactions()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $factions = DB::table('factions')->get();
                return view('layouts.admin.selectFactions', ['factions' => $factions]);
            }
        }
    }

    public function adminGroupLeader(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (is_numeric($request->id) && is_numeric($request->groupid)) {
                    if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                    $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                    if (!$findcharacter) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $group_id = $request->groupid;
                    if (!$group_id || $group_id <= 0 || empty($group_id)) return redirect::to('/home')->with('error', 'Ungültige Gruppierung!');
                    $group2 = DB::table('groups_members')
                        ->where('groupsid', '=', $group_id)
                        ->where('charid', '=', $request->id)
                        ->first();
                    $group = DB::table('groups')
                        ->where('id', '=', $group_id)
                        ->first();
                    if (!$group2) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    if ($group->leader == $findcharacter->id) return Redirect::back()->with('error', 'Der Spieler ist schon Leader der Gruppierung!');
                    $logtext = Auth::user()->name . " hat " . $findcharacter->name . " administrativ zum Leader der Gruppierung gemacht!";
                    DB::table('logs')->insert(array('loglabel' => "group-" . $group_id, 'text' => $logtext, 'timestamp' => time()));
                    $logtext = Auth::user()->name . " hat " . $findcharacter->name . " administrativ aus zum Leader der Gruppierung " . $group->name . " gemacht!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    DB::table('groups_members')->where('groupsid', '=', $group_id)
                        ->where('charid', '=', $findcharacter->id)
                        ->update(['rang' => 12]);
                    DB::table('groups')->where('id', '=', $group_id)
                        ->update(['leader' => $findcharacter->id]);
                    return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich administrativ zum Leader der Gruppierung gemacht!');
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!' . $request->id);
            }
        }
    }


    public function adminGroupKick(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (is_numeric($request->id) && is_numeric($request->groupid)) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $findcharacter = DB::table('characters')->where('id', $request->id)->first();
                if (!$findcharacter) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                $groupleader = DB::table('groups')
                    ->where('id', '=', $request->groupid)
                    ->value('leader');
                $group = DB::table('groups_members')
                    ->where('groupsid', '=',$request->groupid)
                    ->where('charid', '=', $request->id)
                    ->first();
                $group2 = DB::table('groups_members')
                    ->where('groupsid', '=', $request->groupid)
                    ->where('charid', '=', $request->id)
                    ->first();
                $realgroup = DB::table('groups')
                    ->where('id', '=', $request->groupid)
                    ->first();
                if (!$group2) return redirect::to('/groups')->with('error', 'Ungültige Interaktion!');
                    $online = DB::table('users')->where('id', $findcharacter->userid)->value('online');
                    if ($online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                    if ($group->charid == $groupleader) return Redirect::back()->with('error', 'Der Leader kann nicht rausgeworfen werden!');
                    $logtext = $findcharacter->name . " wurde administrativ aus der Gruppierung geworfen!";
                    DB::table('logs')->insert(array('loglabel' => "group-" . $request->groupid, 'text' => $logtext, 'timestamp' => time()));
                    $logtext = Auth::user()->name . " hat " . $findcharacter->name . " administrativ aus der Gruppierung " . $realgroup->name . " geworfen!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    $text = "Gruppierung ".$realgroup->name. " verlassen";
                    DB::table('timeline')->insert(array('userid' => $findcharacter->userid, 'charid' => $findcharacter->id, 'text' => $text, 'icon' => 4, 'timestamp' => time()));
                    DB::table('groups_members')->where('groupsid', '=', $request->groupid)
                        ->where('charid', '=', $findcharacter->id)
                        ->where('groupsid', '=', $request->groupid)
                        ->delete();
                    DB::table('characters')->where('mygroup', '=', $request->groupid)
                        ->where('id', '=', $findcharacter->id)
                        ->update(['mygroup' => -1]);
                    return redirect::to('/groups')->with('success', 'Der Spieler wurde erfolgreich administrativ aus der Gruppierung geworfen!');
            }
            return Redirect::back()->with('error', 'Ungültige Interaktion!' . $request->id);
        }
    }
}

    public function adminLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
            if (session('nemesusworlducp_adminlogin')) {
                session()->forget('nemesusworlducp_failedadminlogin');
                session()->forget('nemesusworlducp_lasttry');
                return redirect::to('/adminDashboard');
            }
            return view('layouts.admin.adminlogin');
        }
    }

    public function adminSettings()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::High_Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (session('nemesusworlducp_adminlogin')) {
                    return view('layouts.admin.adminsettings');
                }
            }
        }
        return redirect::to('/adminLogin')->with('success', 'Adminlogout erfolgreich!');
    }

    public function adminLogout()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (session('nemesusworlducp_adminlogin')) {
                    session()->forget('nemesusworlducp_adminlogin');
                    return redirect::to('/adminLogin')->with('success', 'Adminlogout erfolgreich!');
                }
            }
        }
        return redirect::to('/adminLogin')->with('success', 'Adminlogout erfolgreich!');
    }

    public function deleteUserakte(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $id = $request->id;
                if (!empty($id) && is_numeric($id) && strlen($id) >= 1 && strlen($id) <= 11) {
                    $userfile = DB::table('userfile')->where('id',  $id)->first();
                    if (!$userfile) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $admin = DB::table('users')->select('adminlevel', 'name')->where('id',  $userfile->userid)->first();
                    if (!$admin) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    if (Auth::user()->adminlevel >= $admin->adminlevel) {
                        DB::table('userfile')->where('id', '=', $id)->delete();
                        $logtext = Auth::user()->name . " hat den Userakteneintrag '" . $userfile->text . "' von " . $admin->name . " gelöscht!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        return Redirect::back()->with('success', 'Userakteneintrag erfolgreich gelöscht!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                } else {
                    return Redirect::back()->with('error', 'Ungültige Interaktion!');
                }
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function searchShowAdmin($id)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (!empty($id) && is_numeric($id) && strlen($id) >= 1 && strlen($id) <= 11) {
                    $realid = $id - 99;
                    $character = DB::table('characters')->where('id', $realid)->first();
                    if ($character) {
                        $user = DB::table('users')->where('id', $character->userid)->first();
                        if ($user->dsgvo_closed == 1 && Auth::user()->adminlevel < FunctionsController::High_Administrator) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        $userfile = DB::table('userfile')->where('userid', $character->userid)->orderBy('timestamp', 'desc')->limit(50)->get();
                        $timeline = DB::table('timeline')->where('userid', $character->userid)->orderBy('id', 'desc')->get();
                        $inaktiv = DB::table('inactiv')->where('userid',  $character->userid)->first();
                        $screens = DB::table('screenshots')->where('userid',  $character->userid)->where('screenname',  'not like', "Char-%")->orderBy('timestamp', 'desc')->limit(15)->get();
                        $namechanges = DB::table('namechanges')->where('userid', $character->userid)
                            ->orderBy('timestamp', 'desc')
                            ->limit(50)
                            ->get();
                        $userlog = DB::table('userlog')->where('userid', $character->userid)
                            ->orderBy('timestamp', 'desc')
                            ->limit(50)
                            ->get();
                        $groups = DB::table('groups_members')->where('charid', $character->id)
                            ->get();
                        $chars = DB::table('characters')->where('userid', $character->userid)->get();
                        $tickets = DB::table('tickets')->where('admin', $character->userid)->where('status','>', 0)->selectRaw('timestamp >= UNIX_TIMESTAMP(DATE(NOW() - INTERVAL 21 DAY)')->count();
                        return view('layouts.admin.searchshowadmin', ['characters' => $character, 'timeline' => $timeline, 'user' => $user, 'inaktiv' => $inaktiv, 'userfile' => $userfile, 'chars' => $chars, 'userlog' => $userlog, 'namechanges' => $namechanges, 'groups' => $groups, 'tickets' => $tickets, 'screens' => $screens]);
                    } else {
                        return redirect('/home')->with('error', 'Ungültige Interaktion!');
                    }
                } else {
                    return redirect('/home')->with('error', 'Ungültige Interaktion!');
                }
            } else {
                return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
            }
        }
    }

    public function adminLogs()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (session('nemesusworlducp_adminlogin')) {
                    $alllogs = DB::table('adminlogs')->select('loglabel')->distinct()->get();
                    return view('layouts.admin.adminlogs', ['logs' => null, 'alllogs' => $alllogs]);
                }
            } else {
                return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
            }
        }
    }

    public function setLog($logname)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if(empty($logname) || is_numeric($logname)) return redirect::back()->with('error', 'Ungültiger Log!');
                if (Auth::user()->adminlevel <= FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (str_contains($logname, 'faction-') || str_contains($logname, 'group-') || str_contains($logname, 'groupmoney-') || str_contains($logname, 'govmoney') || str_contains($logname, 'weapon-'))
                {
                    $alllogs = DB::table('logs')->where('loglabel',$logname)->orderBy('timestamp', 'desc')->get();
                    if(!$alllogs) return redirect::back()->with('error', 'Ungültiger Log!');
                    if(str_contains($logname, 'group-') || str_contains($logname, 'groupmoney-'))
                    {
                        return view('layouts.groups.grouplogs', ['logs' => $alllogs]);
                    }
                    else
                    {
                        if (str_contains($logname, 'faction-'))
                        {
                            $logn = 'Fraktionslog';
                        }
                        else if (str_contains($logname, 'weapon-'))
                        {
                            if($logname == 'weapon-2' || $logname == 'weapon-3' || $logname == 'weapon-4')
                            {
                                $logn = 'Lagerlog';
                            }
                            else
                            {
                                $logn = 'Waffenkammerlog';
                            }
                        }
                        else
                        {
                            $logn = 'Staatskassenlog';
                        }
                        return view('layouts.factions.factionlog', ['logname' => $logn, 'logs' => $alllogs]);
                    }
                }
                else
                {
                    return redirect::back()->with('error', 'Ungültiger Log!');
                }
            } else {
                return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
            }
        }
    }

    public function adminChangePassword(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::High_Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (session('nemesusworlducp_adminlogin')) {
                    if (!empty($request->input('password')) && strlen($request->input('password')) >= 6 && strlen($request->input('password')) <= 35) {
                        $logtext = Auth::user()->name . " hat das Adminpasswort geändert!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        DB::table('adminsettings')->where('id', 1)->update(['adminpassword' => Hash::make($request->input('password')."(8wgwWoRld136=")]);
                        return redirect::to('/adminSettings')->with('success', 'Adminpasswort erfolgreich geändert!');
                    }
                    return Redirect::back()->with('error', 'Ungültiges Adminpasswort!');
                }
            } else {
                return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
            }
        }
    }

    public function adminGetPayday(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Administrator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (session('nemesusworlducp_adminlogin'))
                {
                    if (!empty($request->input('payday')))
                    {
                        $payday = DB::table('paydays')->where('id', $request->input('payday'))->first();
                        if($payday)
                        {
                            $paydaylist = json_decode($payday->text);
                            return view('layouts.admin.showPaydays', ['payday' => $payday,'paydaylist' => $paydaylist]);
                        }
                        else
                        {
                            return Redirect::back()->with('error', 'Ungültige Payday ID!');
                        }
                    }
                    return Redirect::back()->with('error', 'Ungültige Payday ID!');
                }
            } else {
                return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
            }
        }
    }

    public function searchAdminLogs(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->adminlevel <= FunctionsController::Probe_Moderator) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
            if (!empty($request->log) && strlen($request->log) > 3 && strlen($request->log) <= 35) {
                return redirect()->route('getAdminLogs', ['log' => $request->log]);
            }
            return Redirect::to('/adminlogs')->with('error', 'Ungültiger Log!');
        }
    }

    public function getAdminLogs(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (session('nemesusworlducp_adminlogin')) {
                    $log = $request->log;
                    if (!empty($log) && strlen($log) >= 3 && strlen($log) <= 35) {
                        $count = DB::table('adminlogs')->where('loglabel', $log)->count();
                        if (!$count || $count <= 0) return redirect::to('/adminLogs')->with('error', 'Ungültiger Log!');
                        $alllogs = DB::table('adminlogs')->select('loglabel')->distinct()->get();
                        $logs = DB::table('adminlogs')->where('loglabel', $log)->limit(150)->orderBy('timestamp', 'desc')->get();
                        $adminlogsnames = DB::table('adminlogsnames')->where('loglabel', $log)->first();
                        if (!$adminlogsnames) {
                            $name = 'n/A Log';
                            $rang = 1;
                            $checkip = 0;
                            $miscellaneous = 0;
                        } else {
                            $name = $adminlogsnames->name;
                            $rang =  $adminlogsnames->rang;
                            $checkip =  $adminlogsnames->checkip;
                            $miscellaneous =  $adminlogsnames->miscellaneous;
                        }
                        if (Auth::user()->adminlevel >= $rang) {
                            return view('layouts.admin.adminlogs', ['logs' => $logs, 'alllogs' => $alllogs, 'logname' => $name, 'checkip' => $checkip, 'miscellaneous' => $miscellaneous]);
                        } else {
                            return redirect::to('/adminLogs')->with('error', 'Keine Berechtigung!');
                        }
                    }
                    return redirect::to('/adminLogs')->with('error', 'Ungültiger Log!');
                }
            } else {
                return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
            }
        }
    }

    public function adminAccountSearchUser(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (!empty($request->search) && strlen($request->search) >= 3 && strlen($request->search) <= 35) {
                    return redirect()->route('adminAccountSearch', ['search' => $request->search]);
                }
                return Redirect::to('/adminDashboard');
            }
        }
    }


    public function adminNamechanges($search)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel < FunctionsController::Moderator) return redirect::to('/adminDashboard')->with('error', 'Keine Berechtigung!');
                if (!empty($search) && strlen($search) >= 3 && strlen($search) <= 35) {
                    $namechanges = DB::table('namechanges')->where('newname', $search)->orwhere('oldname', $search)->orderBy('timestamp', 'desc')->limit(15)->get();
                    if ($namechanges) {
                        return view('layouts.admin.namechanges', ['namechanges' => $namechanges]);
                    }
                }
                return Redirect::to('/adminDashboard')->with('error', 'Ungültige Interaktion!');
            }
        }
    }

    public function adminAccountSearchUserOld(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (str_contains($request->search, 'SELECT') || str_contains($request->search, 'UPDATE') || str_contains($request->search, 'DELETE') || str_contains($request->search, 'DROP') || str_contains($request->search, 'TRUNCATE')) {
                    abort(403);
                }
                if (Auth::user()->adminlevel < FunctionsController::Moderator) return redirect::to('/adminDashboard')->with('error', 'Keine Berechtigung!');
                if (!empty($request->search) && strlen($request->search) >= 3 && strlen($request->search) <= 35) {
                    return Redirect::route('adminNamechanges', [$request->search]);
                }
                return Redirect::back()->with('error', 'Keinen Account oder Charakter gefunden!');
            }
        }
    }

    public function adminAccountSearch(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $search = $request->search;
                if (str_contains($request->search, 'SELECT') || str_contains($request->search, 'UPDATE') || str_contains($request->search, 'DELETE') || str_contains($request->search, 'DROP') || str_contains($request->search, 'TRUNCATE')) {
                    abort(403);
                }
                $validator = Validator::make($request->all(), [
                    'search' => 'required|max:35|min:3',
                ]);

                if (!$validator->fails()) {
                    $search = FunctionsController::db_esc_like_raw($search);
                    $countchar = DB::table('users')->where('name', 'like', '%' . $search . '%')->count();
                    if (!$countchar) {
                        $countchar = DB::table('users')->where('id', ((int)$search) - 99)->count();
                    }
                    if (!$countchar || $countchar <= 0) return view('search', ['characters' => null]);
                    $users = DB::table('users')->where('name', 'like', '%' . $search . '%')->orwhere('id', (int)$search - 99)->limit(10)->first();
                    if (!$users) return view('search', ['characters' => null]);
                    $characters = DB::table('characters')->select('name', 'userid', 'id', 'ucp_privat', 'closed', 'screen')->where('userid', '=', $users->id)->limit(10)->get();
                    return view('search', ['characters' => $characters]);
                }
                return view('search', ['characters' => null]);
            }
        }
    }


    public function adminDashboard()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                if (session('nemesusworlducp_adminlogin')) {
                    $users = DB::table('users')->count();
                    $characters = DB::table('characters')->count();
                    $cars = DB::table('vehicles')->count();
                    $bans = DB::table('bans')->count();
                    $logs = DB::table('logs')->count();
                    $ticket1 = DB::table('tickets')->where('status', '>', 1)->count();
                    $ticket2 = DB::table('tickets')->where('status', '<=', 1)->count();
                    $server_created = DB::table('adminsettings')->where('id', 1)->value('server_created');
                    $punishments = DB::table('adminsettings')->where('id', 1)->value('punishments');
                    $admins = DB::table('users')->where('adminlevel', ">", 0)->orderBy('adminlevel', 'desc')->get();
                    $admincount = DB::table('users')->where('adminlevel', ">", 0)->count();
                    return view('layouts.admin.admindashboard', ['users' => $users, 'characters' => $characters, 'cars' => $cars, 'ticket1' => $ticket1, 'ticket2' => $ticket2, 'admins' => $admins, 'admincount' => $admincount, 'server_created' => $server_created, 'bans' => $bans, 'punishments' => $punishments, 'logs' => $logs]);
                }
            } else {
                return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
            }
        }
    }

    public function showInaktiv()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $inaktiv = DB::table('inactiv')->orderBy('date2', 'desc')->get();
                return view('layouts.admin.showinaktiv', ['inaktiv' => $inaktiv]);
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function showItems()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $items = DB::table('globalitems')->where('id', 1)->limit(2500)->first();

                $showitems = json_decode($items->json);

                return view('layouts.admin.showitems', ['items' => $showitems]);
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function showItemList()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $items = DB::table('itemmodels')->limit(550)->orderBy('description', 'asc')->get();
                return view('layouts.admin.showitemlist', ['items' => $items]);
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function showAnimationList()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $animations = DB::table('animations')->limit(250)->orderBy('category', 'asc')->orderBy('name', 'asc')->get();
                return view('layouts.admin.showanimations', ['animations' => $animations]);
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function showFurnitureList()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $furniture = DB::table('furniture')->limit(750)->orderBy('categorie', 'asc')->orderBy('name', 'asc')->get();
                $categories = DB::table('furniturecategories')->limit(50)->orderBy('id', 'asc')->get();
                return view('layouts.admin.showfurniture', ['furniture' => $furniture,'categories' => $categories]);
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    //Changelogs
    public function createChangelog()
    {
        if ($this->checkAdminLogin())
        {
            if (Auth::user()->adminlevel < FunctionsController::Manager) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
            if (Auth::check())
            {
                return view('layouts.admin.createChangelog');
            }
        }
    }

    public function postChangelog(Request $request)
    {
        if ($this->checkAdminLogin()) {
            if (Auth::user()->adminlevel < FunctionsController::Manager) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
            $adminSettings = DB::table('adminsettings')->select('changelogcd')->where('id', 1)->first();
            if (Auth::check()) {
                $datum = date("d.m.Y", time());
                $client = new \GuzzleHttp\Client();
                $textforum = $request->input('summernote');
                $textforum2 = '<center><img src="https://nemesus-world.de/logo.png" style="width:25%"></center><h1 style="color: rgb(49, 143, 211)">Changelog vom '.$datum.'</h1><div class="legendbox" style="outline-style: inset;outline-color: rgb(49, 143, 211);background-color: rgb(51, 54, 58); padding-left: 0.5vw; padding-top: 0.5vw; padding-bottom: 0.5vw">' . $textforum . '</div><br/><p>Das Update wird mit dem nächsten automatischen Restart um 05:30 Uhr auf den Server gespielt!</p>';
                //ToDo: Forum Changelog System einbinden
                $response = $client->get('HIER' . 'Changelog vom '.$datum . '&nachricht=' . $textforum2);

                $discordtext = $request->input('summernote');
                $discordtext = str_replace("<u>", "__", $discordtext);
                $discordtext = str_replace("</u>", "__", $discordtext);
                $converter = new HtmlConverter();
                $markdown = $converter->convert(FunctionsController::replaceUmlaute($discordtext));

                DB::table('adminsettings')->where('id', 1)->update(['changelogcd' => time()+(60*5)]);

                $logtext = Auth::user()->name . " hat einen neuen Changelog gepostet!";
                DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                return Redirect::back()->with('success', 'Der Changelog wurde erstellt!');
            }
        }
    }

    public function adminGeneratePassword(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (Auth::user()->adminlevel >= FunctionsController::Administrator) {
                        $user = DB::table('users')->where('id', $request->input('id'))->first();
                        if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                        $newpassword = FunctionsController::generatePassword(8, 2, 2, true);
                        $newpassword = strval($newpassword);
                        DB::table('userlog')->insert(array('userid' => $user->id, 'action' => 'Passwort administrativ resettet!', 'timestamp' => time()));
                        $logtext = Auth::user()->name . " hat für " . FunctionsController::getUserName($user->id) . " ein neues Passwort generiert!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        DB::table('users')->where('id', $user->id)->update(['password' => Hash::make($newpassword."(8wgwWoRld136=")]);
                        return Redirect::back()->with('success', 'Neues Passwort erfolgreich generiert: ' . $newpassword);
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminSetNameChange(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (Auth::user()->adminlevel >= FunctionsController::Administrator) {
                        $user = DB::table('users')->where('id', $request->input('id'))->first();
                        if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                        if ($user->namechanges >= 5) return Redirect::back()->with('error', 'Der Spieler kann nur max. 5 Namechanges besitzen!');
                        if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                        $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " einen Namechange gegeben!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        $namechanges = DB::table('users')->where('id', $request->input('id'))->value('namechanges');
                        DB::table('users')->where('id', $user->id)->update(['namechanges' =>  $namechanges + 1]);
                        return Redirect::back()->with('success', '+1 Namechange erfolgreich gesetzt!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function deleteForum(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (Auth::user()->adminlevel >= FunctionsController::Supporter) {
                        $user = DB::table('users')->where('id', $request->id)->first();
                        if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                        if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                        if ($user->forumaccount == -1) return Redirect::back()->with('error', 'Der Spieler hat seinen Account mit noch keinem Forenaccount verifiziert!');
                        $logtext = Auth::user()->name . " hat von " . $user->name . " die Forenaccount Verifizierung aufgehoben!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        DB::table('userlog')->insert(array('userid' => $user->id, 'action' => 'Forenaccount Verifizierung administrativ aufgehoben!', 'timestamp' => time()));
                        DB::table('users')->where('id', $user->id)->update(['forumaccount' =>  -1, 'forumcode' =>  0, 'forumupdate' =>  time()]);
                        $client = new \GuzzleHttp\Client();
                        $groupsremove = FunctionsController::GetAllWBBGroups();
                        //ToDo: Forumconnect System einbinden
                        $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=removefromgroups&userid=' . $user->forumaccount . '&groupids=' . $groupsremove);
                        return Redirect::back()->with('success', 'Du hast die Foren Verifizierung erfolgreich aufgehoben!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminSetPrison(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('grund') && !is_numeric($request->input('grund')) && strlen($request->input('grund')) >= 3 && strlen($request->input('grund')) <= 35)) {
                        if (!empty($request->input('checkpoints') && is_numeric($request->input('checkpoints')) && strlen($request->input('checkpoints')) >= 1 && strlen($request->input('checkpoints')) <= 6)) {
                            if (Auth::user()->adminlevel >= FunctionsController::Probe_Moderator) {
                                $user = DB::table('users')->where('id', $request->input('id'))->first();
                                if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                                if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                                if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                                if ($user->prison > 0) return Redirect::back()->with('error', 'Der Spieler befindet sich bereits im Prison!');
                                if (Auth::user()->adminlevel < FunctionsController::Probe_Moderator && strval($request->input('checkpoints')) > 150) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 150 Checkpoints in Prison stecken');
                                if (Auth::user()->adminlevel < FunctionsController::Moderator && strval($request->input('checkpoints')) > 250) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 250 Checkpoints in Prison stecken');
                                if (Auth::user()->adminlevel < FunctionsController::Supporter && strval($request->input('checkpoints')) > 375) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 375 Checkpoints in Prison stecken');
                                if (Auth::user()->adminlevel < FunctionsController::Administrator && strval($request->input('checkpoints')) > 500) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 500 Checkpoints in Prison stecken');
                                if (Auth::user()->adminlevel < FunctionsController::High_Administrator && strval($request->input('checkpoints')) > 1000) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 1000 Checkpoints in Prison stecken');
                                if (Auth::user()->adminlevel < FunctionsController::Manager && strval($request->input('checkpoints')) > 5000) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 5000 Checkpoints in Prison stecken');
                                if (Auth::user()->adminlevel < FunctionsController::Projektleiter && strval($request->input('checkpoints')) > 999999) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 999999 Checkpoints in Prison stecken');
                                DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => $request->input('grund'), 'penalty' => $request->input('checkpoints') . ' Checkpoints', 'timestamp' => time()));
                                $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " für " . $request->input('checkpoints') . " Checkpoints, Grund: " . $request->input('grund') . " ins Prison gesteckt!";
                                DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                                $punishments = DB::table('adminsettings')->where('id', 1)->value('punishments');
                                DB::table('adminsettings')->where('id', 1)->update(['punishments' => $punishments + 1]);
                                DB::table('users')->where('id', $user->id)->update(['prison' => $request->input('checkpoints')]);
                                return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich ins Prison gesetzt!');
                            } else {
                                return Redirect::back()->with('error', 'Keine Berechtigung!');
                            }
                        } else {
                            return Redirect::back()->with('error', 'Ungültige Anzahl an Checkpoints!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Ungültiger Grund!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminBanUser(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('grund') && !is_numeric($request->input('grund')) && strlen($request->input('grund')) >= 3 && strlen($request->input('grund')) <= 35)) {
                        if (!empty($request->input('zeit') && is_numeric($request->input('zeit')) && strlen($request->input('zeit')) >= 1 && strlen($request->input('zeit')) <= 6)) {
                            if (Auth::user()->adminlevel >= FunctionsController::Supporter) {
                                if (strval($request->input('zeit')) < -1) return Redirect::back()->with('error', 'Ungültige Zeitangabe!');
                                $user = DB::table('users')->where('id', $request->input('id'))->first();
                                if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                                if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                                if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                                if ($user->ban > 0) return Redirect::back()->with('error', 'Der Spieler ist bereits gebannt!');
                                if (Auth::user()->adminlevel < FunctionsController::Administrator && strval($request->input('zeit')) > 1440) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 1440 Minuten (1 Tag) bannen!');
                                if (Auth::user()->adminlevel < FunctionsController::High_Administrator && strval($request->input('zeit')) > 10080) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 10080 Minuten (1 Woche) bannen!');
                                if (Auth::user()->adminlevel < FunctionsController::Manager && strval($request->input('zeit')) > 30240) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 30240 Minuten (3 Wochen) bannen!');
                                if (Auth::user()->adminlevel < FunctionsController::Projektleiter && strval($request->input('zeit')) > 525600) return Redirect::back()->with('error', 'Du kannst den Spieler für max. 525600 Minuten (1 Jahr) bannen!');
                                $zeit = "permanent";
                                if ($request->input('zeit') > -1) {
                                    $zeit = "für " . $request->input('zeit') . " " . "Minuten";
                                }
                                $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " " . $zeit . ", Grund: " . $request->input('grund') . " gebannt!";
                                DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                                DB::table('bans')->insert(array('banname' => $user->name, 'banfrom' => Auth::user()->name, 'text' => $request->grund, 'timestamp' => time(), 'ip' => $user->last_ip, 'identifier' => $user->identifier, 'userid' => $user->id));
                                $time = $request->input('zeit');
                                if ($time > -1) {
                                    $time = time() + (60 * $request->input('zeit'));
                                }
                                if ($request->input('zeit') > -1) {
                                    DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => $request->input('grund'), 'penalty' => $request->input('zeit') . ' Minuten Timeban', 'timestamp' => time()));
                                } else {
                                    DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => $request->input('grund'), 'penalty' => 'Permanenter Ban', 'timestamp' => time()));
                                }
                                $punishments = DB::table('adminsettings')->where('id', 1)->value('punishments');
                                DB::table('adminsettings')->where('id', 1)->update(['punishments' => $punishments + 1]);
                                if ($user->forumaccount > -1) {
                                    $forumban = 0;
                                    if ($request->input('zeit') > -1) {
                                        $forumban = (60 * $request->input('zeit'));
                                    }
                                    $client = new \GuzzleHttp\Client();
                                    //ToDo: Forumconnect System einbinden
                                    $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=ban&userid=' . $user->forumaccount . '&grund=' . $request->input('grund') . '&zeit=' . $forumban);
                                }
                                if($time == -1)
                                {
                                    $time = 1;
                                }
                                DB::table('users')->where('id', $user->id)->update(['ban' => $time, 'bantext' => $request->input('grund'), 'remember_token' => null]);
                                return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich gebannt!');
                            } else {
                                return Redirect::back()->with('error', 'Keine Berechtigung!');
                            }
                        } else {
                            return Redirect::back()->with('error', 'Ungültige Zeitangabe!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Ungültiger Grund!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function closeToDSGVO(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {

                    if (Auth::user()->adminlevel >= FunctionsController::High_Administrator) {
                        $user = DB::table('users')->where('id', $request->input('id'))->first();
                        if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                        if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                        if ($user->dsgvo_closed > 0) return Redirect::back()->with('error', 'Der Spieler hat schon eine Sperre nach DSGVO!');
                        if ($user->forumaccount > -1) {
                            $client = new \GuzzleHttp\Client();
                            $groupsremove = FunctionsController::GetAllWBBGroups();
                            //ToDo: Forumconnect System einbinden
                            $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=removefromgroups&userid=' . $user->forumaccount . '&groupids=' . $groupsremove);
                            $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=ban&userid=' . $user->forumaccount . '&grund=Sperre nach DSGVO&zeit=0');
                        }
                        $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " nach der DSGVO gesperrt und alle personenbezogene Daten gelöscht!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        DB::table('users')->where('id', $user->id)->update(['dsgvo_closed' => 1, 'remember_token' => null, 'last_ip' => 'n/A', 'identifier' => 'n/A', 'forumupdate' => time()]);
                        return Redirect::back()->with('success', 'Der Spieler wurde nach DSGVO gesperrt und alle personenbezogenen Daten wurden gelöscht!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function unCloseToDSGVO(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (Auth::user()->adminlevel >= FunctionsController::High_Administrator) {
                        $user = DB::table('users')->where('id', $request->input('id'))->first();
                        if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                        if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                        if ($user->adminlevel > FunctionsController::Kein_Admin) return Redirect::back()->with('error', 'Dem Spieler müssen erst die Adminrechte entzogen werden!');
                        if ($user->dsgvo_closed != 1) return Redirect::back()->with('error', 'Der Spieler keine Sperre nach DSGVO!');
                        $logtext = Auth::user()->name . " hat die DSGVO Sperre von " . FunctionsController::getUserName($user->id) . " aufgehoben!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        if ($user->forumaccount > -1) {
                            $client = new \GuzzleHttp\Client();
                            //ToDo: Forumconnect System einbinden
                            $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=unban&userid=' . $user->forumaccount);
                        }
                        DB::table('users')->where('id', $user->id)->update(['dsgvo_closed' => 0]);
                        return Redirect::back()->with('success', 'Die DSGVO Sperre wurde aufgehoben!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminRemoveAdmin(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {

                    if (Auth::user()->adminlevel >= FunctionsController::High_Administrator) {
                        $user = DB::table('users')->where('id', $request->input('id'))->first();
                        if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        if ($user->adminlevel <= FunctionsController::Kein_Admin) return Redirect::back()->with('error', 'Der Spieler ist kein Admin!');
                        if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                        if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                        $logtext = Auth::user()->name . " hat von " . FunctionsController::getUserName($user->id) . " die " . FunctionsController::getAdminRangName($user->adminlevel, $user->id) . " Adminrechte entfernt!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        DB::table('users')->where('id', $user->id)->update(['adminlevel' => 0]);
                        if ($user->id == Auth::user()->id) {
                            session()->forget('nemesusworlducp_adminlogin');
                            return redirect::to('/home')->with('success', 'Die Adminrechte vom Spieler wurden erfolgreich entfernt!');
                        } else {
                            return Redirect::back()->with('success', 'Die Adminrechte vom Spieler wurden erfolgreich entfernt!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function removeTwoFactor(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {

                    if (Auth::user()->adminlevel >= FunctionsController::High_Administrator) {
                        $user = DB::table('users')->where('id', $request->input('id'))->first();
                        if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                        if ($user->google2fa_secret == null) return Redirect::back()->with('error', 'Der Spieler hat keine Zwei-Faktor-Authentisierung aktiviert!');
                        DB::table('userlog')->insert(array('userid' => $user->id, 'action' => 'Zwei-Faktor-Authentisierung administrativ deaktiviert!', 'timestamp' => time()));
                        $logtext = Auth::user()->name . " hat von " . FunctionsController::getUserName($user->id) . " die Zwei-Faktor-Authentisierung deaktiviert!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        DB::table('users')->where('id', $user->id)->update(['google2fa_secret' => null]);
                        if ($user->id == Auth::user()->id) {
                            return redirect::to('/home')->with('success', 'Zwei-Faktor-Authentisierung erfolgreich deaktiviert!');
                        } else {
                            return Redirect::back()->with('success', 'Zwei-Faktor-Authentisierung erfolgreich deaktiviert!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminRemoveFaction(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {

                    if (Auth::user()->adminlevel >= FunctionsController::Administrator) {
                        $characters = DB::table('characters')->where('id', $request->input('id'))->first();
                        if (!$characters) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        $user = DB::table('users')->where('id', $characters->userid)->first();
                        if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                        if ($characters->faction <= 0) return Redirect::back()->with('error', 'Der Spieler ist in keiner Fraktion!');
                        $logtext = Auth::user()->name . " hat von " . $characters->name . " die Fraktionsrechte (" . FunctionsController::getFraktionsName($user->id) . ") entfernt!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        DB::table('factions')->where('leader', $request->input('id'))->update(['leader' => -1]);
                        DB::table('characters')->where('id', $request->input('id'))->update(['faction' => 0, 'rang' => 0, 'faction_dutytime' => 0, 'faction_since' => time()]);
                        FunctionsController::updateWBBGroups($user);
                        return Redirect::back()->with('success', 'Die Fraktionsrechte vom Spieler wurden erfolgreich entfernt!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminUnbanUser(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('grund') && !is_numeric($request->input('grund')) && strlen($request->input('grund')) >= 3 && strlen($request->input('grund')) <= 35)) {
                        if (Auth::user()->adminlevel >= FunctionsController::Administrator) {
                            $user = DB::table('users')->where('id', $request->input('id'))->first();
                            $ban = DB::table('bans')->where('userid', $user->id)->first();
                            if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                            if (!$ban) return Redirect::back()->with('error', 'Der Spieler ist nicht gebannt!');
                            if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                            if ($user->ban == 0) return Redirect::back()->with('error', 'Der Spieler ist nicht gebannt!');
                            $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " entbannt, Grund: " . $request->input('grund') . "!";
                            DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                            DB::table('bans')->where('id', '=', $user->id)->delete();
                            DB::table('inactiv')->where('userid', '=', $user->id)->delete();
                            DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => $request->input('grund'), 'penalty' => 'Entbannt', 'timestamp' => time()));
                            if ($user->forumaccount > -1) {
                                $client = new \GuzzleHttp\Client();
                                //ToDo: Forumconnect System einbinden
                                $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=unban&userid=' . $user->forumaccount);
                            }
                            DB::table('users')->where('id', $user->id)->update(['ban' => 0, 'bantext' => 'n/A']);
                            return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich entbannt!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Ungültiger Grund!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminWarnUser(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('grund') && !is_numeric($request->input('grund')) && strlen($request->input('grund')) >= 3 && strlen($request->input('grund')) <= 35)) {
                        if (Auth::user()->adminlevel >= FunctionsController::Supporter) {
                            $user = DB::table('users')->where('id', $request->input('id'))->first();
                            if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                            if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                            if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                            if ($user->ban != 0) return Redirect::back()->with('error', 'Der Spieler muss zuerst entbannt werden!');
                            $warncounter = $user->warns;
                            if ($warncounter >= 5) return Redirect::back()->with('error', 'Der Spieler hat die max. Anzahl an Verwarnungen erreicht!');
                            $warncounter = $user->warns + 1;
                            $warns = explode("|", $user->warns_text);
                            if ($warns[0] == 'n/A') {
                                $warns[0] = $request->input('grund');
                            } else if ($warns[1] == 'n/A') {
                                $warns[1] = $request->input('grund');
                            } else if ($warns[2] == 'n/A') {
                                $warns[2] = $request->input('grund');
                            } else if ($warns[3] == 'n/A') {
                                $warns[3] = $request->input('grund');
                            } else {
                                $warns[4] == $request->input('grund');
                            }
                            $warntext =  $warns[0] . "|" .  $warns[1] . "|" .  $warns[2] . "|" .  $warns[3] . "|" .  $warns[4];
                            $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " verwarnt, Grund: " . $request->input('grund') . "!";
                            DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                            DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => $request->input('grund'), 'penalty' => 'Verwarnung erhalten', 'timestamp' => time()));
                            $punishments = DB::table('adminsettings')->where('id', 1)->value('punishments');
                            DB::table('adminsettings')->where('id', 1)->update(['punishments' => $punishments + 1]);
                            if ($warncounter >= 5) {
                                $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " permanent gebannt, Grund: 5/5 Verwarnungen!";
                                DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                                DB::table('inactiv')->where('id', '=', $user->id)->delete();
                                DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => '5/5 Verwarnungen', 'penalty' => 'Permanenter Ban', 'timestamp' => time()));
                                DB::table('users')->where('id', $user->id)->update(['warns' => $warncounter, 'warns_text' => $warntext, 'ban' => 1, 'bantext' => '5/5 Verwarnungen']);
                                DB::table('bans')->insert(array('banname' => $user->name, 'banfrom' => Auth::user()->name, 'text' => '5/5 Verwarnungen', 'timestamp' => time(), 'ip' => $user->last_ip, 'identifier' => $user->identifier, 'userid' => $user->id));
                            } else {
                                DB::table('users')->where('id', $user->id)->update(['warns' => $warncounter, 'warns_text' => $warntext]);
                            }
                            return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich verwarnt!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Ungültiger Grund!');
                    }
                }
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminUnwarnUser(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('grund') && !is_numeric($request->input('grund')) && strlen($request->input('grund')) >= 3 && strlen($request->input('grund')) <= 35)) {
                        if (Auth::user()->adminlevel >= FunctionsController::High_Administrator) {
                            $user = DB::table('users')->where('id', $request->input('id'))->first();
                            if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                            if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                            if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                            if ($user->ban != 0) return Redirect::back()->with('error', 'Der Spieler muss zuerst entbannt werden!');
                            $warncounter = $user->warns;
                            if ($warncounter <= 0) return Redirect::back()->with('error', 'Der Spieler hat keine Verwarnungen!');
                            $warncounter = $user->warns - 1;
                            $warns = explode("|", $user->warns_text);
                            $warnset = "";
                            if ($warns[4] != 'n/A') {
                                $warnset = $warns[4];
                                $warns[4] = 'n/A';
                            } else if ($warns[3] != 'n/A') {
                                $warnset = $warns[3];
                                $warns[3] = 'n/A';
                            } else if ($warns[2] != 'n/A') {
                                $warnset = $warns[2];
                                $warns[2] = 'n/A';
                            } else if ($warns[1] != 'n/A') {
                                $warnset = $warns[1];
                                $warns[1] = 'n/A';
                            } else {
                                $warnset = $warns[0];
                                $warns[0] == 'n/A';
                            }

                            $warntext =  $warns[0] . "|" .  $warns[1] . "|" .  $warns[2] . "|" .  $warns[3] . "|" .  $warns[4];

                            $logtext = Auth::user()->name . " hat von " . FunctionsController::getUserName($user->id) . " die Verwarnung " . $warnset . ", Grund: " . $request->input('grund') . "!";
                            DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                            DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => $request->input('grund'), 'penalty' => 'Verwarnung gelöscht', 'timestamp' => time()));
                            DB::table('users')->where('id', $user->id)->update(['warns' => $warncounter, 'warns_text' => $warntext]);
                            return Redirect::back()->with('success', 'Du hast erfolgreich eine Warnung vom Spieler gelöscht!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Ungültiger Grund!');
                    }
                }
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminUnsetPrison(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('grund') && !is_numeric($request->input('grund')) && strlen($request->input('grund')) >= 3 && strlen($request->input('grund')) <= 35)) {
                        if (Auth::user()->adminlevel >= FunctionsController::Probe_Moderator) {
                            $user = DB::table('users')->where('id', $request->input('id'))->first();
                            if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                            if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                            if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                            if ($user->prison <= 0) return Redirect::back()->with('error', 'Der Spieler befindet sich nicht im Prison!');
                            DB::table('userfile')->insert(array('userid' => $user->id, 'admin' => FunctionsController::getUserName($user->id), 'text' => $request->input('grund'), 'penalty' => 'Aus dem Prison geholt', 'timestamp' => time()));
                            $logtext = Auth::user()->name . " hat " . FunctionsController::getUserName($user->id) . " aus dem Prison geholt, Grund: " . $request->input('grund') . "!";
                            DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                            DB::table('users')->where('id', $user->id)->update(['prison' => 0]);
                            return Redirect::back()->with('success', 'Der Spieler wurde erfolgreich aus dem Prison geholt!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    } else {
                        return Redirect::back()->with('error', 'Ungültiger Grund!');
                    }
                }
                return redirect::to('/home')->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminChangeName(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('name') && !is_numeric($request->input('name')) && strlen($request->input('name')) >= 3 && strlen($request->input('name')) <= 35)) {
                        if (Auth::user()->adminlevel >= FunctionsController::Administrator) {
                            $user = DB::table('users')->where('id', $request->input('id'))->first();
                            if (!$user) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                            if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                            if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                            if ($user->name == $request->input('name')) return Redirect::back()->with('error', 'Ungültiger Accountname!');
                            preg_match('^[A-Z][a-zA-Z]{2,35}^', $request->input('name'), $matches, PREG_OFFSET_CAPTURE);
                            if (!$matches) return Redirect::back()->with('error', 'Für den Accountnamen dürfen nur Buchstaben benutzt werden und der erste Buchstabe muss groß geschrieben werden!');
                            $checkname = DB::table('users')->where('name', $request->input('name'))->first();
                            if ($checkname) return Redirect::back()->with('error', 'Dieser Accountname ist bereits vergeben!');
                            if ($user->forumaccount > -1) {
                                $client = new \GuzzleHttp\Client();
                                //ToDo: Forumconnect System einbinden
                                $response = $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=updatename&userid=' . $user->forumaccount . '&name=' . $request->input('name'));
                                if ((int)$response->getBody()->getContents() != 1) return redirect::to('/home')->with('error', 'Ungültiger Name!');
                            }
                            $newname = $request->input('name');
                            DB::table('users')->where('id', $user->id)->update(['name' => $newname]);
                            DB::table('users')->where('geworben', FunctionsController::getUserName($user->id))->update(['geworben' => $newname]);
                            DB::table('userlog')->insert(array('userid' => $user->id, 'action' => 'Accountname wurde administrativ auf ' . $newname . " gesetzt!", 'timestamp' => time()));
                            $logtext = Auth::user()->name . " hat den Accountnamen " . FunctionsController::getUserName($user->id) . " auf " . $newname . " geändert!";
                            DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                            DB::table('namechanges')->insert(array('status' => 1, 'userid' => $user->id, 'oldname' => $user->name, 'newname' => $newname, 'timestamp' => time()));
                            return Redirect::back()->with('success', 'Der Name wurde erfolgreich geändert!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    }
                    return Redirect::back()->with('error', 'Ungültiger Accountname!');
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function adminChangeCharName(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (!empty($request->input('id') && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11)) {
                    if (!empty($request->input('cid') && is_numeric($request->input('cid')) && strlen($request->input('cid')) >= 1 && strlen($request->input('cid')) <= 11)) {
                        if (!empty($request->input('name') && !is_numeric($request->input('name')) && strlen($request->input('name')) >= 3 && strlen($request->input('name')) <= 35)) {
                            if (Auth::user()->adminlevel >= FunctionsController::Supporter) {
                                $user = DB::table('users')->where('id', $request->input('id'))->first();
                                $charakter = DB::table('characters')->where('id', $request->input('cid'))->first();
                                if (!$user || !$charakter || $charakter->userid != $user->id) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                                if (Auth::user()->adminlevel < $user->adminlevel) return Redirect::back()->with('error', 'Keine Berechtigung!');
                                if ($user->online == 1) return Redirect::back()->with('error', 'Der Spieler ist nicht offline!');
                                if ($charakter->name == $request->input('name')) return Redirect::back()->with('error', 'Ungültiger Charaktername!');
                                preg_match('^([A-Z][a-z]+[ ][A-Z][a-z]+)$^', $request->input('name'), $matches, PREG_OFFSET_CAPTURE);
                                if (!$matches) return Redirect::back()->with('error', 'Der Charaktername befindet sich nicht im folgenden Format: Vorname Nachname und die jeweils ersten Buchstaben müssen groß sein!');
                                $checkname = DB::table('characters')->where('name', $request->input('name'))->first();
                                if ($checkname) return Redirect::back()->with('error', 'Dieser Charaktername ist bereits vergeben!');
                                $newname = $request->input('name');
                                DB::table('userlog')->insert(array('userid' => $user->id, 'action' => 'Charaktername wurde von ' . $charakter->name . ' administrativ auf ' . $newname . " gesetzt!", 'timestamp' => time()));
                                $logtext = Auth::user()->name . " hat den Charakternamen von " . $charakter->name . " auf " . $newname . " geändert!";
                                DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                                $text = "Charaktername " . $charakter->name . " auf " . $newname . " geändert!";
                                DB::table('timeline')->insert(array('userid' => Auth::user()->id, 'charid' => $charakter->id, 'text' => $text, 'icon' => 0, 'timestamp' => time()));
                                DB::table('namechanges')->insert(array('status' => 2, 'userid' => $user->id, 'oldname' => $charakter->name, 'newname' => $newname, 'timestamp' => time()));
                                DB::table('characters')->where('id', $request->cid)->update(['name' => $newname]);
                                return Redirect::back()->with('success', 'Der Charaktername wurde erfolgreich geändert!');
                            } else {
                                return Redirect::back()->with('error', 'Keine Berechtigung!');
                            }
                        }
                        return Redirect::back()->with('error', 'Ungültiger Accountname!');
                    }
                }
                return Redirect::back()->with('error', 'Ungültige Interaktion!');
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function deleteInaktiv(Request $request)
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                $id = $request->id;
                if (!empty($id) && is_numeric($id) && strlen($id) >= 1 && strlen($id) <= 11) {
                    $checkinactiv = DB::table('inactiv')->where('id',  $id)->first();
                    if (!$checkinactiv) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    if (Auth::user()->adminlevel >= FunctionsController::Administrator) {
                        $inaktiv = DB::table('inactiv')->where('id', $id)->first();
                        DB::table('inactiv')->where('id', '=', $id)->delete();
                        $logtext = Auth::user()->name . " hat die Inaktivmeldung von " . FunctionsController::getUserName($inaktiv->userid) . " gelöscht!";
                        DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                        return Redirect::back()->with('success', 'Inaktivmeldung erfolgreich gelöscht!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                } else {
                    return Redirect::back()->with('error', 'Ungültige Interaktion!');
                }
            }
            return redirect::to('/adminLogin')->with('error', 'Keine aktive Session gefunden!');
        }
    }

    public function getNameChanges()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $namechanges = DB::table('namechanges')->limit(125)->orderBy('timestamp', 'desc')->get();
                return view('layouts.admin.getnamechanges', ['namechanges' => $namechanges]);
            }
        }
    }

    public function archivTickets()
    {
        if (Auth::check()) {
            if ($this->checkAdminLogin()) {
                if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin) return redirect::to('/home')->with('error', 'Keine Berechtigung!');
                $mytickets = DB::table('tickets')->where('status', '=', 9)->limit(150)->orderBy('timestamp', 'desc')->get();
                return view('layouts.admin.ticketarchiv', ['mytickets' => $mytickets]);
            }
        }
    }

    public function changeTicketStatus(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('id')) && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11) {
                if (!empty($request->input('status')) && is_numeric($request->input('status')) && strval($request->input('status')) <= 9 && strval($request->input('status')) > 0) {
                    $ticket = DB::table('tickets')->where('id', $request->input('id'))->first();
                    if ($ticket) {
                        $checkticket = DB::table('ticket_user')->where('ticketid', $request->id)->where('userid', Auth::user()->id)->first();
                        $adminlevel = 1;
                        if ($ticket->admin != -1) {
                            $adminlevel = DB::table('users')->where('name', $ticket->admin)->value('adminlevel');
                        }
                        if ((Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel >= $adminlevel) || $checkticket) {
                            if ($ticket->status == $request->input('status')) return Redirect::back()->with('error', 'Das Ticket hat diesen Status bereits!');
                            if ($ticket->status == 9) return Redirect::back()->with('error', 'Das Ticket wurde bereits archiviert, es kann nicht mehr verändert werden!');
                            if ($request->input('status') == 2 && $ticket->status != 1) return Redirect::back()->with('error', 'Das Ticket muss erst in Bearbeitung gesetzt werden!');
                            if ($request->input('status') == 9 && $ticket->status != 2) return Redirect::back()->with('error', 'Das Ticket muss zuerst geschlossen werden!');
                            $status = "Offen";
                            if ($request->input('status') == 1) $status = "In Bearbeitung";
                            else if ($request->input('status') == 2) $status = "Geschlossen";
                            else if ($request->input('status') == 9) $status = "Archiviert";
                            if($ticket->admin == -1)
                            {
                                DB::table('tickets')->where('id', $request->input('id'))->update(['status' => $request->input('status'),'admin' => Auth::user()->id]);
                                $text = "<p>". Auth::user()->name . " hat '" . Auth::user()->name . "' als Bearbeiter gesetzt!</p>";
                                DB::table('ticket_answers')->insert(array('ticketid' => $request->input('id'), 'userid' => Auth::user()->id, 'text' => $text, 'timestamp' => time()));
                            }
                            else
                            {
                                DB::table('tickets')->where('id', $request->input('id'))->update(['status' => $request->input('status')]);
                            }
                            $text = "<p>". Auth::user()->name . " hat den Status des Tickets auf '" . $status . "' gesetzt!</p>";
                            DB::table('ticket_answers')->insert(array('ticketid' => $request->input('id'), 'userid' => Auth::user()->id, 'text' => $text, 'timestamp' => time()));
                            return Redirect::back()->with('success', 'Status erfolgreich geändert!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    }
                }
            }
            return Redirect::back()->with('error', 'Ungültige Interaktion!');
        }
    }

    public function addUserToTicket(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('id')) && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11) {
                if (!empty($request->input('name')) && !is_numeric($request->input('name')) && strlen($request->input('name')) >= 3  && strlen($request->input('name')) <= 35) {
                    $ticket = DB::table('tickets')->where('id', $request->input('id'))->first();
                    if ($ticket) {
                        $checkticket = DB::table('ticket_user')->where('ticketid', $request->id)->where('userid', Auth::user()->id)->first();
                        if ($ticket->admin != -1) {
                            $adminlevel = DB::table('users')->where('name', $ticket->admin)->value('adminlevel');
                        }
                        if ((Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel >= $adminlevel) || $checkticket) {
                            $name = DB::table('users')->where('name', $request->input('name'))->first();
                            if (!$name) return Redirect::back()->with('error', 'Es konnte kein Spieler mit diesem Namen gefunden werden!');
                            $nameticket = DB::table('ticket_user')->where('ticketid', $request->id)->where('userid', $name->id)->first();
                            if ($nameticket) return Redirect::back()->with('error', 'Der Spieler befindet sich schon in diesem Ticket!');
                            DB::table('ticket_user')->insert(array('ticketid' => $request->id, 'userid' => $name->id, 'timestamp' => time()));
                            $text = "<p>". Auth::user()->name . " hat '" . $request->name . "' zum Ticket hinzugef&uuml;gt!</p>";
                            DB::table('ticket_answers')->insert(array('ticketid' => $request->input('id'), 'userid' => Auth::user()->id, 'text' => $text, 'timestamp' => time()));
                            return Redirect::back()->with('success', 'Der Benutzer wurde erfolgreich zum Ticket hinzugefügt!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    }
                }
            }
            return Redirect::back()->with('error', 'Ungültige Interaktion!');
        }
    }

    public function editTicket(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('id')) && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11) {
                if (!empty($request->input('name')) && !is_numeric($request->input('name')) && strlen($request->input('name')) >= 3  && strlen($request->input('name')) <= 35) {
                    $ticket = DB::table('tickets')->where('id', $request->input('id'))->first();
                    if ($ticket) {
                        $checkticket = DB::table('ticket_user')->where('ticketid', $request->id)->where('userid', Auth::user()->id)->first();
                        if ($ticket->admin != -1) {
                            $adminlevel = DB::table('users')->where('name', $ticket->admin)->value('adminlevel');
                        } else {
                            $adminlevel = 0;
                        }
                        if ((Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel >= $adminlevel) || $checkticket) {
                            $name = DB::table('users')->where('name', $request->input('name'))->first();
                            if (!$name) return Redirect::back()->with('error', 'Es konnte kein Admin mit diesem Namen gefunden werden!');
                            $nameticket = DB::table('ticket_user')->where('ticketid', '=', $request->id)->where('userid', '=', $name->id)->first();
                            if (!$nameticket) return Redirect::back()->with('error', 'Der Admin befindet sich nicht in diesem Ticket!' . $nameticket);
                            if ($name->adminlevel <= FunctionsController::Kein_Admin) return Redirect::back()->with('error', 'Dieser Spieler ist kein Admin!');
                            if ($name->id == $ticket->admin) return Redirect::back()->with('error', 'Dieser Admin ist bereits der Bearbeiter des Tickets!');
                            $text = "<p>". Auth::user()->name . " hat '" . $request->name . "' als Bearbeiter gesetzt!</p>";
                            DB::table('ticket_answers')->insert(array('ticketid' => $request->input('id'), 'userid' => Auth::user()->id, 'text' => $text, 'timestamp' => time()));
                            DB::table('tickets')->where('id', $request->input('id'))->update(['admin' => $name->id]);
                            return Redirect::back()->with('success', 'Der Admin wurde erfolgreich als Bearbeiter gesetzt!');
                        } else {
                            return Redirect::back()->with('error', 'Keine Berechtigung!');
                        }
                    }
                }
            }
            return Redirect::back()->with('error', 'Ungültige Interaktion!');
        }
    }

    public function setAdminLogin(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->adminlevel > FunctionsController::Kein_Admin) {
                if (!session('nemesusworlducp_adminlogin')) {
                    if (session('nemesusworlducp_lasttry') && time() > session('nemesusworlducp_lasttry')) {
                        session()->forget('nemesusworlducp_failedadminlogin');
                        session()->forget('nemesusworlducp_lasttry');
                    }
                    if (session('nemesusworlducp_failedadminlogin') >= 5) {
                        return Redirect::back()->with('error', 'Du bist für den Adminlogin temporär gesperrt!');
                    }
                    if (!empty($request->input('adminpassword')) && strlen($request->input('adminpassword')) >= 6 && strlen($request->input('adminpassword')) <= 35) {
                        //if (Auth::user()->google2fa_secret == null) return Redirect::back()->with('error', 'Du musst zuerst die Zwei-Faktor-Authentisierung aktivieren!');
                        $adminpassword = DB::table('adminsettings')->where('id', 1)->value('adminpassword');
                        if ($adminpassword && Hash::check($request->input('adminpassword')."(8wgwWoRld136=", $adminpassword)) {
                            $logtext = Auth::user()->name . " hat sich erfolgreich ins UCP als " . FunctionsController::getAdminRangName(Auth::user()->adminlevel, Auth::user()->id) . " eingeloggt!";
                            DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                            session(['nemesusworlducp_adminlogin' => Hash::make('tWL<Z,(Us45mVZ,Ef{Lm$PbS:')]);
                            return redirect::to('/adminDashboard')->with('adminDashboard')->with('success', 'Adminlogin erfolgreich!');
                        }
                    }
                    session(['nemesusworlducp_failedadminlogin' => session('nemesusworlducp_failedadminlogin') + 1]);
                    session(['nemesusworlducp_lasttry' => time() + (60 * 5)]);
                    $logtext = Auth::user()->name . " hat sich versucht ins UCP als " . FunctionsController::getAdminRangName(Auth::user()->adminlevel, Auth::user()->id) . " einzuloggen!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    return Redirect::back()->with('error', 'Ungültiger Adminlogin!');
                } else {
                    return redirect::to('/adminDashboard');
                }
            }
            return redirect::to('/home')->with('error', 'Keine Berechtigung!');
        }
    }
}
