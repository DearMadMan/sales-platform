@extends('manager')


@section('head')
    <link rel="stylesheet" href="{{url('/')}}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{url('/')}}/css/tool.css"/>
    <link rel="stylesheet" href="{{url('/')}}/css/formValidation.min.css"/>
<link rel="stylesheet" href="{{url('/')}}/css/login.css"/>
    @stop

@section('header')

    @stop
@section('silde_menu')

    @stop

    @section('content')
            <div id="login" class="container-fluid mg-t-10">

                @if(session('message'))
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <p class="bg-danger message">{{session('message')}}</p>
                        </div>

                    </div>
                    @endif
               <div class="row">
                   <div class="col-md-8 col-md-offset-2">
                       <div class="panel panel-default">
                           <div class="panel-heading">登录</div>
                           <div class="panel-body">
                               @if (count($errors) > 0)
                                   <div class="alert alert-danger">
                                       <strong>哇哦!</strong> 这里好像出现了一些错误:<br><br>
                                       <ul>
                                           @foreach ($errors->all() as $error)
                                               <li>{{ $error }}</li>
                                           @endforeach
                                       </ul>
                                   </div>
                               @endif

                                   <form  data-fv-message="This value is not valid"
                                          data-fv-icon-valid="glyphicon glyphicon-ok"
                                          data-fv-icon-invalid="glyphicon glyphicon-remove"
                                          data-fv-icon-validating="glyphicon glyphicon-refresh" id="login_form" action="{{url('manager/login')}}" method="post" class="form-horizontal">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                      <!-- 邮箱 -->
                                       <div class="form-group">
                                                                                 <label class="col-md-4 control-label" for="email">邮箱：</label>
                                                                                 <div class="col-md-6">
                                                                                     <input required data-fv-emailaddress-message="请输入正确邮箱地址" type="email"  class="form-control" name="email" value="" placeholder="邮箱" /> <p class="help-block"></p>
                                                                                 </div>
                                                                             </div>

                                   <!-- 密码 -->
                                      <div class="form-group">
                                                                              <label class="col-md-4 control-label" for="password">密码：</label>
                                                                              <div class="col-md-6">
                                                                                  <input required  type="password" class="form-control" name="password" value=""  />
                                                                              </div>
                                                                          </div>
                                       <div class="form-group">
                                           <div class="col-md-6 col-md-offset-4">
                                               <a href="javascript:;" id="captcha_a"> <img src="{{url('tool/captcha')}}" alt="验证码"/></a>
                                           </div>
                                       </div>

                                       
                                       <!-- 验证码 -->   
                                          <div class="form-group">
                                                                                  <label class="col-md-4 control-label" for="captcha">验证码：</label>
                                                                                  <div class="col-md-6">
                                                                                      <input  pattern="\S{6}" maxlength="6" data-fv-regexp-message="请输入6位非空验证码"  id="captcha" type="text" class="form-control" name="captcha" value="" placeholder="验证码" />
                                                                                  </div>
                                                                              </div>
                                       
                                       
                                       

                                    <!-- 记住我 -->
                                                                           <div class="form-group">
                                    
                                                                               <div class="col-md-6 col-md-offset-4">
                                                                                   <div class="checkbox">
                                                                                       <label>
                                                                                           <input type="checkbox" name="remember"/>记住我
                                                                                       </label>
                                                                                   </div>
                                                                               </div>
                                    
                                                                           </div>





                                       <div class="form-group">

                                           <div class="col-md-6 col-md-offset-4">
                                               <button type="submit" class="btn btn-primary">登录</button>
                                               {{--<a href="{{url('password/email')}}" class="btn btn-link"> 忘记密码 ?</a>--}}
                                               
                                           </div>


                                       </div>








                                   </form>


                           </div>
                       </div>
                   </div>
               </div>
            </div>
        @stop




@section('js')
    <script src="{{url('/')}}/js/formValidation.min.js"></script>
    <script src="{{url('/')}}/js/formvalidation_bootstrap.min.js"></script>
    <script src="{{url('/')}}/js/login.js"></script>
@stop

@section('footer')
    @stop