<body>
  <form class="form-login" method="POST" action="{{route('login')}}">
      @csrf
      <div class="err_msg_login"></div>

      <div class="row">
        <p class="col-sm-3">ユーザ名<p>
	      <label class="ef col-sm-6">
	        <input type="text" id="inputName" name="name" placeholder="" autofocus>
	      </label>
      </div>

      <div class="row">
        <p class="col-sm-3">パスワード<p>
          <label class="ef col-sm-6">
            <input type="password" id="inputPassword" name="password" placeholder="">
 	      </label>
      </div>        
      
       <button class="btn btn-primary modal-login">ログイン</button>
       <button class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
    </form>
</body>
