<?php

namespace App\Http\Controllers\Manager;

use App\Express;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $path = '../app/Lib/Express/';
        $it = new \FilesystemIterator($path);
        $namespace="\\App\\Lib\\Express\\";
        foreach ($it as $finfo) {
            $file_name = $finfo->getBasename();
            try {
                if (strpos($file_name, 'Express')) {
                    $class = trim($file_name, '.php');
                    $class=$namespace.$class;
                    $obj = new $class();
                    dd($obj);
                }
            } catch (\Exception $e) {
                dd($e->getMessage());
            }


        }
        $express = new Express();
        $expresses = $express->getExpresses($this->manager_id);
        return view('manager.express_list')
            ->with('expresses', $expresses)
            ->with('breadcrumb', $this->breadcrumb);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
