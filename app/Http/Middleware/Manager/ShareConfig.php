<?php namespace App\Http\Middleware\Manager;

use App\WechatConfig;
use App\WechatConfigKey;
use App\WechatManager;
use Closure;
use PhpParser\Node\Expr\Cast\Object_;
use View;

class ShareConfig
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle ($request , Closure $next)
    {
        if ($request->user ()) {
            /* 共享配置信息到视图 */
            $manager = WechatManager::where ('user_id' , $request->user ()->id)->first ();

            $wechatConfig = WechatConfig::Where ('manager_id' , $manager->id)->first ();

            if (empty($wechatConfig)) {
                $wechatConfig = new WechatConfig;
            }
            $Config = json_decode ($wechatConfig->configs);
            $WechatConfigKey = new WechatConfigKey();
            $Config = $WechatConfigKey->checkConfigs ($Config);
            View::share ('config' , $Config);

        }

        return $next($request);
    }

}
