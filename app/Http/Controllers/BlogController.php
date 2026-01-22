<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\User;
use avadim\FastExcelWriter\Excel;         // Workbook ではなく Excel を使用
use avadim\FastExcelWriter\Style\Border;

use avadim\FastExcelWriter\Style\Style;
use avadim\FastExcelWriter\RichText\RichText;


const SESSION_OUT_MSG = 'ログイン操作をして下さい';
const PAGE_NUM=10;    //1ページあたりの表示数

CONST NORMAL_MODE = 1;
CONST NEEDED_MODE = 2;

class BlogController extends Controller
{
        # ホーム画面表示
    public function showHome(){
        $this->newSpreadSheet = Excel::create();

// --- 1. RichTextの定義（ループより先に書く！） ---
$rtEmail = new RichText();
$rtEmail->addText("メールアドレス\n", ['font-size' => 10]);
$rtEmail->addText("※ パソコンやWebメールのアドレスをおすすめします。", ['font-size' => 8]);

// --- 2. スタイル定義 ---
$styleTop = [
    'text-align'     => 'left',
    'vertical-align' => 'center',
    'border'         => Style::BORDER_THIN,
    'fill-color'     => '#E0E0E0',
];
$styleBottom = [ // 3-4行目用
    'text-align'     => 'center',
    'vertical-align' => 'bottom', // 💡 文字位置を下配置
    'border'         => Style::BORDER_THIN,
    'fill-color'     => '#E0E0E0',
];
$styleH = [ // 2, 5行目用
    'text-align'     => 'center',
    'vertical-align' => 'center',
    'border'         => Style::BORDER_THIN,
    'fill-color'     => '#E0E0E0',
];
$styleR = array_merge($styleBottom, ['text-wrap' => true]);
$styleVer = [
    'text-align'     => 'left',
    'vertical-align' => 'top',
    'font-color'     => '#FF0000',
    'font-style'     => 'bold',
    'fill-color'     => '#FFFFFF',
    'border'         => 'none',
];
$styleGreen = array_merge($styleH, ['fill-color' => '#CCFFCC']);
$styleExCenter = array_merge($styleH, ['fill-color' => '#A9A9A9']);
$styleExLeft = array_merge($styleH, ['fill-color' => '#A9A9A9', 'text-align' => 'left']);

// --- 3. データ配列（S3/T3修正済） ---
$row4Data = explode(',', "従業員番号,氏名,氏名 (カナ),性別,生年月日,住所：郵便番号,住所：都道府県,住所：市区郡及び町村名,住所：丁目・番地,住所：アパート・マンション名等,住所：市区郡及び町村名 (カナ),住所：丁目・番地 (カナ),住所：アパート・マンション名等 (カナ),電話番号区分,電話番号,,社員区分,社員区分詳細,出向労働者,役職,社員区分適用日,所属事業所,部署メモ,部署,転勤年月日,業務の種類,勤務場所,入社年月日,試用期間の有無,試用期間の内容,退職年月日,離職理由,離職の種類,出産年月日,産前産後休業期間 (開始),産前産後休業期間 (終了),育児休業期間 (開始),育児休業期間 (終了),介護休業期間 (開始),介護休業期間 (終了),その他休業期間内容,その他休業期間 (開始),その他休業期間 (終了),外国人,氏名 (ローマ字),通称名,通称名（カナ）,国籍・地域,在留資格,在留期間,資格外活動許可の有無,前職情報");
$row5Data = explode(',', "文字,文字,文字（カナ）,文字,日付(YYYY/MM/DD),数字、ハイフン,文字,文字,文字,文字,文字（カナ）,文字（カナ）,文字（カナ）,文字,数字、ハイフン,文字（メールアドレス）,文字,文字,文字,文字,日付(YYYY/MM/DD),文字,文字,文字,日付(YYYY/MM/DD),文字,文字,日付(YYYY/MM/DD),文字,文字,日付(YYYY/MM/DD),文字,文字,日付(YYYY/MM/DD),日付(YYYY/MM/DD),日付(YYYY/MM/DD),日付(YYYY/MM/DD),日付(YYYY/MM/DD),日付(YYYY/MM/DD),日付(YYYY/MM/DD),文字,日付(YYYY/MM/DD),日付(YYYY/MM/DD),文字,文字,文字,文字,文字,文字,日付(YYYY/MM/DD),文字,文字");
$row6Data = explode(',', "99-9999,日本 太郎,ニホン タロウ,男,1970/01/01,530-0001,大阪府,大阪市北区梅田,１丁目９９番地９９号,◯◯ビル,オオサカシキタクウメダ,１チョウメ９９バンチ９９");

// --- 4. 書き込み ---
$sheet = $this->newSpreadSheet->sheet();
$sheet->setFreeze('E7');

// 💡 A-B列は狭く、C列以降は18に戻す
$sheet->setColWidth(1, 4);
$sheet->setColWidth(2, 6);
for ($i = 3; $i <= 100; $i++) { $sheet->setColWidth($i, 18); }

// 💡 5行目の高さを固定
$sheet->setRowHeight(5, 15);

for ($i = 1; $i <= 100; $i++) {
    $idx = $i - 3;
    
    // 1行目：大項目
    if ($i >= 3) {
        $label1 = '';
        if ($i == 3)  $label1 = '本人情報';
        if ($i == 19) $label1 = '所属・勤務情報';
        if ($i == 30) $label1 = '入退社情報';
        if ($i == 36) $label1 = '休業期間情報';
        if ($i == 44) $label1 = '外国人情報';
        if ($i == 54) $label1 = '前職情報';
        $sheet->writeTo([$i, 1], $label1, $styleTop);
    }

    // 2行目：区分
    if ($i >= 3) {
        $label2 = ($i <= 54) ? '登録不可' : '任意';
        $s2 = ($i <= 54) ? $styleH : $styleGreen;
        $sheet->writeTo([$i, 2], $label2, $s2);
    }

    // 3-4行目：項目名（下寄せ） 💡 エラー修正箇所
    if ($i >= 3) {
        $s34 = ($i == 18) ? $styleR : $styleBottom;
        $val34 = ($i == 18) ? $rtEmail : ($row4Data[$idx] ?? '');
        $sheet->writeTo([$i, 3], $val34, $s34);
        $sheet->writeTo([$i, 4], '', $s34);
    }

    // 5行目：属性
    if ($i >= 3) {
        $sheet->writeTo([$i, 5], ($row5Data[$idx] ?? ''), $styleH);
    }

    // 6行目：(例)（左寄せ）
    if ($i >= 3) {
        $sheet->writeTo([$i, 6], ($row6Data[$idx] ?? ''), $styleExLeft);
    }
}

// A, B列固定部分
$sheet->writeTo([1, 1], 'Ver.1', $styleVer);
for ($r = 3; $r <= 5; $r++) $sheet->writeTo([2, $r], ($r == 3 ? 'No.' : ''), $styleH);
$sheet->writeTo([2, 6], '(例)', $styleExCenter);

// --- 5. 結合 ---
$sheet->mergeCells('A1:B2');
$sheet->mergeCells('B3:B5');
$sheet->mergeCells('C1:R1');   // 本人情報
$sheet->mergeCells('S1:AC1');  // 所属・勤務情報
$sheet->mergeCells('AD1:AI1'); // 入退社情報
$sheet->mergeCells('AJ1:AQ1'); // 休業期間情報
$sheet->mergeCells('AR1:BA1'); // 外国人情報
// $sheet->mergeCells('BA1:CV1'); // 前職情報 ←　いらない

for ($i = 3; $i <= 100; $i++) {
    $col = \avadim\FastExcelHelper\Helper::colLetter($i);
    $sheet->mergeCells($col . '3:' . $col . '4');
}


// ------ 基本情報 ---------
// 基本情報取得
$sheet_data = $this->getBasicData();

// 7-1. まず、データを「行ベース」に組み替える（ここは前回通り）
$maxRow = 0;
$rowsToUpdate = [];
foreach ($sheet_data as $colIdx => $rowValues) {
    foreach ($rowValues as $rowIdx => $val) {
        $rowsToUpdate[$rowIdx][$colIdx] = $val;
        if ($rowIdx > $maxRow) $maxRow = $rowIdx;
    }
}

// --- 7-2. 正規のスタイル定義（番号固定） ---
$whiteStyle = [
    'border' => 'thin',
    'fill'   => '#ffffff',
];

$grayStyle = [
    'border' => 'thin',
    'fill'   => '#e0e0e0', // 💡 B列〜BB列（54列目）用のグレー
];

// --- 7-3. 7行目から最大行まで「行単位」でループして一気に書く（番号固定） ---
for ($r = 7; $r <= $maxRow; $r++) {
    $rowData = $rowsToUpdate[$r] ?? [];

    // ① B列(2)：連番を書く（基本情報なのでグレー）
    $sheet->writeTo([2, $r], ($r - 6), $grayStyle);

    // ② C列(3) 〜 CV列(100) までループ
    for ($c = 3; $c <= 100; $c++) {
        
        // データの取得
        $val = $rowData[$c] ?? ''; 

        // 💡 塗りつぶし判定：BB列（54列目）まではグレー、BC列（55列目）以降は白
        $currentStyle = ($c <= 54) ? $grayStyle : $whiteStyle;

        // 書き込み実行
        $sheet->writeTo([$c, $r], $val, $currentStyle);
    }
}

// 1. シート保護を有効にする（プロパティ代入）
// $sheet->protection = true; 


// 2. 7行目以降のロックを解除する
// ① ヘルパーを使って 'C7:CV1000' を 配列形式のアドレスに変換する
// $rangeAddr = \avadim\FastExcelHelper\Helper::rangeAddress('C7:CV1000');

// ② リュウジさんが見つけた「配列を求める内部関数」に、直接流し込む
// $sheet->_setStyleOptions($rangeAddr, 'protection', ['protection-locked' => 0]);

// 保存
        $this->newSpreadSheet->save('C:\tmp\employee_export2.xlsx');
        echo("AAA");







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

    public function getBasicData(): array
    {
$sheet_data =
[
  3 => 
  array (
    7 => '0000',
    8 => '0001',
    9 => '0002',
    10 => '0003',
    11 => '0004',
  ),
  4 => 
  array (
    7 => '従業員 履歴なし',
    8 => 'ビジネス ネーム１',
    9 => '従業員 2',
    10 => '従業員 3',
    11 => '従業員 4',
  ),
  5 => 
  array (
    7 => 'ジュウギョウイン リレキナシ',
    8 => 'ビジネス ネームイチ',
    9 => 'ジュウギョウイン ニ',
    10 => 'ジュウギョウイン サン',
    11 => 'ジュウギョウイン シ',
  ),
  6 => 
  array (
    7 => '',
    8 => '女',
    9 => '男',
    10 => '男',
    11 => '男',
  ),
  7 => 
  array (
    7 => '1999/09/09',
    8 => '1990/01/01',
    9 => '1960/01/02',
    10 => '1960/01/03',
    11 => '1960/01/04',
  ),
  8 => 
  array (
    7 => '',
    8 => '654-0067',
    9 => '671-0252',
    10 => '597-0083',
    11 => '669-2825',
  ),
  9 => 
  array (
    7 => '',
    8 => '兵庫県',
    9 => '兵庫県',
    10 => '大阪府',
    11 => '兵庫県',
  ),
  10 => 
  array (
    7 => '',
    8 => '神戸市',
    9 => '姫路市花田町加納原田',
    10 => '貝塚市海塚',
    11 => '篠山市北野新田',
  ),
  11 => 
  array (
    7 => '',
    8 => '9-11-7',
    9 => '1-3-16',
    10 => '2-20-11',
    11 => '2-8-18',
  ),
  12 => 
  array (
    7 => '',
    8 => '',
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  13 => 
  array (
    7 => '',
    8 => 'コウベシ',
    9 => 'ヒメジシハナダチョウカノウハラダ',
    10 => 'カイヅカシウミヅカ',
    11 => 'ササヤマシキタノシンデン',
  ),
  14 => 
  array (
    7 => '',
    8 => '４－８',
    9 => '１－３－１６',
    10 => '２－２０－１１',
    11 => '２－８－１８',
  ),
  15 => 
  array (
    7 => '',
    8 => '',
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  16 => 
  array (
    7 => '',
    8 => '自宅',
    9 => '自宅',
    10 => '自宅',
    11 => '自宅',
  ),
  17 => 
  array (
    7 => '',
    8 => '06-6339-7209',
    9 => '06-6339-7209',
    10 => '06-6339-7209',
    11 => '06-6339-7209',
  ),
  18 => 
  array (
    7 => '',
    8 => 'emikaneh@fsi.co.jp',
    9 => 'emikaneh@fsi.co.jp',
    10 => 'emikaneh@fsi.co.jp',
    11 => 'emikaneh@fsi.co.jp',
  ),
  19 => 
  array (
    7 => '未設定',
    8 => '正社員',
    9 => 'パートタイマー',
    10 => '役員',
    11 => '兼務役員',
  ),
  20 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  21 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  22 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '専門部長',
    11 => '部長',
  ),
  23 => 
  array (
    7 => '',
    8 => '2025/05/01',
    9 => '2025/05/01',
    10 => '2025/05/01',
    11 => '2025/05/01',
  ),
  24 => 
  array (
    7 => 'FSIタレマネ_金平_すなば(42833027)',
    8 => 'FSIタレマネ_金平_すなば(42833027)',
    9 => 'FSIタレマネ_金平_すなば(42833027)',
    10 => 'FSIタレマネ_金平_すなば(42833027)',
    11 => 'FSIタレマネ_金平_すなば(42833027)',
  ),
  25 => 
  array (
    7 => '',
    8 => 'あああ',
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  26 => 
  array (
    7 => '',
    8 => '部1',
    9 => '部1',
    10 => '部1/課1',
    11 => '部1/課1',
  ),
  27 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  28 => 
  array (
    7 => '',
    8 => '営業',
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  29 => 
  array (
    7 => NULL,
    8 => NULL,
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  30 => 
  array (
    7 => '',
    8 => 40269,
    9 => 40269,
    10 => 40269,
    11 => 40269,
  ),
  31 => 
  array (
    7 => '無',
    8 => '無',
    9 => '無',
    10 => '無',
    11 => '無',
  ),
  32 => 
  array (
    7 => NULL,
    8 => NULL,
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  33 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  34 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  35 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  36 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  37 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  38 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  39 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  40 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  41 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  42 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  43 => 
  array (
    7 => '',
    8 => '',
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  44 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  45 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  46 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  47 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  48 => 
  array (
    7 => ' ',
    8 => ' ',
    9 => ' ',
    10 => ' ',
    11 => ' ',
  ),
  49 => 
  array (
    7 => ' ',
    8 => ' ',
    9 => ' ',
    10 => ' ',
    11 => ' ',
  ),
  50 => 
  array (
    7 => NULL,
    8 => NULL,
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  51 => 
  array (
    7 => NULL,
    8 => NULL,
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
  52 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  53 => 
  array (
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
  ),
  54 => 
  array (
    7 => '',
    8 => '',
    9 => NULL,
    10 => NULL,
    11 => NULL,
  ),
];
return $sheet_data;
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
        // Blog::find($b_id)->increment('cnt');

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
