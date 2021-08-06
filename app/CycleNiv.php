<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cycleniv extends Model
{
    //
     public $timestamps=false;
    // protected $primaryKey='idCycle';
   //public $incrementing=false;
    protected $fillable = [

    'idCycle','idNiv','nom'
];
}
