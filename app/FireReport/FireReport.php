<?php

namespace App\FireReport;

use Illuminate\Database\Eloquent\Model;

class FireReport extends Model
{
    protected $table = 'FireReport';
    protected $fillable = [
        'date_time','latitude','longitude','MAC'
    ];
}
