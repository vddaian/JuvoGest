<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncidentController extends Controller
{
    /* Función que devuelve ha la lista de incidencias */
    public function index()
    {

        // Recoge todas las incidencias que tiene el centro .-
        $ins = DB::table('V_PartnersIncidents')->where([
            ['idUsuario', Auth::user()->id],
            ['deshabilitado', false]
        ])->paginate(25);

        // Recoge todos los socios que tiene el centro .-
        $ptnsIds = PartnerUser::where('idUsuario', Auth::user()->id)->get(['idSocio']);
        $ptns = Partner::whereIn('idSocio', $ptnsIds)->where('deshabilitado', false)->get();

        // Se almacena todo en una variable .-
        $data = [
            'incidents' => $ins,
            'partners' => $ptns
        ];
        return view('incidents.list')->with('data', $data);
    }

    /* Función que envia a la vista de la sala con la lista de incidencias filtrada */
    public function filter(Request $req)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('id') && !$req->filled('fecha') && $req->socio == '-' && $req->tipo == '-') {
            return redirect()->route('incident.index');
        } else {
            try {
                $query = DB::table('V_PartnersIncidents');
                // Comprueba si los campos se han rellenado y añade las condiciones .-
                if ($req->filled('id')) {
                    $query->where('idIncidencia', $req->id);
                }

                if ($req->filled('fecha')) {
                    $query->where('fechaInc', $req->fecha);
                }

                if ($req->tipo != '-') {
                    $query->where('tipo', $req->tipo);
                }

                if ($req->socio != '-') {
                    $query->where('idSocio', $req->socio);
                }

                // Recoge las incidencias .-
                $query->where([['deshabilitado', false], ['idUsuario', Auth::user()->id]]);
                $ins = $query->paginate(25);

                // Recoge todos los socios que tiene el centro .-
                $ptnsIds = PartnerUser::where('idUsuario', Auth::user()->id)->get(['idSocio']);
                $ptns = Partner::whereIn('idSocio', $ptnsIds)->where('deshabilitado', false)->get();

                // Se almacena todo en una variable .-
                $data = [
                    'incidents' => $ins,
                    'partners' => $ptns
                ];

                return view('incidents.list')->with('data', $data);
            } catch (Exception $err) {
                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Función que envia a la vista de la sala con la lista de incidencias filtrada */
    public function filterFromPartner(Request $req, $idSocio)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('fecha') && $req->tipo == '-') {
            return redirect()->route('partner.view', $idSocio);
        } else {
            try {
                $query = Incident::query();
                // Comprueba si los campos se han rellenado y añade las condiciones .-

                if ($req->filled('fecha')) {
                    $query->where('fechaInc', $req->fecha);
                }

                if ($req->tipo != '-') {
                    $query->where('tipo', $req->tipo);
                }

                // Recoge las incidencias .-
                $query->where([['deshabilitado', false], ['idSocio', $idSocio]]);
                $ins = $query->paginate(25);

                // Recoge la información del socio .-
                $prt = new PartnerController();
                $prt = $prt->getPartnerInfo($idSocio);

                // Se almacena todo en una variable .-
                $data = [
                    'incidents' => $ins,
                    'partner' => $prt
                ];

                return view('partners.view')->with('data', $data);
            } catch (Exception $err) {
                return redirect()->back()->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }

    /* Función que redirege a la página de creación */
    public function createIndex()
    {

        // Recoge todos los socios que tiene el centro .-
        $ptnsIds = PartnerUser::where('idUsuario', Auth::user()->id)->get(['idSocio']);
        $ptns = Partner::whereIn('idSocio', $ptnsIds)->where('deshabilitado', false)->get();

        return view('incidents.create')->with('data', $ptns);
    }
    /* Función que redirige a la página de edición */
    public function editIndex($id)
    {
        // Recoge todos los socios que tiene el centro .-
        $ptnsIds = PartnerUser::where('idUsuario', Auth::user()->id)->get(['idSocio']);
        $ptns = Partner::whereIn('idSocio', $ptnsIds)->where('deshabilitado', false)->get();

        // Recoge la información de la incidencia .-
        $inc = $this->getIncidentInfo($id);

        // Se almacena toda la info dentro de una variable .-
        $data = [
            'partners' => $ptns,
            'incident' => $inc
        ];
        return view('incidents.edit')->with('data', $data);
    }

    /* Función que redirige a la vista de la incidencia */
    public function viewIndex($id)
    {
        // Recoge la información de la incidencia .-
        $inc = $this->getIncidentInfo($id);
        return view('incidents.view')->with('data', $inc);
    }

    /* Función que realiza el almacenamiento de la incidencia */
    public function store(Request $req)
    {
        // Verifica los campos .-
        $this->validateOthers($req);

        // Se almacena todo en una variable .-
        $data = [
            'idUsuario' => Auth::user()->id,
            'idSocio' => $req->socio,
            'tipo' => $req->tipo,
            'fechaInc' => date('Y-m-d'),
            'fechaFinExp' => $req->fechaFinExp,
            'informacion' => $req->info
        ];
        try {
            // Cambia el estado del socio a expulsado .-
            PartnerUser::where('idSocio', $req->socio)->update(['expulsado' => true]);

            Incident::create($data);
            return redirect()->back()->with('info', ['message' => 'Incidencia creada con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que actualiza la incidencia */
    public function update(Request $req, $id)
    {
        // Verifica los campos .-
        $this->validateOthers($req);

        // Se almacena todo en una variable .-
        $data = [
            'idSocio' => $req->socio,
            'tipo' => $req->tipo,
            'fechaFinExp' => $req->fechaFinExp,
            'informacion' => $req->info
        ];
        try {
            Incident::where('idIncidencia', $id)->update($data);
            return redirect()->back()->with('info', ['message' => 'Incidencia actualizada con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que deshabilita la incidencia */
    public function disable($id)
    {
        try {
            Incident::where('idIncidencia', $id)->update(['deshabilitado' => true]);
            return redirect()->back()->with('info', ['message' => 'Incidencia eliminada con exito!']);
        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }
    }

    /* Función que devuelve toda la información de la incidencia */
    public function getIncidentInfo($id)
    {
        return DB::table('V_PartnersIncidents')->where('idIncidencia', $id)->get();
    }

    /* Metodo que realiza la validación de los campos que no son numericos */
    public function validateOthers($req)
    {
        $val = $req->validate([
            'fechaFinExp' => 'required|date'
        ]);
    }

    /* Metodo que comprueba si hay socios que se les acaba la expulsión y luego les quita el estado de expulsion */
    public static function checkOutDates()
    {
        $prts = Incident::where('deshabilitado', false)
            ->whereDate('fechaFinExp', '=', now()->format('Y-m-d'))
            ->groupBy('idSocio')
            ->select('idSocio', DB::raw('MAX(fechaFinExp) as fechaFinExp'))
            ->get();

        foreach ($prts as $key => $value) {
            Log::debug($value);
        }
        /* PartnerUser::whereIn('idSocio', $prts)->update(['expulsado', false]); */
    }
}
