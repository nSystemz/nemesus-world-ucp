<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\FunctionsController as FunctionsController;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Checkban
        if (auth()->check() && (auth()->user()->ban > 0 || auth()->user()->dsgvo_closed == 1))
        {
            HomeController::logoutUser();
            session()->flash('error', 'Dieser Account ist gesperrt!');
            return redirect()->route('login');
        }
        //Charakterlöschung
        if(auth()->user()->selectedcharacter == -1 && auth()->user()->selectedcharacterintern == -1)
        {
            HomeController::logoutUser();
            session()->flash('error', 'Bitte wähle einen Charakter ingame aus, oder erstelle dir einen!');
            return redirect()->route('login');
        }
        //Forumupdate
        if(auth()->check() && auth()->user()->forumaccount > -1 && (auth()->user()->forumupdate+432000) < time())
        {
            FunctionsController::updateWBBGroups(auth()->user());
        }
        //Wartungsmodus check
        if(auth()->check() && FunctionsController::CheckWartung())
        {
            abort(599, "Wartungsmodus, wir sind in kürze wieder zurück!");
        }
        return $next($request);
    }
}
