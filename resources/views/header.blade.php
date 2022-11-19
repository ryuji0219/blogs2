<nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
    <a class="navbar-brand" href="">ブログ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" 
            data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="{{route('home')}}" >ブログ一覧 <span class="sr-only"></span></a>
            @if (isset($user['name']))
                <a class="nav-item nav-link" href="{{route('BlogCreate')}}">ブログ作成</a>
                <a class="nav-item nav-link" href="{{route('logout')}}">ログアウト</a>
            @else
                <a class="nav-item nav-link" href="{{route('ShowLogin')}}">ログイン</a>
                <a class="nav-item nav-link" href="{{route('UserCreate')}}">会員登録</a>
            @endif
       </div>
    </div>
</nav>
