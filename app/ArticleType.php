<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{

    //
    public $timestamps = false;

    public function articles(){
        return $this->hasMany("App\Article","type_id","id");
    }

    public function getTypes($manager_id){
        $types=$this->where('manager_id',$manager_id)->get();
        if($types->isEmpty()){
            $this->type_name="普通文章";
            $this->manager_id=$manager_id;
            $this->save();
            return $this;
        }
        return $types;
    }
}
