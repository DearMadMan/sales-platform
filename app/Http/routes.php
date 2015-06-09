<?php
    use App\Article;
    use App\User;
    use Dearmadman\Captcha\Captcha;
    use Overtrue\Wechat\Server;

    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the controller to call when that URI is requested.
    |
    */

    Route::get('test',function(){

        return session('captcha');
    });

    Route::get('/',function(){
        $server=new Server("wx51bbebf779eec25f","zzz" );
        dd($server);
        return view('404');
    });


    Route::get("404",function(){
        return view('404');
    });
//    Route::get('callback',function(){
//        $server=new Server("xxx","zzzz" );
//
//        return $server->serve();
//    });

    Route::any ('callback' , "WechatCallbackController@index");

    Route::resources ([
        'manager/user' => 'Manager\UserController'
    ]);
    /* 微信菜单 */
    Route::resource( 'manager/wechat-menu','Manager\WechatMenuController');

    Route::Controllers ([
        'tool' => 'ToolController',
        'manager'=>'Manager\ManagerController'
    ]);