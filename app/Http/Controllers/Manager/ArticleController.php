<?php

namespace App\Http\Controllers\Manager;

use App\Article;
use App\Breadcrumb;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function __construct(){
        $this->middleware('manager');
    }

    public function index(Breadcrumb $breadcrumb,Article $articles,Request $request){

        $breadcrumb->setBreadcrumbs("文章列表",[
            ['manager/article','文章中心',0],
            ['','文章列表',1]
        ]);
        $user=$request->user();
        $articles=$articles->where([
            'manager_id'=>$user->manager_id
        ])
            ->paginate(config("page.paginate"));
        return view('manager.article_list')
            ->with('articles',$articles)
            ->with('breadcrumb', $breadcrumb);
    }

    public function create(){

    }

    public function store(){

    }

    public function edit(){
    }

    public function update(){

    }

    public function show(){

    }

    public function destroy(){

    }
}
