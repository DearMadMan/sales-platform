<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\WechatConfig;
use App\WechatManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Overtrue\Wechat\Services\Message;
use Overtrue\Wechat\Wechat;

class WechatCallbackController extends Controller
{


    public function index ($manager_id)
    {
        $wechat = $this->init ($manager_id);
        $wechat->on ('message' , function ($message) {
            return Message::make ('text')->content ('您好！' . $message->FromUserName);
        });
        $result = $wechat->serve ();

        return $result;
    }


    /**
     * [初始化并获取Wechat实例]
     * @param $manager_id
     * @return Wechat|string
     */
    public function init ($manager_id)
    {
        $manager = WechatManager::find ($manager_id);
        if (empty($manager)) {
            return 'Whoops!Everything is ok!';
        }

        $configs = json_decode ($manager->config->configs , true);
        $options = [
            'appId'  => $configs['app_id'] ,
            'secret' => $configs['app_secret'] ,
            'token'  => $configs['token']
        ];
        $wechat = Wechat::make ($options);

        return $wechat;

    }


}
