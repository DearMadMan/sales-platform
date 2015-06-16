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


    }
