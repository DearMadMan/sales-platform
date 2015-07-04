<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Express extends Model
{
    //
    public  $timestamps=false;

    public function getExpresses($manager_id){
        return $this->where('manager_id',$manager_id)->get();
    }

    public function hasExpress($manager_id,$code){
        return $this->where(['manager_id'=>$manager_id,'code'=>$code])->first();
    }

    public function existExpress($manager_id,$id){
        return $this->where(['manager_id'=>$manager_id,'id'=>$id])->first();
    }
}
