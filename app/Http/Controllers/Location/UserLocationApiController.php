<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location\UserLocation;

class UserLocationApiController extends Controller
{
    public function saveLocation(Request $request){
        set_time_limit(0);
        $request->validate([
            'ubicaciones' => 'required',
        ]);
        $jsonDatos= $request->input('ubicaciones'); 
        $array=array();
        $datos=json_decode($jsonDatos,true);
        foreach($datos as $key=> $dato){
            $persona = UserLocation::create([
                'date_time' =>$datos[$key]['fecha'],
                'latitude'=>$datos[$key]['latitude'],
                'longitude'=>$datos[$key]['longitude'],
                'MAC'=>$datos[$key]['mac'],
            ]);
             array_push($array,$datos[$key]);
        }
        if(sizeof($array)>0){
            return ['respuesta'=>'true'];
        }else{
            return ['respuesta'=>'false'];
        }
        
    }
}
