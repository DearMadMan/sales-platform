<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    //
    public $timestamps = false;

    public function user ()
    {
        $this->belongsTo ('App\User' , 'id' , 'address_id');
    }

}
