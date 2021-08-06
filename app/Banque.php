<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    //
    public $timestamps=false;
    protected $primaryKey='IDBanq';
   public $incrementing=false;
    protected $fillable = [
    'IDBanq','LibBanq'
];

}
