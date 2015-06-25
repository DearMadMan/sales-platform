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
                    <div class="panel-title">文章列表</div>
                    <div class="pull-right">
                        <a class="btn btn-info" href="{{url('manager/article/create')}}">新增</a>
                    </div>
                </div>

                <div class="panel-body">

                    <table class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th class="no-sorting">
                                <input type="checkbox" class="cbr">
                            </th>
                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">标题</th>
                            <th class="no-sorting">文章分类</th>
                            <th class="no-sorting">显示状态</th>
                            <th class="no-sorting">添加时间</th>
                            <th class="no-sorting">编辑</th>

                        </tr>
                        </thead>
                        <tbody class="middle-align">
                @if(!$articles->isEmpty())
                    @foreach($articles as $v)
                        <tr>
                            <td>
                                <input type="checkbox" class="cbr">
                            </td>
                            <td>{{$v->id}}</td>
                            <td>{{str_limit($v->title,30)}}</td>

                            <td>@if($v->type)
                                {{$v->type->type_name}}
                                    @endif
                            </td>
                            <td>
                                <input type="checkbox"
                                       @if($v->is_show)
                                           checked
                                           @endif
                                       class="iswitch iswitch-turquoise">
                            </td>
                            <td>{{$v->created_at}}</td>
                            <td>
                                <a href="{{url("manager/article").'/'.$v->id.'/edit'}}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                    Edit
                                </a>

                                <a href="#" class="btn btn-danger btn-sm btn-icon icon-left">
                                    Delete
                                </a>

                                <a href="{{url('manager/article/').'/'.$v->id}}" class="btn btn-info btn-sm btn-icon icon-left">
                                    Profile
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                        </tbody>
                    </table>

                    <ul class="pagination text-center">
                        {!! $articles->render() !!}
                    </ul>


                </div>
            </div>

        </div>
    </div>






@stop



@section('js')
@stop