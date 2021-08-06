<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    //
    public $timestamps=false;
    protected $fillable = [

    'id','nomsalle','cycle','Sitefr','SiteAr','CapSal'
];
}
