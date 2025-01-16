<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/students',function(){
    return 'holi';
});
Route::post('/usuarios', [UsuarioController::class, 'index']);
Route::post('/registrarUsuario', [UsuarioController::class, 'registrarUsuario']);
Route::post('/actualizarUsuario', [UsuarioController::class, 'actualizarUsuario']);
Route::post('/reporTarea', [UsuarioController::class, 'reporTarea']);
Route::post('/registrartarea', [UsuarioController::class, 'registrartarea']);
Route::get('/materias', [UsuarioController::class, 'obtenermaterias']);
Route::get('/obtenerestado', [UsuarioController::class, 'obtenerestado']);


Route::put('/actualizarEstado', [UsuarioController::class, 'actualizarEstado']);
Route::delete('/eliminarTarea/{id_tarea}', [UsuarioController::class, 'eliminarTarea']);







