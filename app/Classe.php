<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    //
     public $timestamps=false;
    protected $fillable = [
                'id',
                'idFil',
                'niv',
                'titreCourt',
                'titre',
                'anneeUniversitaire',
                'nbrEtudiant'
];

}
