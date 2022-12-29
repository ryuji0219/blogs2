<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BlogController;

class UserCreateController extends Controller
{
    # 会員登録画面表示
    public function showUserCreate() 
    {
        return view('UserCreate');
    }

   // ユーザ登録チェック
   public function DoUserCheck(UserCreateRequest $request){ 
        $inputs = $request->all();

        if(DB::table("users")->where('name', $inputs['newName'])->exists()){
            $res = [ 'result'=> 'NG','errMsg' => $inputs['newName'] . 'は登録済みです。別のユーザ名を指定して下さい'];
        }
        elseif($inputs['newPassword'] !== $inputs['newPassword2']){
            $res = [ 'result'=> 'NG','errMsg' => '入力パスワードと確認パスワードが一致しません!'];
        }else{
            $res = [ 'result'=> 'OK','errMsg' => ''];
        }
        return response()->json($res);
    }

   #会員登録する
   public function exeUserStore(UserCreateRequest $request) 
   {
       $inputs = $request->all();

    //    if(!$this->CheckUseInp($inputs)){
    //       return back();
    //    }

       //　パスワード暗号化'
       $inputs['password']= md5(strtolower($inputs['newPassword']));

        $newData = [
            'name' => $inputs['newName'],
            'password' =>  md5(strtolower($inputs['newPassword'])),
            'email' =>  md5(strtolower($inputs['newEmail'])),
        ];

        \DB::beginTransaction();

        try {
            // ユーザ登録
            User::create($newData);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('ok_msg', $inputs['newName'] . 'さんを会員登録しました。ログインするとブログの登録などが出来ます。');
        // $_SESSION['user']=$newData['name'];
        // session(['user' => $newData['name']]);
        return redirect(route('showHome'));
        
    }

     # 会員削除（退会）
     public function exeUserDelete()
     {
        $ybrr = app()->make('App\Http\Controllers\BlogController');
        if(!$ybrr->SessionChk()){
            return redirect(route('showHome'));
        }

        $user = session('user');
 
        try {
             // ブログを削除
             User::destroy($user['id']);
          } catch(\Throwable $e) {
             abort(500);
         }
 
        //  セッション削除
        $_SESSION=array();
        if(isset($_COOKIE[session_name()])==true)
        {
            setcookie(session_name(),'',time()-42000,'/');
        }
        session_destroy();

         \Session::flash('ok_msg', $user['name'] . 'さんの退会処理を行いました。またのご参加をお待ちしております。');
         return redirect(route('showHome'));
     }
}
