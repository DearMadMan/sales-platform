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
                    <div class="panel-title">新建微信关键字</div>
                </div>
                <div class="panel-body">

                    {{-- 商品基本信息 --}}
                    <form class="form-horizontal" action="{{url("manager/keyword")}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="key">关键字：</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="key" id="key" placeholder=" example: 化妆品"/>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-1">
                                <button type="submit" class="btn btn-gray btn-single">新增</button>
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