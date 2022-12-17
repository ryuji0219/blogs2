<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\User;

// test1 branch
// git branch test2

const SESSION_OUT_MSG = 'ログイン操作をして下さい';
const PAGE_NUM=10;    //1ページあたりの表示数

CONST NORMAL_MODE = 1;
CONST NEEDED_MODE = 2;

class BlogController extends Controller
{
    # ホーム画面表示
    public function showHome(){
        // $entity_list_array = [];
        $entity_list_array = $this->makeData();


        if(!$this->SessionChk()){
            $user['id']  = '0';
        }
        else{
            $user=session('user');
        }

        
        $ids = [111,222,333];
        // $r_ids = [];
        foreach ($ids as $id){
            $r_ids[] = (object)['id' => $id];
        };
        $c_ids = collect($r_ids);

        $new_test_ids = [];
        foreach ($c_ids as $c_id) {
            array_push($new_test_ids, $c_id->id);
        }
        
        $claim_datas = [
            ['payment_times' => 1,  'countings_id' => '111'],
            ['payment_times' => 2,  'countings_id' => '222'],
            ['payment_times' => 3,  'countings_id' => '333'],
            ['payment_times' => 1,  'countings_id' => '111'],
            ['payment_times' => 1,  'countings_id' => '111'],
        ];

        $countings_datas = [];
        foreach ($claim_datas as $index => $claim_data){
            if (empty($countings_datas[$claim_data['payment_times']])){
                $countings_datas[$claim_data['payment_times']] = $claim_data['countings_id'];
            }
        }

        $counting_ids = []; 
        foreach ($countings_datas as $index => $countings_data) {
           $counting_ids[] = (object)['id' => $countings_data];
        }

        foreach ($countings_datas as $index => $value) {
            $counting_ids[] = (object)['id' => $value];
         }

        // $c_counting_ids = collect($counting_ids);
        // foreach ($c_counting_ids as $c_counting_id) {
        //     array_push($new_ids, $c_counting_id->id);
        // }
     
  
        // $query0 = blog::select(DB::raw('title', 'id'));
        $query0 = DB::table('blogs');
        $query0->where(DB::raw("CONCAT(id, '-', title)"), 'like', '%' . 'a' . '%')->get();
        // $query1 = blog::select(DB::raw('CONCAT(id, "-", title) AS full_name'), 'id')->get();
        // $query1 = blog::select(DB::raw('CONCAT(id, "-", title) AS full_name'), 'id')->get();
        // $query2=blog::where(DB::raw('CONCAT(id,title)'), 'like','a')->get();


        // $query2 = DB::table('blogs');
        // $query2->select(DB::raw('CONCAT(ifnull(b.id,""),"-",ifnull(b.title,"") AS AA'))->get();
             
        // dd($query1);                

        $name1='ああいう123';

        $aa = mb_strlen($name1);
        $name2='airi';
        $flag = TRUE;
        $include_late_fees = TRUE;
        $key1 = "b";
        $key1B = "%b%";
        $key2 = "a";
        $insurance_year_from = "2022";
        $payment_times_from = "08";
        $insurance_year_to = "2022";
        $payment_times_to = "08";

        $date_from = $insurance_year_from . "-" .  $payment_times_from;
        $date_to = $insurance_year_to . "-" .  $payment_times_to;

        $query = DB::table('blogs as b')
           ->Join('users as u', 'b.user_id', '=', 'u.id')
             ->select('b.id','b.title' ,'b.content','u.name','b.updated_at');

            //  $query->Where(function($query2) use($name1,$name2){
            //     if(!empty($name1)){
            //         $query2->Where('name', $name1);
            //     }
            //     if(!empty($name2)){
            //         $query2->orWhere('name', $name2);
            //     }                
            //     // $query2->Where('u.name', $name1)
            //     //         ->orWhere('u.name',$name2);
            // });

            //  $query->Where(function($query) use($name1,$name2){
            //     $query->where('name', 'like',"'%'")
            //           ->Where(function($query) use($name1,$name2){
            //                  $query->orWhere('name', $name1)
            //                        ->orWhere('name',$name2);
            //           });
            // });
            

        // if(!empty($name1)){
        //     $query->Where('name', $name1);
        // }
        // if(!empty($name2)){
        //     $query->orWhere('name', $name2);
        // }

        // $query->whereRaw("CONCAT(b.title, '-', b.id) like  :key ",
        //                    ['key' => "%b%"]);
        // $query->whereRaw("CONCAT(b.title, '-', b.id) like  :key2 ",
        //                    ['key2' => "%b%"]);
        // $query->whereRaw("b.updated_at >=  :date_from AND b.updated_at >=  :date_to ",
        // ['date_from' =>  $date_from,'date_to' =>  $date_to]);

       $query_all = $query->get();
 
        $blogs = $query_all->paginate(PAGE_NUM);
        return view::make('BlogList',['user'=>$user,'blogs'=>$blogs]);
    }

