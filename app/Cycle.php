<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    //
     public $timestamps=false;
    protected $primaryKey='id';
   public $incrementing=false;
    protected $fillable = [

    'id','nom'
];
}
