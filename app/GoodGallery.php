<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodGallery extends Model
{
    //
    public $timestamps = false;

    /**
     * [get galleries list]
     * @param $good_id
     * @return mixed
     */
    public function GetGalleries($good_id)
    {
        return $this->where('good_id', $good_id)->get();
    }

    public function GetIdFormFileName($file_name)
    {
        $arr = explode('/', $file_name);
        if (is_array($arr)) {
            $count = count($arr);
            $file_name = $arr[$count - 1];
        }

        $res = $this->where('file_name', $file_name)->first();
        $res = $res ? $res->id : 0;
        return $res;

    }
}
