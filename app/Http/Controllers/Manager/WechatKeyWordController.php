<?php

namespace App\Http\Controllers\Manager;

use App\Article;
use App\Breadcrumb;
use App\WechatKeyword;
use App\WechatKeywordArticle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WechatKeyWordController extends Controller
{
    public function __construct()
    {
        $this->middleware("manager");
    }

    public function show(Breadcrumb $breadcrumb, Request $request, $id)
    {
        $breadcrumb->setBreadcrumbs('设置关键词', [
            ['url' => 'manager/fans-list',  '微信中心',  0],
            ['url' => '',  '设置关键词',  1]
        ]);

        $keyword = new WechatKeyword();
        $keyword = $keyword->where('manager_id', $request->user()->manager_id)
            ->where('id', $id)
            ->first();

        if (!$keyword) {
            return redirect("404");
        }
        $keyword_articles = WechatKeywordArticle::firstOrNew(["keyword_id" => $keyword->id]);
        $articles = false;
        if (!empty($keyword_articles->article_ids)) {
            $arr = explode(',', $keyword_articles->article_ids);
            $articles = Article::whereIn("id", $arr)
                ->get();
        }
        return view('manager.keyword_edit')
            ->with('breadcrumb', $breadcrumb)
            ->with("keyword", $keyword)
            ->with("articles", $articles);
    }

    public function index(Breadcrumb $breadcrumb, Request $request)
    {
        $breadcrumb->setBreadcrumbs('关键词', [
            [ 'manager/fans-list',  '微信中心',  0],
            [ '',  '关键词',  1]
        ]);

        $keywords = new WechatKeyword();
        $keywords = $keywords->where('manager_id', $request->user()->manager_id)
            ->get();

        return view('manager.keyword_list')
            ->with('breadcrumb', $breadcrumb)
            ->with("keywords", $keywords);
    }

    public function Search(Request $request)
    {
        $user = $request->user();
        $articles = Article::where("manager_id", $user->manager_id)
            ->where("title", "like", '%' . $request->input('search') . '%')
            ->get();
        return json_encode($articles);
    }

    public function update(Request $request, $id)
    {
        $keyword = WechatKeyword::find($id);
        if (!$keyword || $keyword->manager_id != $request->user()->manager_id) {
            return redirect('404');
        }
        $type = (int)$request->input("type");
        if ($type) {
            /*image model*/
            $keyword->type = 1;
            $ids = $request->input("ids");
            if (!empty($ids)) {
                $ids = trim($ids, ',');
                $ids_arr = explode(',', $ids);
                $articles = Article::whereIn('id', $ids_arr)
                    ->where('manager_id', "<>", $request->user()->manager_id)
                    ->get();
                if (!empty($articles->toArray())) {
                    dd($articles->toArray());
                    return redirect('404');
                }

                $keyword_article = WechatKeywordArticle::firstOrNew(['keyword_id' => $id]);
                $keyword_article->article_ids = $ids;
                $keyword_article->manager_id = $request->user()->manager_id;
                $keyword_article->save();


            }
        } else {
            $keyword->type = 0;
            $keyword->contents = $request->input('contents');
        }
        $keyword->save();
        return redirect('manager/keyword')->with("tips", "Update Success!");
    }

    public function create(Breadcrumb $breadcrumb)
    {
        $breadcrumb->setBreadcrumbs('新增关键词', [
            [ 'manager/fans-list',  '微信中心',  0],
            [ '',  '新增关键词',  1]
        ]);
        return view('manager.add_keyword')
            ->with('breadcrumb', $breadcrumb);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $key = $request->input("key");
        if (!$key) {
            return redirect()->back()
                ->withErrors("关键字不能为空！");
        }
        $keyword = new WechatKeyword();
        $keyword->where("manager_id", $user->manager_id)
            ->where("key", $key)
            ->first();
        if (!$key) {
            return redirect()->back()
                ->withErrors("关键字已存在！");
        }
        $keyword->key = $key;
        $keyword->type = 0;
        $keyword->manager_id = $user->manager_id;
        $keyword->save();
        return redirect('manager/keyword/' . $keyword->id);
    }

}
