<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    public $timestamps=false;


    // usage 
    // $regions=new \App\Region();
    // $regions=$regions->whereBetween('lft',[279,294])->orderBy('level_id','asc')->get();
    // print_r($regions->toArray());
    // die;
}
