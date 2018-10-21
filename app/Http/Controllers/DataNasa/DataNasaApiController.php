<?php

namespace App\Http\Controllers\DataNasa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataNasa\DataNasa;
class DataNasaApiController extends Controller
{
    public function descargarDatos(){
        $datosNasa = curl_init('http://localhost/SavingLives/app/Nasa/getTXT.php');
        curl_setopt($datosNasa, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($datosNasa);
        $datos=json_decode($response,true);
        foreach($datos as $key=> $dato){
            $registro=DataNasa::create([
                'latitude'=>$datos[$key]['latitud'],
                'longitude'=>$datos[$key]['longitud'],
                'daynight'=>$datos[$key]['daynight'],
                'fecha'=>$datos[$key]['date']]);
        }
    }
    public function cargarDatos(){
        $datosNasa = DataNasa::take(20)->get();
        if(sizeof($datosNasa)>0){
            return['respuesta'=>'true','contenido'=>$datosNasa] ;
        }else{
            return['respuesta'=>'true','contenido'=>''] ;
        }
    }
}
