<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\FunctionsController as FunctionsController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

//HomeController für alle Allgemeinen Sachen z.B Charakter und Accountinhalte
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkbanned');
        $this->middleware('2fa')->except('signOut');
    }

    //Get characters from account
    public function index()
    {
        if (Auth::check()) {
            if(Auth::user()->selectedcharacter < 0)
            {
                return redirect('selectCharacter')->with('error', 'Du musst zuerst einen Charakter auswählen!');
            }
            $timeline = DB::table('timeline')->where('userid', Auth::user()
                ->id)
                ->orderBy('id', 'desc')
                ->get();
            $userfile = DB::table('userfile')->where('userid', Auth::user()
                ->id)
                ->orderBy('timestamp', 'desc')
                ->limit(50)
                ->get();
            $namechanges = DB::table('namechanges')->where('userid', Auth::user()
                ->id)
                ->orderBy('timestamp', 'desc')
                ->limit(50)
                ->get();
            $userlog = DB::table('userlog')->where('userid', Auth::user()
                ->id)
                ->orderBy('timestamp', 'desc')
                ->limit(50)
                ->get();
            DB::table('inactiv')->where('date2', '<', time())->delete();
            $inaktiv = DB::table('inactiv')->where('userid', Auth::user()
                ->id)
                ->limit(1)
                ->get();
            $characters = DB::table('characters')->where('userid', Auth::user()
                ->id)
                ->get();
            $groups = DB::table('groups_members')->where('charid', Auth::user()
                ->selectedcharacterintern)
                ->get();
            if (!$characters) {
                session()->forget('nemesusworlducp_adminlogin');
                session()->forget('nemesusworlducp_failedadminlogin');
                session()->forget('nemesusworlducp_lasttry');
                session()->forget('google2fa');
                Auth::logout();
                return redirect('login')->with('error', 'Bitte erstelle dir erst einen Character!');
            }
            return view('home', ['characters' => $characters, 'timeline' => $timeline, 'userfile' => $userfile, 'namechanges' => $namechanges, 'userlog' => $userlog, 'inaktiv' => $inaktiv, 'groups' => $groups]);
        }
    }

    public function twoFactor()
    {
        if (Auth::check()) {
            $google2fa = null;
            $secret = null;
            $QR_Image = null;
            if (Auth::user()->google2fa_secret == null) {
                $google2fa = app('pragmarx.google2fa');
                $secret = $google2fa->generateSecretKey();

                $QR_Image = $google2fa->getQRCodeInline(
                    'Nemesus World.de UCP/Server',
                    Auth::user()->name,
                    $secret
                );
            }
            return view('layouts.auth.zweifaktor', ['QR_Image' => $QR_Image, 'secret' => $secret]);
        }
    }

    public function forum()
    {
        if (Auth::check()) {
            $forumcheck = -1;
            if (Auth::user()->forumaccount == -1) {
                $client = new \GuzzleHttp\Client();
                //ToDo: Forumconnect System einbinden
                $response = $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=getid&name=' . Auth::user()->name);
                $forumcheck = (int)$response->getBody()->getContents();
            }
            return view('layouts.auth.forum', ['forumcheck' => $forumcheck]);
        }
    }

    public function postForum(Request $request)
    {
        if (Auth::check()) {
            $client = new \GuzzleHttp\Client();
            //ToDo: Forumconnect System einbinden
            $response = $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=getid&name=' . Auth::user()->name);
            $forumcheck = (int)$response->getBody()->getContents();
            if (Auth::user()->forumaccount == -1) {
                if ((int)$response->getBody()->getContents() > 0) {
                    $user = DB::table('users')->where('forumaccount', (int)$response->getBody()->getContents())->get();
                    if ($user) return redirect::to('/forum')->with('success', 'Dieser Forumaccount ist bereits mit einem anderen Account verifiziert!');
                }
                $code = FunctionsController::generateCode();
                $nachricht = "Bitte bestätige deine Identität mit folgendem Code: " . $code;
                //ToDo: Forumconnect System einbinden
                $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=conversation&betreff=Forenaccount-Verifizierung&nachricht=' . $nachricht . '&userid=' . $forumcheck);
                DB::table('users')->where('id', Auth::user()->id)->update(['forumaccount' => -2, 'forumcode' => $code]);
                return redirect::to('/forum');
            } else if (Auth::user()->forumaccount == -2) {
                if (!empty($request->code) && is_numeric($request->code)) {
                    $authcode = DB::table('users')->where('id', Auth::user()->id)->value('forumcode');
                    if ($authcode == $request->code) {
                        DB::table('users')->where('id', Auth::user()->id)->update(['forumaccount' => $forumcheck, 'forumcode' => 0]);
                        //ToDo: Forumconnect System einbinden
                        $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=settogroups&userid=' . $forumcheck . '&groupids=6');
                        DB::table('userlog')->insert(array('userid' => Auth::user()->id, 'action' => 'Forenaccount synchronisiert!', 'timestamp' => time()));
                        return redirect::to('/forum')->with('success', 'Die Forenverifizierung war erfolgreich!');
                    } else {
                        return redirect::to('/forum')->with('error', 'Ungültiger Code!');
                    }
                }
            }
            return redirect::to('/forum')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function updateForum(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->forumaccount > -1) {
                if (time() > Auth::user()->forumupdate) return redirect::to('/forum')->with('error', 'Du kannst deine Forumrechte nur alle 25 Minuten updaten!');
                if(FunctionsController::updateWBBGroups(Auth::user()))
                {
                    return redirect::to('/forum')->with('success', 'Forumrechte erfolgreich aktualisiert!');
                }
                return redirect::to('/forum')->with('error', 'Die Forumrechte konnten nicht aktualisiert werden!');
            }
            return redirect::to('/forum')->with('error', 'Ungültige Interaktion!');
        }
    }

    public function postTwoFactor(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('one_time_password')) && strlen($request->input('one_time_password')) >= 5 && strlen($request->input('one_time_password')) <= 25) {
                DB::table('userlog')->insert(array('userid' => Auth::user()->id, 'action' => 'Zwei-Faktor-Authentisierung aktiviert!', 'timestamp' => time()));
                DB::table('users')->where('id', Auth::user()->id)->update(['google2fa_secret' => encrypt($request->input('one_time_password'))]);
                $request->session()->flash('success', 'Zwei-Faktor-Authentisierung erfolgreich aktiviert!');
                return redirect::to('/home');
            }
            return Redirect::back()->with('error', 'Ungültige Interaktion!');
        }
    }

    public function postDeleteTwoFactor(Request $request)
    {
        if (Auth::check()) {
            session()->forget('google2fa');
            DB::table('users')->where('id', Auth::user()->id)->update(['google2fa_secret' => null]);
            $request->session()->flash('success', 'Zwei-Faktor-Authentisierung erfolgreich deaktiviert!');
            return Redirect::back();
        }
    }

    //selected character
    public function selectCharacter()
    {
        if (Auth::check()) {
            $characters = DB::table('characters')->where('userid', Auth::user()->id)->get();
            if(!$characters)
            {
                session()->forget('nemesusworlducp_adminlogin');
                session()->forget('nemesusworlducp_failedadminlogin');
                session()->forget('nemesusworlducp_lasttry');
                session()->forget('google2fa');
                Auth::logout();
                return redirect('login')->with('error', 'Bitte erstelle dir erst einen Character!');
            }
            return view('character', ['characters' => $characters]);
        }
    }

    //magic mushroom view
    public function magischeMuschel()
    {
        if (Auth::check()) {
            return view('magischemuschel');
        }
    }

    //avatar view
    public function avatar()
    {
        if (Auth::check()) {
            return view('avatar');
        }
    }

    //Ticketsystem
    public function answerTicket(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('id')) && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11) {
                if (!empty($request->input('answer')) && strlen($request->input('answer')) <= 3500 && !is_numeric($request->input('answer')) && strlen($request->input('answer')) >= 15) {
                    $ticket = DB::table('tickets')->where('id', $request->input('id'))->first();
                    if ($ticket) {
                        $checkticket = DB::table('ticket_user')->where('ticketid', $request->id)->where('userid', Auth::user()->id)->first();
                        $adminlevel = -1;
                        if ($ticket->admin != -1) {
                            $adminlevel = DB::table('users')->where('name', $ticket->admin)->value('adminlevel');
                        }
                        if ((Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel >= $adminlevel) || $checkticket) {
                            if ($ticket->status > 1)  return Redirect::back()->withInput($request->all())->with('error', 'Auf das Ticket kann nicht(mehr) geantwortet werden!');
                            DB::table('ticket_answers')->insert(array('ticketid' => $request->input('id'), 'userid' => Auth::user()->id, 'text' => $request->input('answer'), 'timestamp' => time()));
                            return Redirect::back()->with('success', 'Du hast erfolgreich auf das Ticket geantwortet!');
                        } else {
                            return Redirect::back()->withInput($request->all())->with('error', 'Keine Berechtigung!');
                        }
                    }
                } else {
                    return Redirect::back()->withInput($request->all())->with('error', 'Ungültige Antwortlänge!');
                }
            }
            return Redirect::back()->withInput($request->all())->with('error', 'Ungültige Interaktion!');
        }
    }

    public function ticketFinish(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('id')) && is_numeric($request->input('id')) && strlen($request->input('id')) >= 1 && strlen($request->input('id')) <= 11) {
                $ticket = DB::table('tickets')->where('id', $request->input('id'))->first();
                if ($ticket) {
                    if ($ticket->userid == Auth::user()->id) {
                        if ($ticket->status > 1) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        $text = Auth::user()->name . " hat das Ticket als 'erledigt' markiert!";
                        DB::table('ticket_answers')->insert(array('ticketid' => $request->input('id'), 'userid' => Auth::user()->id, 'text' => $text, 'timestamp' => time()));
                        DB::table('tickets')->where('id', $request->input('id'))->update(['status' => 2]);
                        return Redirect::back()->with('success', 'Du hast das Ticket erfolgreich als erledigt markiert!');
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                }
            }
            return Redirect::back()->with('error', 'Ungültige Interaktion!');
        }
    }


    public function showTicket(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->id) && is_numeric($request->id) && strlen($request->id) >= 1 && strlen($request->id) <= 11) {
                $adminlevel = 0;
                $ticket = DB::table('tickets')->where('id', $request->id)->first();
                if ($ticket) {
                    $checkticket = DB::table('ticket_user')->where('ticketid', $request->id)->where('userid', Auth::user()->id)->first();
                    if ($ticket->admin != -1) {
                        $adminlevel = DB::table('users')->where('id', $ticket->admin)->value('adminlevel');
                    }
                    if ((Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->adminlevel >= $adminlevel) || $checkticket) {
                        $answers = DB::table('ticket_answers')->where('ticketid',  $request->id)->orderBy('timestamp', 'asc')->get();
                        return view('layouts.tickets.showticket', ['ticket' => $ticket, 'answers' => $answers, 'adminlevel' => $adminlevel]);
                    } else {
                        return Redirect::back()->with('error', 'Keine Berechtigung!');
                    }
                } else {
                    return Redirect::back()->with('error', 'Keine Berechtigung!');
                }
            }
            return Redirect::back()->with('error', 'Ungültige Interaktion!');
        }
    }

    public function myTickets()
    {
        if (Auth::check()) {
            $mytickets = null;
            if (Auth::user()->adminlevel <= FunctionsController::Kein_Admin || !session('nemesusworlducp_adminlogin')) {
                $mytickets = DB::table('tickets as ts')->distinct()->join('ticket_user as tu', 'ts.id', '=', 'tu.ticketid')->where('ts.status', "!=", 9)->select('ts.*')->where('tu.userid', Auth::user()->id)->orderby('timestamp', 'asc')->limit(50)->get();
            } else {
                if(Auth::user()->adminlevel >= FunctionsController::High_Administrator)
                {
                    $mytickets = DB::table('tickets as ts')->distinct()->join('ticket_user as tu', 'ts.id', '=', 'tu.ticketid')->where('ts.status', "!=", 9)->select('ts.*')->orderby('timestamp', 'asc')->limit(50)->get();
                }
                else
                {
                    $mytickets = DB::table('tickets as ts')->distinct()->join('ticket_user as tu', 'ts.id', '=', 'tu.ticketid')->where('ts.status', "!=", 9)->select('ts.*')->where(function ($q) {
                        $q->where('tu.userid', Auth::user()->id)->orwhere('ts.admin', -1);
                    })->orderby('timestamp', 'asc')->limit(50)->get();
                }
            }
            return view('layouts.tickets.mytickets', ['mytickets' => $mytickets]);
        }
    }

    public function archivTicketsPlayer()
    {
        if (Auth::check()) {
            $mytickets = DB::table('tickets as ts')->distinct()->join('ticket_user as tu', 'ts.id', '=', 'tu.ticketid')->where('ts.status', "=", 9)->select('ts.*')->where('tu.userid', Auth::user()->id)->orderBy('ts.timestamp', 'desc')->limit(50)->get();
            return view('layouts.tickets.ticketsarchivplayer', ['mytickets' => $mytickets]);
        }
    }

    public function createTicket()
    {
        if (Auth::check()) {
            return view('layouts.tickets.createticket');
        }
    }

    public function postCreateTicket(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->name != "Nemesus") return Redirect::back()->with('error', 'Als Admin kannst du keine Tickets erstellen!');
            if (empty($request->input('title') || empty($request->input('prio'))) || empty($request->input('summernote'))) {
                return Redirect::back()->withInput($request->all())->with('error', 'Alle Felder müssen ausgefüllt werden!');
            } else {
                if (strlen($request->input('summernote')) < 15 || strlen($request->input('summernote')) > 3500)
                    return Redirect::back()->withInput($request->all())->with('error', 'Ungültige Beschreibungslänge!');
                if ($request->input('prio') != "low" && $request->input('prio') != "middle" && $request->input('prio') != "high")
                    return Redirect::back()->withInput($request->all())->with('error', 'Ungültige Priorität!');
                if (strlen($request->input('title')) < 3 || strlen($request->input('title')) > 64)
                    return Redirect::back()->withInput($request->all())->with('error', 'Ungültige Titellänge!');
                if (Auth::user()->adminlevel > FunctionsController::Kein_Admin && Auth::user()->name != "Nemesus")
                    return Redirect::back()->withInput($request->all())->with('error', 'Du kannst als Admin kein Ticket eröffnen!');
                $count = DB::table('tickets')->where('userid', Auth::user()->id)->where('status', 1)->count();
                if ($count >= 3)  return Redirect::back()->withInput($request->all())->with('error', 'Du kannst nur max. 3 Tickets gleichzeitig erstellen!');
                $ticketid = DB::table('tickets')->insertGetId(array('userid' => Auth::user()->id, 'title' => $request->input('title'), 'prio' => $request->input('prio'), 'text' => $request->input('summernote'), 'timestamp' => time(), 'status' => 0, 'admin' => -1));
                DB::table('ticket_user')->insert(array('ticketid' => $ticketid, 'userid' => Auth::user()->id, 'timestamp' => time()));
                $webhooktext = Auth::user()->name. " hat ein neues Ticket[".$ticketid."] im UCP erstellt - ".$request->input('title')." | https://ucp.nemesus-world.de/showTicket/".$ticketid;
                $url = "https://discord.com/api/webhooks/990210041418252338/LXEvXHfrFh3N4y22zQIEvyGTJlCGE1sKp5ww9WNyEncs18dn6ZKm1BgQt3NngbUSpHdC";
                $headers = [ 'Content-Type: application/json; charset=utf-8' ];
                $POST = [ 'username' => 'Gameserver', 'content' => $webhooktext ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
                $response   = curl_exec($ch);
                return redirect::to('/myTickets')->with('success', 'Das Ticket wurde erfolgreich angelegt, in kürze wird sich ein Teammitglied bei dir melden!');
            }
        }
    }

    //statistics
    public function getStatistic()
    {
        if (Auth::check()) {
            $level = DB::table('users')->orderBy('level', 'desc')->limit(10)->get();
            $play_time = DB::table('users')->orderBy('play_time', 'desc')->limit(10)->get();
            $shootingrange = DB::table('users')->where('shootingrange','>',0)->orderBy('shootingrange', 'asc')->limit(10)->get();
            $tode = DB::table('users')->orderBy('deaths', 'desc')->limit(10)->get();
            $crimes = DB::table('users')->orderBy('crimes', 'desc')->limit(10)->get();
            $login_bonus = DB::table('users')->orderBy('login_bonus', 'desc')->limit(10)->get();
            $accounts = DB::table('users')->count();
            $charaktere = DB::table('characters')->count();
            $cars = DB::table('vehicles')->count();
            $houses = DB::table('houses')->count();
            $team = DB::table('users')->where('adminlevel','>',0)->count();
            return view('getstatistic', ['level' => $level, 'play_time' => $play_time, 'tode' => $tode, 'login_bonus' => $login_bonus, 'crimes' => $crimes, 'accounts' => $accounts, 'charaktere' => $charaktere, 'cars' => $cars, 'houses' => $houses, 'team' => $team, 'shootingrange' => $shootingrange]);
        }
    }

    //Update selected character
    public function changeCharacter($charid = null)
    {
        if (Auth::check()) {
            if (!is_numeric($charid) || $charid == -1) return Redirect::back()->with('error', 'Ungültige Interaktion!');

            if (Auth::user()->online == 1) return Redirect::back()->with('error', 'Du bist nicht offline!');

            $count = DB::table('characters')->where('userid', Auth::user()->id)->count();

            if ($charid < 0 || $charid > $count) return Redirect::back()->with('error', 'Ungültige Interaktion!');

            $realcharid = DB::table('characters')->where('userid', Auth::user()
            ->id)->skip($charid)->first()->id;

            DB::table('users')->where('id', Auth::user()
                ->id)
                ->update(['selectedcharacter' => $charid]);

            DB::table('users')->where('id', Auth::user()
                ->id)
                ->update(['selectedcharacterintern' => $realcharid]);

            return Redirect::back()->with('success', 'Charakterwechsel erfolgreich!');
        }
    }

    //Car view
    public function getCars()
    {
        if (Auth::check()) {
            $id = DB::table('characters')->where('userid', Auth::user()
                ->id)
                ->value('id');
            $count = DB::table('vehicles')->where('owner', 'character-' . $id)
                ->count();
            if (!$count || $count <= 0) return redirect::to('/home')->with('error', 'Keine Fahrzeuge vorhanden!');
            $vehicles = DB::table('vehicles')->where('owner', 'character-' . $id)
                ->get();
            return view('cars', ['vehicles' => $vehicles]);
        }
    }

    //Housesystem
    public function getHouse()
    {
        if (Auth::check()) {
            $name = DB::table('characters')->where('id', Auth::user()
            ->selectedcharacterintern)
            ->value('name');
            $house = DB::table('houses')->where('owner', $name)->get();
            $count = DB::table('houses')->where('owner', $name)->count();
            if (!$count || $count <= 0) return redirect::to('/home')->with('error', 'Keine Häuser vorhanden!');
            return view('house', ['houses' => $house]);
        }
    }

        //Bizzsystem
        public function getBizz()
        {
            if (Auth::check()) {
                $name = DB::table('characters')->where('id', Auth::user()
                ->selectedcharacterintern)
                ->value('name');
                $bizz = DB::table('business')->where('owner', $name)->get();
                $count = DB::table('business')->where('owner', $name)->count();
                if (!$count || $count <= 0) return redirect::to('/home')->with('error', 'Keine Businesse vorhanden!');
                return view('bizz', ['bizz' => $bizz]);
            }
        }

    public function getFurniture($id=-1)
    {
        if (Auth::check()) {
        if (!is_numeric($id) || $id == -1) return Redirect::back()->with('error', 'Ungültige Interaktion!');
            if (Auth::check()) {
                 $name = DB::table('houses')->where('id', $id)
                ->value('owner');
                $name2 = DB::table('characters')->where('id', Auth::user()
                ->selectedcharacterintern)
                ->value('name');
                if($name != $name2) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                $furniture = DB::table('furniturehouse')->where('house', $id)->get();
                if (!$furniture) return redirect::to('/house')->with('error', 'Keine Möbelstücke vorhanden!');
                return view('furniture', ['furniture' => $furniture]);
            }
        }
    }

    public function GetTenants($id=-1)
    {
        if (Auth::check()) {
        if (!is_numeric($id) || $id == -1) return Redirect::back()->with('error', 'Ungültige Interaktion!');
            if (Auth::check()) {
                 $name = DB::table('houses')->where('id', $id)
                ->value('owner');
                $name2 = DB::table('characters')->where('id', Auth::user()
                ->selectedcharacterintern)
                ->value('name');
                if($name != $name2) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                $search = "Miethausnummer: ".$id;
                $tenants = DB::table('characters')->select('id','name')->where('items', 'like', '%' . $search . '%')->get();
                if (!$tenants) return redirect::to('/house')->with('error', 'Keine Mieter vorhanden!');
                return view('tenants', ['tenants' => $tenants]);
            }
        }
    }

    //advertised
    public function getAdvertised()
    {
        if (Auth::check()) {
            $count = DB::table('users')->where('geworben', Auth::user()->name)->count();
            if (!$count) return redirect::to('/home')->with('error', 'Du hast noch keine Spieler geworben!');
            $advertised = DB::table('users')->where('geworben', Auth::user()->name)->orderBy('account_created', 'desc')->get();
            return view('geworben', ['geworben' => $advertised]);
        }
    }

    //inactiv
    public function getInaktiv()
    {
        if (Auth::check()) {
            $inaktiv = DB::table('inactiv')->where('userid', Auth::user()->id)->limit(1)->get();
            return view('inaktiv', ['inaktiv' => $inaktiv]);
        }
    }

    public function unsetInaktiv()
    {
        if (Auth::check()) {
            DB::table('inactiv')->where('userid', '=', Auth::user()->id)->delete();
            DB::table('userlog')->insert(array('userid' => Auth::user()->id, 'action' => 'Inaktivitätsmeldung aufgehoben', 'timestamp' => time()));
            return redirect::to('/inaktiv')->with('success', 'Inaktivitätsmeldung erfolgreich aufgehoben!');
        }
    }

    public function setInaktiv(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('grund')) && strlen($request->input('grund')) > 3 && strlen($request->input('grund')) <= 35 && !empty($request->input('daterange')) && strlen($request->input('daterange')) == 23) {
                $datum = explode("-", strval($request->input('daterange')));
                if (Auth::user()->online == 1) return redirect::to('/inaktiv')->with('error', 'Du bist nicht offline!');
                if (strlen($datum[0]) != 11 || strlen($datum[1]) != 11) return redirect::to('/inaktiv')->with('error', 'Ungültiger Grund oder ungültiges Datum!');
                DB::table('userlog')->insert(array('userid' => Auth::user()->id, 'action' => 'Inaktiv gemeldet', 'timestamp' => time()));
                DB::table('inactiv')->insert(array('userid' => Auth::user()->id, 'date1' => strtotime($datum[0]), 'date2' => strtotime($datum[1]), 'text' => $request->input('grund')));
                return redirect::to('/inaktiv')->with('success', 'Erfolgreich inaktiv gemeldet!');
            } else {
                return redirect::to('/inaktiv')->with('error', 'Ungültiger Grund oder ungültiges Datum!');
            }
        }
    }

    //user settings
    public function changeName(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->namechanges <= 0) return redirect::to('/home')->with('error', 'Du hast keine Namechanges mehr!');
            if (!empty($request->input('name') && strlen($request->input('name')) >= 3 && strlen($request->input('name')) <= 35) && Auth::user()->name != $request->input('name')) {
                $checkname = DB::table('users')->where('name', $request->input('name'))->first();
                if (Auth::user()->online == 1) return redirect::to('/home')->with('error', 'Du bist nicht offline!');
                if ($checkname) return redirect::to('/home')->with('error', 'Dieser Name ist bereits vergeben!');
                preg_match('^[A-Z][a-zA-Z]{2,35}^', $request->input('name'), $matches, PREG_OFFSET_CAPTURE);
                if (!$matches) return Redirect::back()->with('error', 'Für den Accountnamen dürfen nur Buchstaben benutzt werden und der erste Buchstabe muss groß geschrieben werden!');
                if (Auth::user()->forumaccount > -1) {
                    $client = new \GuzzleHttp\Client();
                    //ToDo: Forumconnect System einbinden
                    $response = $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=updatename&userid=' . Auth::user()->forumaccount . '&name=' . $request->input('name'));
                    if ((int)$response->getBody()->getContents() != 1) return redirect::to('/home')->with('error', 'Ungültiger Name!');
                }
                DB::table('users')->where('id', Auth::user()->id)->update(['name' => $request->input('name')]);
                DB::table('users')->where('geworben', Auth::user()->name)->update(['geworben' => $request->input('name')]);
                DB::table('userlog')->insert(array('userid' => Auth::user()->id, 'action' => 'Accountname geändert', 'timestamp' => time()));
                DB::table('namechanges')->insert(array('status' => 1, 'userid' => Auth::user()->id, 'oldname' => Auth::user()->name, 'newname' => $request->input('name'), 'timestamp' => time()));
                return redirect::to('/home')->with('success', 'Accountname erfolgreich geändert!');
            } else {
                return redirect::to('/home')->with('error', 'Ungültiger Accountname!');
            }
        }
    }

    public function changePassword(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('password') && strlen($request->input('password')) >= 6 && strlen($request->input('password')) <= 35)) {
                DB::table('userlog')->insert(array('userid' => Auth::user()->id, 'action' => 'Neues Passwort gesetzt', 'timestamp' => time()));
                $newpassword = $request->input('password');
                DB::table('users')->where('id', Auth::user()->id)->update(['password' => Hash::make($newpassword."(8wgwWoRld136=")]);
                return redirect::to('/home')->with('success', 'Passwort erfolgreich geändert!');
            } else {
                return redirect::to('/home')->with('error', 'Ungültiges Passwort!');
            }
        }
    }

    //banksystem
    public function selectBank()
    {
        if (Auth::check()) {
            $found = false;
            $banknumbers = array();
            $items = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('items');
            if($items)
            {
                $getitems = json_decode($items);
                foreach($getitems as $data)
                {
                    if($data->description == "EC-Karte" && strlen($data->props) > 5)
                    {
                        array_push($banknumbers, $data->props);
                        $found = true;
                    }
                }
            }
            array_unique($banknumbers);
            if ($found == false) return redirect::to('/home')->with('error', 'Kein Konto vorhanden!');
            $bank = DB::table('bank')->whereIn('banknumber', $banknumbers)->get();
            return view('selectbank', ['bank' => $bank]);
        }
    }

    public function getBank(Request $request)
    {
        if (Auth::check()) {
            $banknumber = $request->input('banknumber');
            if(!$banknumber || strlen($banknumber) != 13) return redirect::to('/selectBank')->with('error', 'Ungültige Interaktion!');
            $bank = DB::table('bank')->where('banknumber', $banknumber)->first();
            if(!$bank) return redirect::to('/selectBank')->with('error', 'Ungültige Interaktion!');
            $standingorder = DB::table('standingorder')->where('bankfrom', $banknumber)->orderBy('id', 'desc')->get();
            $bankfiles = DB::table('bankfile')->where('bankid', $bank->id)->orderBy('id', 'desc')->get();
            $banksettings = DB::table('banksettings')->where('banknumber', $banknumber)->orderBy('id', 'desc')->get();
            return view('bank', ['bank' => $bank, 'standingorder' => $standingorder, 'bankfiles' => $bankfiles, 'banksettings' => $banksettings]);
        }
    }

    public function getBank2($id)
    {
        if (Auth::check()) {
            $found = false;
            $banknumber = $id;
            if(!$banknumber || strlen($banknumber) != 13) return redirect::to('/selectBank')->with('error', 'Ungültige Interaktion!');
            $bank = DB::table('bank')->where('banknumber', $banknumber)->first();
            if(!$bank) return redirect::to('/selectBank')->with('error', 'Ungültige Interaktion!');
            $items = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('items');
            if($items)
            {
                $getitems = json_decode($items);
                foreach($getitems as $data)
                {
                    if($data->description == "EC-Karte" && strlen($data->props) > 5 && $data->props == $id)
                    {
                        $found = true;
                        break;
                    }
                }
            }
            if ($found == false) return redirect::to('/selectBank')->with('error', 'Ungültige Interaktion!');
            $standingorder = DB::table('standingorder')->where('bankfrom', $banknumber)->orderBy('id', 'desc')->get();
            $bankfiles = DB::table('bankfile')->where('bankid', $bank->id)->orderBy('id', 'desc')->get();
            $banksettings = DB::table('banksettings')->where('banknumber', $banknumber)->orderBy('id', 'desc')->get();
            return view('bank', ['bank' => $bank, 'standingorder' => $standingorder, 'bankfiles' => $bankfiles, 'banksettings' => $banksettings]);
        }
    }

    public function transfer(Request $request)
    {
        if (Auth::check()) {
            $inputs = array(
                'von' => $request->input('von'),
                'empfänger' => $request->input('empfänger'),
                'betrag' => $request->input('betrag'),
                'verwendungszweck' => $request->input('verwendungszweck'),
                'bankpin' => $request->input('bankpin'),
                'tage' => $request->input('tage')

            );
            if (!empty($inputs['von']) && !empty($inputs['empfänger']) && !empty($inputs['betrag']) && !empty($inputs['verwendungszweck']) && !empty($inputs['bankpin'])) {
                if (!is_numeric($inputs['betrag'])) {
                    return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Ungültige Betrag Eingabe!');
                }
                if (!is_numeric($inputs['bankpin'])) {
                    return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Ungültige Pin Eingabe!');
                }
                $found = false;
                $items = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('items');
                if($items)
                {
                    $getitems = json_decode($items);
                    foreach($getitems as $data)
                    {
                        if($data->description == "EC-Karte" && strlen($data->props) > 5 && $data->props == $request->input('von'))
                        {
                            $found = true;
                            break;
                        }
                    }
                }
                if ($found == false) return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Ungültige Interaktion!');
                $bankstats = DB::table('bank')->where('banknumber', $inputs['von'])->first();
                $bankstats2 = DB::table('bank')->where('banknumber', $inputs['empfänger'])->first();
                if ($inputs['von'] == $inputs['empfänger']) return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Ungültiges Empfängerkonto!');
                if (!$bankstats2) return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Ungültiges Empfängerkonto!');
                if (intval($inputs['bankpin']) != intval($bankstats->pincode)) return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Ungültige Pin Eingabe!');
                if (intval($inputs['betrag']) > intval($bankstats->bankvalue)) return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Soviel Geld ist auf dem Konto nicht verfügbar!');
                if (empty($inputs['tage'])) {
                    DB::table('transfer')->insert(array('bankfrom' => $inputs['von'], 'bankto' => $inputs['empfänger'], 'banktext' => $inputs['verwendungszweck'], 'bankvalue' => $request->input('betrag'), 'bankname' => FunctionsController::getCharacterNameByID(Auth::user()->selectedcharacterintern)));
                    return redirect()->to('getBank2/'.$request->input('von'))->with('success', 'Überweisung getätigt, diese wird innerhalb der nächsten 30 Minuten durchgeführt!');
                } else {
                    if (!is_numeric($inputs['tage']) || strlen($inputs['tage']) > 3 || strlen($inputs['tage']) < 1) {
                        return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Ungültige Tage!');
                    }
                    DB::table('banksettings')->insert(array('banknumber' => $bankstats->banknumber, 'setting' => 'Dauerauftrag eingestellt!', 'value' => $inputs['betrag'], 'name' => FunctionsController::getCharacterNameByID(Auth::user()->selectedcharacterintern), 'timestamp' => time()));
                    DB::table('standingorder')->insert(array('ownercharid' => Auth::user()->selectedcharacter, 'bankfrom' => $inputs['von'], 'bankto' => $inputs['empfänger'], 'bankvalue' => $inputs['betrag'], 'banktext' => $inputs['verwendungszweck'], 'days' => $inputs['tage'], 'timestamp' => time()));
                    DB::table('transfer')->insert(array('bankfrom' => $inputs['von'], 'bankto' => $inputs['empfänger'], 'banktext' => $inputs['verwendungszweck'], 'bankvalue' => $request->input('betrag'), 'bankname' => FunctionsController::getCharacterNameByID(Auth::user()->selectedcharacterintern)));
                    return redirect()->to('getBank2/'.$request->input('von'))->with('success', 'Dauerauftrag erfolgreich erstellt, Überweisung wird innerhalb der nächsten 30 Minuten durchgeführt. Die nächste Überweisung wird in ' . $inputs['tage'] . ' Tagen getätigt!');
                }
            } else {
                return redirect()->to('getBank2/'.$request->input('von'))->with('error', 'Alle Felder müssen ausgefüllt sein!');
            }
        }
    }

    //Change theme
    public function changeTheme(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->input('newtheme')) && ($request->input('newtheme') == "dark" || $request->input('newtheme') == "light")) {
                if (Auth::user()->online == 1) return redirect::to('/')->with('error', 'Du bist nicht offline!');
                $newtheme = $request->input('newtheme');
                DB::table('users')->where('id', Auth::user()->id)->update(['theme' => $newtheme]);
                if (Auth::user()->forumaccount > -1) {
                    $client = new \GuzzleHttp\Client();
                    if ($newtheme == 'dark') {
                        //ToDo: Forumconnect System einbinden
                        $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=updatetheme&userid=' . Auth::user()->forumaccount . '&theme=2');
                    } else {
                        //ToDo: Forumconnect System einbinden
                        $client->get('HIER/forumConnect.php?id=9yeBgA33sVxRWkvXLmQv&status=updatetheme&userid=' . Auth::user()->forumaccount . '&theme=3');
                    }
                }
                return redirect::to('/')->with('success', 'Theme erfolgreich geändert, wenn sich der Style im Forum nicht ändert, einfach einmal aus/einloggen im Forum!');
            }
        }
        return redirect::to('/')->with('success', 'Ungültige Interaktion!');
    }

    //Change ucp status
    public function changeUcpStatus()
    {
        if (Auth::check()) {
            $status = DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->value('ucp_privat');
            if($status == 0)
            {
                $status = 1;
            }
            else
            {
                $status = 0;
            }
            DB::table('characters')->where('id', Auth::user()->selectedcharacterintern)->update(['ucp_privat' => $status]);
            return redirect::to('/')->with('success', 'UCP Status erfolgreich aktualisiert!');
        }
        return redirect::to('/')->with('success', 'Ungültige Interaktion!');
    }

    public function searchShow($id)
    {
        if (Auth::check()) {
            if (!empty($id) && is_numeric($id) && strlen($id) >= 1 && strlen($id) <= 11) {
                $realid = $id;
                $character = DB::table('characters')->where('id', $realid)->first();
                if ($character) {
                    if ($character->ucp_privat == 0) {
                        $user = DB::table('users')->where('id', $character->userid)->first();
                        if ($user->dsgvo_closed == 1) return Redirect::back()->with('error', 'Ungültige Interaktion!');
                        $timeline = DB::table('timeline')->where('userid', $character->userid)->orderBy('id', 'desc')->get();
                        $inaktiv = DB::table('inactiv')->where('userid',  $character->userid)->first();
                        return view('searchshow', ['characters' => $character, 'timeline' => $timeline, 'user' => $user, 'inaktiv' => $inaktiv]);
                    }
                    return Redirect::back()->with('error', 'Das Profil steht auf privat!');
                } else {
                    return Redirect::back()->with('error', 'Ungültige Interaktion!');
                }
            } else {
                return Redirect::back()->with('error', 'Ungültige Interaktion!');
            }
        }
    }

    public function search(Request $request)
    {
        if (Auth::check()) {
            $search = $request->search;
            if (str_contains($request->search, 'SELECT') || str_contains($request->search, 'UPDATE') || str_contains($request->search, 'DELETE') || str_contains($request->search, 'DROP') || str_contains($request->search, 'TRUNCATE')) {
                abort(403);
            }
            $validator = Validator::make($request->all(), [
                'search' => 'required|max:35|min:3',
            ]);

            if (!$validator->fails()) {
                $search = FunctionsController::db_esc_like_raw($search);
                $countchar = DB::table('characters')->where('name', 'like', '%' . $search . '%')->where('closed', 0)->count();
                if (!$countchar || $countchar <= 0) return view('search', ['characters' => null]);
                $characters = DB::table('characters')->select('id', 'userid', 'name', 'ucp_privat', 'closed', 'screen')->where('closed', 0)->where('name', 'like', '%' . $search . '%')->orwhere('name', $search)->limit(4)->get();
                return view('search', ['characters' => $characters]);
            }
            return view('search', ['characters' => null]);
        }
    }

    public function searchUser(Request $request)
    {
        if (Auth::check()) {
            if (!empty($request->search) && strlen($request->search) > 3 && strlen($request->search) <= 35) {
                return redirect()->route('search', ['search' => $request->search]);
            }
            return Redirect::to('/home');
        }
    }

    public function signOut()
    {
        if (Auth::check()) {
            return view('layouts.auth.signout');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            session()->forget('nemesusworlducp_adminlogin');
            session()->forget('nemesusworlducp_failedadminlogin');
            session()->forget('nemesusworlducp_lasttry');
            session()->forget('google2fa');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Auth::logout();
            return redirect('/login')->with('success', 'Logout war erfolgreich!');
        }
    }

    public static function logoutUser()
    {
        if (Auth::check()) {
            session()->forget('nemesusworlducp_adminlogin');
            session()->forget('nemesusworlducp_failedadminlogin');
            session()->forget('nemesusworlducp_lasttry');
            session()->forget('google2fa');
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            Auth::logout();
        }
    }
}
