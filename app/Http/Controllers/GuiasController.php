<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Guias;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GuiasController extends Controller
{
    //Constructor para proteccion Middleware
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['guardarGuia','mostrarTotalGuias','mostrarGuias','mayorGuiasMensajero']]);
    }

    //Metodo para registrar guias
    public function guardarGuia(Request $request)
    {

        $request->validate([
            //especificamos que datos queremos capturar
            'id_guia' => 'required|unique:guias',
            'destinatario' => 'required',
            'direccion' => 'required',
            'users_id' => 'required',
            ]);

            //Alta de guia
            $guia = new Guias();
            $guia->id_guia = $request->id_guia;
            $guia->destinatario = $request->destinatario;
            $guia->users_id = $request->users_id;
            $guia->direccion = $request->direccion;
            $guia->save();

            //Respuesta 
            return response($guia, Response::HTTP_CREATED);
    }

    //Metodo para mostrar total guias registradas
    public function mostrarTotalGuias()
    {
        $totalguias = Guias::all()->count();

        return response()->json([
            "Total de guias registradas" => $totalguias
        ]);

    }

    //Metodo para mostrar la informacion de todas las guias
    public function mostrarGuias()
    {
        $totalguias = Guias::all();

        return response()->json([
            "Informacion de todas las guias registradas" => $totalguias
        ]);

    }

    //Metodo para mostrar el mensajero con mayor cantidad de guias
    public function mayorGuiasMensajero()
    {
        $consultaMensajeroMasGuias = DB::table('guias')
        ->join('users', 'guias.users_id', '=', 'users.id')
        ->select('users.nombres', DB::raw('COUNT(users_id) AS total_guias'))
        ->groupBy('users.nombres')
        ->orderBy('total_guias', 'desc')
        ->limit(1)
        ->get();
        return ($consultaMensajeroMasGuias);
    }
}
