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
                    <div class="panel-title">文章分类</div>
                    <div class="pull-right">
                        <a class="btn btn-info" href="{{url('manager/article-type/create')}}">新增</a>
                    </div>

                </div>

                <div class="panel-body">
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    @endif
                    <table class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th class="no-sorting">
                                <input type="checkbox" class="cbr">
                            </th>
                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">分类名称</th>
                            <th class="no-sorting">编辑</th>

                        </tr>
                        </thead>
                        <tbody class="middle-align">
                        @if(!$types->isEmpty())
                            @foreach($types as $v)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="cbr">
                                    </td>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->type_name}}</td>
                                    <td>
                                        <a href="{{url("manager/article-type").'/'.$v->id.'/edit'}}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                            Edit
                                        </a>

                                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left">
                                            Delete
                                        </a>

                                        <a href="{{url('manager/article-type/').'/'.$v->id}}" class="btn btn-info btn-sm btn-icon icon-left">
                                            Profile
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <ul class="pagination text-center">
                        {!! $types->render() !!}
                    </ul>


                </div>
            </div>

        </div>
    </div>






@stop



@section('js')
@stop