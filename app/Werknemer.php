<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Werknemer extends Model
{
    protected $table = 'werknemers';
    public $timestamps = false;
    protected $fillable = [
        'naam'
    ];
}
