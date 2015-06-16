<?php

namespace App\Http\Controllers;

use App\WechatNotify;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Overtrue\Wechat\Message;

class WechatEventController extends Controller
{
    protected $configs = null;
    protected $manager_id = 0;
    protected $temp_obj=null;
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
                $notify->contents=str_replace(['\n','<br>'],"\n",$notify->contents);
                $this->temp_obj=$notify;
                if ($notify->type == "text") {
                    return Message::make('text')->content($notify->contents);
                } else {
                    $news = Message::make('news')->items(function() {
                        return array(
                            Message::make('news_item')->title($this->temp_obj->title)
                            ->description($this->temp_obj->contents)
                            ->picUrl("http://ddd.tunnel.mobi/".$this->temp_obj->image_url)
                            ->url($this->temp_obj->url),
                        );

                    });
                    return $news;
                }

            }
        }
        return false;
    }
}
