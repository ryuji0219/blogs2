<nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
    <a class="navbar-brand" href="">ブログ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" 
            data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="{{route('showHome')}}" >ブログ一覧 <span class="sr-only"></span></a>
            @if (isset($user['name']))
                <a class="nav-item nav-link" href="{{route('BlogCreate')}}">ブログ作成</a>
                <a class="nav-item nav-link" href="{{route('logout')}}">ログアウト</a>
            @else
                {{-- <a class="nav-item nav-link" href="{{route('ShowLogin')}}">ログイン</a> --}}
                <a class="nav-item nav-link btn" data-toggle="modal" data-target="#loginDsp">ログイン</a>
                {{-- <a class="nav-item nav-link" href="{{route('UserCreate')}}">会員登録</a> --}}
                <a class="nav-item nav-link btn" data-toggle="modal" data-target="#joinMember">会員登録</a>
            @endif
       </div>
    </div>

    {{-- ログイン --}}
    <div class="modal fade" id="loginDsp">
            <div class="modal-dialog modal-dialog-centered"  role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        @include('loginMordal')
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- 会員登録 --}}
    <div class="modal fade" id="joinMember">
            <div class="modal-dialog modal-dialog-centered"  role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        @include('UserCreateMordal')
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
