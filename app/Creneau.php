<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{

     public $timestamps=false;
     protected  $table='creneaux';
     protected $fillable = [
    'id','heureDebut','heureFin'

];
}


