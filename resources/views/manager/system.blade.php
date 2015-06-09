@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url()}}/assets/js/dropzone/css/dropzone.css">


@stop

@section('content')
    @parent

    @include('manager.breadcrumb')


    {{-- 表单 --}}

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default panel-tabs">
                <div class="panel-heading">
                    <div class="panel-title">配置信息：</div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li >
                                <a href="#manager" data-toggle="tab">个人信息</a>
                            </li>
                            <li >
                                <a href="#system" data-toggle="tab">系统相关</a>
                            </li>
                            <li class="active">
                                <a href="#wechat-config" data-toggle="tab">微信设置</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">



                    <form action="" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="manager_id" value="{{ Auth::user()->manager_id }}">

                        @if(session('tips'))
                        <div class="form-group">
                            <p class=" bg-success">{{session('tips')}}</p>
                        </div>
                        @endif
                        @if($errors->all())
                            <div class="form-group">
                            @foreach($errors->all() as $k => $v)
                                <div class="alert alert-warning">
                                    <button class="close" type="button" data-dismiss="alert">
                                        <span aria-hidden="true">x</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <strong>Whoops! </strong> {{$v}}
                                </div>

                                @endforeach
                            </div>
                            @endif


                    <div class="tab-content">
                        {{-- 个人信息 --}}
                        <div class="tab-pane" id="manager">

                            {{-- 姓名 --}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="name">姓名：</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="{{$user->manager->name}}" id="name" name="name"/>
                                </div>
                            </div>

                            {{-- 微信号 --}}

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="wechat">微信号：</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="wechat" value="{{$user->manager->wechat}}" name="wechat"/>
                                </div>
                            </div>

                            {{--  手机号 --}}

                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="phone">手机号：</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="{{$user->manager->phone}}" id="phone" name="phone"/>
                                </div>

                            </div>

                            {{-- 邮箱 --}}

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="email">邮箱：</label>
                                <div class="col-sm-10">
                                    <input class="form-control" value="{{$user->manager->email}}" type="text" id="email" name="email"/>
                                </div>
                            </div>


                            {{-- QQ --}}

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="qq">QQ：</label>
                                <div class="col-sm-10">
                                    <input class="form-control" value="{{$user->manager->qq}}" type="text" id="qq" name="qq"/>
                                </div>
                            </div>

                        </div>
                        {{-- 微信相关 --}}
                        <div class="tab-pane  active" id="wechat-config">

                            {{-- Token --}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="token">Token:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="token" name="token" type="text" value="{{$config->token}}"/>
                                </div>
                            </div>

                            {{-- Appid --}}

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="appid">Appid:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="appid" name="app_id" type="text" value="{{$config->app_id}}"/>
                                </div>
                            </div>

                            {{-- AppSecret --}}
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="app_secret">AppSecret:</label>
                                <div class="col-sm-10">
                                    <input value="{{$config->app_secret}}" class="form-control" id="app_secret" name="app_secret" type="text" value=""/>
                                </div>
                            </div>


                        </div>

                        {{-- 系统相关 --}}
                        <div class="tab-pane" id="system">

                        </div>
                    </div>

                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button type="submit" class="btn btn-gray btn-single">更新</button>
                                <button type="reset" class="btn btn-info btn-single pull-right">重置</button>
                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>




@stop


@section('js')

@stop