<?php

namespace App\Http\Controllers\Manager;

use App\Article;
use App\ArticleType;
use App\Breadcrumb;
use App\Http\Requests\Manager\ArticleStoreRequest;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    protected $breadcrumbs_url = 'manager/article';

    public function __construct()
    {
        $this->middleware('manager');
    }

    public function index(Breadcrumb $breadcrumb, Article $articles, Request $request)
    {

        $breadcrumb->setBreadcrumbs("文章列表", [
            ['manager/article', '文章中心', 0],
            ['', '文章列表', 1]
        ]);
        $user = $request->user();
        $articles = $articles->where([
            'manager_id' => $user->manager_id
        ])->orderBy('id', 'desc')
            ->paginate(config("page.paginate"));
        return view('manager.article_list')
            ->with('articles', $articles)
            ->with('breadcrumb', $breadcrumb);
    }

    public function create(Request $request, Breadcrumb $breadcrumb)
    {
        $breadcrumb->setBreadcrumbs('新增文章', [
            [$this->breadcrumbs_url, '文章列表', 0],
            ['', '新增文章', 1]
        ]);

        $types = new ArticleType();
        $types->getTypes($request->user()->manager_id);

        return view('manager.add_article')
            ->with('breadcrumb', $breadcrumb)
            ->with('types', $types);
    }

    public function store(ArticleStoreRequest $request)
    {
        $target = false;
        if ($request->hasFile("pic_url")) {
            $upload = new UploadController();
            $target = $upload->UploadImageHander($request, "pic_url");
        }
        $article = new Article();
        $article->title = $request->input('title');
        $type = new ArticleType();
        $type = $type->where([
            'id' => $request->input('type_id'),
            'manager_id' => $request->user()->manager_id
        ]);
        if (!$type) {
            return redirect("manager/article/create");
        }
        $article->type_id = $request->input('type_id');
        $article->content = $request->input('content');
        $request->has("is_show") ? $article->is_show = 1 : $article->is_show = 0;
        $request->out_link = $request->input('out_link');
        $article->manager_id = Auth::user()->manager_id;
        $target ? $article->pic_url = $target : 0;
        $article->save();
        return redirect($this->breadcrumbs_url);
    }

    public function edit(Request $request, Breadcrumb $breadcrumb, $id)
    {
        $breadcrumb->setBreadcrumbs('修改文章', [
            [$this->breadcrumbs_url, '文章列表', 0],
            ['', '修改文章', 1]
        ]);
        $article = new Article();
        $article = $article->where([
            'id' => $id,
            'manager_id' => $request->user()->manager_id
        ])->first();
        if (!$article) {
            return redirect($this->breadcrumbs_url);
        }
        $types = new ArticleType();
        $types = $types->getTypes($request->user()->manager_id);

        return view('manager.article_edit')
            ->with('breadcrumb', $breadcrumb)
            ->with('article', $article)
            ->with('types', $types);
    }

    public function update(ArticleStoreRequest $request, $id)
    {
        $article = new Article();
        $article = $article->where([
            'id' => $id,
            "manager_id" => $request->user()->manager_id
        ])->first();

        if(!$article)
        {
            return redirect($this->breadcrumbs_url);
        }

        $type = new ArticleType();
        $type = $type->where([
            'id' => $request->input('type_id'),
            'manager_id' => $request->user()->manager_id
        ]);
        if (!$type) {
            return redirect("manager/article/create");
        }


        $target = false;
        if ($request->hasFile("pic_url")) {
            $upload = new UploadController();
            $target = $upload->UploadImageHander($request, "pic_url");
        }

        $article->title = $request->input('title');

        $article->type_id = $request->input('type_id');
        $article->content = $request->input('content');
        $request->has("is_show") ? $article->is_show = 1 : $article->is_show = 0;
        $request->out_link = $request->input('out_link');
        $target ? $article->pic_url = $target : 0;
        $article->save();
        return redirect($this->breadcrumbs_url);
    }

    public function show(Breadcrumb $breadcrumb, Request $request, $id)
    {
        $breadcrumb->setBreadcrumbs("文章展示", [
            ['manager/article', '文章中心', 0],
            ['', '文章展示', 1]
        ]);

        $article = new Article();
        $article = $article->where([
            'id' => $id,
            'manager_id' => $request->user()->manager_id
        ])->first();
        if (!$article) {
            return redirect($this->breadcrumbs_url);
        }
        return view('manager.article_show')->with('article', $article)->with('breadcrumb', $breadcrumb);;
    }

    public function destroy()
    {

    }
}
