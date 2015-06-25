<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{

    //

    public function getGoods($manager_id, $paginate = true)
    {
        if ($paginate) {
            $goods = $this->where(['manager_id' => $manager_id, 'is_delete' => false])->paginate(config('page.paginate'));
        } else {
            $goods = $this->where(['manager_id' => $manager_id, 'is_delete' => false])->get();
        }
        return $goods;
    }

}
