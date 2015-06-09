<?php namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Manager\WechatMenuStore;
use App\WechatMenu;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class WechatMenuController extends Controller
{


    public function __construct ()
    {
        $this->middleware ('manager');
        $this->middleware ('manager.wechat_menu' , ["except" => ['index' , 'create' , 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index ()
    {
        $breadcrumb_title = '菜单管理';
        $breadcrumb = [
            ['url' => 'manager/user-list' , 'title' => '微信中心' , 'is_active' => 0] ,
            ['url' => '' , 'title' => '菜单管理' , 'is_active' => 1]
        ];
        $wechat_menu = new WechatMenu( Auth::user ()->manager_id);
        $menu_list = $wechat_menu->getMenuList ();

        return view ('manager.wechat_menu')
            ->with ('menu_list' , $menu_list)
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('breadcrumb' , $breadcrumb);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create ()
    {
        $menu = new WechatMenu( Auth::user ()->manager_id);
        $menu_list = $menu->getFirstMenu ();
        $breadcrumb_title = '新增菜单';
        $breadcrumb = [
            ['url' => 'manager/user-list' , 'title' => '微信中心' , 'is_active' => 0] ,
            ['url' => 'manager/wechat-menu' , 'title' => '菜单管理' , 'is_active' => 0] ,
            ['url' => '' , 'title' => '新增菜单' , 'is_active' => 1]
        ];

        return view ('manager.wechat_menu_create')
            ->with ('method' , 'post')
            ->with ('menu' , $menu)
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('breadcrumb' , $breadcrumb)
            ->with ('menu_list' , $menu_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WechatMenuStore $request
     * @return Response
     */
    public function store (WechatMenuStore $request)
    {

        $wechat_menu = new WechatMenu( Auth::user ()->manager_id);
        $res = $wechat_menu->UpdateOrCreateFromRequest ($request);
        if ($res !== true) {
            return $res;
        }
        /* 发送至微信进行更新菜单 */


        /* 返回 */

        return redirect ('manager/wechat-menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show ($id)
    {
        /* 一级菜单 删除该菜单下所有子菜单  */
        $wechatMenu = new WechatMenu();

        if ($wechatMenu->isFirstMenu ($id)) {
            /* 删除当前菜单及其子菜单 */
            $wechatMenu->DeleteFromFirstId ($id);
        } else {
            $wechatMenu->destroy ($id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit ($id)
    {
        $menu = WechatMenu::find ($id);
        $menu->setMId(Auth::user ()->manager_id);
        $menu_list = $menu->getFirstMenu ();

        $breadcrumb_title = '修改菜单';
        $breadcrumb = [
            ['url' => 'manager/user-list' , 'title' => '微信中心' , 'is_active' => 0] ,
            ['url' => 'manager/wechat-menu' , 'title' => '菜单管理' , 'is_active' => 0] ,
            ['url' => '' , 'title' => '修改菜单' , 'is_active' => 1]
        ];

        return view ('manager.wechat_menu_create')
            ->with ('method' , 'put')
            ->with ('menu' , $menu)
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('breadcrumb' , $breadcrumb)
            ->with ('menu_list' , $menu_list);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param WechatMenuStore $request
     * @param  int $id
     * @return Response
     */
    public function update (WechatMenuStore $request , $id)
    {
        $wechat_menu = WechatMenu::find ($id);
        $res = $wechat_menu->UpdateOrCreateFromRequest ($request);
        if ($res !== true) {
            return $res;
        }
        /* 发送至微信进行更新菜单 */


        /* 返回 */

        return redirect ('manager/wechat-menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy ($id)
    {
        /* 一级菜单 删除该菜单下所有子菜单  */

        $wechatMenu = new WechatMenu(Auth::user ()->manager_id);

        if ($wechatMenu->isFirstMenu ($id)) {
            /* 删除当前菜单及其子菜单 */


            $wechatMenu->DeleteFromFirstId ($id);

            return '1';
        } else {
            $wechatMenu->destroy ($id);

            return "0";
        }

    }

}
