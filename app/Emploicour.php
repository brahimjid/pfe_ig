<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emploicour extends Model
{
    //
     public $timestamps=false;
     protected $guarded=[];
    protected $fillable = [
                'id',
                'idGroupe',
                'idProf',
                'idMat',
                'idSalle',
                'annee',
                'typeCours',
                'heureDebut',
                'heureFin',
                'statusCours',
                 'idJour',
                 'idDuplicate'
];
}
