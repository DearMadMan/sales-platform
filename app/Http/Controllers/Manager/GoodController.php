<?php

namespace App\Http\Controllers\Manager;

use App\Breadcrumb;
use App\Good;
use App\GoodType;
use App\Http\Requests\Manager\GoodStore;
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
        $this->setBreadcrumb('添加新产品');
        $good=new Good();
        $good->UnSetGalleries();
        $type=new GoodType();
        $types=$type->getTypes($this->manager_id,false);
        return view('manager.add_goods')
            ->with('breadcrumb',$this->breadcrumb)
            ->with('method','post')
            ->with("types",$types)
            ->with('good',$good);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(GoodStore $request)
    {
        $good=new Good();
        $res=$good->GoodStore($request);
        if(!$res){
            return redirect($this->breadcrumbs_url)->with('message','Store Something Error!');

        }
        return redirect($this->breadcrumbs_url)->with('message','Store Good Success!');
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
        $this->setBreadcrumb('修改商品');
        $good=new Good();
        $res=$good->getGood($this->manager_id,$id);
        $type=new GoodType();
        $types=$type->getTypes($this->manager_id);
        if(!$good)
        {
            return redirect($this->breadcrumbs_url)->with('message',"Whoops, looks like something went wrong.");
        }
        return view('manager.add_goods')
            ->with('breadcrumb',$this->breadcrumb)
            ->with('good',$good)
            ->with('types',$types);
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
