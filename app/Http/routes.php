<?php
    use App\Article;
    use App\User;
use App\WechatKeyword;
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

    /* post 独立路由 */
    Route::post('manager/upload-images','Manager\UploadController@UploadImages');  /* 独立路由 需要在之前定义*/
    Route::post('manager/keyword/search','Manager\WechatKeywordController@Search');  /* 独立路由 需要在之前定义*/

    Route::get ('test' , function () {

        return session ('captcha');
    });

    Route::get ('/' , function () {

        $keyword = WechatKeyword::where(["key" => 'bbb', "manager_id"=>1])
            ->first();
        dd($keyword);
        return view ('404');
    });


    Route::get ("404" , function () {
        return view ('404');
    });
//    Route::get('callback',function(){
//        $server=new Server("xxx","zzzz" );
//
//        return $server->serve();
//    });

    Route::any ('callback/{manager_id}' , "WechatCallbackController@index");

    Route::resources ([
        'manager/user' => 'Manager\UserController'
    ]);
    /* 微信菜单 */
    Route::resource ('manager/wechat-menu' , 'Manager\WechatMenuController');
    Route::resource ('manager/keyword' , 'Manager\WechatKeywordController');
    Route::Controllers ([
        'tool'    => 'ToolController' ,
        'manager' => 'Manager\ManagerController'
    ]);



