<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Controllers\BlogController;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    # ログイン画面表示
    public function showLogin(){
        return view('login');
    }

    // ログイン処理
    public function DoLoginCheck(LoginFormRequest $request){
        $err[] = [];
        $name = $request['name'];
        //小文字変換 → 暗号化
        $pass = md5(strtolower($request['password']));
        $DB_User = User::where('name',$name)->first();
        if ($DB_User == NULL){
            $res = [ 'result'=> 'NG','errMsg' => '登録されていないユーザ名です!'];
        }
        else{    
            // ログインチェック
            if(strtolower($name) == strtolower($DB_User["name"]) && 
                $pass == $DB_User["password"]){
                    $res = [ 'result'=> 'OK','errMsg' => ''];
                // return true;
            }
            else{
                $res = [ 'result'=> 'NG',
                            'errMsg' => 'ユーザ名とパスワードが一致しません!'];
                // return false;
            }
        }
        return response()->json($res);
    }

    // ログイン処理
    public function DoLogin(LoginFormRequest $request){
        $err[] = [];
        $name = $request['name'];
        //小文字変換 → 暗号化
        $pass = md5(strtolower($request['password']));

        $DB_User = User::where('name',$name)->first();
        if ($DB_User == NULL){
             return back()-> with([
                'login_error' => '登録されていないユーザ名です',
            ]);
       }
        // ログインチェック
        if(strtolower($name) !== strtolower($DB_User["name"]) && 
                  $pass == $DB_User["password"]){
            return back()-> with([
                'login_error' => 'ユーザ名とパスワードが一致しません!',
            ]);        
        }

        $blogs = Blog::all();
        $date = date("Y-m-d H:i:s");

        \DB::beginTransaction();
        try {
            // ログイン時間保存
            $DB_User->fill([
                'login_at' => $date,
            ]);
            $DB_User->save();

            \DB::commit();
            session_start();
            header('Expires: -1');
            header('Cache-Control:');
            header('Pragma:');
            $_SESSION['user']=$DB_User;

            session(['user' => $DB_User]);
            \Session::flash('ok_msg', 'ログインしました。');
            return redirect(route('showHome'));

        } catch(\Throwable $e) {
            \DB::rollback();
            return back()-> with([
                'login_error' => '予期せぬエラーが発生しました。'
            ]);
        }
    }

    // ログアウト処理
    public function DoLogout()
    {
        session_start();
        $_SESSION = [];
        if(isset($_COOKIE[session_name()])==true)
        {
            setcookie(session_name(),'',time()-42000,'/');
        }
        session_destroy();
        session()->flush();
        \Session::flash('logout_msg', 'ログアウトしました');
        return redirect(route('showHome'));
    }

}
