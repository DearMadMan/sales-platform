@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url()}}/assets/js/dropzone/css/dropzone.css">
@stop


@section('content')
    @parent
    @include('manager.breadcrumb')


    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                @if(session("tips"))
                    <div class="alert alert-success">
                        {{session("tips")}}
                    </div>
                @endif
                <div class="panel-heading">
                    <div class="panel-title">关键词列表</div>
                    <div class="pull-right"><a class="btn btn-info" href="{{url("manager/keyword/create")}}">新增</a></div>
                </div>
                <div class="panel-body">

                    <table class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th class="no-sorting">
                                <input type="checkbox" class="cbr">
                            </th>
                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">关键词</th>
                            <th class="no-sorting">回复类型</th>
                            <th class="no-sorting">启用状态</th>
                            <th class="no-sorting">编辑</th>

                        </tr>
                        </thead>
                        <tbody class="middle-align">
                        @foreach($keywords as $v)
                        <tr>
                            <td>
                                <input type="checkbox" class="cbr">
                            </td>
                            <td>{{$v->id}}</td>
                            <td>{{$v->key}}</td>
                            <td>
                                @if($v->type)
                                    图文
                                    @else
                                    文本
                                @endif
                            </td>
                            <td>
                                <input type="checkbox"
                                       @if($v->status)
                                           checked
                                           @endif
                                       class="iswitch iswitch-turquoise">
                            </td>
                            <td>
                                <a href="{{url("manager/keyword")}}/{{$v->id}}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                    Edit
                                </a>

                                <a href="#" class="btn btn-danger btn-sm btn-icon icon-left">
                                    Delete
                                </a>

                                <a href="#" class="btn btn-info btn-sm btn-icon icon-left">
                                    Profile
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <ul class="pagination text-center">
                        <li><a href="#"><i class="fa-angle-left"></i></a></li>
                        <li><a href="#">1</a></li>
                        <li class="active"><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li class="disabled"><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#"><i class="fa-angle-right"></i></a></li>
                    </ul>


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