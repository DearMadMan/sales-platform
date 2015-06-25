<?php

namespace App\Http\Controllers\Manager;

use App\Breadcrumb;
use App\Good;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GoodController extends BaseManagerController
{

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs_url = "manager/good";
        $this->breadcrumbs_main = ['manager/good', '商品管理', 0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->setBreadcrumb('商品列表');
        $good = new Good();
        $goods = $good->getGoods($this->manager_id);
        return view('manager.goods_list')
            ->with('goods', $goods)
            ->with('breadcrumb', $this->breadcrumb);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $good=new Good();
        return view('manager.add_goods')
            ->with('breadcrumb',$this->breadcrumb)
            ->with('method','post')
            ->with('good',$good);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
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
