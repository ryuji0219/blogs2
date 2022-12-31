<body>
  <form class="form-login" method="POST" action="{{route('login')}}">
      @csrf
      <h1 class="h3 mb-3 font-weight-normal">ログイン画面</h1>
      <div class="err_msg_login"></div>

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
      
       <button class="btn btn-primary modal-login">ログイン</button>
       <button class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
    </form>
</body>
