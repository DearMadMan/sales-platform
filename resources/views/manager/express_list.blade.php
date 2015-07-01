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
                        @foreach($expresses as $v)
                            <tr>

                                <td>{{$i}}</td>
                                <td>{{str_limit($v->goods_name,30)}}</td>
                                <td>{{$v->goods_number}}</td>
                                <td>
                                    <input type="checkbox" @if($v->is_on_sale) checked @endif class="iswitch iswitch-turquoise">
                                </td>
                                <td>
                                    <a href="{{url('manager/good').'/'.$v->id.'/edit'}}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                        Edit
                                    </a>

                                    <a href="javascript:;"  data="{{$v->id}}" class="btn btn-danger btn-sm btn-icon icon-left">
                                        Delete
                                    </a>
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