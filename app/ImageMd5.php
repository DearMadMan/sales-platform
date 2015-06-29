<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class ImageMd5 extends Model
    {

        public $timestamps = false;

        public function hasFile ($file_name)
        {
            $file = $this->where ('file_name' , $file_name)->first ();
            return ! empty($file) ? $file : false;
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
