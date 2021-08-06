<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profcoursgroupe extends Model
{
    //
    public $timestamps=false;
      protected $primaryKey=['idProf','idMat','idGroupe'];
    protected $fillable = [

    'idProf','idMat','idGroupe'
];
}
