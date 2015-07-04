@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/datatables/dataTables.bootstrap.css">
@stop


@section('content')
    @parent
    @include('manager.breadcrumb')

    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">配送区域</div>
                <div class="pull-right">
                    <a class="btn btn-info" href="">新增</a>
                </div>
            </div>


            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="no-sorting">ID</th>
                        <th class="no-sorting">名称</th>
                        <th class="no-sorting">配送地区</th>
                        <th class="no-sorting">编辑</th>
                    </tr>
                    </thead>
                    <tbody class="middle-align">

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    </tbody>

                </table>
            </div>


        </div>

    </div>





@stop


@section('footer')

    @parent

    {{--  modals-start --}}

    <div class="modal fade form form-horizontal" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">区域设置</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="field-3" class="col-md-3 control-label">配置名称：</label>

                                <div class="col-md-8">
                                    <input type="text" name="name" value="" class="form-control " id="field-3"
                                           placeholder="名称">
                                </div>
                            </div>

                        </div>
                    </div>
                    @if(isset($attributes->input))
                        @foreach($attributes->input as $v)
                            @if($v->type=='select')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">


                                            <label class="control-label col-md-3"
                                                   for="{{$v->name}}">{{$v->label}}</label>

                                            <div class="col-md-8">
                                                <select class="form-control" name="{{$v->name}}" id="{{$v->name}}">

                                                    @foreach($v->options as $k=>$p)

                                                        <option value="{{$k}}"
                                                                @if($k==$v->value)
                                                                    checked
                                                                    @endif
                                                                >{{$p}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($v->type=='text')
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label for="{{$v->name}}" class="col-md-3 control-label">{{$v->label}}</label>

                                            <div class="col-md-8">
                                                <input type="text" name="{{$v->name}}" value="{{$v->value}}" class="form-control "
                                                       id="{{$v->name}}"
                                                       placeholder="{{$v->name}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif





                        @endforeach
                    @endif


                </div>


                <div class="modal-header">
                    <button type="button" class="btn btn-success btn-sm pull-right">+</button>
                    <h4 class="modal-title">配送区域：</h4>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="province">省:</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="province" id="province">
                                        <option value="1">安徽省</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="city">市:</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="city" id="city">
                                        <option value="1">合肥市</option>
                                    </select>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="area">区:</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="province" id="area">
                                        <option value="1">瑶海区</option>
                                    </select>
                                </div>

                            </div>
                        </div>



                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modals-end --}}


    <script>
        $(function () {
            $("#modal").modal("show", {});
        });
    </script>

@stop


@section('js')
    <script src="{{url()}}/assets/js/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{url()}}/assets/js/datatables/dataTables.bootstrap.js"></script>
    <script src="{{url()}}/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
    <script src="{{url()}}/assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>
    <script src="{{url()}}/assets/js/underscore-min.js"></script>
    <script src="{{url()}}/assets/js/backbone-min.js"></script>
    <script src="{{url()}}/assets/js/city.js"></script>


@stop