<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{

    public $timestamps = false;

    public function user ()
    {
        $this->belongsToMany ('users' , 'id' , 'user_type_id');
    }
}
