<?php namespace App\Http\Middleware\Manager;

use App\WechatMenu;
use Closure;

class WechatMenuIsBelongsToManager
{

    /**
     * [判断菜单是否属于该管理员]
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle ($request , Closure $next)
    {
        $user = $request->user ();
        $pattern = "/\/(\d+)/";
        $id = 0;
        $match = [];
        preg_match ($pattern , $request->getPathInfo () , $match);
        $match ? $id = $match[1] : '';
        $menu = WechatMenu::find ($id);
        if (empty($menu) || $menu->manager_id != $user->manager_id) {
            return redirect ('404');
        }

        return $next($request);
    }

}
