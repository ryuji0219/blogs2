<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\SearchAddressRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $errMsg = "";

        if($inputs['user_id'] == 0 && DB::table("users")->where('name', $inputs['newName'])
                             ->where('invalid','!=',1)->exists()){
            $errMsg = $inputs['newName'] . 'は登録済みです。別のユーザ名を指定して下さい。<br>';
        }
        if($inputs['newPassword'] !== $inputs['newPassword2']){
            $errMsg .= '入力パスワードと確認パスワードが一致しません。<br>';
        }

        if (!empty($inputs['postCode']) && !preg_match("/^\d{3}-\d{4}$/",$inputs['postCode']) && !preg_match("/^\d{3}\d{4}$/",$inputs['postCode'])) {
            $errMsg .= '郵便番号は「123-4567」の形式で入力してください。';
        }

        if (empty($errMsg)){
            $res_user = [ 'result'=> 'OK','errMsg' => ''];
        }
        else{
            $res_user = [ 'result'=> 'NG','errMsg' => $errMsg];
        }


        
        return response()->json($res_user);
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
            'email' =>  $inputs['newEmail'],
            'postCode' =>  $inputs['postCode'],
            'address1' =>  $inputs['address1'],
            'address2' =>  $inputs['address2'],
            'updated_at' => now()
        ];

        \DB::beginTransaction();

        try {
            if ($inputs['user_id'] === 0){
            // ユーザ登録
            User::create($newData);
            }
            else{
                $user = User::find($inputs['user_id']);
                $user->fill($newData);
            }
            $user->update();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        if ($inputs['user_id'] === 0){
            \Session::flash('ok_msg', $inputs['newName'] . 'さんを会員登録しました。ログインするとブログの登録などが出来ます。');
        }
        else{
            \Session::flash('ok_msg', $inputs['newName'] . 'さんの会員情報を更新しました。');
        }
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

        \DB::beginTransaction();
        try {
             // ユーザの削除フラグON
            //  User::destroy($user['id']);
            $user = User::where('id',$user->id)->first();
            $user->fill([
                'invalid' => 1,
                'updated_at' => now()
            ]);
            $user->update();
            \DB::commit();
          } catch(\Throwable $e) {
             abort(500);
         }
 
        //  セッション削除
        $_SESSION = [];
        if(isset($_COOKIE[session_name()])==true)
        {
            setcookie(session_name(),'',time()-42000,'/');
        }
        session_destroy();
        session()->flush();
         \Session::flash('ok_msg', $user['name'] . 'さんの退会処理を行いました。またのご参加をお待ちしております。');
         return redirect(route('showHome'));
     }

    //住所検索
    public function searchAddress($postCode) 
    {
        if(empty($postCode)){
            $res = [ 'result'=> 'NG',
                'errMsg' => '郵便番号を入力して下さい。'];
        }
        else if (!preg_match("/^\d{3}-\d{4}$/",$postCode) && !preg_match("/^\d{3}\d{4}$/",$postCode)) {
            $res = [ 'result'=> 'NG',
                'errMsg' => '郵便番号は「123-4567」の形式で入力してください。'];
        }
        else{
            $url = "http://zipcloud.ibsnet.co.jp/api/search?zipcode=". $postCode;
            $json = file_get_contents($url);
            $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
            $addressData = json_decode($json,true);
            if (empty($addressData['results'])){
                $res = [ 'result'=> 'NG',
                'errMsg' => '入力された郵便番号に該当する住所は見つかりませんでした。'];

            }
            else{
                $address = $addressData['results'][0]['address1'] . $addressData['results'][0]['address2'] .$addressData['results'][0]['address3'];
                $res = [ 'result'=> 'OK',
                'address' => $address
               ];
            }
        } 
        return response()->json($res);

    }

}
