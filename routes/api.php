<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuiasController;
use App\Http\Controllers\TipoVehiculosController;
use App\Http\Controllers\UsersController;
use App\Models\TipoVehiculos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class,'logout']);

Route::post('register', [UsersController::class, 'register']);
Route::get('user-profile', [UsersController::class,'userProfile']);
Route::get('users', [UsersController::class, 'allUsers']);
Route::put('update-User', [UsersController::class, 'updateUsers']);
Route::delete('destroy-User', [UsersController::class, 'destroyUser']);

Route::post('register-guias', [GuiasController::class, 'guardarGuia']);
Route::post('show-totalGuias', [GuiasController::class, 'mostrarTotalGuias']);
Route::post('guias', [GuiasController::class, 'mostrarGuias']);
Route::post('mayor-guias-Mensajero', [GuiasController::class, 'mayorGuiasMensajero']);

Route::post('vehiculo-mas-utilizado', [TipoVehiculosController::class, 'VehiculoMasUtilizado']);



