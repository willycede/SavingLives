<?php

namespace App\Http\Controllers\Multimedia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Multimedia\Multimedia;

class MultimediaApiController extends Controller
{
    public function cargarMultimedia(){
        $multimedias= Multimedia::all();
        $u="'\'";
        foreach($multimedias as $key=>$multimedia){
           
                      
            $multimedias[$key]['MULTIMEDIA'] = "192.168.1.43/SavingLives/Incendios/". $multimedias[$key]['MULTIMEDIA']; ;

        }
        return $multimedias;
    }
}
