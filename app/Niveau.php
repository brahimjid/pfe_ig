<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    //
     public $timestamps=false;
    protected $fillable = [

    'id','nom'
];
}
