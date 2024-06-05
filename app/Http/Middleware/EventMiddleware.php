<?php

namespace App\Http\Middleware;

use App\Models\Event;
use App\Models\Incident;
use App\Models\Room;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EventMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rmsIds = Room::where([['idUsuario', Auth::user()->id],['deshabilitado', false]])->get(['idSala']);
        if (Event::whereIn('idSala', $rmsIds)->where([['deshabilitado', false], ['idEvento', $request->id]])->exists()) {
            return $next($request);
        } else{
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'El evento al cual intentas acceder no esta disponible!'
            ]);
        }
    }
}
