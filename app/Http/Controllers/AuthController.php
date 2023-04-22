<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //Para autenticaciones
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //Constructor para proteccion Middleware
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    //Metodo para realizar login
    public function login(Request $request)
    {
        //Se validan los datos
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        //Se genera el toquen
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        //Si el token se genera correctamente muestra informacion del usuario y token
        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    //Metodo para que el usuario se logue
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Se cerro la sesión con éxito',
        ]);
    }

    //Metodo que invalida el token de autenticación del usuario y genera uno nuevo
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}


