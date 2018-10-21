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
Route::match(['get','post'],'user-location', 'Location\UserLocationApiController@saveLocation');
Route::match(['get','post'],'download-data-nasa', 'DataNasa\DataNasaApiController@descargarDatos');
Route::match(['get','post'],'report-fire', 'FireReport\FireReportApiController@reportarIncendio');
Route::match(['get','post'],'fire-multimedia', 'Multimedia\MultimediaApiController@cargarMultimedia');
Route::match(['get','post'],'cargar-notificaciones', 'NotificacionApiController@cargarNotificaciones');
Route::match(['get','post'],'cargar-datos', 'DataNasa\DataNasaApiController@cargarDatos');
Route::match(['get','post'],'verificar-incendio', 'FireReport\FireReportApiController@verificarIncendio ');