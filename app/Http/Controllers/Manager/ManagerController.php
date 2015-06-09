<?php namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Manager\WechatConfigUpdate;
use App\WechatConfig;
use App\WechatManager;
use App\WechatMenu;
use Auth;
use Dearmadman\Captcha\Captcha;
use Input;
use Overtrue\Wechat\Menu;
use Overtrue\Wechat\MenuItem;
use Request;

class ManagerController extends Controller
{

    public function __construct ()
    {
        $this->middleware ('manager' , [
            'except' => ['anyLogin']
        ]);

        $this->middleware ('shareConfig');
    }

    /**
     * [控制面板]
     * @return $this
     */
    public function getIndex ()
    {
        return view ('manager.dashboard')
            ->with ('title' , '微信分销公众号管理系统');
    }

    /**
     * [登录]
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function anyLogin ()
    {
        $user = Auth::user ();
        if ($user) {
            $manager = WechatManager::where ('user_id' , $user->id)->get ();
            if ($manager) {
                return redirect ('manager');
            } else {
                return redirect ('user');
            }
        }
        if (Request::isMethod ('post')) {
            $captcha = Captcha::GetInstance ();
            if ( ! $captcha->check (Input::get ('captcha'))) {
                return redirect ()->back ()->with ('message' , '验证码不正确！');
            }


            if (Auth::attempt (['email' => Request::input ('email') , 'password' => Request::input ('password')])) {
                return redirect ('manager');
            } else {

                return redirect ()->back ()
                    ->with ('message' , '邮箱不存在或密码错误!');
            }
        }

        return view ('manager.login');
    }


    /**
     * [添加商品]
     * @return \Illuminate\View\View
     */
    public function anyAddGoods ()
    {

        return view ('manager.add_goods');
    }


    /**
     * [商品列表]
     * @return \Illuminate\View\View
     */
    public function getGoodsList ()
    {
        $breadcrumb_title = '商品回收站';
        $breadcrumb = [
            ['url' => 'manager/goods-list' , 'title' => '商品管理' , 'is_active' => 0] ,
            ['url' => '' , 'title' => '商品列表' , 'is_active' => 1]
        ];

        return view ('manager.goods_list')
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('breadcrumb' , $breadcrumb);
    }


    /**
     * [商品回收站]
     * @return \Illuminate\View\View
     */
    public function getGoodsRecycle ()
    {
        $breadcrumb_title = '商品回收站';
        $breadcrumb = [
            ['url' => 'manager/goods-list' , 'title' => '商品管理' , 'is_active' => 0] ,
            ['url' => 'manager/good-recycle' , 'title' => '商品回收站' , 'is_active' => 1]
        ];

        return view ('manager.goods_list')
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('breadcrumb' , $breadcrumb);
    }


    /**
     * [商品分类]
     * @return \Illuminate\View\View
     */
    public function getGoodTypes ()
    {
        $breadcrumb_title = '商品分类';
        $breadcrumb = [
            ['url' => 'manager/goods-list' , 'title' => '商品管理' , 'is_active' => 0] ,
            ['url' => 'manager/good-types' , 'title' => '商品分类' , 'is_active' => 1]
        ];

        return view ('manager.goods_type')
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('breadcrumb' , $breadcrumb);
    }

    /**
     * [新增商品分类]
     * @return $this
     */
    public function getAddGoodType ()
    {
        $breadcrumb_title = '添加分类';
        $breadcrumb = [
            ['url' => 'manager/goods-list' , 'title' => '商品管理' , 'is_active' => 0] ,
            ['url' => '' , 'title' => '添加分类' , 'is_active' => 1]
        ];

        return view ('manager.add_good_type')
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('breadcrumb' , $breadcrumb);
    }


    public function getSystem ()
    {
        $user = Auth::user ();
        $breadcrumb_title = '系统设置';
        $breadcrumb = [
            ['url' => '' , 'title' => '系统设置' , 'is_active' => 1]
        ];

        return view ('manager.system')
            ->with ('breadcrumb_title' , $breadcrumb_title)
            ->with ('user' , $user)
            ->with ('breadcrumb' , $breadcrumb);
    }

    /**
     * [Update WechatConfigs]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSystem (WechatConfigUpdate $request)
    {
        $user = $request->user ();
        /* check User */
        if ( ! $user->isManager ()) {
            return redirect ('manager/login')
                ->with ('message' , '无权限！');
        }

        /* manager info*/
        $manger = $user->manager;
        $manger->name = Input::get ('name');
        $manger->wechat = Input::get ('wechat');
        $manger->email = Input::get ('email');
        $manger->phone = Input::get ('phone');
        $manger->qq = Input::get ('qq');
        $manger->save ();

        /* wechatConfig */
        $wechatConfig = WechatConfig::where ('manager_id' , $user->manager_id)->first ();
        $config = [];
        $config['token'] = Input::get ('token');
        $config['app_id'] = Input::get ('app_id');
        $config['app_secret'] = Input::get ('app_secret');
        $config = json_encode ($config);
        if (empty($wechatConfig)) {
            $wechatConfig = new WechatConfig();
            $wechatConfig->manager_id = $user->manager_id;
        }
        $wechatConfig->configs = $config;
        $wechatConfig->save ();


        return redirect ('manager/system')
            ->with ('tips' , '数据更新成功！');
    }


    /**
     * [Set WechatMenu to Wechat]
     * @return string
     */
    public function getSetWechatMenu ()
    {
        $user = Auth::user ();
        $menu_list = WechatMenu::where ('manager_id' , $user->manager_id)
            ->orderBy ('parent_id' , 'asc')
            ->orderBy ('index' , 'desc')
            ->get ();

       $wechat_configs=WechatConfig::where('manager_id',$user->manager_id)
           ->first();

        $configs=json_decode($wechat_configs->configs);
        $app_id=$configs->app_id;
        $app_secret=$configs->app_secret;

        $menu=new Menu($app_id,$app_secret);



        $target = [];
        foreach ($menu_list as $menu) {

            /* 一级菜单 */
            if ($menu->parent_id == 0) {
                $item = new MenuItem ($menu['name'] , $menu['menu_type'] , $menu['value']);


                /* 二级菜单 */
                $buttons = [];
                    foreach ($menu_list as $button) {

                    if ($button->parent_id == $menu['id']) {

                        $buttons[]=new MenuItem($button['name'] , $button['menu_type'] , $button['value']);

                    }
                }
                $item->buttons($buttons);
                $target[]=$item;
            }
        }
    dd($menu);
       $menu->set($target); // 失败会抛出异常

        return '菜单设置成功！';

    }

    /**
     * [退出登录]
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout ()
    {
        Auth::logout ();

        return redirect ('manager');
    }


}
