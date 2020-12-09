<?php

use App\Http\Controllers\Api\LoginController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitePedagogique;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\ProfessorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 *  Routes of Pedagogic unity
 */
Route::post('/unitePedagogique', [UnitePedagogique::class, 'store']);
Route::get('/unitePedagogique', [UnitePedagogique::class, 'index']);
Route::get('/unitePedagogique/{id}', [UnitePedagogique::class, 'show']);
Route::put('/unitePedagogique/{id}', [UnitePedagogique::class, 'update']);
Route::delete('/unitePedagogique/{id}', [UnitePedagogique::class, 'destroy']);
/*
|--------------------------------------------------------------------------
| Professors
|--------------------------------------------------------------------------
|
| Here we have all professors's routes
|
*/

Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/professors', [ProfessorController::class, 'index']);
Route::post('/professors/create', [ProfessorController::class, 'store']);
Route::post('/professors/{id}', [ProfessorController::class, 'update']);
Route::post('/professors/show/{id}', [ProfessorController::class, 'destroy']);
