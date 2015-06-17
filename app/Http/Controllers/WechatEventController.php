<?php

namespace App\Http\Controllers;

use App\Article;
use App\WechatKeyword;
use App\WechatKeywordArticle;
use App\WechatNotify;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Overtrue\Wechat\Message;

class WechatEventController extends Controller
{
    protected $configs = null;
    protected $manager_id = 0;
    protected $temp_obj = null;

    public function  __construct($manager_id, $configs)
    {
        $this->manager_id = $manager_id;
        $this->configs = $configs;
    }

    public function subscribe($event)
    {
        if ($this->configs->subscribe) {
            $notify = WechatNotify::where('event', 'subscribe')
                ->where('enabled', 1)
                ->where('manager_id', $this->manager_id)
                ->first();
            if (!empty($notify)) {
                $notify->contents = str_replace(['\n', '<br>'], "\n", $notify->contents);
                $this->temp_obj = $notify;
                if ($notify->type == "text") {
                    return Message::make('text')->content($notify->contents);
                } else {
                    $news = Message::make('news')->items(function () {
                        return array(
                            Message::make('news_item')->title($this->temp_obj->title)
                                ->description($this->temp_obj->contents)
                                ->picUrl("http://ddd.tunnel.mobi/" . $this->temp_obj->image_url)
                                ->url($this->temp_obj->url),
                        );

                    });
                    return $news;
                }

            }
        }
        return false;
    }

    public function keyword($message)
    {
        $key = $message->Content;
        $keyword = WechatKeyword::where(["key" => $key, "manager_id"=>$this->manager_id])
            ->first();
        if ($keyword) {
            if ($keyword->type) {
                /* image-text model */
                $keyword_articles = WechatKeywordArticle::where("keyword_id", $keyword->id)->first();
                if ($keyword_articles) {
                    $articles = Article::whereIn("id", explode(',',$keyword_articles->article_ids))->get();
                    if (!$articles->isEmpty()) {
                        $news = Message::make('news')->items(function () use ($articles) {
                            $arr = [];
                            foreach ($articles as $v) {
                                        $arr[]=Message::make("news_item")->title($v->title)->url($v->out_link)->picUrl($v->pic_url);
                            }
                            return $arr;
                        });
                        return $news;
                    }
                    else
                    {
                        return "Article is Empty!";
                    }
                }
                else
                {
                    return "Keyword article relationship is empty!";
                }
            } else {
                return Message::make('text')->content($keyword->contents);
            }
        }
        else
        {
            return $key.":".$this->manager_id;
        }
        return false;
    }


}
