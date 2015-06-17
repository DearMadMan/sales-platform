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
                    <div class="panel-title">关键词:&nbsp;&nbsp;<span class="green "> {{$keyword->key}}</span></div>
                </div>
                <div class="panel-body">


                    <div class="row">
                        <div class="col-sm-2 text-right">
                            <p>当前状态：</p>
                        </div>
                        <div class="col-sm-10">
                            <p>
                                @if($keyword->status)
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
                                @if($keyword->type)
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

                            <form class="horizontal" action="" method="post">
                                <input name="_method" value="put" type="hidden"/>
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                <input name="type" value="0" type="hidden"/>
                                <div class="form-group">
                                    <textarea class="form-control wysihtml5"
                                              data-stylesheet-url="{{url()}}/assets/js/wysihtml5/lib/css/wysiwyg-color.css"
                                              name="contents">{{$keyword->contents}}</textarea>
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
                                <input name="type" value="1" type="hidden"/>
                                <input name="_method" value="put" type="hidden"/>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="search" placeholder="Search..." name="s"/>
                                        <button type="button" id="search_btn"  class="btn-unstyled search-btn">
                                            <i class="linecons-search"></i>
                                        </button>
                                    </div>





                                </div>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                搜索到的文章：
                                            </div>
                                            <div class="panel-body">
                                                <select multiple class="search-select" name="selected" id="selected">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                       <div class="col-sm-6 col-sm-offset-3 search-c-btn">
                                           <p> <btton class="btn btn-info" id="add_btn"> Add </btton> </p>
                                           <p> <btton class="btn btn-danger" id="remove_btn" > Remove </btton> </p>
                                           <p> <btton class="btn btn-info" id="add_all_btn"> Add All </btton> </p>
                                           <p> <btton class="btn btn-danger" id="remove_all_btn"> Remove All </btton> </p>
                                       </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                已选文章:
                                            </div>
                                            <div class="panel-body">
                                                <select multiple class="search-select" name="picked" id="picked">
                                                    @if($articles)
                                                    @foreach($articles as $v)
                                                        <option value="{{$v->id}}">{{$v->title}}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>
                                            <input name="ids" id="ids" value="" type="hidden"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button type="submit" id="update" class="btn btn-gray btn-single">更新</button>
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
    <script src="{{url()}}/assets/js/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="{{url()}}/assets/js/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.js"></script>
    <script src="{{url()}}/assets/js/dropzone/dropzone.min.js"></script>
    <script src="{{url()}}/js/select_keyword.js"></script>


@stop