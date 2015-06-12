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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">菜单信息</div>
                </div>
                <div class="panel-body">

                    {{-- 菜单信息 --}}
                    <form class="form-horizontal"
                          @if($method=='post')
                          action="{{url('manager/wechat-menu')}}"
                          @else
                          action="{{url('manager/wechat-menu').'/'.$menu->id}}"
                          @endif
                                  @if($method!="get")
                          method="post">
                    @else
                            method="get">
                                      @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="manager_id" value="{{ Auth::user()->manager_id  }}">
                        <input type="hidden" name="_method" value="{{$method}}"/>


                        @if(session('tips'))
                            <div class="form-group">
                                <p class=" bg-info">{{session('tips')}}</p>
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

                        {{-- 菜单类型 --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="menu_type">菜单类型：</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="menu_type" id="menu_type">
                                    <option value="click" @if($menu->menu_type=='click') checked @endif>Click</option>
                                    <option value="view"
                                            @if($menu->menu_type=='view')
                                            selected
                                            @endif
                                            >View
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- 菜单名称 --}}
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">菜单名称：</label>
                            <div class="col-sm-10">
                                <input class="form-control" value="{{$menu->name}}" type="text" id="name" name="name" placeholder="菜单栏显示的名称"/>
                            </div>
                        </div>

                        {{-- 菜单值 --}}

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="value">菜单值：</label>
                            <div class="col-sm-10">
                                <input class="form-control" value="{{$menu->value}}" type="text" id="value" name="value" placeholder="Click的值为关键字匹配值,View为跳转URL"/>
                            </div>
                        </div>

                        {{-- 索引排序 --}}

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="index">索引排序：</label>
                            <div class="col-sm-10">
                                <input class="form-control" value="{{$menu->index}}" type="text" id="index" name="index" placeholder="同级菜单根据索引值进行排序,值越大越靠前"/>
                            </div>
                        </div>

                        {{-- 菜单等级 --}}

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="parent_id">菜单等级：</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="0">一级菜单</option>
                                    @foreach($menu_list as $k => $v)
                                        <option value="{{$v['id']}}"
                                        @if($menu->parent_id == $v['id'])
                                                selected
                                        @endif
                                                >{{$v['name']}}
                                        </option>

                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button type="submit" class="btn btn-danger">提交</button>
                                <button type="reset" class="pull-right btn btn-info">重置</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>






@stop


@section('js')
    <script src="{{url()}}/assets/js/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="{{url()}}/assets/js/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.js"></script>
    <script src="{{url()}}/assets/js/dropzone/dropzone.min.js"></script>



@stop