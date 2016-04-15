@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url('')}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url('')}}/assets/js/dropzone/css/dropzone.css">
@stop


@section('content')
    @parent
    @include('manager.breadcrumb')


    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">关注回复</div>
                </div>
                <div class="panel-body">




                    <div class="row">
                        <div class="col-sm-2 text-right">
                            <p>当前状态：</p>
                        </div>
                        <div class="col-sm-10">
                            <p>
                                @if($config->subscribe)
                                    <span class="red fz-16"><i class="fa fa-lightbulb-o"></i></span>
                                @else
                                    <span class="fz-16"><i class="fa fa-lightbulb-o"></i></span>
                                @endif

                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 text-right">
                            <p>启用方式：</p>
                        </div>
                        <div class="col-sm-10">
                            <p>
                                @if($text_model->enabled)
                                    文本模式
                                    @elseif($text_image_model->enabled)
                                    图文模式
                                @else
                                    文本模式
                                @endif
                            </p>
                        </div>
                    </div>


                </div>
            </div>


            <div class="panel panel-default panel-tabs">
                <div class="panel-heading">
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li><a href="#text" data-toggle="tab">文本模式</a></li>
                            <li><a href="#text-image" data-toggle="tab">图文模式</a></li>
                        </ul>
                    </div>
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


                    @if(session('tips'))
                            <div class="alert alert-success">
                               <span>{{session('tips')}}</span>
                            </div>
                        @endif

                    <div class="tab-content">


                        {{-- 文本模式 --}}

                        <div class="tab-pane active" id="text">

                            <form class="horizontal" action="" method="post" >
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

                                <div class="form-group">
                                    <input name="type" value="text" type="hidden"/>
                                    <input name="event" value="subscribe" type="hidden"/>
                                    <textarea class="form-control wysihtml5"
                                              data-stylesheet-url="{{url('')}}/assets/js/wysihtml5/lib/css/wysiwyg-color.css"
                                              name="contents">{{$text_model->contents}}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="submit" class="btn btn-gray btn-single">更新</button>
                                        <button type="reset" class="btn btn-info btn-single pull-right">重置</button>
                                    </div>
                                </div>
                            </form>

                        </div>


                        {{-- 图文模式 --}}


                        <div class="tab-pane" id="text-image">

                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                <!-- Title -->

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="title">标题：</label>

                                    <div class="col-md-10">
                                        <input id="title" type="text" class="form-control" name="title" value="{{$text_image_model->title}}"
                                               placeholder="Title"/>
                                        <input name="type" value="text-image" type="hidden"/>
                                        <input name="event" value="subscribe" type="hidden"/>
                                    </div>
                                </div>

                                <div class="form-group-separator"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="image_url">主图：</label>

                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" name="image_url" id="image_url"/>
                                    </div>
                                </div>
                                <div class="form-group-separator"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="url">导向链接：</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="url" value="{{$text_image_model->url}}" id="url"/>
                                    </div>
                                </div>

                                <div class="form-group-separator"></div>

                                <div class="form-group">
                                    <textarea class="form-control wysihtml5"
                                              data-stylesheet-url="{{url('')}}/assets/js/wysihtml5/lib/css/wysiwyg-color.css"
                                              name="contents">{{$text_image_model->contents}}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="submit" class="btn btn-gray btn-single">更新</button>
                                        <button type="reset" class="btn btn-info btn-single pull-right">重置</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <hr/>


                    </div>
                </div>

            </div>


        </div>
    </div>






@stop



@section('js')
    <script src="{{url('')}}/assets/js/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="{{url('')}}/assets/js/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="{{url('')}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.js"></script>
    <script src="{{url('')}}/assets/js/dropzone/dropzone.min.js"></script>


@stop