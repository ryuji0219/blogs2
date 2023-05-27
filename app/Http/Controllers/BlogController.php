<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\User;

const SESSION_OUT_MSG = 'ログイン操作をして下さい';
const PAGE_NUM=10;    //1ページあたりの表示数

CONST NORMAL_MODE = 1;
CONST NEEDED_MODE = 2;

class BlogController extends Controller
{
    //チェリーテスト
    //チェリーテスト２
    //チェリーテスト３
    //チェリーテスト４

        # ホーム画面表示
    public function showHome(){
         if(!$this->SessionChk()){
            $user['id']  = '0';
            $dsp = ['title' => "会員登録",'btn' => '新規登録'];
            User::find(0)->increment('cnt');
        }
        else{
            $user=session('user');
            $dsp = ['title' => "会員情報",'btn' => '更新'];
            $user = User::where('id',$user['id'])->first();
            session(['user' => $user]);
            User::find($user['id'])->increment('cnt');
        }
        $query = DB::table('blogs as b')
           ->Join('users as u', 'b.user_id', '=', 'u.id')
           ->where('u.invalid','!=',1)
           ->where('b.invalid','!=',1)
             ->select('b.id','b.title' ,'b.content','b.user_id','u.name','b.updated_at')
             ->orderby('b.updated_at','DESC');


       $query_all = $query->get(); 
        $blogs = $query_all->paginate(PAGE_NUM);

        return view::make('BlogList',['user'=>$user,'blogs'=>$blogs,'dsp'=>$dsp]);
    }

    // プログ詳細
    public function showDetail($b_id)
    {
        if(!$this->SessionChk()){
            $user['name'] = "ゲストさん";
        }
        else{
            $user=session('user');
        }
 
        $blog = Blog::find($b_id);

        $blog = DB::table('blogs as b')
           ->Join('users as u', 'b.user_id', '=', 'u.id')
           ->select('b.id','b.title','b.content','u.name', 'b.user_id', 'b.updated_at', 'b.invalid')
           ->where('b.id', '=', $b_id)
           ->first(); 
        
        $_SESSION['blog'] = $blog;

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('showHome'));
        }

        $dsp = ['title' => "会員情報",'btn' => '更新'];
        return view::make('BlogDetail',['user'=>$user,'blog'=>$blog,'dsp'=>$dsp]);
    }

    
    # プログ作成画面表示
    public function showBlogCreate() 
    {
        if(!$this->SessionChk()){
            return redirect(route('showHome'));
        }
       $user=session('user');

        $dsp = ['title' => "会員情報",'btn' => '更新'];
        return view::make('BlogCreate',['user'=>$user,'dsp'=>$dsp]);
    }

    //  ブログ編集フォーム
    public function showEdit()
    {
        if(!$this->SessionChk()){
            return redirect(route('showHome'));
        }
        $blog = $_SESSION['blog'];
        $user=session('user');

       if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        // return view('BlogEdit',compact('user', 'blog'));
        return view::make('BlogEdit',['user'=>$user,'blog'=>$blog]);
    }
    
    #　プログ更新 or 削除
    public function exeUpdateDelelte(BlogRequest $request) 
    {
        // ブログのデータを受け取る
        $inputs = $request->all();

        if($request->has('delete')){
            $this->exeDelete($inputs);
         }
        else{
            $this->exeUpdate($inputs);
         }
         return redirect(route('showHome'));
   }
   

    # ブログ更新
    public function exeUpdate($inputs)
    {
        if(!$this->SessionChk()){
            return redirect(route('showHome'));
        }

        \DB::beginTransaction();
        try {

            // ブログを更新
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
                'updated_at' => now()
            ]);
            $blog->update();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('ok_msg', $inputs['title'] . ' のブログを更新しました');
        return redirect(route('showHome'));
    }

     # ブログ削除
    public function exeDelete($inputs)
    {
        if(!$this->SessionChk()){
            return redirect(route('showHome'));
        }
        \DB::beginTransaction();
        try {
            // ブログを削除
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
                'invalid' => '1',
                'updated_at' => now()
            ]);
            $blog->save();
            // Blog::destroy($inputs['id']);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('ok_msg', $inputs['title'] . ' のブログを削除しました');
        return redirect(route('showHome'));
    }

    #ブログを登録する
    public function exeBlogStore(BlogRequest $request) 
    {
        if(!$this->SessionChk()){
            return redirect(route('showHome'));
        }
        // ブログのデータを受け取る
        $inputs = $request->all();
        \DB::beginTransaction();  
   
        try {
            // ブログを登録
            Blog::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('ok_msg', $inputs['title'] . 'のブログを登録しました');
        return redirect(route('showHome'));
    }

      
    public function SessionChk()
    {
        session_start();
        
        $data = session('user');
    //   dump($data);
        if(!isset($data)){
            \Session::flash('session_error', SESSION_OUT_MSG);
            return false;
        }

        session()->regenerate();
        // ssession_egenerate_id(true);
         return True;
    }
  
}
