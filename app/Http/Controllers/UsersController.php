<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehiculos;
use Illuminate\Support\Facades\Hash; //Para contraseñas


class UsersController extends Controller
{
    //Constructor para proteccion Middleware
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register','updateUsers','destroyUser']]);
    }

    //Metodo para capturar los datos para registrar un usuario
    public function register(Request $request)
    {
        //Validacion de los datos
        //Cramos variable para validar que rol tiene
        $RolesValidate = $request->input('roles_id');
        //Si rol es igual a 1: Mensajero
        if ($RolesValidate == 1)
        {
            $request->validate([
                //especificamos que datos queremos capturar
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'cedula' => 'required|unique:users',
                'nombres' => 'required',
                'apellidos' => 'required',
                'telefono' => 'required',
                'edad' => 'required',
                'roles_id' => 'required',
                'placa' => 'required|unique:vehiculos',
                'tipo_vehiculos_id' => 'required'
                ]);

                //Alta de usuario
                $user = new User();
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->cedula = $request->cedula;
                $user->nombres = $request->nombres;
                $user->apellidos = $request->apellidos;
                $user->telefono = $request->telefono;
                $user->edad = $request->edad;
                $user->roles_id = $request->roles_id;
                $user->save();
                
                $vehicle = new Vehiculos();
                $vehicle->users_id = $user->id;
                $vehicle->placa = $request->placa;
                $vehicle->tipo_vehiculos_id = $request->tipo_vehiculos_id;
                $vehicle->save();

                //Respuesta 
                return response($user, Response::HTTP_CREATED);
        }
        //Si el Rol es 2 Usuario o si es 3 Cliente
        elseif ($RolesValidate >= 2 && $RolesValidate <= 3)  
        {
            $request->validate([
                //especificamos que datos queremos capturar
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'cedula' => 'required|unique:users',
                'nombres' => 'required',
                'apellidos' => 'required',
                'telefono' => 'required',
                'edad' => 'required',
                'roles_id' => 'required',
                ]);

                //Alta de usuario
                $user = new User();
                $user->email = $request->email;
                $user->cedula = $request->cedula;
                $user->password = Hash::make($request->password);
                $user->nombres = $request->nombres;
                $user->apellidos = $request->apellidos;
                $user->telefono = $request->telefono;
                $user->edad = $request->edad;
                $user->roles_id = $request->roles_id;
                $user->save();

                //Respuesta 
                return response($user, Response::HTTP_CREATED);
        }
        else {
            return response()->json([
                "message" => "El rol no existe"
            ]);
        } 
    }

    //Metodo para traer los datos basicos del usuario
    public function userProfile(Request $request)
    {
        return response()->json([
            "message" => "Perfil de Usuario",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }

    //Metodo para ver todos los usuarios que tenemos
    public function allUsers (Request $request)
    {
        $users = User::all();
        return response()->json([
            "users" => $users
        ]);
    }

    //Metodo para actualizar un usuario
    public function updateUsers (Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->cedula = $request->cedula;
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->edad = $request->edad;
        $user->roles_id = $request->roles_id;
        
        $user->save();

        //Respuesta 
        return response($user, Response::HTTP_CREATED);
    }

    //Metodo para eliminar un usuario
    public function destroyUser(Request $request)
    {
        User::findOrFail($request->id)->delete();
        return response()->json([
            "message" => "¡Usuario Eliminado!",
        ], Response::HTTP_OK);
    }
}


