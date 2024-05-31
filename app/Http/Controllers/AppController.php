<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Incident;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\Room;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    /* Función que redirije al usuario al home o al login */
    public function index()
    {
        if (Auth::check()) {
            // Recoge los socios expulsados .-
            $prtIds = PartnerUser::where([
                ['expulsado', true],
                ['idUsuario', Auth::user()->id],
                ['deshabilitado', false],
            ])->get(['idSocio']);

            $oPrts = Partner::whereIn('idSocio', $prtIds)->where([
                ['deshabilitado', false],
            ])->get();

            // Recoge los proximos eventos .-
            $rmsIds = Room::where('idUsuario', Auth::user()->id)->get(['idSala']);
            $evs = Event::whereIn('idSala', $rmsIds )->where('deshabilitado', false)->get();

            // Recoge los socios nuevos en los ultimos 15 dias .-
            $date = now();
            date_sub($date, date_interval_create_from_date_string("15 days"));
            
            $prtIds = PartnerUser::where([['idUsuario', Auth::user()->id], ['fechaAlta', '>=', $date]], ['deshabilitado', false])->get(['idSocio']);
            $nwPrts = Partner::whereIn('idSocio', $prtIds)->get();

            // Recoge las nuevas incidencias en los ultimos 15 dias .-
            $incs = Incident::where([['fechaInc', '>=', $date], ['deshabilitado', false], ['idUsuario', Auth::user()->id]])->get();
            
            // Se almacena todo en una variable .-
            $data = [
                'outPartners' => $oPrts,
                'events' => $evs,
                'newPartners' => $nwPrts,
                'incidents' => $incs
            ];
            
            return view('index')->with('data', $data);
        } else {
            return redirect()->route('login.index');
        }
    }

    public function show()
    {
        return view('index');
    }
}
