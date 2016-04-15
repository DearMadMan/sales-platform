@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url('')}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url('')}}/assets/js/dropzone/css/dropzone.css">


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
                    <form class="form-horizontal"  @if($method!='post')
                          action="{{url('manager/article-type').'/'.$type->id}}"
                          @else
                          action="{{url('manager/article-type')}}"
                          @endif  method="post">
                        <input name="_method" value="{{$method}}" type="hidden"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="type_name">分类名称：</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="type_name" value="{{$type->type_name}}" id="type_name" placeholder=""/>
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