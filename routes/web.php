<?php

use Lib\Route;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\SessionController;
use App\Controllers\PublicationController;
use App\Controllers\LikeController;  
use App\Controllers\FavouriteController;

//home
Route::get('/', [HomeController::class, 'index']);
Route::get('/acerca', [HomeController::class, 'about']);

//autenticacion o sesion
Route::post('/login', [SessionController::class, 'login']);
Route::get('/logout', [SessionController::class, 'logout']);

//registro y perfil
Route::get('/registrar', [UserController::class, 'index']);
Route::post('/registrar', [UserController::class, 'store']);
Route::get('/recuperar', [UserController::class, 'recovery']);
Route::post('/recuperar', [UserController::class, 'sendMailRecovery']);
Route::get('/nuevo-pass/:token', [UserController::class, 'changePass']);
Route::post('/nuevo-pass', [UserController::class, 'editPass']);
Route::get('/perfil/:user', [UserController::class, 'show']);
Route::get('/editar-perfil', [UserController::class, 'showProfileEdit']);
Route::post('/editar-perfil', [UserController::class, 'update']);
Route::post('/editar-password', [UserController::class, 'editPassProfile']);
Route::get('/eliminar-usuario/:user', [UserController::class, 'delete']);

//administrador
Route::get('/crear-admin', [UserController::class, 'showFormAdmin']);
Route::post('/crear-admin', [UserController::class, 'createAdmin']); 
Route::get('/usuarios', [UserController::class, 'showAllUsers']);

//historias 
Route::get('/agregar-chiste', [PublicationController::class, 'show']);
Route::post('/agregar-chiste', [PublicationController::class, 'store']);
Route::get('/principal', [PublicationController::class, 'list']); 
Route::get('/chiste/:id/:user', [PublicationController::class, 'showJoke']);
Route::get('desechados/:user', [PublicationController::class, 'showDiscarded']);
Route::get('desechar-chiste/:id/:user', [PublicationController::class, 'discarded']);
Route::get('restaurar/:id', [PublicationController::class, 'restore']);
Route::get('/editar-chiste/:id/:user', [PublicationController::class, 'showUpdate']);
Route::post('/editar-chiste', [PublicationController::class, 'update']);
Route::get('/eliminar-chiste/:id', [PublicationController::class, 'delete']);
Route::get('/categoria/:id', [PublicationController::class, 'showCategory']);

//likes 
Route::post('/enviar-like', [LikeController::class, 'store']);

//favoritos
Route::post('/agregar-fav', [FavouriteController::class, 'store']);
Route::get('/favoritos', [FavouriteController::class, 'show']);

Lib\Route::dispatch();