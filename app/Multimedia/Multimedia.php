<?php

namespace App\Multimedia;

use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    protected $table = 'FireMultimedia';
    public $timestamps = false;
    protected $fillable = [
        'ID_FIRE','DATE','NAME_FIRE','MULTIMEDIA'
    ];
}
