<?php namespace  App\Http\Requests\Manager;

use App\Http\Requests\Request;

class WechatMenuStore extends Request {

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

			"parent_id"=>"required|numeric",
			"name"=>"required",
			"menu_type"=>"required",
			"value"=>"required",
			"index"=>"numeric"

		];
	}

}
