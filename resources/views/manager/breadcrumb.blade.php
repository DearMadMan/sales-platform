{{-- breadcrumb --}}
<div class="page-title">

    <div class="title-env">
        <h1 class="title">{{$breadcrumb->title}}</h1>
    </div>

    <div class="breadcrumb-env">

        <ol class="breadcrumb bc-1">
            <li>
                <a href="{{url('manager')}}"><i class="fa-home"></i>控制面板</a>
            </li>
           @foreach($breadcrumb->lists as $k => $v)
                @if($v['is_active'])
                    <li  class="active">

                     <strong>{{$v['title']}}</strong>
                    </li>
                    @else
                <li >

                    <a href="{{url($v['url'])}}">{{$v['title']}}</a>
                </li>
                @endif
               @endforeach
        </ol>

    </div>

</div>