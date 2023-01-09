<?php
    if (!empty($user['id']) && $user['id'] != 0){
        $user_id = $user['id'];
        $name = $user['name'];
        $email = $user['email'];
        // $password = '$user['password']';
        $postCode = $user['postCode'];
        $address1 = $user['address1'];
        $address2 = $user['address2'];
    }
    else{
        $user_id = 0;
        $name = "";
        $email = "";
        // $password ="";
        $postCode ="";
        $address1 ="";
        $address2 ="";
    }
?>
<body>
    <div class="container">
    <form method="POST" action="{{ route('UserStore') }}" onSubmit="return checkSubmit()">
        @csrf
        <div class="err_msg_user"></div>
        <div class="row">
            <p class="col-sm-2">ユーザ名<p>
            <label class="ef col-sm-6">
	        <input type="text" name="newName" placeholder="（必須）" value={{$name}} >
	      </label>
        </div>

        <div class="row">
           <p class="col-sm-2">Eメール<p>
            <label class="ef col-sm-6">
               <input type="email" name="newEmail" placeholder="（必須）" value={{$email}}>
 	      </label>
        </div>  

        <div class="row">
            <p class="col-sm-2">パスワード<p>
            <label class="ef col-sm-6">
               <input type="password" name="newPassword" placeholder="（必須）" value="">
 	      </label>
        </div>          

        <div class="row">
          <p class="col-sm-2">パスワード確認用<p>
          <label class="ef col-sm-6">
               <input type="password" name="newPassword2" placeholder="（必須）" value="">
 	      </label>
        </div>  

        <div class="row">
            <p class="col-sm-2">郵便番号<p>
            <label class="ef col-sm-2">
                  <input type="text" name="postCode" placeholder="（任意）" size=7 value={{$postCode}}>
            </label>
            <button class="address-search address_search_button">住所検索</button>
        </div>  
        <div class="err_msg_address"></div>

        <div class="row">
            <p class="col-sm-2">住所(都道府県・市町村)<p>
            <label class="ef col-sm-6">
                <input type="text" id = "address1" name="address1" placeholder="（任意）" value={{$address1}} >
            </label>
        </div>

        <div class="row">
            <p class="col-sm-2">住所(番地・建物名・部屋番号)<p>
            <label class="ef col-sm-6">
                <input type="text" name="address2"  placeholder="（任意）" value={{$address2}}>
            </label>
        </div>  
        <br>
  
        <input type="hidden" name="user_id" value="{{ $user_id }}">

        <p>
            <button class="btn btn-primary user-create" >{{$dsp['btn']}}</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        </p>
    </form>
</div>
</body>

