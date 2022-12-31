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
        <h1>ブログ詳細表示</h1>
        <p>　作成者：{{ $blog->name }}</p>
        <p>更新日時：{{substr($blog->updated_at,0,19) }}</p>
        <p>
            <label>
                タイトル<br>
                <textarea
                cols="90"
                rows="1"
                readonly          
                >{{ $blog->title }}</textarea>
            </label>
        </p>
        <p>
            <label>
                本文<br>
                <textarea
                cols="90"
                rows="6"
                readonly           
                >{{ $blog->content }}</textarea>
            </label>
        </p>
        @if(isset($user['id']) && $blog->user_id == $user->id)
            <button type="button" class="btn btn-primary" onclick="location.href='{{route('showEdit')}}'">編集</button>
        @endif
        <input type="button" class="btn btn-secondary" onclick="history.back()" value="戻る">
    </div>
</div>
</body>
</html>
@endsection