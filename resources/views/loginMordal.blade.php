<body>
  <form class="form-login" method="POST" action="{{route('login')}}">
 {{-- <form class="form-login"> --}}
      @csrf
      <h1 class="h3 mb-3 font-weight-normal">ログイン画面</h1>
      {{-- <div class="alert text-danger err_msg"></div> --}}
      <div class="err_msg"></div>

      <div class="cp_iptxt">
	      <label class="ef">
	        <input type="text" id="inputName" name="name" placeholder="ユーザ名" autofocus>
	      </label>
      </div>

      <div class="cp_iptxt">
	      <label class="ef">
           <input type="password" id="inputPassword" name="password" placeholder="パスワード">
 	      </label>
      </div>        
       <br>
      
       {{-- オープン --}}
       {{-- <button type="submit" class="btn btn-primary modal-login">ログイン</button> --}}
       <button class="btn btn-primary modal-login">ログイン</button>
       {{-- <input type="button" class="btn btn-primary modal-login" value="ログイン"> --}}

       {{-- クローズ --}}
       <button type=submit class="btn btn-secondary" data-dismiss="modal">Close</button>
       {{-- <button type="button" class="btn btn-secondary btn-close">Close</button> --}}
    </form>
</body>
