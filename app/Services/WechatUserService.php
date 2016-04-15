<?php namespace App\Services;

use App\User;
use Overtrue\Wechat\User as UserService;
use Carbon\Carbon;
use Auth;
use Overtrue\Wechat\Auth as Authorize;
use Log;

class WechatUserService {

  protected $user;
  protected $userService;
  protected $wechatConfig;

  public function __construct (User $user) {
    $this->user = $user; 
  }

  public function getUserFromOpenId ($open_id) {
    return $this->user->where('open_id', $open_id)->first(); 
  }

  /**
   * [设置公共号配置信息]
   * @param [type] $config [config对象]
   */
  public function setConfig ($config) {
    $this->config = $config; 
  }

  public function isSubscribe($open_id = '') {
    if ($open_id) {
      $user = $this->getUserFromOpenId($open_id);
      if ($user) {
        return $user->subscribe_status;
      }
    }
    return $this->user->subscribe_status;
  }

  /**
   * [初始化服务，配置服务信息]
   * @param  [type] $config [微信公众号信息]
   * @return [type]         [description]
   */
  public function init ($config) {
    $this->setConfig($config);
    $this->UserService = new UserService($config->app_id,$config->app_secret); 
  }

  /**
   * [根据openid拉取微信端用户数据信息]
   * @param  [type] $open_id [微信openid || FromUser]
   * @return [type]          [用户信息对象]
   */
  public function getUserInfoFromWechat($open_id) {
    $user = $this->UserService->get($open_id);
    return $user;
  }

  /**
   * [根据用户信息对象在数据库中录入一条用户数据]
   * @param  [type] $userInfo [用户对象]
   * @return [type]           [description]
   */
  public function createFans ($userInfo) {
    $user = new User();
    $user->nick_name = $userInfo->nickname;
    $user->open_id = $userInfo->openid;
    $user->image_url = $userInfo->headimgurl;
    $user->subscribe_status = true;
    $user->subscribe_time = Carbon::now();
    $user->sex = $userInfo->sex;
    $user->city = $userInfo->city;
    $user->country = $userInfo->country;
    $user->province = $userInfo->province;
    $user->lang = $userInfo->language;
    $user->email = time().rand(0,999999999).'@domian.com';
    $user->manager_id = 1;
    $user->user_type_id = 1;
    $user->save();
  }

  /**
   * [根据微信openid在从微信拉取用户信息并在数据库中生成一条数据]
   * @param  [type] $open_id [description]
   * @return [type]          [description]
   */
  public function createFansWithOpenId ($open_id) {
    $user = $this->getUserInfoFromWechat($open_id);
    $this->createFans($user);
  }

  /**
   * [静默授权并登录, 已登录用户不再做授权]
   */
  public function LoginFromWechat() {
    if(Auth::user()){
      return true;
    }  
    $this->authorizeAndLogin();
  }

  /**
   * [静默授权并登录]
   * @return [type] [description]
   */
  public function authorizeAndLogin () {
      $auth = new Authorize($this->config->app_id,$this->config->app_secret);     
      $user = $auth->authorize(null,'snsapi_base');
      $user = $this->getUserFromOpenId($user->openid);
      if(!$user) {
        throw new \Exception('not found user!');
      }
      Auth::login($user);
  }

}