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
Route::post('manager/upload-images', 'Manager\UploadController@UploadImages');  /* 独立路由 需要在之前定义*/
Route::post('manager/good-gallery', 'Manager\UploadController@GoodGallery');  /* 独立路由 需要在之前定义*/
Route::post('manager/upload-images-ckeditor', 'Manager\UploadController@UploadImagesCkeditor');  /* 独立路由 需要在之前定义*/
Route::post('manager/keyword/search', 'Manager\WechatKeywordController@Search');  /* 独立路由 需要在之前定义*/

/* get 独立路由 */
Route::get('manager/article/recycle', 'Manager\ArticleController@Recycle');  /* 独立路由 需要在之前定义*/
Route::get('manager/article/{id}/restore', 'Manager\ArticleController@Restore')->where('id', '[0-9]+');;  /* 独立路由 需要在之前定义*/
Route::get('manager/good/recycle', 'Manager\GoodController@Recycle');  /* 独立路由 需要在之前定义*/
Route::get('manager/good/{id}/restore', 'Manager\GoodController@Restore')->where('id', '[0-9]+');;  /* 独立路由 需要在之前定义*/

Route::get('test', function () {
    if (Input::get('clear')) {
        session()->forget('image_gallery');
        session()->save();

    }
    dd(session()->all());
    return session('image_gallery');
});

Route::get('/', function () {

    $keyword = WechatKeyword::where(["key" => 'bbb', "manager_id" => 1])
        ->first();
    dd($keyword);
    return view('404');
});


Route::get("404", function () {
    return view('404');
});


Route::any('callback/{manager_id}', "WechatCallbackController@index");


/* 微信菜单 */
Route::resources([
    'manager/user' => 'Manager\UserController',
    'manager/wechat-menu' => 'Manager\WechatMenuController',
    'manager/keyword' => 'Manager\WechatKeywordController',
    'manager/article' => 'Manager\ArticleController',
    'manager/article-type' => 'Manager\ArticleTypeController',
    'manager/good' => 'Manager\GoodController',
    'manager/express' => 'Manager\ExpressController',
    'manager/good-type' => 'Manager\GoodTypeController'
]);


Route::Controllers([
    'tool' => 'ToolController',
    'manager' => 'Manager\ManagerController'
]);



