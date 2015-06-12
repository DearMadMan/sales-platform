<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WechatConfig extends Model
{

    //
    public $timestamps = false;

    public function manager(){
        return $this->belongsTo('App\WechatManager','manager_id','id');
    }


}