    private function makeData(){
        $li_no=array("A001","A002","A003","A004","A005");
       
        $entity_list_array= [];

        for($i=0;$i<count($li_no);$i++){
          $detail_entry_list= array();
        
          for($cnt_ki=0;$cnt_ki<20;$cnt_ki++){
            $insurance_year=rand(2021, 2022);
        
            $payment_times=rand(1, 2);
        
            $sub_id=rand(1, 2);
            switch($sub_id){
              case 1:
                $subject = "労働保険料";
                break;
              case 2:
                $subject = "拠出金";
                break;
            }
            $detail_entry_list[]= array(
                'insurance_year' => $insurance_year,
                'payment_times' => $payment_times,
                'bill_counting_type_name' => $subject,
                'bill_counting_amount' => $sub_id * 1000
              );
          } 
        
          for($cnt_zuiji=0;$cnt_zuiji<20;$cnt_zuiji++){
            $insurance_year=rand(2021, 2022);
        
            $payment_times=rand(1, 2);
        
            $sub_id=rand(31, 34);
            switch($sub_id){
              case 31:
              case 32:
                $subject = "延滞";
                break;
              case 33:
              case 34:
                $subject = "追徴";
                break;
            }
            $detail_entry_list[]= array(
                'insurance_year' => $insurance_year,
                'payment_times' => $payment_times,
                'bill_counting_type_name' => $subject,
                'bill_counting_amount' => $sub_id * 1000
              );
          } 
        
          for($cnt_zuiji2=0;$cnt_zuiji2<10;$cnt_zuiji2++){
            $insurance_year=rand(2021, 2022);
        
            $payment_times=rand(1, 2);
        
            $sub_id=rand(10, 11);
            switch($sub_id){
              case 10:
              case 11:
                $subject = "再確定による不足額";
                break;
            }
            $detail_entry_list[]= array(
                'insurance_year' => $insurance_year,
                'payment_times' => $payment_times,
                'bill_counting_type_name' => $subject,
                'bill_counting_amount' => $sub_id * 1000
              );
          } 
        
          $entity_list_array [] = array(
            'li_no' => $li_no[$i],
            'list' =>  $detail_entry_list
          );
        }
        return($entity_list_array);
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
           ->select('b.id','b.title','b.content','u.name', 'b.user_id', 'b.updated_at')
           ->where('b.id', '=', $b_id)
           ->first(); 
        
        $_SESSION['blog'] = $blog;

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('home'));
        }
        return view('BlogDetail',compact('user','blog'));
    }

    //  ブログ編集フォーム
    public function showEdit()
    {
        if(!$this->SessionChk()){
            return redirect(route('ShowLogin'));
        }
        $blog = $_SESSION['blog'];
        $user=session('user');

       if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        return view('BlogEdit',compact('user', 'blog'));
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
         return redirect(route('home'));
   }
   

    # ブログ更新
    public function exeUpdate($inputs)
    {
    if(!$this->SessionChk()){
        return redirect(route('ShowLogin'));
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

        $blog->save();
        \DB::commit();
    } catch(\Throwable $e) {
        \DB::rollback();
        abort(500);
    }

    \Session::flash('ok_msg', $inputs['title'] . ' のブログを更新しました');
        return redirect(route('home'));
    }

     # ブログ削除
    public function exeDelete($inputs)
    {
        if(!$this->SessionChk()){
            return redirect(route('ShowLogin'));
        }
        \DB::beginTransaction();
        try {
            // ブログを削除
            Blog::destroy($inputs['id']);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('ok_msg', $inputs['title'] . ' のブログを削除しました');
        return redirect(route('home'));
    }

    # プログ作成画面表示
    public function showBlogCreate() 
    {
        if(!$this->SessionChk()){
            return redirect(route('Shsession[owLogin'));
        }
       $user=session('user');

        return view('BlogCreate',compact('user'));
    }

    #ブログを登録する
    public function exeBlogStore(BlogRequest $request) 
    {
        if(!$this->SessionChk()){
            return redirect(route('ShowLogin'));
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
           return redirect(route('home'));
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
