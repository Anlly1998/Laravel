<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TipoVehiculos;

class TipoVehiculosController extends Controller
{

    //Metodo para mostrar el tipo de vehiculo mas utilizado
    public function VehiculoMasUtilizado()
    {
        $vehiculo = DB::table('vehiculos')
        ->join('tipo_vehiculos', 'vehiculos.tipo_vehiculos_id', '=', 'tipo_vehiculos.id')
        ->select('tipo_vehiculos.tipo_vehiculo', DB::raw('COUNT(tipo_vehiculos_id) AS total_tipo_vehiculos'))
        ->groupBy('tipo_vehiculos.tipo_vehiculo')
        ->orderBy('total_tipo_vehiculos', 'desc')
        ->limit(1)
        ->get();
        return ($vehiculo);

    }
}
