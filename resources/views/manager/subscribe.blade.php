@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url()}}/assets/js/dropzone/css/dropzone.css">
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
                            文本模式
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
                    <div class="tab-content">


                        {{-- 文本模式 --}}

                        <div class="tab-pane active" id="text">

                            <div class="form-group">
                                <textarea class="form-control wysihtml5" data-stylesheet-url="{{url()}}/assets/js/wysihtml5/lib/css/wysiwyg-color.css" name="contents" ></textarea>
                            </div>


                        </div>


                        {{-- 图文模式 --}}

                        <div class="tab-pane" id="text-image">
                            <p>asdasdasdadssad</p>
                            <div class="form-group">
                                <textarea class="form-control wysihtml5" data-stylesheet-url="{{url()}}/assets/js/wysihtml5/lib/css/wysiwyg-color.css" name="contents" ></textarea>
                            </div>


                        </div>


                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button type="submit" class="btn btn-gray btn-single">更新</button>
                                <button type="reset" class="btn btn-info btn-single pull-right">重置</button>
                            </div>
                        </div>


                    </div>
                </div>

            </div>



        </div>
    </div>






@stop



@section('js')
    <script src="{{url()}}/assets/js/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="{{url()}}/assets/js/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.js"></script>
    <script src="{{url()}}/assets/js/dropzone/dropzone.min.js"></script>


@stop