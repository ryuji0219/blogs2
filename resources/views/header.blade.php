<nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
    <div class="collapse navbar-collapse">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="{{route('showHome')}}" >ブログ一覧 <span class="sr-only"></span></a>
            @if (isset($user['name']))
                <a class="nav-item nav-link" href="{{route('BlogCreate')}}">ブログ作成</a>
                <a class="nav-item nav-link btn" data-toggle="modal" data-target="#joinMember">{{$dsp['title']}}</a>
                <a class="nav-item nav-link" href="{{route('logout')}}">ログアウト</a>
            @else
                <a class="nav-item nav-link btn" data-toggle="modal" data-target="#loginDsp">ログイン</a>
                <a class="nav-item nav-link btn" data-toggle="modal" data-target="#joinMember">{{$dsp['title']}}</a>
            @endif
       </div>
       
       <div id="clock">
            <div class="date">
                @{{year}} / @{{month}} / @{{day}}
            </div>
            <div class="time">
                @{{hours}} : @{{minutes}} <span class="minutes">: @{{seconds}}</span>
            </div>
        </div>
    </div>

    {{-- ログイン --}}
    <div class="modal fade" id="loginDsp">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ログイン画面</h4>
                    </div>                    
                    <div class="modal-body">
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
                        {{-- <h4 class="modal-title">会員登録画面</h4> --}}
                        <h4 class="modal-title">{{$dsp['title']}}画面</h4>
                    </div>                    
                    <div class="modal-body">
                        @include('UserCreateMordal')
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
#clock {
    height:20px;
    display:flex;
    flex-flow:column;
    align-items:flex-end;
    color:white;
    margin-right: 190pt;
 }

.date{
    font-size:13px;
}
.time{
    font-size:18px;
}
.minutes{
    font-size:13px;
}
</style>
