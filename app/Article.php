<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	//
    public function manager(){
      return  $this->belongsTo('App\WechatManager','manager_id','id');
    }
}
