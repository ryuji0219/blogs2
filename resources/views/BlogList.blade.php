@extends('layout')
@section('title', 'ブログ一覧')
@section('content')
<body>
    <div class="row">
        <div class="col-md-10">
            @if (session('logout_msg'))
                <p class="text-danger">
                    {{ session('logout_msg') }}
                </p>
            @endif 
            <h1>ブログ記事一覧</h1>

            @if ( !empty($user["name"]))
                <p2>ユーザ名：{{ $user["name"] }}</p2>
                <p3>ログイン時間：{{ $user["login_at"] }}</p3>
            @else
                <p2>ゲストさん</p2>
            @endif
  
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
                        class="search_text"><input type="submit" class="search_button" value="検索">
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
            </form>
            <br><br>
            @if (session('err_msg'))
                <p class="text-danger">
                    {{ session('err_msg') }}
                </p>
            @endif
            @if (session('ok_msg'))
                <p class="text-primary">
                    {{ session('ok_msg') }}
                </p>
            @endif            
             {{-- 一覧表示  --}}
            <table class="table table-striped">
                @if ( !empty($user["name"]))
                <tr>
                    <th>番号</th>
                    <th>タイトル</th>
                    <th>作成者</th>
                    <th>更新日時</th>
                </tr>
                @endif
                @foreach($blogs as  $blog)
                <tr>
                    <td>{{ $loop->index + 1 + 10*($blogs->currentPage()-1)}}</td>
                    <td><a href="showDetail/{{$blog->id}}">{{ $blog->title  }}</a></td>
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