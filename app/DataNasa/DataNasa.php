<?php

namespace App\DataNasa;

use Illuminate\Database\Eloquent\Model;

class DataNasa extends Model
{
    protected $table = 'datanasa';
    public $timestamps=false;
    protected $fillable = [
        'latitude','longitude','daynight','fecha'
    ];
}
