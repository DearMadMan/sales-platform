<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpressAreaRegion extends Model
{
    //
    public $timestamps = false;

    public function region()
    {
        return $this->hasOne('App\Region', 'id', 'region_id');
    }

    public function getRegionNames($express_area_id)
    {
        $res = $this->where('express_area_id', $express_area_id)->get();
        $names='';
        if(!$res->isEmpty()){
            $ids=[];
            foreach($res as $v){
                $ids[]=$v->region_id;
            }
            $region=new Region();
            $region=$region->whereIn('id',$ids)->get();
            foreach($region as $v){
                $names.=$v->name.",";
            }
        }


        return trim($names,',');
    }
}
