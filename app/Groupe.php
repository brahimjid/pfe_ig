<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    //
     public $timestamps=false;
      protected $primaryKey='idGroupe';
    protected $fillable=['idGroupe','idClasse','ordre'];
}
