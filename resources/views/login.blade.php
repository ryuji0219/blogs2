@extends('layout')
@section('title', 'ログイン画面')
@section('content')
<body>
  <form class="form-signin" method="POST" action="{{route('login')}}">
  @csrf
    <h1 class="h3 mb-3 font-weight-normal">ログイン画面</h1>

      @if (session('session_error'))
        <div class="text-primary">
          {{ session('session_error') }}
        </div>
       @endif

      <div class="cp_iptxt">
	      <label class="ef">
	        <input type="text" id="inputName" name="name" placeholder="ユーザ名" autofocus>
	      </label>
      </div>
      @if ($errors->has('name'))
        <div class="text-danger">
          {{ $errors->first('name') }}
        </div>
       @endif

      <div class="cp_iptxt">
	      <label class="ef">
           <input type="password" id="inputPassword" name="password" placeholder="パスワード">
 	      </label>
      </div>        
       @if ($errors->has('password'))
        <div class="text-danger">
          {{ $errors->first('password') }}
        </div>
       @endif
       @if (session('login_error'))
        <div class="text-danger">
          {{ session('login_error') }}
        </div>
       @endif
       @if (session('ok_msg'))
                <p class="text-primary">
                    {{ session('ok_msg') }}
                </p>
       @endif     
       <br>
      
       <button class="btn btn-lg btn-primary button_place" type="submit">ログイン</button>
 </form>
</body>
@endsection