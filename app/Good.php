<?php namespace App;

use App\Http\Controllers\Manager\UploadController;
use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{

    //
    public $timestamps = false;

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
        $this->goods_number = $request->input('goods_number');
        $this->shipping_free = $request->has('shipping_free') ? true : false;
        $this->is_on_sale = $request->has('is_on_sale') ? true : false;
        $this->goods_desc = $request->input('goods_desc');
        $this->manager_id = $request->user()->manager_id;
        /* Determine if upload the good main photo */
        if ($request->hasFile('file')) {
            $upload = new UploadController();
            $target = $upload->UploadImageHandler($request, 'file');
            if ($target) {
                $image=new ImageMd5();

                $this->goods_img = $image->GetIdFormFileName($target);
                /* compress image */
                $upload->CompressHandler($target);
            }
        }
        $res = $this->save();
        if (!$res) {
            return false;
        }
        /* Insert GoodGallery */
        $image_gallery = session('post_image_gallery');
        $galleries = [];
        foreach ($image_gallery as $k => $v) {
            $arr = explode('/', $k);
            if ($arr) {
                $count = count($arr);
                $file_name = $arr[$count - 1];
                $date_dir = $arr[$count - 2];
                $galleries[] = [
                    'good_id' => $this->id,
                    'date_dir' => $date_dir,
                    'file_name' => $file_name
                ];
            }

        }
        if ($galleries) {
            $gallery = new GoodGallery();
            $gallery->insert($galleries);
            $this->UnSetGalleries();
        }
        return $this;
    }

    public function UnSetGalleries($id = 0)
    {
        $session = $id ? 'put_image_gallery' . $id : 'post_image_gallery';
        session()->forget($session);
        session()->save();
    }

    public function goodGallery()
    {
        return $this->hasMany('App\GoodGallery', 'good_id', 'id');
    }


    public function UpdateGood(Request $request, $id)
    {
        $good = $this->GetGood($request->user()->manager_id, $id);
        if (!$good)
            return false;
        /* update attributes*/
        $good->goods_name = $request->input('goods_name');
        $good->type_id = $request->input('type_id');
        $good->shop_price = $request->input('shop_price');
        $good->market_price = $request->input('market_price');
        $good->goods_sn = $request->input('goods_sn');
        $good->goods_number = $request->input('goods_number');
        $good->shipping_free = $request->has('shipping_free') ? true : false;
        $good->is_on_sale = $request->has('is_on_sale') ? true : false;
        $good->goods_desc = $request->input('goods_desc');
        /* Determine if upload the good main photo */
        if ($request->hasFile('file')) {
            $upload = new UploadController();
            $target = $upload->UploadImageHandler($request, 'file');

            if ($target) {
                $image=new ImageMd5();
                $good->goods_img = $image->GetIdFormFileName($target);

                /* compress image */
                $upload->CompressHandler($target);
            }
        }
        $good->save();
        /* update GoodGallery */

        $delete_file = $request->input('delete_file');
        $delete_file = trim($delete_file, ',');
        $delete_file = explode(',', $delete_file);
        $files = [];
        if (is_array($delete_file)) {
            foreach ($delete_file as $v) {
                $temp = explode('/', $v);
                $count = count($temp);
                $file_name = $temp[$count - 1];
                array_push($files, $file_name);
            }
        }
        $good_gallery = new GoodGallery();

        if ($files) {
            /* delete from table */

            $good_gallery->whereIn('file_name', $files)->where(['good_id' => $id])->delete();
        }
        /* Insert New GoodGallery to table */

        $image_gallery = session('put_image_gallery' . $id);
        if ($image_gallery) {


            /* goodGallery numbers can't greater than ten */
            $galleries = $good_gallery->GetGalleries($id);
            $data_count = count($galleries);
            $session_count = count($image_gallery);
            if ($data_count >= 10) {
                $this->UnSetGalleries($id);
                return false;
            }
            if ($data_count + $session_count > 10) {
                /* cut the galleries */
                $arr = array_chunk($image_gallery, 10 - $data_count, true);
                $image_gallery = $arr[0];
            }

            $galleries = [];
            foreach ($image_gallery as $k => $v) {
                $arr = explode('/', $k);
                if ($arr) {
                    $count = count($arr);
                    $file_name = $arr[$count - 1];
                    $date_dir = $arr[$count - 2];
                    $galleries[] = [
                        'good_id' => $id,
                        'date_dir' => $date_dir,
                        'file_name' => $file_name
                    ];
                }
            }
            if ($galleries) {
                $gallery = new GoodGallery();
                $gallery->insert($galleries);
                $this->UnSetGalleries($id);
            }
        }
        return true;


    }


    public function getRecycles($manager_id, $paginate = true)
    {
        if ($paginate) {
            $goods = $this->where([
                'manager_id' => $manager_id,
                'is_delete' => true
            ])->Paginate(config('page.paginate'));
        } else {
            $goods = $this->where([
                'manager_id' => $manager_id,
                'is_delete' => true
            ])->get();
        }

        return $goods;
    }

    public function Restore($manager_id,$id){
        $good=$this->where(['manager_id'=>$manager_id,"id"=>$id])->first();
        if($good)
        {
            $good->is_delete=false;
            $good->save();
            return true;
        }
        return false;
    }

    public function Recycle( $manager_id,$id){
        $good=$this->GetGood($manager_id,$id);
        if($good){
            $good->is_delete=true;
            $good->save();
            return true;
        }
        return false;

    }


}
