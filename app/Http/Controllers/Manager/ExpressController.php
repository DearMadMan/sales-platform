<?php

namespace App\Http\Controllers\Manager;

use App\Express;
use App\ExpressArea;
use App\Http\Requests\ExpressAreaUpdateForExpressController;
use App\Http\Requests\ExpressStoreForExpressController;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;

class ExpressController extends BaseManagerController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs_url = "manager/express";
        $this->breadcrumbs_main = ['manager/express', '配送中心', 0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->setBreadcrumb('配送方式');

        $collection = $this->getSystemExpress();
        $express = new Express();
        $expresses = $express->getExpresses($this->manager_id)->toArray();
        $arr = [];
        foreach ($expresses as $k => $v) {
            $arr[$v['code']] = $v;
        }
        $expresses = $arr;
        return view('manager.express_list')
            ->with('expresses', $expresses)
            ->with('collection', $collection)
            ->with('breadcrumb', $this->breadcrumb);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExpressStoreForExpressController $request
     * @return Response
     */
    public function store(ExpressStoreForExpressController $request)
    {
        $express = new Express();
        $res = $express->storeDeliverRegion($request);
        return $res;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {

        $express = new Express();
        $res = $express->existExpress($this->manager_id, $id);
        if (!$res) {
            return redirect($this->breadcrumbs_url)->with('message', "Something Error!");
        }
        /* get DeliverRegions */
        $express_area_list = $express->getDeliverRegions($id);
        /* get configs for plugin inputs*/
        $express = $res;
        $attributes = $express->config;
        $attributes = json_decode($attributes);
        $this->setBreadcrumb($express->name);
        return view('manager.edit_express')
            ->with('express', $express)
            ->with("express_area_list", $express_area_list)
            ->with('attributes', $attributes)
            ->with('breadcrumb', $this->breadcrumb);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExpressAreaUpdateForExpressController $request
     * @param  int $id
     * @return Response
     */
    public function update(ExpressAreaUpdateForExpressController $request, $id)
    {
        $express = new Express();
        $res = $express->existExpress($this->manager_id, $id);
        if (!$res) {
            return $express->ajaxResponse(-1, 'Nothing Todo!');
        }
        $express_area = new ExpressArea();
        $res = $express_area->updateConfig($request, $res);
        return $res;

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

    public function install($code)
    {
        $express = new Express();
        $res = $express->hasExpress($this->manager_id, $code);
        if ($res) {
            return redirect($this->breadcrumbs_url)->with('message', 'Already Have It!');
        }
        $collection = $this->getSystemExpress();
        foreach ($collection as $v) {
            if ($v->code == $code) {
                /* insert to table */
                $express->name = $v->name;
                $express->desc = $v->desc;
                $express->code = $v->code;
                $express->config = json_encode($v->config);
                $express->manager_id = $this->manager_id;
                $express->enable = true;
                $express->save();
                return redirect($this->breadcrumbs_url)->with('message', 'Insert Success!');
                break;
            }
        }
        return redirect($this->breadcrumbs_url)->with('message', 'Nothing Todo!');


    }

    /**
     * uninstall express to table
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uninstall($code)
    {
        $express = new Express();
        $res = $express->hasExpress($this->manager_id, $code);
        if ($res) {
            $res->delete();
            return redirect($this->breadcrumbs_url)->with('message', 'UnInsert Success!');
        }
        return redirect($this->breadcrumbs_url)->with('message', 'Nothing Todo!');

    }

    /**
     *  need search plugin of express from local system
     * @return Collection
     */
    public function getSystemExpress()
    {
        /*  Collect Expresses from System */
        $path = '../app/Lib/Express/';
        $it = new \FilesystemIterator($path);
        $namespace = "\\App\\Lib\\Express\\";
        $contracts = $namespace . "Contracts";
        $collection = new Collection();
        foreach ($it as $finfo) {
            $file_name = $finfo->getBasename();
            try {
                if (strpos($file_name, 'Express')) {
                    $class = trim($file_name, '.php');
                    $class = $namespace . $class;
                    if (class_exists($class)) {
                        $obj = new $class();
                        if ($obj instanceof $contracts) {
                            $collection->push($obj);
                        }
                    }
                }
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
        return $collection;

    }
}
