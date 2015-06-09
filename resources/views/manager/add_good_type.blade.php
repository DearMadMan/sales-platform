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
                    <div class="panel-title">新的商品分类</div>
                </div>
                <div class="panel-body">

                    {{-- 商品基本信息 --}}
                    <form class="form-horizontal" action="" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="manager_id" value="{{ Auth::user()->manager_id  }}">

                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="goods_name">分类名称：</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="goods_name" id="goods_name" placeholder=" example: 化妆品"/>
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