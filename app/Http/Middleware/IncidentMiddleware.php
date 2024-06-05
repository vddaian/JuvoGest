<?php

namespace App\Http\Middleware;

use App\Models\Incident;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IncidentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Incident::where([
            ['idIncidencia', $request->id],
            ['idUsuario', Auth::user()->id],
            ['deshabilitado', false],
        ])->exists()) {
            return $next($request);
        } else{
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'La incidencia a la cual intentas acceder no esta disponible!'
            ]);
        }
        
    }
}
