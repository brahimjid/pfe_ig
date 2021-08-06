<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    //
    public $timestamps=false;
     protected $primaryKey='idFil';
   public $incrementing=false;
    protected $fillable = ['idFil',
    'nom',
    'dept'
];
}
