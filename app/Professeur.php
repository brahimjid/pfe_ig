<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    //
  public $timestamps=false;
  protected $primaryKey='Matricule';
  public $incrementing=false;
    protected $fillable = [
             'Matricule',
                'Nom',
                'Noma',
                'nodep',
                'type',
                'Adresse',
                'daten',
                'lieun',
                'Nat',
                'telephone',
                'email',
                'Diplome',
                'TauxHor',
                'NbHrAPayer',
                'sexe' ,
                'Banque',
                'NumCompte' ,
                'nbcours' ,
                'grade' ,
                'Nomf'
                ];
}
