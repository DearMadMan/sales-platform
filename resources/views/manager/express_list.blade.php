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
                    <div class="panel-title">插件列表</div>
                </div>
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                <div class="panel-body">
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped" >
                        <thead>
                        <tr>

                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">快递名称</th>
                            <th class="no-sorting">描述</th>
                            <th class="no-sorting">作者</th>
                            <th class="no-sorting">email</th>
                            <th class="no-sorting">编辑</th>

                        </tr>
                        </thead>
                        <tbody class="middle-align">
                        @foreach($collection as $k=>$v)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{str_limit($v->name,30)}}</td>
                                <td>{{str_limit($v->desc,30)}}</td>
                                <td>
                                    {{$v->auth}}
                                </td>
                                <td>{{$v->email}}</td>
                                <td>
                                @if(array_key_exists($v->code,$expresses))
                                        <a href="{{url('manager/express').'/'.$expresses[$v->code]['id'].'/edit'}}" class="btn btn-primary btn-sm btn-icon icon-left">
                                            Config
                                        </a>
                                        <a href="{{url('manager/express').'/'.$v->code.'/uninstall'}}" class="btn btn-danger btn-sm btn-icon icon-left">
                                            UnInsert
                                        </a>
                                    @else
                                    <a href="{{url('manager/express').'/'.$v->code.'/install'}}" class="btn btn-info btn-sm btn-icon icon-left">
                                        Insert
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>



                </div>
            </div>

        </div>
    </div>





@stop



@section('js')
    <script src="{{url()}}/assets/js/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{url()}}/assets/js/datatables/dataTables.bootstrap.js"></script>
    <script src="{{url()}}/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
    <script src="{{url()}}/assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>


@stop