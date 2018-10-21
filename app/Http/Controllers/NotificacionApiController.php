<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notificaciones\Notificacion;

class NotificacionApiController extends Controller
{
    public function cargarNotificaciones(Request $requst){
    
        set_time_limit(0);
        $request->validate([
            'mac' => 'required',
        ]);
        $mac= $request->input('mac'); 
        $notificaciones=Notificacion::where('MAC',$mac)->where('estado','A')->get();
        return['notificaciones'=>$notificaciones];
  
    }

}
