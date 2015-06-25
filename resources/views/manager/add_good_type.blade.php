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
                    <div class="panel-title">新的分类</div>
                </div>
                <div class="panel-body">

                    {{-- 商品基本信息 --}}
                    <form class="form-horizontal" @if($method == 'post') action="{{url("manager/good-type")}}" @else action="{{url('manager/good-type').'/'.$type->id}}" @endif  method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input name="_method" value="{{$method}}" type="hidden"/>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="type_name">分类名称：</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="type_name" id="type_name" value="{{$type->type_name}}" placeholder=" example: 化妆品"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="parent_id">上级分类：</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="0">顶级分类</option>
                                    @foreach($types as $v)
                                        <option @if($type->parent_id == $v->id) selected @endif value="{{$v->id}}">{{$v->type_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" id="update" class="btn btn-gray btn-single">更新</button>
                                <button type="reset" class="btn btn-info btn-single pull-right">重置</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>





@stop


@section('js')




@stop