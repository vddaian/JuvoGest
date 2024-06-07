<?php

namespace App\Http\Middleware;

use App\Models\Room;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Room::where([
            ['idSala', $request->id],
            ['idUsuario', Auth::user()->id],
            ['deshabilitado', false],
        ])->exists()) {
            if($request->id != session()->get('storage')[0]['idSala']){
            return $next($request);
            } else {
            	return redirect()->back()->with('info', [
                	'error' => true,
                	'message' => 'No puedes modificar el almacen principal!'
            	]);
            }
        } else{
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'La sala a la cual intentas acceder no esta disponible!'
            ]);
        }
    }
}
