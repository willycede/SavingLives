<?php

namespace App\Notificaciones;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notification';
    public $timestamps=false;
    protected $fillable = [
        'MAC','mensaje','fecha','estado'
    ];
}
