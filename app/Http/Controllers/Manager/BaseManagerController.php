<?php

namespace App\Http\Controllers\Manager;

use App\Breadcrumb;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseManagerController extends Controller
{
    protected $breadcrumbs_url = "";
    protected $breadcrumbs_main = []; // ['manager/good', '商品管理', 0]
    protected $breadcrumb = null;
    protected $user = null;
    protected $manager_id = null;

    /**
     * [ base construct  init breadcrumb and user]
     */
    public function __construct()
    {
        $this->middleware('manager');
        $this->breadcrumb = new Breadcrumb();
        $this->user = Auth::user();
        if (!$this->user) {
            return redirect('manager/login');
        }
        $this->manager_id = $this->user->manager_id;
    }


    /**
     * [ set Breadcrumb list]
     * @param $title
     * @param null $arr
     */
    public function setBreadcrumb($title, $arr = null)
    {
        $data = [];
        foreach ($this->breadcrumbs_main as $v) {
            if (count($v) != 3) {
                array_push($data, $this->breadcrumbs_main);
                break;
            }
            array_push($data, $v);
        }
        if (is_array($arr)) {
            foreach ($arr as $v) {
                array_push($data, $v);
            }
        }
        $this->breadcrumb->setBreadcrumbs($title, $data);

    }
}
