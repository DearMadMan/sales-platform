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
                <div class="panel-title">商品列表</div>
                <div class="pull-right">
                    <a class="btn btn-info" href="{{url('manager/good/create')}}">新增</a>
                </div>
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
                        <th class="no-sorting">
                            <input type="checkbox" id="checkbox_leader" class="cbr">
                        </th>
                        <th class="no-sorting">ID</th>
                        <th class="no-sorting">商品名称</th>
                        <th class="no-sorting">库存</th>
                        <th class="no-sorting">上架</th>
                        <th class="no-sorting">编辑</th>

                    </tr>
                    </thead>
                    <tbody class="middle-align">
                    @foreach($goods as $v)
                    <tr>
                        <td>
                            <input type="checkbox" data="{{$v->id}}"  class="cbr">
                        </td>
                        <td>{{$v->id}}</td>
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
                    <div class="tool-btn">
                        <button class="btn btn-info btn-sm" onclick="checked();">全选</button>
                        <button class="btn btn-info btn-sm" onclick="unCheck();">全不选</button>
                        <button class="btn btn-danger btn-sm" id="delete_all">删除</button>
                    </div>
                <ul class="pagination text-center">
                    {!! $goods->render() !!}
                </ul>


            </div>
        </div>

    </div>
</div>




<script>
    var post_url="{{url('manager/good')}}"+"/";
</script>

    @stop



@section('js')
    <script src="{{url()}}/assets/js/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{url()}}/assets/js/datatables/dataTables.bootstrap.js"></script>
    <script src="{{url()}}/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
    <script src="{{url()}}/assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>
    <script src="{{url()}}/js/tool.js"></script>


    @stop