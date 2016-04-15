<?php

namespace App\Http\Controllers;

use App\Article;
use App\WechatKeyword;
use App\WechatKeywordArticle;
use App\WechatNotify;
use Illuminate\Http\Request;
use App\Services\WechatUserService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Overtrue\Wechat\Message;
use App\User;
use Log;

class WechatEventController extends Controller
{
    protected $configs;
    protected $manager_id;
    protected $temp_obj;
    protected $userService;

    public function __construct($manager_id, $configs, WechatUserservice $userService)
    {
        $this->manager_id = $manager_id;
        $this->configs = $configs;
        $this->userService = $userService;
    }

    /**
     * [在用户关注时初始化用户信息，用户信息入库，改变用户关注状态]
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    public function initUser($event)
    {
        $open_id = $event['FromUserName'];
        // 查询用户信息
        $user = $this->userService->getUserFromOpenId($open_id);
        if (!$user) {
            $this->userService->createFansWithOpenId($open_id);
        }
    }

    /**
     * [subscribe event listener]
     * @param $event
     * @return bool
     */
    public function subscribe($event)
    {
        if ($this->configs->subscribe) {
            // 查询该公众号 是否开启关注回复功能
            $notify = WechatNotify::where('event', 'subscribe')
                ->where('enabled', 1)
                ->where('manager_id', $this->manager_id)
                ->first();
            if (!empty($notify)) {
                $notify->contents = str_replace(['\n', '<br>'], "\n", $notify->contents);
                empty($notify->url) ? $notify->url = config('image.domain') . "show/{$notify->id}" : true;
                $this->temp_obj = $notify;

                if ($notify->type == "text") {
                    return Message::make('text')->content($notify->contents);
                } else {
                    $news = Message::make('news')->items(function () {
                        return array(
                            Message::make('news_item')->title($this->temp_obj->title)
                                ->description($this->temp_obj->contents)
                                ->picUrl(config("image.domain") . $this->temp_obj->image_url)
                                ->url($this->temp_obj->url),
                        );

                    });
                    return $news;
                }
            }
        }
        return false;
    }

    /**
     * [关键字回复]
     * @param  [type] $message [Message]
     * @return [type]          [description]
     */
    public function keyword($message)
    {
        $key = $message->Content;
        if (empty($key)) {
            $key = $message->EventKey;
        }
        $keyword = WechatKeyword::where(["key" => $key, "manager_id" => $this->manager_id])
            ->first();
        if ($keyword) {
            if ($keyword->type) {
                /* image-text model */
                $keyword_articles = WechatKeywordArticle::where("keyword_id", $keyword->id)->first();
                if ($keyword_articles) {
                    $articles = Article::whereIn("id", explode(',', $keyword_articles->article_ids))->get();
                    if (!$articles->isEmpty()) {
                        $news = Message::make('news')->items(function () use ($articles) {
                            $arr = [];
                            foreach ($articles as $v) {
                                empty($v->out_link) ? $v->out_link = config('image.domain') . "show/{$v->id}" : true;
                                $arr[] = Message::make("news_item")
                                    ->title($v->title)
                                    ->url($v->out_link)
                                    ->picUrl(config("image.domain") . $v->pic_url);
                            }
                            return $arr;
                        });
                        return $news;
                    } else {
                        return "Article is Empty!";
                    }
                } else {
                    return "Keyword article relationship is empty!";
                }
            } else {
                return Message::make('text')->content($keyword->contents);
            }
        } else {
            return $key . ":" . $this->manager_id;
        }
        return '';
    }
}
