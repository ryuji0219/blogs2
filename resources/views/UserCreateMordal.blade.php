<body>
    <div class="container">
    <form method="POST" action="{{ route('UserStore') }}" onSubmit="return checkSubmit()">
        @csrf
        <h1 class="h3 mb-3 font-weight-normal">会員登録フォーム</h1>
        <div class="err_msg_user"></div>

        <div class="cp_iptxt">
	      <label class="ef">
	        <input type="text" name="newName" placeholder="ユーザ名（必須）"  autofocus value={{old('newName')}}>
	      </label>
        </div>

        <div class="cp_iptxt">
	      <label class="ef">
           <input type="email" name="newEmail" placeholder="Eメール（必須）" value={{old('newEmail')}} >
 	      </label>
        </div>  

        <div class="cp_iptxt">
	      <label class="ef">
           <input type="password" name="newPassword" placeholder="パスワード（必須）">
 	      </label>
        </div>          

        <div class="cp_iptxt">
	      <label class="ef">
           <input type="password" name="newPassword2" placeholder="パスワード確認用（必須）">
 	      </label>
        </div>  
        <br>
        <p>
            <button class="btn btn-primary user-create" >新規登録</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        </p>
    </form>
    </div>
</body>
