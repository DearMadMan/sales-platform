<?php

namespace App\Http\Requests\Manager;

use App\Http\Requests\Request;

class GoodStore extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goods_name'=>'required',
            'type_id'=>'required|numeric|min:1',
            'shop_price'=>'required|numeric|min:0',
            'cost'=>'required|numeric|min:0',
            'market_price'=>'required|numeric|min:0',
            'goods_number'=>'required|numeric|min:0',
            'goods_weight'=>'required|numeric|min:0'

        ];
    }
}
