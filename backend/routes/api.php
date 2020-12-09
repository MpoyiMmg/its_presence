<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitePedagogique;

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
