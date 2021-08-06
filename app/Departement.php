<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
 
    
       public $timestamps=false;
       protected $primaryKey='NODEP';
       public $incrementing=false;
    protected $fillable=['NODEP', 'LDEPL','LDEPA','CDEPA','CDEPL','TDEP'];
}
