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
        $type=new GoodType();
        $types=$type->getTypes($this->manager_id,false);
        $good=new Good();
        $good->type_id=0;
        $good->is_on_sale=true;

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
        $good=$good->getGood($this->manager_id,$id);
        if(!$good)
        {
            return redirect($this->breadcrumbs_url)->with('message',"Whoops, looks like something went wrong.");
        }
        $type=new GoodType();
        $types=$type->getTypes($this->manager_id);
        return view('manager.add_goods')
            ->with('breadcrumb',$this->breadcrumb)
            ->with('good',$good)
            ->with('method','put')
            ->with('types',$types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GoodStore $request
     * @param  int $id
     * @return Response
     */
    public function update(GoodStore $request,$id)
    {
        $good=new Good();
        $res=$good->UpdateGood($request,$id);
        if(!$res){
            return redirect($this->breadcrumbs_url)->with('message','Update Something Error!');

        }
        return redirect($this->breadcrumbs_url)->with('message','Update Good Success!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request,$id)
    {
        $good=new Good();
        $res=$good->Recycle($request->user()->manager_id,$id);
        return $res?"true":'false';
    }


    public function Recycle(Request $request)
    {
        $this->setBreadcrumb('商品回收站');
        $good = new Good();
        $goods = $good->getRecycles($request->user()->manager_id);
        return view('manager.good_recycle_list')
            ->with('goods', $goods)
            ->with('breadcrumb', $this->breadcrumb);
    }

    public function Restore(Request $request,$id)
    {
        $good=new Good();
        $good=$good->Restore($request->user()->manager_id,$id);
        if($good)
        {
            return redirect('manager/good/recycle')->with('message','Restore Data Success!');
        }
        return redirect('manager/good/recycle')->with('message','Restore Data Failed!');

    }


}
