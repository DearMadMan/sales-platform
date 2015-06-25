<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{

    //

    /**
     * [ Get Goods list ]
     * @param $manager_id
     * @param bool $paginate
     * @return mixed
     */
    public function getGoods($manager_id, $paginate = true)
    {
        if ($paginate) {
            $goods = $this->where(['manager_id' => $manager_id, 'is_delete' => false])->paginate(config('page.paginate'));
        } else {
            $goods = $this->where(['manager_id' => $manager_id, 'is_delete' => false])->get();
        }
        return $goods;
    }

    public function GetGood($manager_id,$id){
        $good=$this->where(['manager_id'=>$manager_id,'id'=>$id])->first();
        return $good;
    }

}
