<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{

    //
    public $timestamps = false;

    public function articles(){
        return $this->hasMany("App\Article","type_id","id");
    }

    public function getTypes($manager_id,$render=false){
        if($render)
        {

            return $this->where('manager_id',$manager_id)->paginate(config('page.paginate'));
        }
        $types=$this->where('manager_id',$manager_id)->get();
        if($types->isEmpty()){
            $this->type_name="普通文章";
            $this->manager_id=$manager_id;
            $this->save();

            return $this->where('id',$this->id)->get();
        }
        return $types;
    }


    public function UpdateType($request,$id){
        $manager_id=$request->user()->manager_id;
        $type=$this->isOwn($manager_id,$id);
            if($type){
                $type->type_name=$request->input('type_name');
                $type->save();
                return true;
            }
        return false;
    }

    public function isOwn($manager_id,$id){
        $row=$this->where(['manager_id'=>$manager_id,"id"=>$id])->first();
        return $row;
    }


}
