<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

  /*  
    //Un vehiculo tiene un tipo de vehiculo
    public function TipoVehiculos()
    {
        return $this->belongsTo(TipoVehiculos::class, 'tipo_vehiculos_id');
    }
*/
}



