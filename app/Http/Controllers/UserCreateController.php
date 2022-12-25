<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserCreateController extends Controller
{
    # 会員登録画面表示
    public function showUserCreate() 
    {
        return view('UserCreate');
    }

   #会員登録する
   public function exeUserStore(UserCreateRequest $request) 
   {
         // ブログのデータを受け取る
       $inputs = $request->all();

       if(!$this->CheckUseInp($inputs)){
          return back();
       }

       //　パスワード暗号化'
       $inputs['password']= md5(strtolower($inputs['password']));
       \DB::beginTransaction();

       try {
           // ブログを登録
           User::create($inputs);
           \DB::commit();
       } catch(\Throwable $e) {
           \DB::rollback();
           abort(500);
       }

       \Session::flash('member_ok', $inputs['name'] . 'さんを会員登録しました');
        return redirect(route('showHome'));
   }

   // 会員登録チェック
   public function CheckUseInp($inputs)
   {
       $blnResult = true;
    //バリデーション
    //    if(!isset($inputs['name'])){
    //        \Session::flash('err_name', 'ユーザ名を入力して下さい');
    //        $blnResult = false;
    //    }

         if(DB::table("users")->where('name', $inputs['name'])->exists()){
            \Session::flash('err_member', $inputs['name'] . 'は登録済みです。別のユーザ名を指定して下さい');
            $blnResult = false;
       }

    //バリデーション
    //     if(!isset($inputs['email'])){
    //        $err[] = 'emailを入力して下さい';
    //        \Session::flash('err_email', 'emailを入力して下さい');
    //        $blnResult = false;
    //     }
    //    if(!isset($inputs['password'])){
    //        $err[] = 'パスワードを入力して下さい';
    //        \Session::flash('err_password', 'パスワードを入力して下さい');
    //        $blnResult = false;
    //    }

    //    if (!preg_match('/^[a-z0-9]{3,100}$/i',$inputs['password'])){
    //         \Session::flash('err_password', 'パスワードは英数字4文字以上で入力して下さい');
    //         $blnResult = false;
    //    }

    //    if (preg_match('/^[a-z]+$/',$inputs['password'])){
    //     \Session::flash('err_password', 'パスワードは英字数字それぞれ1文字以上必須です');
    //     $blnResult = false;
    //    }

    //    if (preg_match('/^[0-9]+$/',$inputs['password'])){
    //         \Session::flash('err_password', 'パスワードは英字数字それぞれ1文字以上必須です');
    //         $blnResult = false;
    //    }

       if($inputs['password'] !== $inputs['pass2']){
           \Session::flash('err_member', '入力パスワードが一致しません。');
           $blnResult = false;
       }

       return $blnResult;
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
