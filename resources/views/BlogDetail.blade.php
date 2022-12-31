@extends('layout')
@section('title', 'ブログ詳細')
@section('content')
<body>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @if (isset($user['id']))
            <p2>ユーザ名：{{ $user["name"] }}</p2>
            {{-- <p3>ログイン時間：{{ $user["login_at"] }}</p3> --}}
        @else
            <p2>ゲストさん</p2>
        @endif
    <form method="POST" action="{{ route('BlogUpdateDelelte') }}" onSubmit="return checkSubmit_up()">
        @csrf
            <h1>ブログ詳細表示</h1>
        <p>　作成者：{{ $blog->name }}</p>
        <p>更新日時：{{substr($blog->updated_at,0,19) }}</p>
        <p>
            <label>
                タイトル<br>
                @if(isset($user['id']) && $blog->user_id == $user->id)
                    <input type="hidden" name="id" value="{{ $blog->id }}">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input id="title" name="title" class="form-control" value="{{ $blog->title }}" type="text">
                @else
                    <textarea cols="90" rows="1" readonly>{{ $blog->title }}</textarea>
                @endif
            </label>
        </p>
        <p>
            <label>
                本文<br>
                @if(isset($user['id']) && $blog->user_id == $user->id)
                    <textarea id="content" name="content" class="form-control"
                        cols="90" rows="6" >{{ $blog->content }}</textarea>
                @else
                    <textarea cols="90" rows="6" readonly>{{ $blog->content }}</textarea>
                @endif
            </label>
        </p>
        @if(isset($user['id']) && $blog->user_id == $user->id)
            <button type="submit" class="btn btn-primary" name="update">更新</button>
            <button type="submit" class="btn btn-danger" name="delete">削除</button>
        @endif
        <input type="button" class="btn btn-secondary" onclick="history.back()" value="戻る">
    </form>
    </div>
</div>
</body>
</html>
<script>
function checkSubmit_up(){
        if(window.confirm('処理を続行してよろしいですか？')){
            return true;
        } else {
            return false;
        }
}
</script>
@endsection