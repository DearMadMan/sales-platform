<?php

namespace App\Http\Controllers\Manager;

use App\GoodType;
use App\Http\Requests\Manager\GoodTypeStore;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GoodTypeController extends BaseManagerController
{

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs_url = "manager/good-type";
        $this->breadcrumbs_main = ['manager/good-type', '商品管理', 0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->setBreadcrumb('分类列表');
        $type = new GoodType();
        $types = $type->getTypes($this->manager_id);
        return view('manager.goods_type')
            ->with('breadcrumb', $this->breadcrumb)
            ->with('types', $types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->setBreadcrumb('新建分类');
        $type = new GoodType();
        $types=$type->getTypes($this->manager_id,false);
        return view('manager.add_good_type')
            ->with('breadcrumb', $this->breadcrumb)
            ->with('method', 'post')
            ->with('type', $type)
            ->with('types',$types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GoodTypeStore $request
     * @return Response
     */
    public function store(GoodTypeStore $request)
    {
        $type=new GoodType();
        $res=$type->StoreNew($request);
        if(!$res)
        {
            return redirect($this->breadcrumbs_url)->with('message','Store Date Failed!');
        }
        return redirect($this->breadcrumbs_url)->with('message',"Store Data Success!");
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
        $type=new GoodType();
        $types=$type;
        $type=$type->getType($this->manager_id,$id);
        if(!$type){
            return redirect($this->breadcrumbs_url);
        }
        $types=$types->getTypes($this->manager_id,false);
        return view('manager.add_good_type')
            ->with('breadcrumb',$this->breadcrumb)
            ->with('type',$type)
            ->with('types',$types)
            ->with('method',"put");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GoodTypeStore $request
     * @param  int $id
     * @return Response
     */
    public function update(GoodTypeStore $request,$id)
    {
        $type=new GoodType();
        $res=$type->UpdateType($request,$id);
        if(!$res){
            return redirect($this->breadcrumbs_url)->with('message',"Whoops, looks like something went wrong.");
        }
        return redirect($this->breadcrumbs_url)->with('message',"Update Type Success!");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $type=new GoodType();
        $res=$type->DeleteType($this->manager_id,$id);
        if(!$res){
            return redirect($this->breadcrumbs_url)->with('message',"Whoops, looks like something went wrong.");
        }
        return redirect($this->breadcrumbs_url)->with('message',"Delete Type Success!");
    }
}
