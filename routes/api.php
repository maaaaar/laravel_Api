<?php

use Illuminate\Http\Request;

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

Route::apiResource('ciudad', 'Api\CiudadController');
Route::apiResource('hotel', 'Api\HotelController');
Route::apiResource('cadena', 'Api\CadenaController');
Route::get('hotel/{id_ciudad}/{nombre}','Api\HotelController@show');
Route::put('hotel/{id_ciudad}/{nombre}','Api\HotelController@update');
Route::delete('hotel/{id_ciudad}/{nombre}','Api\HotelController@destroy');
