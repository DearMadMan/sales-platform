@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url('')}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url('')}}/assets/js/dropzone/css/dropzone.css">


@stop

@section('content')
    @parent
    @include('manager.breadcrumb')
    {{-- breadcrumb --}}


    {{-- 表单 --}}
    <form class="form-horizontal" 
    @if($method=='post')
    action="{{url('manager/oauth-list')}}" 
    @else
    action="{{url('manager/oauth-list').'/'.$url->id}}"
    @endif
    method="post" enctype="multipart/form-data">
    {!! method_field($method) !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Url信息</div>

                    </div>
                    <div class="panel-body">
                        @if(count($errors)>0)

                            <div class="alert alert-danger">
                                <strong>提示!</strong> 这里有一些输入错误.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- 商品基本信息 --}}

                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="title">标题：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" value="{{$url->name}}" id="title"
                                       placeholder=""/>
                            </div>

                        </div>


                        <div class="form-group-separator"></div>

                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="redirect_url">目标地址：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="redirect_url" id="redirect_url"
                                       placeholder="" value="{{$url->redirect_url or 'http://'}}" />
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" id="update" class="btn btn-gray btn-single">更新</button>
                                <button type="reset" class="btn btn-info btn-single pull-right">重置</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


    </form>



@stop
