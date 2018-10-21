<?php

namespace App\Http\Controllers\FireReport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FireReport\FireReport;
use App\Location\UserLocation;
use App\DataNasa\DataNasa;
use App\Notificaciones\Notificacion;
use DateTime;
use DB;
include '../app/Nasa/getDistance.php';
class FireReportApiController extends Controller
{
    public function reportarIncendio(Request $request){
        set_time_limit(0); 
        $jsonDatos= $request->input('datos'); 
        if($jsonDatos!=null){
            $array=array();
            $datos=json_decode($jsonDatos,true);
            
           
            $latitud= '';
            $longitud='';
            $usuarios= DB::table('userlocation')->select('MAC')
            ->groupBy('MAC')->get();
            $datosNasa=DataNasa::all();
            foreach($datos as $key=> $dato){
                $latitud=$datos[$key]['latitude'];
                $longitud=$datos[$key]['longitude'];
                $fireReport = FireReport::create([
                    'date_time' =>$datos[$key]['fecha'],
                    'latitude'=>$datos[$key]['latitude'],
                    'longitude'=>$datos[$key]['longitude'],
                    'MAC'=>$datos[$key]['mac'],
                ]);
                array_push($array,$datos[$key]);
            }
            foreach($datosNasa as $key=>$datoNasa){
                $distance= distance($latitud,$longitud,$datoNasa->latitude,$datoNasa->longitude);
                if($distance<=2.5){
                    $existeIncendio='true';
                }else{
                    $existeIncendio='false';
                }
            }
            //se empieza a obtener la distancia para cada usuario, de esta manera se  avisara a los mas cercanos
            //filtros a seguir seleccionar usuarios que hayan reportado su localizacion en las ultimas dos horas 
            //Obtener la latitud y longitud del reportador del incendio y compararla con la latitud y longitud del usuario 2 max 2kl
            if($existeIncendio==='true'){
                
            
                foreach($usuarios as $key=>$usuario){
                    
                    $user=UserLocation::where('MAC',$usuario->MAC)->first();

                    $distance= distance($latitud,$longitud,$user->latitude,$user->longitude);
                    if (is_nan($distance) || $distance<=0.001)
                    {
                        $distance=0;
                    }
                    if($distance<=2)
                    {   
                        //INSERTA A TABLA NOTIFICACION
                        $mensaje='EXISTE UNA ALERTA DE INCENDIO CERCA DE SU LOCALIZACION, TOMAR LAS MEDIDAS NECESARIAS';
                        $notificaciones=Notificacion::create([
                            'MAC'=>$user->MAC,
                            'mensaje'=>$mensaje,
                            'fecha'=>$user->fecha,
                            'estado'=>'A',
                        ]);
                        return ['respuesta'=>'true','latitud'=> $latitud,'longitud'=>$longitud];
                    }
                }
            }else{
                $mensaje='EXISTE UNA POSIBLE ALERTA DE INCENDIO CERCA DE SU LOCALIZACION, POR FAVOR AYUDAR A CONFIRMARLO';
               
                foreach($usuarios as $key=>$usuario){
                  
                    $user=UserLocation::where('MAC',$usuario->MAC)->first();

                    $notificaciones=Notificacion::create([
                        'MAC'=>$user->MAC,
                        'mensaje'=>$mensaje,
                        'fecha'=>$user->date_time,
                        'estado'=>'A',
                    ]);
                }
               
                return ['respuesta'=>'true','latitud'=> $latitud,'longitud'=>$longitud];
            }
        }else{
            return ['respuesta'=>'true'];
        }
        
    }
    public function verificarIncendio(Request $request){
        set_time_limit(0); 
        $jsonDatos= $request->input('datos'); 
        $array=array();
        $datos=json_decode($jsonDatos,true);
        $dateTime=new DateTime();
        $hasta= $dateTime->format( 'Y-m-d H:i:s' );
        $clone= $dateTime;
        $desde= $clone->modify('-1 day')->format( 'Y-m-d H:i:s' );
        $latitud= '';
        $longitud='';
        
        $incendios=FireReport::whereBetween('date_time',[$desde,$hasta])->get();

        foreach($datos as $key=> $dato){
            $latitud=$datos[$key]['latitude'];
            $longitud=$datos[$key]['longitude'];
        }
        foreach($incendios as $key=>$incendio){
            $distance= distance($latitud,$longitud,$incendio->latitude,$incendio->longitude);
            if($distance<=2.5){
                $existeIncendio='true';
            }else{
                $existeIncendio='false';
            }
        }

        //se empieza a obtener la distancia para cada usuario, de esta manera se  avisara a los mas cercanos
        //filtros a seguir seleccionar usuarios que hayan reportado su localizacion en las ultimas dos horas 
        //Obtener la latitud y longitud del reportador del incendio y compararla con la latitud y longitud del usuario 2 max 2kl
        if($existeIncendio){
            
            $usuarios= UserLocation::whereBetween('date_time',[$desde,$hasta])->get();
            foreach($usuarios as $usuario){
                $distance= distance($latitud,$longitud,$usuario->latitude,$usuario->longitude);
                if (is_nan($distance) || $distance<=0.001)
                {
                    $distance=0;
                }
                if($distance<=2)
                {   
                    //INSERTA A TABLA NOTIFICACION
                    $mensaje='EXISTE UNA CONFIRMACIÓN DE INCENDIO CERCA DE SU LOCALIZACION, TOMAR LAS MEDIDAS NECESARIAS';
                    $notificaciones=Notificacion::create([
                        'MAC'=>$usuario->MAC,
                        'mensaje'=>$mensaje,
                        'fecha'=>$usuario->fecha,
                        'estado'=>'A',
                    ]);
                    return ['latitud'=> $latitud,'longitud'=>$longitud];
                }
            }
        }
    }
}
