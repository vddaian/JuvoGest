<?php

namespace App\Http\Middleware;

use App\Models\Resource;
use App\Models\Room;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ResourceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rmsIds = Room::where([['idUsuario', Auth::user()->id],['deshabilitado', false]])->get(['idSala']);
        if (Resource::whereIn('idSala', $rmsIds)->where([['idRecurso', $request->id], ['deshabilitado', false]])->exists()) {
            return $next($request);
        } else{
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'El recurso al cual intentas acceder no esta disponible!'
            ]);
        }
    }
}
