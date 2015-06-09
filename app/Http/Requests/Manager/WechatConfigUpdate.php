<?php namespace App\Http\Requests\Manager;

use App\Http\Requests\Request;

class WechatConfigUpdate extends Request {

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
			"token"=>"required",
			"app_id"=>"required",
			"app_secret"=>"required",
			"name"=>"required",
			"wechat"=>"required",
			"phone"=>"required|digits:11",
			"email"=>"required|email",
			"qq"=>"numeric"
		];
	}

}
