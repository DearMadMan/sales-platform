<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Dearmadman\Captcha\Captcha;
use Illuminate\Http\Request;

class ToolController extends Controller {

	public function getCaptcha(Captcha $captcha){
		$captcha->InitFromArray([
			'width'=>120,
			'height'=>35,
			'char_num'=>6,
			'line_x'=>2,
			'line_y'=>2
		]);
		return $captcha->PushImage();
	}

    public function postDelete(Request $request){

    }

}
