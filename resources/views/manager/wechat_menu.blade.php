@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/datatables/dataTables.bootstrap.css">
@stop


@section('content')
    @parent
    @include('manager.breadcrumb')


    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">

                <div class="panel-heading">
                    <div class="panel-title">菜单列表</div>
                    <div class="pull-right">
                        <a href="{{url('manager/set-wechat-menu')}}" class="btn btn-sm btn-danger">更新菜单至微信</a>
                        <a href="{{url('manager/wechat-menu/create')}}" class="btn btn-sm btn-info">新增</a>
                    </div>
                </div>
                <div class="panel-body">
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
                    <div class="alert alert-info">
                        <span>菜单的组成单位，分为一级与二级，一个微信菜单包含最多3个一级菜单项。一个一级菜单项可以包含最多5个二级菜单项。</span>

                    </div>
                    <div class="alert alert-danger">
                        <strong>注意：</strong><span>目前自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。</span>
                    </div>
                    <table class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th class="no-sorting">
                                <input type="checkbox" id="checkbox_leader" class="cbr">
                            </th>
                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">类型</th>
                            <th class="no-sorting">所属</th>
                            <th class="no-sorting">名称</th>
                            <th class="no-sorting">值</th>
                            <th class="no-sorting">编辑</th>
                            </tr>
                        </thead>
                        <tbody class="middle-align">

                        @foreach($menu_list as $k => $v)
                        <tr>
                            <td>
                                <input type="checkbox" data="{{$v->id}}"  class="cbr">
                            </td>
                            <td>{{$v->id}}</td>
                            <td>{{$v->menu_type}}</td>
                            <td>@if($v->parent_id==0)
                                    一级菜单
                                    @else

                                    {{$v->parent->name}}
                                @endif</td>
                            <td>{{$v->name}}</td>
                            <td>

                                <div class="sub-span">{{$v->value}}</div>
                            </td>
                            <td>
                                <a href="{{url('manager/wechat-menu/').'/'.$v->id}}/edit" class="btn btn-secondary btn-sm btn-icon icon-left">
                                    编辑
                                </a>

                                <a href="javascript:;" data="{{$v->id}}" class="btn btn-danger btn-sm btn-icon icon-left">
                                    删除
                                </a>
                            </td>
                        </tr>
                        @endforeach









                        </tbody>
                    </table>



                    <div class="col-sm-12 ">
                        <button class="btn btn-info btn-sm" onclick="checked();">全选</button>
                        <button class="btn btn-info btn-sm" onclick="unCheck();">全不选</button>
                        <button class="btn btn-danger btn-sm" id="delete_all">删除</button>
                    </div>


                </div>
            </div>

        </div>
    </div>

<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
    <script>

        var post_url="{{url('manager/wechat-menu')}}"+"/";

    </script>




@stop



@section('js')
    <script src="{{url()}}/assets/js/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{url()}}/assets/js/datatables/dataTables.bootstrap.js"></script>
    <script src="{{url()}}/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
    <script src="{{url()}}/assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>
    <script src="{{url()}}/js/tool.js"></script>

@stop