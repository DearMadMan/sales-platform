@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url()}}/assets/js/dropzone/css/dropzone.css">


@stop

@section('content')
    @parent

    {{-- breadcrumb --}}
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">添加商品</h1>

            <p class="description">添加商品以便于向用户展示</p>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <a href="{{url('manager')}}"><i class="fa-home"></i>控制面板</a>
                </li>
                <li>

                    <a href="{{url('manager/goods-list')}}">商品管理</a>
                </li>
                <li class="active">

                    <strong>添加商品</strong>
                </li>
            </ol>

        </div>

    </div>


    {{-- 表单 --}}

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
                    <form id="form"  class="form-horizontal" @if($method=='post') action="{{url('manager/good')}}" @else action="{{url('manager/good').'/'.$good->id}}" @endif method="post">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input name="_method" value="{{$method}}" type="hidden"/>

                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="goods_name">商品标题：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="goods_name" value="{{$good->goods_name}}" id="goods_name"
                                       placeholder=" example: Guerisson奇迹马油霜企划套组"/>
                            </div>

                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="goods_sn">商品编号：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="{{$good->goods_sn}}" name="goods_sn" id="goods_sn"
                                       placeholder=" example: ST000001"/>
                            </div>

                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="type_id">商品分类：</label>

                            <div class="col-sm-10">
                                <select class="form-control " name="type_id" id="type_id">
                                   @foreach($types as $v)
                                        <option @if($good->type_id==$v->id) selected @endif value="{{$v->id}}">{{$v->type_name}}</option>
                                       @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="shop_price">本店价格：</label>

                            <div class="input-group input-group-sm input-group-minimal col-sm-10 pd-15">
										<span class="input-group-addon">
											<i class="linecons-money"></i>
										</span>
                                <input type="text" id="shop_price" name="shop_price" class="form-control" value="{{$good->shop_price}}"
                                       data-mask="fdecimal" placeholder=" example: 9.9" data-rad="." data-digits="2"
                                       maxlength="10">
                            </div>

                        </div>


                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="market_price">市场价格：</label>

                            <div class="input-group input-group-sm input-group-minimal col-sm-10 pd-15">
										<span class="input-group-addon">
											<i class="linecons-money"></i>
										</span>
                                <input type="text" id="market_price" name="market_price" class="form-control" value="{{$good->market_price}}"
                                       data-mask="fdecimal" placeholder=" example: 9.9" data-rad="." data-digits="2"
                                       maxlength="10">
                            </div>

                        </div>

                        <div class="form-group-separator"></div>
                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="goods_number">库存：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="goods_number" id="goods_number" value="{{$good->goods_number}}"
                                       placeholder=" example: 99999"/>
                            </div>

                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods_img">商品主图：</label>

                            <div class="col-sm-10">
                                <input class="form-control" type="file" name="goods_img" id="goods_img"/>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods_img">是否包邮：</label>

                            <div class="col-sm-10">
                                <input type="checkbox" name="shipping_free" @if($good->shipping_free) checked @endif class="iswitch iswitch-turquoise">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods_img">上架销售：</label>

                            <div class="col-sm-10">
                                <input type="checkbox" name="shipping_free" @if($good->is_on_sale) checked  @endif class="iswitch iswitch-pink  ">
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">商品相册</div>
                </div>
                <div class="panel-body">
                    <form action="{{url("manager/good-gallery")}}" class="dropzone dz-clickable">
                        <div class="dz-default dz-message"><span></span></div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">商品详情</div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <textarea form="form"  class="form-control wysihtml5"
                                  data-stylesheet-url="{{url()}}/assets/js/wysihtml5/lib/css/wysiwyg-color.css"
                                  name="goods_desc" id="goods_desc"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" id="update" class="btn btn-gray btn-single" form="form">更新</button>
                            <button type="reset" class="btn btn-info btn-single pull-right">重置</button>
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