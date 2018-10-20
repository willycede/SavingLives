<?php

namespace App\Location;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $table = 'userLocation';
    protected $fillable = [
        'date_time','latitude','longitude','MAC'
    ];
}
