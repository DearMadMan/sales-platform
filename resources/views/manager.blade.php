<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>{{$title or '用户中心'}}</title>
    @section('head')

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/fonts/linecons/css/linecons.css">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/fonts/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/bootstrap.css">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/xenon-core.css">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/xenon-forms.css">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/xenon-components.css">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/xenon-skins.css">
        <link rel="stylesheet" href="{{url('/')}}/assets/css/custom.css">

        <script src="{{url('/')}}/assets/js/jquery-1.11.1.min.js"></script>


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="{{url('/')}}/assets/js/html5shiv.min.js"></script>
        <script src="{{url('/')}}/assets/js/respond.min.js"></script>
        <![endif]-->

    @show
</head>
<body class="page-body skin-white">
{{-- 页头 --}}
@section('header')
    @include('manager.header')
    @show

{{-- 主体 --}}
<div class="page-container">

    {{-- 边栏菜单 --}}
    @section('silde_menu')
        @include('manager.slide_menu')
        @show

        {{-- 主内容 --}}
        <div class="main-content">

            @section('content')
            @include('manager.top_bar')
            @show

        </div>
</div>
@section('footer')
    @include('manager.footer')
    @show

<div class="page-loading-overlay" style="background: #868686;">
    <div class="loader-2"></div>
</div>

<!-- Bottom Scripts -->
<script src="{{url('/')}}/assets/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/assets/js/TweenMax.min.js"></script>
<script src="{{url('/')}}/assets/js/resizeable.js"></script>
<script src="{{url('/')}}/assets/js/joinable.js"></script>
<script src="{{url('/')}}/assets/js/xenon-api.js"></script>
<script src="{{url('/')}}/assets/js/xenon-toggles.js"></script>

@section('js')

    <!-- Imported scripts on this page -->
    <script src="{{url('/')}}/assets/js/xenon-widgets.js"></script>

@show
        <!-- JavaScripts initializations and stuff -->
    <script src="{{url('/')}}/assets/js/xenon-custom.js"></script>
</body>
</html>