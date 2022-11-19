<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\User;

class SearchController extends Controller
{
    # ブログ検索
    public function exeBlogSearch(SearchRequest $request){
        // 検索条件を格納
        $search["text"]= $request->search_text;
        $search["option"]= $request->search_option;

        $ybrr = app()->make('App\Http\Controllers\BlogController');
        if(!$ybrr->SessionChk()){
            $user['id']  = '0';
        }
        else{
            // $user = User::find($_SESSION['u_id']);
            $user=session('user');
        }

        $blogs= $this->getSearchData($user,$search);

        $_SESSION['search_text']=$search["text"];
        $_SESSION['search_option']=$search["option"];

        return view('BlogList',compact('blogs','user','search'));

    }

    // ブログ検索データ抽出
    public function getSearchData($user,$search){
        // BlogsとUsersテーブル結合
        $querys = DB::table('blogs as b')
           ->leftJoin('users as u', 'b.user_id', '=', 'u.id')
           ->select('b.id','b.title','b.content','u.name','b.updated_at')
           ->where($search["option"], 'like', '%' . $search["text"]  . '%')
           ->orderBy('b.created_at', 'desc')
           ->get();

        $blogs = $querys->paginate(10);
         return($blogs);
    }

       // ブログ検索データ抽出
    //    public function getSearchData(&$user,&$blogs,&$search){
    //     // BlogsとUsersテーブル結合
    //     $querys = DB::table('blogs as b')
    //        ->leftJoin('users as u', 'b.user_id', '=', 'u.id')
    //        ->select('b.id','b.title','b.content','u.name','b.updated_at')
    //        ->where($search["option"], 'like', '%' . $search["text"]  . '%')
    //        ->orderBy('b.created_at', 'desc')
    //        ->get(); 

    //     $blogs = $querys->paginate(10);
    // }

    # ブログ検索データの抽出（ページング時）
    public function showBlogSearch(){

        $ybrr = app()->make('App\Http\Controllers\BlogController');
        if(!$ybrr->SessionChk()){
            $user['id']  = '0';
        }
        else{
            // $user = User::find($_SESSION['u_id']);
            $user=session('user');
        }

        $search["option"]=$_SESSION['search_option'];
        $search["text"]=$_SESSION['search_text'];

        $blogs=$this->getSearchData($user,$search);

        return view('BlogList',compact('blogs','user','search'));
    }   

}