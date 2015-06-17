<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breadcrumb extends Model
{
    protected $lists=[];
    protected $title="";
    public function setBreadcrumbs($title,$arr){
            $this->title=$title;
            foreach($arr as $v){
                $this->lists[]=[
                    'url' => $v[0], 'title' => $v[1], 'is_active' => $v[2]
                ];
            }
    }
    public function __get($key){
        if(property_exists($this,$key))
        {
            return $this->$key;
        }
        return null;
    }
}
