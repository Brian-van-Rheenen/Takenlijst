<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taak extends Model
{
    protected $table = 'taken';
    public $timestamps = false;
    protected $fillable = [
        'dag',
        'taak',
        'werknemer_id'
    ];
}
