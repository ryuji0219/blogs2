@extends('layout')
@section('title', '会員登録画面')
@section('content')
<body>
    <div class="container">
    <form method="POST" action="{{ route('UserStore') }}" onSubmit="return checkSubmit()">
        @csrf
        <h1 class="h3 mb-3 font-weight-normal">会員登録フォーム</h1>
        @if ($errors->any())
        <div class="alert text-danger">
            <ul>
                @foreach ($errors->all() as $error)
                  {{ $error }} . <br>
                @endforeach 
            </ul>
        </div>
        @endif

        <div class="cp_iptxt">
	      <label class="ef">
	        <input type="text" name="name" placeholder="ユーザ名"  autofocus value={{old('name')}}>
	      </label>
        </div>
        {{-- バリデーション --}}
        @if ($errors->has('name'))
        <div class="text-danger">
            {{ $errors->first('name') }}
        </div>
        @endif
        {{-- コントローラでのチェック --}}
        @if (session('err_name'))
        <div class="text-danger">
            {{ session('err_name') }}
            </div>
        @endif


        <div class="cp_iptxt">
	      <label class="ef">
           <input type="email" name="email" placeholder="email" value={{old('email')}} >
 	      </label>
        </div>  
        @if (session('err_email'))
            <div class="text-danger">
            {{ session('err_email') }}
            </div>
        @endif
       @if ($errors->has('email'))
            <div class="text-danger">
                {{ $errors->first('email') }}
            </div>
        @endif
        
        <div class="cp_iptxt">
	      <label class="ef">
           <input type="password" name="password" placeholder="パスワード" value={{old('password')}}>
 	      </label>
        </div>          

        @if (session('err_password'))
            <div class="text-danger">
            {{ session('err_password') }}
            </div>
        @endif
        @if ($errors->has('password'))
            <div class="text-danger">
                {{ $errors->first('password') }}
            </div>
        @endif
        
        <div class="cp_iptxt">
	      <label class="ef">
           <input type="password" name="pass2" placeholder="パスワード確認用">
 	      </label>
        </div>  
        @if (session('err_pas2'))
            <div class="text-danger">
            {{ session('err_pas2') }}
            </div>
        @endif
        @if ($errors->has('pass2'))
            <div class="text-danger">
                {{ $errors->first('pass2') }}
            </div>
        @endif
        
        <p>
            <button type="submit" class="btn btn-primary c-button button_place" >新規登録</button>　
        </p>
    </form>
    </div>
</body>
@endsection