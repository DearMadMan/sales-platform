@extends('manager')

@section('head')
    @parent
    <link rel="stylesheet" href="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.css">
    <link rel="stylesheet" href="{{url()}}/assets/js/dropzone/css/dropzone.css">


@stop

@section('content')
    @parent
    @include('manager.breadcrumb')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>{{$article->title}}</h1>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">

                </div>
                <div class="col-sm-10 col-sm-off-set-1 text-right">
                    Created_at:{{$article->created_at}}&nbsp;&nbsp;Updated_at: {{$article->updated_at}}
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                    {!!$article->content!!}
                </div>
            </div>
        </div>
    </div>



@stop


@section('js')


    <script src="{{url()}}/assets/js/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>

    <script src="{{url()}}/assets/js/inputmask/jquery.inputmask.bundle.js"></script>
    <script src="{{url()}}/assets/js/wysihtml5/src/bootstrap-wysihtml5.js"></script>
    <script src="{{url()}}/assets/js/ckeditor/ckeditor.js"></script>
    <script src="{{url()}}/assets/js/dropzone/dropzone.min.js"></script>

@stop