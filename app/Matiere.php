<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    //
     public $timestamps=false;
      protected $primaryKey='nummat';
   public $incrementing=false;
    protected $fillable = [

    'nummat','mat','Niv','NOPRFL','sem'
];
}
