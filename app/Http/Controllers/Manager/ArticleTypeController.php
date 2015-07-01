<?php

namespace App\Http\Controllers\Manager;

use App\ArticleType;
use App\Breadcrumb;
use App\Http\Requests\Manager\ArticletypeStore;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleTypeController extends BaseManagerController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs_url = "manager/article-type";
        $this->breadcrumbs_main = ['manager/article', '文章中心', 0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(ArticleType $articleType, Request $request)
    {
        $this->setBreadcrumb("文章分类");
        $types = $articleType->getTypes($request->user()->manager_id, true);
        return view("manager.article_type_list")
            ->with("breadcrumb", $this->breadcrumb)
            ->with('types', $types);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(ArticleType $type)
    {
        $this->setBreadcrumb("新的分类");

        return view('manager.add_article_type')
            ->with("breadcrumb", $this->breadcrumb)
            ->with("method", "post")
            ->with('type', $type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ArticletypeStore $request)
    {

        $manager_id = $request->user()->manager_id;
        $type_name = $request->input("type_name");
        $type = new ArticleType();
        $row = $type->where(['manager_id' => $manager_id, 'type_name' => $type_name])->first();
        if ($row) {
            return redirect($this->breadcrumbs_url)->with('message', "ArticleType Already exist!");
        }
        $type->type_name = $type_name;
        $type->manager_id = $manager_id;
        $type->save();
        return redirect($this->breadcrumbs_url)->with('message', "Store date success!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $this->setBreadcrumb("更新分类");
        $type = new ArticleType();
        $row = $type->where(['id' => $id, 'manager_id' => $request->user()->manager_id])->first();
        if (!$row) {
            return redirect($this->breadcrumbs_url);
        }
        return view('manager.add_article_type')
            ->with('breadcrumb', $this->breadcrumb)
            ->with('type', $row)
            ->with('method', 'put');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(ArticletypeStore $request, $id)
    {
        $type = new ArticleType();
        $type->UpdateType($request, $id);
        return redirect($this->breadcrumbs_url)->with('message', "Update Date Success!");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
