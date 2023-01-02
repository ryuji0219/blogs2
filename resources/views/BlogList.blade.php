@extends('layout')
@section('title', 'ブログ一覧')
@section('content')
<body>
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        {{ $error }} . <br>
                        @endforeach 
                    </ul>
                </div>
            @elseif (session('err_member'))
                {{-- 会員登録エラー --}}
                <div class="text-danger">
                  {{ session('err_member') }}
                </div>

            @elseif (session('logout_msg'))
                <p class="text-danger">
                    {{ session('logout_msg') }}
                </p>
            @elseif (session('ok_msg'))
                <div class="text-primary">
                    {{ session('ok_msg') }}
                </div>
            @elseif (session('session_error'))
                <div class="text-primary">
                    {{ session('session_error') }}
                </div>
            @endif 

            <div class='user'>
                @if (!empty($user["name"]))
                    <p2>ユーザ名：{{ $user["name"] }}</p2>
                    {{-- <p3>ログイン時間：{{ $user["login_at"] }}</p3> --}}
                @else
                    <p2>ゲストさん</p2>
                @endif
            </div>

            <h1>ブログ記事一覧</h1>

            {{-- 検索処理 --}}
            <form method="post" class="search_all" action="{{route('BlogSearch')}}">
            @csrf
                @if (isset($search['text']))
                {{-- 検索時の表示 --}}
                    <select name="search_option" class="search_select">
                        @if ($search['option'] == 'title')
                            <option value="name">作成者</option>
                            <option value="title" selected>タイトル</option>
                            <option value="content">本文</option>
                        @elseif ($search['option'] == 'content')
                            <option value="name">作成者</option>
                            <option value="title">タイトル</option>
                            <option value="content" selected>本文</option>
                        @else
                            <option value="name" selected>作成者</option>
                            <option value="title">タイトル</option>
                            <option value="content">本文</option>
                        @endif
                    </select>

                    <input type="text" name="search_text" placeholder="キーワードを入力" value="{{$search['text']}}" 
                        class="search_text"><Button class="search_button">検索</Button>
                {{-- 通常時の表示 --}}
                @else
                    <select name="search_option" class="search_select">
                        <option value="name">作成者</option>
                        <option value="title" selected>タイトル</option>
                        <option value="content">本文</option>
                    </select>
                    <input type="text" name="search_text" placeholder="キーワードを入力" value="{{old('search_text')}}" 
                        class="search_text"><input type="submit" class="search_button" value="検索">
               @endif
               <Button class="clear_search_button">クリア</Button>
            </form>
            <br><br>
            @if (session('err_msg'))
                <p class="text-danger">
                    {{ session('err_msg') }}
                </p>
            @endif
          
             {{-- 一覧表示  --}}
            <table class="table table-striped">
                <tr>
                    <th>番号</th>
                    <th>タイトル</th>
                    <th>作成者</th>
                    <th>更新日時</th>
                </tr>
                @foreach($blogs as  $blog)
                <tr>
                    <td>{{ $loop->index + 1 + 10*($blogs->currentPage()-1)}}</td>
                    <td><a href="showDetail/{{$blog->id}}">{{ $blog->title}}</a></td>
                    <td>{{ $blog->name}}</td>
                    <td>{{ substr($blog->updated_at,0,19) }}</td>
                </tr>
                @endforeach
            </table>
            {{-- ページング表示 pagination::defaultは先頭/最終ページリンク用--}}
            {{ $blogs->links('pagination::default') }}
        </div>

    </div>
</body>
@endsection