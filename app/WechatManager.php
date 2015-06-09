<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WechatManager extends Model
{

    public $timestamps = false;

    //Model WechatManager
    public function article ()
    {
        return $this->hasMany ('App\Article' , 'manager_id' , 'id');
    }
    public function config(){
        return $this->hasOne('App\WechatConfig','manager_id','id');
    }
}
