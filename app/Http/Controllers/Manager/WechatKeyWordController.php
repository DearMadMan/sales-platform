<?php

namespace App\Http\Controllers\Manager;

use App\WechatKeyword;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WechatKeyWordController extends Controller
{
    public function show(Request $request,$id)
    {
        $breadcrumb_title = '设置关键词';
        $breadcrumb = [
            ['url' => 'manager/fans-list', 'title' => '微信中心', 'is_active' => 0],
            ['url' => '', 'title' => '设置关键词', 'is_active' => 1]
        ];

        $keyword = new WechatKeyword();
        $keyword = $keyword->where('manager_id', $request->user()->manager_id)
            ->where('id',$id)
            ->first();
        if(!$keyword){
            return redirect("404");
        }
        return view('manager.keyword_edit')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb)
            ->with("keyword", $keyword);
    }

    public function lists(Request $request)
    {
        $breadcrumb_title = '关键词';
        $breadcrumb = [
            ['url' => 'manager/fans-list', 'title' => '微信中心', 'is_active' => 0],
            ['url' => '', 'title' => '关键词', 'is_active' => 1]
        ];

        $keywords = new WechatKeyword();
        $keywords = $keywords->where('manager_id', $request->user()->manager_id)
            ->get();

        return view('manager.keyword_list')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb)
            ->with("keywords", $keywords);
    }

    public function create(){
        $breadcrumb_title = '新增关键词';
        $breadcrumb = [
            ['url' => 'manager/fans-list', 'title' => '微信中心', 'is_active' => 0],
            ['url' => '', 'title' => '新增关键词', 'is_active' => 1]
        ];
        return view('manager.add_keyword')
            ->with('breadcrumb_title', $breadcrumb_title)
            ->with('breadcrumb', $breadcrumb);
    }

}
