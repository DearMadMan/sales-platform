<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\WechatConfig;
use App\WechatManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Overtrue\Wechat\Server;
use Overtrue\Wechat\Services\Message;
use Overtrue\Wechat\Wechat;

class WechatCallbackController extends Controller
{


    public function index(Request $request, $manager_id = 1)
    {
        $manager_config = new WechatConfig();
        $manager_config = $manager_config->where("manager_id", $manager_id)->first();
        if (!$manager_config) {
            return false;
        }
        $configs = $manager_config->getConfigs();
        $server = new Server($configs->app_id, $configs->token, $configs->encodingAESKey);
        if ($request->isMethod("get")) {
            /* server validate */
            return $server->serve();
        }


        $wechat_event=new WechatEventController($manager_id,$configs);

        $server->on('event', 'subscribe',[$wechat_event,"initUser"]);
        $server->on('event', 'subscribe',[$wechat_event,"subscribe"]);
        $server->on('event','click',[$wechat_event,'keyword']);
        $server->on('message','text',[$wechat_event,'keyword']);
        return $server->serve();
    }


}
