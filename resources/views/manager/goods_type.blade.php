@extends('manager')



@section('content')
    @parent
    @include('manager.breadcrumb')

    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">分类列表</div>
                    <div class="pull-right">
                        <a class="btn btn-info" href="{{url('manager/good-type/create')}}">新增</a>
                    </div>
                </div>
                <div class="panel-body">
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    @endif
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="no-sorting">
                                <input type="checkbox" class="cbr">
                            </th>
                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">分类名称</th>
                            <th class="no-sorting">父级名称</th>
                            <th class="no-sorting">编辑</th>

                        </tr>
                        </thead>
                        <tbody class="middle-align">
                        @foreach($types as $v)
                            <tr>
                                <td>
                                    <input type="checkbox" class="cbr">
                                </td>
                                <td>{{$v->id}}</td>
                                <td>{{str_limit($v->type_name,30)}}</td>
                                <td>{{str_limit($v->GetParentTypeName(),30)}}</td>
                                <td>
                                    <a href="{{url('manager/good-type').'/'.$v->id.'/edit'}}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                        Edit
                                    </a>

                                    <a href="javascript: void(0);" data="{{$v->id}}" class="btn btn-danger btn-sm btn-icon icon-left">
                                        Delete
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <ul class="pagination text-center">
                       {!!$types->render()!!}
                    </ul>


                </div>
            </div>

        </div>
    </div>
<script>
    var post_url="{{url('manager/good-type')}}"+"/";
</script>
@stop

@section('js')
    @parent
    <script src="{{url('')}}/js/tool.js"></script>
@endsection