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
                <table class="table table-border table-striped">
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



@section('js')
    <script src="{{url()}}/assets/js/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{url()}}/assets/js/datatables/dataTables.bootstrap.js"></script>
    <script src="{{url()}}/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
    <script src="{{url()}}/assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>
    <script src="{{url()}}/assets/js/underscore-min.js"></script>
    <script src="{{url()}}/assets/js/backbone-min.js"></script>


@stop