@extends('layout')
@section('title', 'ブログ一覧')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

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
            {{-- </form> --}}
            <br><br>
            @if (session('err_msg'))
                <p class="text-danger">
                    {{ session('err_msg') }}
                </p>
            @endif
            
            1 <input type="checkbox" name="chkbox[]" value="1" id="chkbox_1">
            2 <input type="checkbox" name="chkbox[]" value="2" id="chkbox_2">
            3 <input type="checkbox" name="chkbox[]" value="3" id="chkbox_3"><br>

            <p>【配列】<input type="checkbox" name="ueno[]" value="あいり">：あいり
                <input type="checkbox" name="ueno[]" value="ゆりな">：ゆりな
                <input type="checkbox" name="ueno[]" value="パパ">：パパ</p>
                    
            <!--結果出力用-->
            <span id="p00"></span> 
            <span name="moji_airi"></span>     
            <span id="moji_airi[0]"></span>     
    
            <p>【排他】<input type="checkbox" name="check" value="あいり" id="airi">：あいり
            <input type="checkbox" name="check" value="ゆりな" id="val">：ゆりな
            <input type="checkbox" name="check" value="パパ" id="papa">：パパ</p>

            <p id="p01"></p>      
            <p id="p02"></p>      
            <p id="p03"></p>      

        
             {{-- 一覧表示  --}}
            <table id="tblLocations" class="table table-striped">
                <tr>
                    <th>番号</th>
                    <th>タイトル</th>
                    <th>作成者</th>
                    <th>更新日時</th>
                </tr>
                @foreach($blogs as $i => $blog)
                <tr>
                    <td>{{ $loop->index + 1 + 10*($blogs->currentPage()-1)}}</td>
                    <td><a href="showDetail/{{$blog->id}}">{{ $blog->title}}</a></td>
                    <td>{{ $blog->name}}</td>
                    <td>{{ substr($blog->updated_at,0,19) }}</td>
                    <td><input type="hidden" name="title[]" value={{ $blog->title}}></td>
                    <td>
                        <input type="hidden" name="ueno_airi[{{$i}}]" value="0">
                        <input type="hidden" name="ueno_yuri[{{$i}}]" value="0">
                        <input type="hidden" name="ueno_ryu[{{$i}}]" value="0">
                        @if($i % 2 === 0)
                        <input type="checkbox" name="ueno_airi[{{$i}}]" value="1">あいり
                        <input type="checkbox" name="ueno_yuri[{{$i}}]" value="1">ゆりな
                        <input type="checkbox" name="ueno_ryu[{{$i}}]" value="1">パパ
                        @else
                        <input type="checkbox" name="ueno_airi[{{$i}}]" value="1" style="display:none;"><span name="moji_airi[{{$i}}]" style="display:none;">あいり</span>
                        <input type="checkbox" name="ueno_yuri[{{$i}}]" value="1" style="display:none;"><span name="moji_yuri[{{$i}}]" style="display:none;">ゆりな</span>
                        <input type="checkbox" name="ueno_ryu[{{$i}}]" value="1" style="display:none;"><span name="moji_ryu[{{$i}}]" style="display:none;">パパ</span>
                        <input type="button" name="button[{{$i}}]" value="ボタン">
                        @endif
                    </td> 
                </tr>
                @endforeach
            </table>
            {{-- ページング表示 pagination::defaultは先頭/最終ページリンク用--}}
            {{ $blogs->links('pagination::default') }}
        </div>
    </form>
     
    </div>
</body>
@endsection