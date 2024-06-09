<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Exception;
use Illuminate\Support\Facades\Redirect;

setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

//Allgemeine Funktionen wie z.B getJobName etc
class FunctionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkbanned');
        $this->middleware('2fa')->except('logout');
    }

    //Adminrangs
    const Kein_Admin = 0;
    const Probe_Moderator = 1;
    const Moderator = 2;
    const Supporter = 3;
    const Administrator = 4;
    const High_Administrator = 5;
    const Manager = 6;
    const Projektleiter = 7;

    public static function generatePassword(
        $passwordlength = 8,
        $numNonAlpha = 0,
        $numNumberChars = 0,
        $useCapitalLetter = false
    ) {

        $numberChars = '123456789';
        $specialChars = '!$%&=?*-:;.,+~@_';
        $secureChars = 'abcdefghjkmnpqrstuvwxyz';
        $stack = '';

        $stack = $secureChars;

        if ($useCapitalLetter == true)
            $stack .= strtoupper($secureChars);

        $count = $passwordlength - $numNonAlpha - $numNumberChars;
        $temp = str_shuffle($stack);
        $stack = substr($temp, 0, $count);

        if ($numNonAlpha > 0) {
            $temp = str_shuffle($specialChars);
            $stack .= substr($temp, 0, $numNonAlpha);
        }

        if ($numNumberChars > 0) {
            $temp = str_shuffle($numberChars);
            $stack .= substr($temp, 0, $numNumberChars);
        }

        $stack = str_shuffle($stack);

        if(strlen($stack) < 8)
        {
            return FunctionsController::generatePassword(8, 2, 2, true);
        }
        return $stack;
    }

    public static function generateCode() {;
        return mt_rand(1000, 9999);
    }

    public static function getJobName($job)
    {
        switch ($job) {
            case -1:
                return "Arbeitslos";
            case 1:
                return "Spediteur";
            case 2:
                return "Jäger";
            case 3:
                return "Busfahrer";
            case 4:
                return "Müllmann";
            case 5:
                return "Kanalreiniger";
            case 6:
                return "Taxifahrer";
            case 7:
                return "Landwirt";
            case 8:
                return "Geldlieferant";
            default:
                return "Keinen";
        }
    }

    public static function getAllWBBGroups($user=null)
    {
        //6: Verifiziert
        //14-16: Premium Bronze, Premium Silber, Premium Gold
        //20-21: SAPD Member, SAPD Leader
        return "6,16,15,14,21,20";
    }

    public static function updateWBBGroups($user)
    {
        if(!$user)
        {
            if($user->forumaccount == -1) return false;
            $groups = "6"; //Verifiziert
            $removegroups = "-1"; //Gruppen zum löschen
            //Premium
            if($user->premium > 0 && $user->premium_time > time())
            {
                if($user->premium == 1)
                {
                    $groups = $groups . ",16";
                    $removegroups = $removegroups . ",14,15";
                }
                else if($user->premium == 1)
                {
                    $groups = $groups . ",15";
                    $removegroups = $removegroups . ",14,16";
                }
                else if($user->premium == 1)
                {
                    $groups = $groups . ",14";
                    $removegroups = $removegroups . ",15,16";
                }
            }
            else
            {
                $removegroups = $removegroups . ",14,15,16";
            }
            //Fraktion
            $characters = DB::table('characters')->where('userid', $user->id)->get();
            if(!$characters) return false;
            foreach($characters as $data)
            {
                if($data->faction > 0)
                {
                    $leader = DB::table('factions')->where('id', $data->faction)->value('leader');
                    //SAPD
                    if($data->faction == 1)
                    {
                        if($data->id == $leader || $data->rang >= 10)
                        {
                            if(!str_contains($groups, ',20'))
                            {
                                $groups = $groups . ",20";
                            }
                            if(!str_contains($removegroups, ',21'))
                            {
                                $removegroups = $removegroups . ",21";
                            }
                        }
                        else
                        {
                            if(!str_contains($groups, ',21'))
                            {
                                $groups = $groups . ",21";
                            }
                            if(!str_contains($removegroups, ',20'))
                            {
                                $removegroups = $removegroups . ",20";
                            }
                        }
                    }
                }
            }
            //SAPD
            if(!str_contains($groups, ',20') && !str_contains($groups, ',21') && !str_contains($removegroups, ',20') && !str_contains($removegroups, ',21'))
            {
                $removegroups = $removegroups . ",20,21";
            }
            //Fraktionen entfernen
            $client = new \GuzzleHttp\Client();
            //ToDo: Forumconnect System einbinden
            $response1 = $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=removefromgroups&userid=' . $user->forumaccount . '&groupids='.$removegroups);
            $response2 = $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=settogroups&userid=' . $user->forumaccount . '&groupids='.$groups);
            DB::table('users')->where('id', $user->forumaccount)->update(['forumupdate' => time() + (60 * 25)]);
            return true;
        }
    }

    public static function getAdminRangName($admin, $userid = -1)
    {
        if (!is_numeric($admin)) return "n/A";
        if ($userid != -1 && is_numeric($userid) && strlen($userid) >= 1 && strlen($userid) <= 11) {
            $rangname = DB::table('users')->where('id', $userid)->value('admin_rang');
            if ($rangname && $rangname != "n/A") {
                return $rangname;
            }
        }
        switch ($admin) {
            default:
                return "Kein Admin";
            case 1:
                return "Probe Moderator";
            case 2:
                return "Moderator";
            case 3:
                return "Supporter";
            case 4:
                return "Administrator";
            case 5:
                return "High-Administrator";
            case 6:
                return "Manager";
            case 7:
                return "Development";
            case 8:
                return "Projektleiter";
        }
    }

    public static function getAdminStatus($id)
    {
        if (!is_numeric($id) || strlen($id) < 1 && strlen($id) > 11) return false;
        $admin = DB::table('users')->where('id', $id)->value('adminlevel');
        if ($admin && $admin > FunctionsController::Kein_Admin) {
            return true;
        }
        return false;
    }

    public static function getDSGVOClosed($id)
    {
        if (!is_numeric($id) || strlen($id) < 1 && strlen($id) > 11) return 0;
        $dsgvo_closed = DB::table('users')->where('id', $id)->value('dsgvo_closed');
        if (!$dsgvo_closed) return 0;
        return $dsgvo_closed;
    }

    public static function getGroupMembers($groupid)
    {
        if (!is_numeric($groupid) || strlen($groupid) < 1 && strlen($groupid) > 11) return 0;
        $count = DB::table('groups_members')->where('groupsid', $groupid)->count();
        return $count;
    }

    public static function getFactionMembers($factionid)
    {
        if(!$factionid)
        {
            session()->flash('error', 'Bitte erstell dir zuerst einen Charakter!');
            session()->forget('nemesusworlducp_adminlogin');
            session()->forget('nemesusworlducp_failedadminlogin');
            session()->forget('nemesusworlducp_lasttry');
            session()->forget('google2fa');
            session()->forget('nemesusworlducp_code');
            session()->forget('nemesusworlducp_codetime');
            session()->forget('nemesusworlducp_codeid');
            session()->forget('nemesusworlducp_codeforumaccount');
            Auth::logout();
            return;
        }
        if (!is_numeric($factionid) || strlen($factionid) < 1 && strlen($factionid) > 11) return 0;
        $count = DB::table('characters')->where('faction', $factionid)->count();
        return $count;
    }

    public static function getGroupName($id)
    {
        if (!is_numeric($id) || strlen($id) < 1 && strlen($id) > 11) return "n/A";
        $name = DB::table('groups')->where('id', $id)->value('name');
        if (!$name) return 'n/A';
        return $name;
    }

    public static function getAdminLevel($id)
    {
        if (!is_numeric($id) || strlen($id) < 1 && strlen($id) > 11) return false;
        $admin = DB::table('users')->where('id', $id)->value('adminlevel');
        if ($admin) {
            return $admin;
        }
        return 0;
    }

    public static function getMiniJobName($minijob)
    {
        switch ($minijob) {
            default:
                return "Keinen";
        }
    }

    public static function getGroupStatus($status)
    {
        switch ($status) {
            case 0:
                return "Gruppierung";
            case 1:
                return "Firma";
            case 2:
                return "Partei";
            default:
                return "Gruppierung";
        }
    }

    public static function getAdminLogName($log)
    {
        $log = DB::table('adminlogsnames')->where('loglabel', $log)->value('name');
        if (!$log) return "n/A Log";
        return $log;
    }

    public static function getAdminLogRang($log)
    {
        $rang = DB::table('adminlogsnames')->where('loglabel', $log)->value('rang');
        if (!$rang) return 1;
        return $rang;
    }

    public static function getFraktionsName($fraktion)
    {
        if ($fraktion <= 0) return 'Keine Fraktion';
        $faction = DB::table('factions')->where('id', $fraktion)->first();
        return $faction->name;
    }

    public static function getRangName($rang, $faction)
    {
        if ($rang <= 0 || $faction <= 0) return "Kein Rang";
        $rangname = 'rang' . strval($rang);
        return DB::table('factionsrangs')->where('factionid', $faction)->first()->$rangname;
    }

    public static function getRangNameGroup($rang, $group)
    {
        if ($rang <= 0 || $group <= 0) return "Kein Rang";
        $rangname = 'rang' . strval($rang);
        $rname = DB::table('groupsrangs')->where('groupsid', $group)->first()->$rangname;
        if (!$rname || $rname == null) return "Kein Rang";
        return $rname;
    }

    public static function getSideBarCP()
    {
        return "by Nemesus.de";
    }

    public static function getNameFromBank($banknumber)
    {
        if (Auth::check()) {
            $bank = DB::table('bank')->where('banknumber', $banknumber)->first();
            $name = "n/A";
            if($bank->groupid <= 0)
            {
                $charactername = DB::table('characters')->where('id', $bank->ownercharid)->value('name');
                $name = $charactername;
            }
            else
            {
                $groupname = DB::table('groups')->where('id', $bank->groupid)->value('name');
                $name = $groupname;
            }
            return $name;
        }
    }


    public static function getCharacterName($id)
    {
        if (Auth::check() && is_numeric($id) && $id != -1) {
            $character = DB::table('characters')->where('id', $id)->first();
            if (!$character || $character == null)
            {
                $name = "Keiner";
            }
            else
            {
                $name = $character->name;
            }
            return $name;
        }
        return "Keiner";
    }

    public static function getCharacterNameByID($id)
    {
        if (Auth::check() && is_numeric($id) && $id != -1) {
            $character = DB::table('characters')->where('id',$id)->first();
            if (!$character || $character == null)
            {
                $name = "Keiner";
            }
            else
            {
                $name = $character->name;
            }
            return $name;
        }
        return "Keiner";
    }

    public static function getOnlineStatus($id)
    {
        if (Auth::check() && is_numeric($id) && $id != -1) {
            $onlinestatus = DB::table('characters')->where('id',$id)->first()->online;
            return $onlinestatus;
        }
        return 0;
    }

    public static function getUserName($id, $tag = false)
    {
        if (Auth::check()) {
            $name = DB::table('users')->where('id', $id)->value('name');
            if (!$name || $name == null) {
                $name = "n/A";
            } else {
                if ($tag == true) {
                    if (Auth::user()->adminlevel > FunctionsController::Kein_Admin || session('nemesusworlducp_adminlogin')) {
                        $name = "[NW]" . $name;
                    }
                }
            }
            return $name;
        }
    }

    public static function GetDefaultKonto($id)
    {
        if (!$id || $id == -1) return "n/A";
        $konto = DB::table('characters')->where('id', $id)->first()->defaultbank;
        return $konto;
    }

    public static function getUserNameTicket($id)
    {
        if (Auth::check()) {
            $name = "Keiner";
            if (!$id || $id == -1) return "Warte auf Bearbeitung";
            $name = DB::table('users')->where('id', $id)->value('name');
            if (!$name || $name == null)
            {
                return "Keiner";
            }
            return $name;
        }
    }

    public static function getTicketStatus($id)
    {
        if (Auth::check()) {
            $name = "Warte auf Bearbeitung";
            if ($id == 0) $name = "Warte auf Bearbeitung";
            else if ($id == 1) $name = "In Bearbeitung";
            else if ($id == 2) $name = "Abgeschlossen";
            else if ($id == 9) $name = "Archiviert";
            return $name;
        }
    }

    public static function countTickets($id)
    {
        $ticketcount = 0;
        if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin || !session('nemesusworlducp_adminlogin')) {
            $tickets = DB::table('tickets as ts')->distinct()->join('ticket_user as tu', 'ts.id', '=', 'tu.ticketid')->where('ts.status', "!=", 9)->select('ts.*')->where('tu.userid', Auth::user()->id)->orderby('timestamp', 'asc')->limit(50)->get();
        } else {
            if(Auth::user()->adminlevel >= FunctionsController::High_Administrator)
            {
                $tickets = DB::table('tickets as ts')->distinct()->join('ticket_user as tu', 'ts.id', '=', 'tu.ticketid')->where('ts.status', "!=", 9)->select('ts.*')->orderby('timestamp', 'asc')->limit(50)->get();
            }
            else
            {
                $tickets = DB::table('tickets as ts')->distinct()->join('ticket_user as tu', 'ts.id', '=', 'tu.ticketid')->where('ts.status', "!=", 9)->select('ts.*')->where(function ($q) {
                    $q->where('tu.userid', Auth::user()->id)->orwhere('ts.admin', -1);
                })->orderby('timestamp', 'asc')->limit(50)->get();
            }
        }
        foreach($tickets as $data)
        {
            $ticketcount++;
        }
        return $ticketcount;
    }

    public static function db_esc_like_raw($str)
    {
        $nstr = $str;
        DB::getPdo()->quote($nstr);
        $ret = str_replace(['%', '_'], ['\%', '\_'], $nstr);
        return $ret;
    }

    public static function getBankValue($banknumber)
    {
        if (Auth::check()) {
            $bankvalue = DB::table('bank')->where('banknumber', $banknumber)->sum('bankvalue');
            return $bankvalue;
        }
    }

    public static function getBankValueFromAll($charid)
    {
        if (Auth::check()) {
            if($charid == -1) return 0;
            $bankvalue = DB::table('bank')->where('ownercharid', $charid)->sum('bankvalue');
            return $bankvalue;
        }
    }

    public static function getFaction($type)
    {
        if (Auth::check()) {
            $charid = DB::table('characters')->where('userid', Auth::user()->id)->skip(Auth::user()->selectedcharacter)->orderby('id', 'asc')->first()->id;
            $characters = DB::table('characters')->where('id', $charid)->first();
            if ($type == 'faction') {
                $return = $characters->faction;
            } else if ($type == 'rang') {
                $return = $characters->rang;
            }
            return $return;
        }
    }

    public static function checkWartung()
    {
        if (Auth::check()) {
            $wartung = DB::table('settings')->where('id', 1)->value('wartung');
            if($wartung && $wartung == 1)
            {
                return true;
            }
            return false;
        }
    }

    public static function getGroup($type)
    {
        if (Auth::check()) {
            $charid = DB::table('characters')->where('userid', Auth::user()->id)->where('id', Auth::user()->selectedcharacterintern)->first();
            if(!$charid) return 0;
            $characters = DB::table('characters')->where('id', $charid->id)->first();
            if(!$characters) return 0;
            if ($type == 'group') {
                $return = $characters->mygroup;
            } else if ($type == 'rang') {
                $group = DB::table('groups_members')->where('charid', $charid->id)->where('groupsid', $characters->mygroup)->first();
                if(!$group) return 0;
                $return = $group->rang;
            }
            return $return;
        }
    }

    public static function getSkillName($skillevel)
    {
        if (Auth::check())
        {
            $retSkill = "Anfänger";
            if(strval($skillevel) <= 1)
            {
                $retSkill = "Anfänger";
            }
            else if(strval($skillevel) == 2)
            {
                $retSkill = "Erfahrener";
            }
            else if(strval($skillevel) == 3)
            {
                $retSkill = "Profi";
            }
            else if(strval($skillevel) == 4)
            {
                $retSkill = "Meister";
            }
            else if(strval($skillevel) > 4)
            {
                $retSkill = "Experte";
            }
            return $retSkill;
        }
    }

    public static function getItemType($type)
    {
        switch ($type) {
            case 1: {
              return "Essen";
            }
            case 2: {
              return "Trinken";
            }
            case 3: {
              return "Sonstiges";
            }
            case 4: {
                return "Benutzbare Items";
            }
            case 5: {
              return "Waffen";
            }
            case 6: {
              return "Munition";
            }
        }
        return "Essen";
    }

    public static function countItemWeight($item)
    {
        $count = 0;
        if($item)
        {
            $props = explode(",", $item->props);
            if($props[0] >= 5000)
            {
                $props[0] = 0;
            }
            if($item->type != 5)
            {
                $count += $item->weight*$item->amount;
            }
            else
            {
                if($item->description == "Flaregun")
                {
                    $count += $item->weight + ($props[0] * 30);
                }
                else
                {
                    $count += $item->weight + ($props[0] * 3);
                }
            }
        }
        return $count;
    }

    public static function isAMeeleWeapon($weaponname)
    {
        switch (strtolower($weaponname)) {
            case "dolch": {
              return 1;
            }
            case "baseballschläger": {
              return 1;
            }
            case "brechstange": {
              return 1;
            }
            case "taschenlampe": {
              return 1;
            }
            case "golfschläger": {
              return 1;
            }
            case "axt": {
              return 1;
            }
            case "schlagring": {
              return 1;
            }
            case "messer": {
              return 1;
            }
            case "machete": {
              return 1;
            }
            case "klappmesser": {
              return 1;
            }
            case "schlagstock": {
              return 1;
            }
            case "poolcue": {
              return 1;
            }
        }
        return 0;
    }

    static function replaceUmlaute($string)
    {
        $string = str_replace("ä", "ae", $string);
        $string = str_replace("ü", "ue", $string);
        $string = str_replace("ö", "oe", $string);
        $string = str_replace("Ä", "Ae", $string);
        $string = str_replace("Ü", "Ue", $string);
        $string = str_replace("Ö", "Oe", $string);
        $string = str_replace("ß", "ss", $string);
        return $string;
    }

    static function timeAgo($time_ago)
    {
        $time_ago =  strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
        $time  = time() - $time_ago;

        switch ($time):
                // seconds
            case $time <= 60;
                return 'weniger als eine Minute vergangen';
                // minutes
            case $time >= 60 && $time < 3600;
                return (round($time / 60) == 1) ? 'eine Minute' : round($time / 60) . ' Minuten vergangen';
                // hours
            case $time >= 3600 && $time < 86400;
                return (round($time / 3600) == 1) ? 'eine Stunde' : round($time / 3600) . ' Stunden vergangen';
                // days
            case $time >= 86400 && $time < 604800;
                return (round($time / 86400) == 1) ? 'ein Tag' : round($time / 86400) . ' Tage vergangen';
                // weeks
            case $time >= 604800 && $time < 2600640;
                return (round($time / 604800) == 1) ? 'eine Woche' : round($time / 604800) . ' Wochen vergangen';
                // months
            case $time >= 2600640 && $time < 31207680;
                return (round($time / 2600640) == 1) ? 'ein Monat' : round($time / 2600640) . ' Monate vergangen';
                // years
            case $time >= 31207680;
                return (round($time / 31207680) == 1) ? 'ein Jahr' : round($time / 31207680) . ' Jahre vergangen';

        endswitch;
    }

    static function checkForUCPUpdate()
    {
        $oldVersionDate = "2023-12-28T15:55:53Z";
        $url = "https://api.github.com/repos/nSystemz/nemesus-world-ucp/releases/latest";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $dataCheck = json_decode($response);
        $data = $dataCheck[0]->created_at;
        if($data != $oldVersionDate)
        {
            return true;
        }
        return false;
    }
}
