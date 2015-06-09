<?php namespace App\Http\Controllers;

use Overtrue\Wechat\Services\Message;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->middleware ('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index ()
    {
        $a=1;
        $options = [
            'appId'  => 'wx51bbebf779eec25f' ,
            'secret' => '1f8bcc3a5f0dd9bcf62ee6b4a16d4b6f' ,
            'token'  => 'zzz'
        ];

        $wechat = \Overtrue\Wechat\Wechat::make ($options);

        $server = $wechat->on ('message' , function ($message) {
                return Message::make ('text')->content ("您好！欢迎关注 overtr ueasdsd<p> \r  \n asdsa");
        });

        return $wechat->serve ();
    }

}
