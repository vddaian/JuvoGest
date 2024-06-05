<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Incident;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\Resource;
use App\Models\Room;
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
                return redirect()->back()->with('info', [
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

     /* Función que deshabilita y elimina todos los datos del socio */
     public function deleteCenterInfo( Request $req)
     {
 
         // Deshabilita todas las relaciones que tiene el socio con los centros o con alguna referencia .-
         $this->disableAllUserRelations($req->id);
 
         // Remplaza todos los datos del socio por '-'
         $data = [
            'nombreEntidad' => '-',
            'username' => substr($req->id,0,20),
            'password' => '-',
            'direccion' => '-',
            'localidad' => '-',
            'rol' => 'User',
            'cp' => 0,
            'telefono' => 000000000,
            'email' => '-',
            'foto' => '-',
            'deshabilitado' => true
        ];
 
         User::where('id', $req->id)->update($data);
 
         return redirect()->back()->with('info', ['message' => 'Usuario eliminado con exito!']);
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
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }



    }

    /* Metodo que realiza toda la deshabilitacion de relaciones del usuario */
    public function disableAllUserRelations($id)
    {
        try {
            dd($id);
            // Deshabilita la relacion con los centros .-
            PartnerUser::where('idUsuario', $id)->update(['deshabilitado' => true]);
            $rmIds = Room::where('idUsuario', $id)->get(['idSala']);

            $data = [
                'nombre' => '-',
                'informacion' => '-',
                'tipo' => 'PEQUEÑA',
                'deshabilitado' => true
            ];
            // Deshabilita las salas .-
            Room::where('idUsuario', $id)->update($data);

            $data = [
                'tipo' => 'LEVE',
                'fechaInc' => date_create('01-01-1999'),
                'fechaFinExp' => date_create('01-01-1999'),
                'informacion' => '-',
                'deshabilitado' => true
            ];
            // Deshabilita todos los incidentes que ha tenido .-
            Incident::where('idUsuario', $id)->update($data);

            $data = [
                'nombre' => '-',
                'tipo' => 'OTROS',
                'deshabilitado' => true
            ];
            Resource::whereIn('idSala', $rmIds)->update($data);

            $data = [
                'titulo' => '-',
                'entidadOrg' => '-',
                'numeroAsistentes' => 0,
                'fechaEvento' => date_create('01-01-1999'),
                'informacion' => '-',
                'deshabilitado' => true
            ];
            Event::whereIn('idSala', $rmIds)->update($data);


        } catch (Exception $err) {
            return redirect()->back()->with('info', [
                'error' => $err,
                'message' => 'Algo no ha ido bien!'
            ]);
        }



    }
}
