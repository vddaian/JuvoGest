<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /* Función que devuelve la lista de socios */
    public function partnersIndex()
    {
        $prts = Partner::whereColumn('idSocio','!=', 'dni')->paginate(25);
        return view('admin.partners')->with('data', $prts);
    }

    /* Función que envia a la lista de socios filtrada */
    public function partnersFilter(Request $req)
    {
        // Comprueba si alguno de los campos ha sido rellenado .-
        if (!$req->filled('dni') && !$req->filled('nombre') && !$req->filled('apellido') && !$req->filled('fecha')) {
            return redirect()->route('admin.partners.index');
        } else {
            try {
                $query = Partner::query();

                // Comprueba si los campos se han rellenado y añade las condiciones .-
                if ($req->filled('dni')) {
                    $query->where('dni', 'like', '%' . $req->dni . '%');
                }

                if ($req->filled('nombre')) {
                    $query->where('prNombre', 'like', '%' . $req->nombre . '%');
                    $query->orWhere('sgNombre', 'like', '%' . $req->nombre . '%');
                }

                if ($req->filled('apellido')) {
                    $query->where('prApellido', 'like', '%' . $req->apellido . '%');
                    $query->orWhere('sgApellido', 'like', '%' . $req->apellido . '%');
                }

                if ($req->filled('fecha')) {
                    $query->where('fechaNacimiento', $req->fecha);
                }

                // Recoge los socios del centro .-
                $query->where('deshabilitado', false);

                $objs = $query->paginate(25);
                return view('admin.partners')->with('data', $objs);
            } catch (Exception $err) {
                echo $err;
                return redirect()->route('app.show')->with('info', [
                    'error' => $err,
                    'message' => 'Algo no ha ido bien!'
                ]);
            }
        }
    }


    /* Función que deshabilita y elimina todos los datos del socio */
    public function deletePartnerInfo( Request $req)
    {

        // Deshabilita todas las relaciones que tiene el socio con los centros o con alguna referencia .-
        $this->disableAllPartnerRelations($req->id);

        // Remplaza todos los datos del socio por '-'
        $data = [
            'dni' => $req->id,
            'prNombre' => '-',
            'sgNombre' => '-',
            'prApellido' => '-',
            'sgApellido' => '-',
            'fechaNacimiento' => date_create('01-01-1999'),
            'direccion' => '-',
            'localidad' => '-',
            'cp' => 0,
            'telefono' => 0,
            'prTelefonoResp' => 0,
            'sgTelefonoResp' => 0,
            'email' => '-',
            'alergias' => '-',
            'foto' => '-'
        ];

        Partner::where('idSocio', $req->id)->update($data);

        return redirect()->back()->with('info', ['message' => 'Socio eliminado con exito!']);
    }

    /* Metodo que realiza toda la deshabilitacion de relaciones del socio */
    public function disableAllPartnerRelations($id)
    {
        try {

            // Deshabilita la relacion con los centros .-
            PartnerUser::where('idSocio', $id)->update(['deshabilitado' => true]);

            // Deshabilita el socio .-
            Partner::where('idSocio', $id)->update(['deshabilitado' => true]);

            // Deshabilita todos los incidentes que ha tenido .-
            Incident::where('idSocio', $id)->update(['deshabilitado' => true]);

        } catch (Exception $err) {
            return view('other.error')->with('data', $err);
        }



    }
}
