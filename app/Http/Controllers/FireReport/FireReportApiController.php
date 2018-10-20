<?php

namespace App\Http\Controllers\FireReport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FireReport\FireReport;
use DateTime;
use App\Location\UserLocation;

class FireReportApiController extends Controller
{
    public function reportarIncendio(Request $request){
        set_time_limit(0);
     
        $jsonDatos= $request->input('datos'); 
        $array=array();
        $datos=json_decode($jsonDatos,true);
        $dateTime=new DateTime();
        $hasta= $dateTime->format( 'd-m-Y H:i:s' );
        $clone= $dateTime;
        $desde= $clone->modify('-1 day')->format( 'd-m-Y H:i:s' );
        $latitud= '';
        $longitud='';
        foreach($datos as $key=> $dato){
            $latitud=$datos[$key]['latitude'];
            $longitud=$datos[$key]['longitude'];
            $fireReport = FireReport::create([
                'date_time' =>['fecha'],
                'latitude'=>$datos[$key]['latitude'],
                'longitude'=>$datos[$key]['longitude'],
                'MAC'=>$datos[$key]['mac'],
            ]);
             array_push($array,$datos[$key]);
        }
        //se empieza a obtener la distancia para cada usuario, de esta manera se  avisara a los mas cercanos
        //filtros a seguir seleccionar usuarios que hayan reportado su localizacion en las ultimas dos horas 
        //Obtener la latitud y longitud del reportador del incendio y compararla con la latitud y longitud del usuario 2 max 2kl
        $usuarios= UserLocation::whereBetween('date_time',[$desde,$hasta])->get();
        foreach($usuarios as $usuario){
            //calculamos la diferencia de entre la longitud de los dos puntos
            $diferenciaX = $longitud - $usuario->longitud;
            //ahora calculamos la diferencia entre la latitud de los dos puntos
            $diferenciaY = $latitud -$usuario->latitud;
            // ahora ponemos en practica el teorema de pitagora para calcular la distancia
            $distancia = sqrt(pow($diferenciaX,2) + pow($diferenciaY,2));
            if($distancia<=7){

            }
        }

        return $array;

        
    }
}
