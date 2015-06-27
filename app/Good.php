<?php namespace App;

use App\Http\Controllers\Manager\UploadController;
use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{

    //
    public $timestamps=false;

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

    /**
     * [get Good ]
     * @param $manager_id
     * @param $id
     * @return mixed
     */
    public function GetGood($manager_id, $id)
    {
        $good = $this->where(['manager_id' => $manager_id, 'id' => $id])->first();
        return $good;
    }

    /**
     * [ Store a new Good ]
     * @param Request $request
     * @return bool
     */
    public function GoodStore(Request $request)
    {
        $this->goods_name = $request->input('goods_name');
        $this->goods_sn = $request->input('goods_sn');
        $this->type_id = $request->input('type_id');
        $this->shop_price = $request->input('shop_price');
        $this->market_price = $request->input('market_price');
        $this->shipping_free = $request->has('shipping_free') ? true : false;
        $this->is_on_sale = $request->has('is_on_sale') ? true : false;
        $this->goods_desc=$request->input('goods_desc');
        $this->manager_id=$request->user()->manager_id;
        /* Determine if upload the good main photo */
        if ($request->has('file')) {
            $upload=new UploadController();
            $target=$upload->UploadImageHander($request,'file');
            if($target)
            {
                $this->goods_img=$target;
                /* compress image */
                $upload->CompressHandler($target);
            }
        }
       $res=$this->save();
        if(!$res)
        {
            return false;
        }
        /* Insert GoodGallery */
        $image_gallery=session('image_gallery');
        $galleries=[];
        foreach($image_gallery as $k=>$v){
            $arr=explode('/',$k);
            if($arr)
            {
                $count=count($arr);
                $file_name=$arr[$count-1];
                $date_dir=$arr[$count-2];
                $galleries[]=[
                    'good_id'=>$this->id,
                    'data_dir'=>$date_dir,
                    'file_name'=>$file_name
                ];
            }

        }
        if($galleries){
            $gallery=new GoodGallery();
            $gallery->insert($galleries);
            $this->UnSetGalleries();
        }
        return $this;
    }
    public function UnSetGalleries(){
        session()->forget('image_gallery');
        session()->save();
    }

}
