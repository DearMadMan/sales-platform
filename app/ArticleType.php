<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{

    //
    public $timestamps = false;

    public function articles(){
        return $this->hasMany("App\Article","type_id","id");
    }
}
