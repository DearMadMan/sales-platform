@if(session('message'))
  <div class="alert alert-success">
      {{session('message')}}
  </div>
@endif
@if(session('success'))
  <div class="alert alert-success">
      {{session('success')}}
  </div>
@endif
@if(session('error'))
  <div class="alert alert-danger">
      {{session('message')}}
  </div>
@endif

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

