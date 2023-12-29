<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

//LoginController zuständig für alle Auth Sachen
class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 5;
    protected $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    public function login()
    {
        if (session('nemesusworlducp_codetime') && time() > session('nemesusworlducp_codetime')) {
            session()->forget('nemesusworlducp_code');
            session()->forget('nemesusworlducp_codetime');
            session()->forget('nemesusworlducp_codeid');
            session()->forget('nemesusworlducp_codeforumaccount');
        }
        return view('layouts.auth.login');
    }

    public function passwordForget()
    {
        if (session('nemesusworlducp_codetime') && time() > session('nemesusworlducp_codetime')) {
            session()->forget('nemesusworlducp_code');
            session()->forget('nemesusworlducp_codetime');
            session()->forget('nemesusworlducp_codeid');
            session()->forget('nemesusworlducp_codeforumaccount');
        }
        return view('layouts.auth.passwordforget');
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $name = $request->input('name');
        $sperre = 0;

        if (session('nemesusworlducp_lasttry') && time() > session('nemesusworlducp_lasttry')) {
            session()->forget('nemesusworlducp_failedadminlogin');
            session()->forget('nemesusworlducp_lasttry');
        }

        if (session('nemesusworlducp_failedadminlogin') >= 3) {
            return Redirect::back()->with('error', 'Du bist für diese Funktion temporär gesperrt!');
        }

        if (session('nemesusworlducp_codetime') && time() > session('nemesusworlducp_codetime')) {
            session()->forget('nemesusworlducp_code');
            session()->forget('nemesusworlducp_codetime');
            session()->forget('nemesusworlducp_codeid');
            session()->forget('nemesusworlducp_codeforumaccount');
        }

        if (!session('nemesusworlducp_code')) {
            if (!empty($request->input('email')) && strlen($request->input('email')) > 5 && strlen($request->input('email')) <= 64 && !empty($request->input('name')) && strlen($request->input('name')) >= 3 && strlen($request->input('name')) <= 35) {
                $forumaccount = DB::table('users')->where('name', $name)->value('forumaccount');
                $id = DB::table('users')->where('name', $name)->value('id');
                if ($forumaccount != -1 && $id > 0) {
                    $client = new \GuzzleHttp\Client();
                    //ToDo: Forumconnect System einbinden
                    $response = $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=password&email=' . $email . '&userid=' . $forumaccount);
                    if ((int)$response->getBody()->getContents() == 1) {
                        $code = FunctionsController::generateCode();
                        $nachricht = "Dein Passwort Wiederherstellungscode: " . $code . ", solltest du keine Passwort Wiederherstellungsanfrage gestellt haben so ignoriere diese Konversation oder melde dich bei einem Admin!";
                        //ToDo: Forumconnect System einbinden
                        $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=conversation&betreff=Passwort Wiederherstellung&nachricht=' . $nachricht . '&userid=' . $forumaccount);
                    }
                    else
                    {
                        $sperre = 1;
                    }
                }
                if($sperre == 0)
                {
                    $logtext = "Es wurde eine Passwort Vergessens Anfrage für den Account ".$request->input('name')." gestellt!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                }
                if($sperre == 1)
                {
                    session(['nemesusworlducp_failedadminlogin' => session('nemesusworlducp_failedadminlogin') + 1]);
                    session(['nemesusworlducp_lasttry' => time() + (60 * 5)]);
                }
                session(['nemesusworlducp_code' => $code]);
                session(['nemesusworlducp_codeid' => $id]);
                session(['nemesusworlducp_codeforumaccount' => $forumaccount]);
                session(['nemesusworlducp_codetime' => time() + (60 * 15)]);
                return Redirect::to('/passwordForget')->with('success', 'Sofern ein Account vorhanden ist, wurde dir im Forum eine Konversation geschickt!');
            }
        } else {
            if (!empty($request->input('code')) && is_numeric($request->input('code')) && strlen($request->input('code')) == 4) {
                if ($request->input('code') == session('nemesusworlducp_code')) {
                    $newpassword = FunctionsController::generatePassword(8, 2, 2, true);
                    $forumaccount = session('nemesusworlducp_codeforumaccount');
                    $id = session('nemesusworlducp_codeid');
                    $name = DB::table('users')->where('id', $id)->value('name');
                    if (!$name)  return Redirect::back()->with('error', 'Ungültige Interaktion!');
                    $nachricht = "Dein neues Passwort, für den Gameserver/UCP: " . $newpassword;
                    //ToDo: Forumconnect System einbinden
                    //$client = new \GuzzleHttp\Client();
                    //$client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=conversation&betreff=Dein neues Passwort&nachricht=' . $nachricht . '&userid=' . $forumaccount);
                    DB::table('userlog')->insert(array('userid' =>  $id, 'action' => 'Passwort über Passwort Vergessens Funktion neu generiert!', 'timestamp' => time()));
                    $logtext = $name . " hat sich über die Passwort Vergessens Funktion ein neues Passwort generieren lassen!";
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    DB::table('users')->where('id', $id)->update(['password' => Hash::make($newpassword."(8wgwWoRld136=")]);
                    session()->forget('nemesusworlducp_code');
                    session()->forget('nemesusworlducp_codetime');
                    session()->forget('nemesusworlducp_codeid');
                    session()->forget('nemesusworlducp_codeforumaccount');
                    return Redirect::to('login')->with('success', 'Dein neues Passwort wurde dir via Konversation zugeschickt!');
                } else {
                    session()->flash('error', 'Ungültiger Code!');
                    return Redirect::back();
                }
            }
        }
        return Redirect::back()->with('error', 'Ungültige Interaktion');
    }

    public function postLogin(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');

        if (session('nemesusworlducp_lasttry') && time() > session('nemesusworlducp_lasttry')) {
            session()->forget('nemesusworlducp_failedadminlogin');
            session()->forget('nemesusworlducp_lasttry');
        }

        if (session('nemesusworlducp_failedadminlogin') >= 3) {
            return Redirect::back()->with('error', 'Du bist für den Login temporär gesperrt!');
        }

        if (!empty($request->input('name')) && strlen($request->input('name')) > 2 && strlen($request->input('name')) <= 35 && !empty($request->input('password')) && strlen($request->input('password')) >= 6 && strlen($request->input('password')) <= 35) {
            if (Auth::attempt(['name' => $name, 'password' => $password."(8wgwWoRld136=", 'dsgvo_closed' => 0], true)) {
                $checkban = DB::table('bans')->where('banname', Auth::user()->name)->orWhere('identifier', Auth::user()->identifier)->first();
                $characters = DB::table('characters')->where('closed', 0)->where('userid', Auth::user()->id)->count();
                if(!$characters)
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
                    return Redirect::back();
                }
                if (($checkban && $checkban->identifier != "n/A") || Auth::user()->ban > 0) {
                    if (Auth::user()->ban == 1) {
                        session()->flash('error', 'Du bist permanent gebannt, Grund: ' . Auth::user()->bantext . "!");
                    } else if (Auth::user()->ban > 1) {
                        session()->flash('error', 'Du bist noch bis zum ' . strftime('%d %b. %Y - %H:%M:%S', Auth::user()->ban) . ' Uhr gebannt, Grund: ' . Auth::user()->bantext . "!");
                    }
                    else
                    {
                        session()->flash('error', 'Du bist permanent gebannt, bitte melde dich bei uns im Support!');
                    }
                    $logtext = Auth::user()->name . ' hat versucht sich ins UCP einzuloggen, obwohl er gebannt ist!';
                    DB::table('adminlogs')->insert(array('loglabel' => "ucplog", 'text' => $logtext, 'timestamp' => time(), 'ip' => $_SERVER["REMOTE_ADDR"]));
                    session()->forget('nemesusworlducp_adminlogin');
                    session()->forget('nemesusworlducp_failedadminlogin');
                    session()->forget('nemesusworlducp_lasttry');
                    session()->forget('google2fa');
                    session()->forget('nemesusworlducp_code');
                    session()->forget('nemesusworlducp_codetime');
                    session()->forget('nemesusworlducp_codeid');
                    session()->forget('nemesusworlducp_codeforumaccount');
                    Auth::logout();
                    return Redirect::back();
                }
                DB::table('adminlogs')->insert(array('loglabel' => 'loginlog', 'text' => $name . ' hat sich erfolgreich ins UCP eingeloggt!', 'timestamp' => time(), 'ip' => $_SERVER['REMOTE_ADDR']));
                session()->forget('nemesusworlducp_failedadminlogin');
                session()->forget('nemesusworlducp_lasttry');
                session()->forget('google2fa');
                session()->forget('nemesusworlducp_code');
                session()->forget('nemesusworlducp_codetime');
                session()->forget('nemesusworlducp_codeid');
                session()->forget('nemesusworlducp_codeforumaccount');
                return redirect::to('/home');
            }
        }
        $checkacc = DB::table('users')->where('name', $request->input('name'))->value('id');
        if ($checkacc) {
            DB::table('userlog')->insert(array('userid' => $checkacc, 'action' => 'Ungültiger UCP Login', 'timestamp' => time()));
        }
        session(['nemesusworlducp_failedadminlogin' => session('nemesusworlducp_failedadminlogin') + 1]);
        session(['nemesusworlducp_lasttry' => time() + (60 * 5)]);
        return Redirect::back()->with('error', 'Ungültiger Login!');
    }
}
