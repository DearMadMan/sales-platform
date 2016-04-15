<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OauthUrl;

class OAuthUrlController extends BaseManagerController
{

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs_url = "manager/oauth-list";
        $this->breadcrumbs_main = ['manager/fans-list', '微信中心', 0];
    }

    public function index()
    {
      $this->setBreadcrumb('免登陆授权列表');
      $urls = new OauthUrl();
      $urls = $urls->orderBy('id','desc')->paginate(config('page.paginate'));
      return view('manager.oauth_list',['urls'=>$urls,'breadcrumb'=>$this->breadcrumb]);
    }

    public function store(Request $request) {
      $url = new OauthUrl();
      $url->name = $request->get('name');
      $url->redirect_url = $request->get('redirect_url');
      $url->save();
      return redirect($this->breadcrumbs_url)->withMessage('store url success');
    }

    public function create(Request $request) {
      $this->setBreadcrumb('新增URL');
      $url = new OauthUrl(); 
      return view('manager.oauth_add',['url'=>$url, 'breadcrumb' => $this->breadcrumb, 'method' => 'post']) ;
    }

    public function edit($id) {
      $this->setBreadcrumb('修改URL');
      $url = OauthUrl::find($id);
      if(!$url) {
        return redirect()->back()->withError('url not found!');
      }
      return view('manager.oauth_add',['url'=>$url, 'breadcrumb'=> $this->breadcrumb, 'method' => 'put']);
    }

    public function update(Request $request, $id) {
      $url = OauthUrl::find($id);
      if(!$url) {
        return redirect()->back()->withError('url not found!');
      }
      $url->name = $request->get('name');
      $url->redirect_url = $request->get('redirect_url');
      $url->save();
      return redirect($this->breadcrumbs_url)->withSuccess('update success!');
    }

    public function destroy(Request $request, $id) {
      $url = OauthUrl::destroy($id);
      if(!$url) {
        return 'false';
      }
      return 'true';

    }
}
