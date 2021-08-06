<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jour extends Model
{
    //
    public $timestamps=false;
    protected $fillable = [

    'id','jour'
];
}

