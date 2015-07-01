<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Express extends Model
{
    //
    public  $timestamps=false;

    public function getExpresses($manager_id){
        return [];
    }
}
