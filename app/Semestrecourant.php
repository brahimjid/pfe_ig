<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semestrecourant extends Model
{
    //
       public $timestamps=false;
       protected $table='semestrecourant';
       protected $primaryKey=['annee','semestre'];
       public $incrementing=false;
    protected $fillable=['annee', 'semestre','dateDebut','dateFin'];

}
