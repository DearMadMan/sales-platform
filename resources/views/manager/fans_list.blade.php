@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url('')}}/assets/js/datatables/dataTables.bootstrap.css">
@stop


@section('content')
    @parent
    @include('manager.breadcrumb')


    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">粉丝列表</div>
                </div>
                <div class="panel-body">

                    <table class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th class="no-sorting">
                                <input type="checkbox" class="cbr">
                            </th>
                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">头像</th>
                            <th class="no-sorting">昵称</th>
                            <th class="no-sorting">性别</th>
                            <th class="no-sorting">关注状态</th>
                            <th class="no-sorting">关注时间</th>

                        </tr>
                        </thead>
                        <tbody class="middle-align">
                        @foreach($users as $v)
                        <tr>
                            <td>
                                <input type="checkbox" class="cbr">
                            </td>
                            <td>{{$v->id}}</td>
                            <td>
                               @if($v->image_url != '') 
                               <img class="header-img" src="{{$v->image_url}}" alt="">
                               @endif 
                            </td>
                            <td>{{$v->nick_name}}</td>
                            <td>
                                <input type="checkbox" @if($v->sex) checked="" @endif disabled class="iswitch iswitch-turquoise">
                            </td>
                            <td>
                            <input type="checkbox" @if($v->subscribe_status) checked="" @endif disabled class="iswitch iswitch-turquoise">
                            </td>
                            <td>{{$v->subscribe_time}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {!!$users->render()!!}


                </div>
            </div>

        </div>
    </div>






@stop



@section('js')
    <script src="{{url('')}}/assets/js/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{url('')}}/assets/js/datatables/dataTables.bootstrap.js"></script>
    <script src="{{url('')}}/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
    <script src="{{url('')}}/assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>


@stop