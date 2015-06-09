@extends('manager')



@section('content')
    @parent
    @include('manager.breadcrumb')

    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">分类列表</div>
                </div>
                <div class="panel-body">

                    <table class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th class="no-sorting">
                                <input type="checkbox" class="cbr">
                            </th>
                            <th class="no-sorting">ID</th>
                            <th class="no-sorting">分类名称</th>
                            <th class="no-sorting">编辑</th>

                        </tr>
                        </thead>
                        <tbody class="middle-align">

                        <tr>
                            <td>
                                <input type="checkbox" class="cbr">
                            </td>
                            <td>1</td>
                            <td>Guerisson奇迹马油霜企划套组   Guerisson奇迹马油霜企划套组</td>
                            <td>
                                <a href="#" class="btn btn-secondary btn-sm btn-icon icon-left">
                                    Edit
                                </a>

                                <a href="#" class="btn btn-danger btn-sm btn-icon icon-left">
                                    Delete
                                </a>

                                <a href="#" class="btn btn-info btn-sm btn-icon icon-left">
                                    Profile
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <ul class="pagination text-center">
                        <li><a href="#"><i class="fa-angle-left"></i></a></li>
                        <li><a href="#">1</a></li>
                        <li class="active"><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li class="disabled"><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#"><i class="fa-angle-right"></i></a></li>
                    </ul>


                </div>
            </div>

        </div>
    </div>

    @stop