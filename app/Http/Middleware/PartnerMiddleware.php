<?php

namespace App\Http\Middleware;

use App\Http\Controllers\PartnerController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $prt = new PartnerController();
        if ($prt->userRelationExists($request->id)) {
            return $next($request);
        } else {
            return redirect()->back()->with('info', [
                'error' => true,
                'message' => 'El usuario al cual intentas acceder no esta disponible!'
            ]);
        }
    }
}
