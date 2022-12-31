@extends('layout')
@section('title', 'ブログ編集')
@section('content')
<body>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>ブログ編集画面</h1>
        <p2>ユーザ名：{{ $user["name"] }}</p2>
        {{-- <p3>ログイン時間：{{ $user["login_at"] }}</p3> --}}

        <p>　作成者：{{$blog->name}}</p>
        <p>更新日時：{{substr($blog->updated_at,0,19) }}</p>
        <form method="POST" action="{{ route('BlogUpdateDelelte') }}" onSubmit="return checkSubmit_up()">
        @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="id" value="{{ $blog->id }}">
            <div class="form-group">
                <label for="title">
                    タイトル
                </label>
                <input id="title" name="title" class="form-control"
                    value="{{ $blog->title }}" type="text">
                @if ($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="content">
                    本文
                </label>
                <textarea id="content" name="content" class="form-control"
                    cols="90" rows="6" >{{ $blog->content }}</textarea>
                @if ($errors->has('content'))
                    <div class="text-danger">
                        {{ $errors->first('content') }}
                    </div>
                @endif
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-primary" name="update">更新</button>
                <button type="submit" class="btn btn-danger" name="delete">削除</button>
                <input type="button" class="btn btn-secondary" onclick="history.back()" value="戻る">
           </div>
        </form>
    </div>
</div>
<script>
function checkSubmit_up(){
    if(window.confirm('処理続行してよろしいですか？')){
        return true;
    } else {
        return false;
    }
}
</script>
@endsection