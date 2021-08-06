<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creneaujours extends Model
{
  //
    public $timestamps=false;
    //protected  $table='creneaujours';
    protected $fillable = [

    'idJour','idCreneau'
];
}
