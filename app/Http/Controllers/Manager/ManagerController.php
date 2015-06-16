<?php namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Manager\WechatConfigUpdate;
use App\Http\Requests\Manager\WechatNotifyUpdate;
use App\ImageMd5;
use App\WechatConfig;
use App\WechatManager;
use App\WechatMenu;
use App\WechatNotify;
use Auth;
use Dearmadman\Captcha\Captcha;
use Illuminate\Http\Request;
use Input;
use Overtrue\Wechat\Menu;
use Overtrue\Wechat\MenuItem;

class ManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('manager', [
            'except' => ['anyLogin']
        ]);

        $this->middleware('shareConfig');
    }

    /**
     * [控制面板]
     * @return $this
     */
    public function getIndex()
    {
        return view('manager.dashboard')
            ->with('title', '微信分销公众号管理系统');
    }

    /**
     * [登录]
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function anyLogin(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $manager = WechatManager::where('user_id', $user->id)->get();
            if ($manager) {
                return redirect('manager');
            } else {
                return redirect('user');
            }
        }
        if ($request->isMethod('post')) {
            $captcha = Captcha::GetInstance();
            if (!$captcha->check(Input::get('captcha'))) {
                return redirect()->back()->with('message', '验证码不正确！');
            }


            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                return redirect('manager');
            } else {

                return redirect()->back()
                    ->with('message', '邮箱不存在或密码错误!');
            }
        }

        return view('manager.login');
    }


    /**
     * [添加商品]
     * @return \Illuminate\View\View
     */
    public function anyAddGoods()
    {

        return view('manager.add_goods');
    }


    /**
     * [商品列表]
     * @return \Illuminate\View\View
     */
    public function getGoodsList()
    {
        $breadcrumb_title = '商品回收站';
        $breadcrumb = [
            ['url' => 'manager/goods-list', 'title' => '商品管理', 'is_active' => 0],
            ['url' => '', 'title' => '商品列表', 'is_active' => 1]
        ];

        return view('manager.goods_list')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb);
    }


    /**
     * [商品回收站]
     * @return \Illuminate\View\View
     */
    public function getGoodsRecycle()
    {
        $breadcrumb_title = '商品回收站';
        $breadcrumb = [
            ['url' => 'manager/goods-list', 'title' => '商品管理', 'is_active' => 0],
            ['url' => 'manager/good-recycle', 'title' => '商品回收站', 'is_active' => 1]
        ];

        return view('manager.goods_list')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb);
    }


    /**
     * [商品分类]
     * @return \Illuminate\View\View
     */
    public function getGoodTypes()
    {
        $breadcrumb_title = '商品分类';
        $breadcrumb = [
            ['url' => 'manager/goods-list', 'title' => '商品管理', 'is_active' => 0],
            ['url' => 'manager/good-types', 'title' => '商品分类', 'is_active' => 1]
        ];

        return view('manager.goods_type')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb);
    }

    /**
     * [新增商品分类]
     * @return $this
     */
    public function getAddGoodType()
    {
        $breadcrumb_title = '添加分类';
        $breadcrumb = [
            ['url' => 'manager/goods-list', 'title' => '商品管理', 'is_active' => 0],
            ['url' => '', 'title' => '添加分类', 'is_active' => 1]
        ];

        return view('manager.add_good_type')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb);
    }


    /**
     * [get Manager Configs]
     * @return $this
     */
    public function getSystem()
    {
        $user = Auth::user();
        $breadcrumb_title = '系统设置';
        $breadcrumb = [
            ['url' => '', 'title' => '系统设置', 'is_active' => 1]
        ];

        return view('manager.system')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('user', $user)
            ->with('breadcrumb', $breadcrumb);
    }

    /**
     * [Update WechatConfigs]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSystem(WechatConfigUpdate $request)
    {

        $user = $request->user();
        /* check User */
        if (!$user->isManager()) {
            return redirect('manager/login')
                ->with('message', '无权限！');
        }

        /* manager info*/
        $manger = $user->manager;
        $manger->name = Input::get('name');
        $manger->wechat = Input::get('wechat');
        $manger->email = Input::get('email');
        $manger->phone = Input::get('phone');
        $manger->qq = Input::get('qq');
        $manger->save();

        /* wechatConfig */
        $wechatConfig = WechatConfig::where('manager_id', $user->manager_id)->first();
        $config = [];
        $config['token'] = Input::get('token');
        $config['app_id'] = Input::get('app_id');
        $config['app_secret'] = Input::get('app_secret');
        $config['subscribe'] = Input::get('subscribe');
        $config = json_encode($config);
        if (empty($wechatConfig)) {
            $wechatConfig = new WechatConfig();
            $wechatConfig->manager_id = $user->manager_id;
        }
        $wechatConfig->configs = $config;
        $wechatConfig->save();


        return redirect('manager/system')
            ->with('tips', '数据更新成功！');
    }


    /**
     * [get fans list]
     * @return $this
     */
    public function getFansList()
    {
        $breadcrumb_title = '粉丝列表';
        $breadcrumb = [
            ['url' => 'manager/fans-list', 'title' => '微信中心', 'is_active' => 0],
            ['url' => '', 'title' => '粉丝列表', 'is_active' => 1]
        ];

        return view('manager.fans_list')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb);
    }


    /**
     * [get Subscribe event configs]
     * @return $this
     */
    function getSubscribe()
    {
        $breadcrumb_title = '关注回复';
        $breadcrumb = [
            ['url' => 'manager/fans-list', 'title' => '微信中心', 'is_active' => 0],
            ['url' => '', 'title' => '关注回复', 'is_active' => 1]
        ];

        /* get NotifyInfo with Subscribe */

        $user=Auth::user();
        $wechat_notify=new WechatNotify();
        $text_model=$wechat_notify->where('manager_id',$user->manager_id)
            ->where('event',"subscribe")
            ->where('type','text')
            ->first();
        if(empty($text_model))
        {
            $text_model=new WechatNotify();
            $text_model->contents="";
            $text_model->enabled=false;
        }

        $text_image_model=$wechat_notify->where('manager_id',$user->manager_id)
            ->where('event',"subscribe")
            ->where('type','text-image')
            ->first();
        if(!$text_image_model)
        {
            $text_image_model=new WechatNotify();
        }

        return view('manager.subscribe')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb)
            ->with('text_model',$text_model)
            ->with('text_image_model',$text_image_model);
    }


    /**
     * [Update Subscribe Notify]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function postSubscribe(WechatNotifyUpdate $request)
    {
        /* determine request type and events */
        $all = $request->all();
        $user = $request->user();
        if ($all['type'] == "text-image") {
            /* text-image model */
            if (empty($all['title']) || empty($all['url'])) {
                return redirect()->back()->withErrors("title or url can't empty")->withInput();
            }
            $wechat_notify = new WechatNotify();
            $wechat_notify = $wechat_notify->where("manager_id", $user->manager_id)
                ->where("type", "text-image")
                ->where("event", "subscribe")
                ->first();
            if (!$wechat_notify) {
                $wechat_notify = new WechatNotify();
                $wechat_notify->type = "text-image";
                $wechat_notify->event = "subscribe";
                $wechat_notify->manager_id = $user->manager_id;
            }
            /* update image-url */
            if ($request->hasFile("image_url")) {
                $file = $request->file("image_url");
                /* Determine file's mine is legal  */
                $files_access_mime_type = ['image/jpeg', 'image/png', 'image/gif'];
                $ext = ['jpg', 'png', 'gif'];
                $mime_type = $file->getMimeType();
                if (!in_array($mime_type, $files_access_mime_type)) {
                    return redirect()->back()->withErrors("Illegal file type mime!")->withInput();
                } else {
                    $ext = $ext[array_search($mime_type, $files_access_mime_type)];
                }
                /* Detemine if is manager */
                $auth = \Auth::user();
                if (!$auth->isManager()) {
                    return redirect()->back()->withErrors("Illegal user type!")->withInput();
                }
                /* move images to destination */
                $file_name = md5_file($file->getRealPath()) . '.' . $ext;
                $image_md5 = new ImageMd5();
                $target = "";
                if ($img = $image_md5->hasFile($file_name)) {
                    $target = config('image.storage_path') . $img->date_dir . $file_name;
                } else {
                    $data_dir = date("Ymd") . '/';
                    $path = config('image.storage_path') . $data_dir;
                    $target = $file->move($path, $file_name);
                    if ($target) {
                        $target = $path . $file_name;
                        /* insert Md5 file info */
                        $image_md5->date_dir = $data_dir;
                        $image_md5->file_name = $file_name;
                        $image_md5->save();
                    }
                }

                $wechat_notify->image_url = $target;
            }
            /* update notify */
            $wechat_notify->title = $all['title'];
            $wechat_notify->contents = $all['contents'];
            $wechat_notify->url = $all['url'];
            $wechat_notify->enabled = true;
            $wechat_notify->save();

            $wechat_notify = $wechat_notify->where("manager_id", $user->manager_id)
                ->where("type", "text")
                ->where("event", "subscribe")
                ->first();
            if (!empty($wechat_notify)) {
                $wechat_notify->enabled = false;
                $wechat_notify->save();
            }

        }

        if ($all['type'] == "text") {
            $wechat_notify = new WechatNotify();
            $wechat_notify = $wechat_notify->where("manager_id", $user->manager_id)
                ->where("type", "text")
                ->where("event", "subscribe")
                ->first();
            if(empty($wechat_notify))
            {
                $wechat_notify=new WechatNotify();
                $wechat_notify->event="subscribe";
                $wechat_notify->manager_id=$user->manager_id;
            }
            $wechat_notify->enabled = true;
            $wechat_notify->contents = $all['contents'];
            $wechat_notify->save();


            $wechat_notify = $wechat_notify->where("manager_id", $user->manager_id)
                ->where("type", "text-image")
                ->where("event", "subscribe")
                ->first();

            if (!empty($wechat_notify)) {
                $wechat_notify->enabled = false;
                $wechat_notify->save();
            }
        }


        return redirect()->back()
            ->with("tips", "Update Success!");


    }


    public function getKeyword(){
        $breadcrumb_title = '关键词';
        $breadcrumb = [
            ['url' => 'manager/fans-list', 'title' => '微信中心', 'is_active' => 0],
            ['url' => '', 'title' => '关键词', 'is_active' => 1]
        ];

        return view('manager.keyword')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb);
    }


    /**
     * [Set WechatMenu to Wechat]
     * @return string
     */
    public function getSetWechatMenu()
    {
        $user = Auth::user();
        $menu_list = WechatMenu::where('manager_id', $user->manager_id)
            ->orderBy('parent_id', 'asc')
            ->orderBy('index', 'desc')
            ->get();

        $wechat_configs = WechatConfig::where('manager_id', $user->manager_id)
            ->first();

        $configs = json_decode($wechat_configs->configs);
        $app_id = $configs->app_id;
        $app_secret = $configs->app_secret;

        $wechat_menu = new Menu($app_id, $app_secret);


        $target = [];
        foreach ($menu_list as $menu) {

            /* 一级菜单 */
            if ($menu->parent_id == 0) {
                $item = new MenuItem ($menu['name'], $menu['menu_type'], $menu['value']);


                /* 二级菜单 */
                $buttons = [];
                foreach ($menu_list as $button) {

                    if ($button->parent_id == $menu['id']) {

                        $buttons[] = new MenuItem($button['name'], $button['menu_type'], $button['value']);

                    }
                }
                $item->buttons($buttons);
                $target[] = $item;
            }
        }

        if (!empty($target)) {
            $wechat_menu->set($target); // 失败会抛出异常
        } else {
            $wechat_menu->delete();
        }

        return redirect('manager/wechat-menu')
            ->with('tips', '菜单设置成功！');

    }

    /**
     * [退出登录]
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect('manager');
    }


}
