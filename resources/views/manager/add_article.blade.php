@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url()}}/assets/js/dropzone/css/dropzone.css">


@stop

@section('content')
    @parent
    @include('manager.breadcrumb')
    {{-- breadcrumb --}}


    {{-- 表单 --}}
    <form class="form-horizontal" action="{{url('manager/article')}}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">基本信息</div>

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
                                <input class="form-control" type="text" name="title" id="title"
                                       placeholder=""/>
                            </div>

                        </div>


                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="type_id">文章分类：</label>

                            <div class="col-sm-10">
                                <select class="form-control " name="type_id" id="type_id">
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->type_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group-separator"></div>

                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="goods_sn">是否显示：</label>

                            <div class="col-sm-10">
                                <input type="checkbox"
                                       checked
                                       class="iswitch iswitch-turquoise" name="is_show">
                            </div>

                        </div>
                        <div class="form-group-separator"></div>

                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="out_link">导向链接：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="out_link" id="out_link"
                                       placeholder="文章跳转链接或微信跳转链接，为空则导向本文链接"/>
                            </div>

                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="pic_url">文章主图：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="file" name="pic_url" id="pic_url"/>
                            </div>
                        </div>
                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">文章内容</div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <textarea class="form-control ckeditor" rows="10" name="content"
                                                  id="content"></textarea>
                                        {{--  <textarea class="form-control wysihtml5"
                                                    data-stylesheet-url="{{url()}}/assets/js/wysihtml5/lib/css/wysiwyg-color.css"
                                                    name="content" id="content"></textarea>--}}
                                    </div>

                                </div>
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


@section('js')
    <script src="{{url()}}/assets/js/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>

    <script src="{{url()}}/assets/js/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.js"></script>
    <script src="{{url()}}/assets/js/ckeditor/ckeditor.js"></script>
    <script src="{{url()}}/assets/js/dropzone/dropzone.min.js"></script>



@stop