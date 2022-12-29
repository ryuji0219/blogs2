<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserCreateController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SearchController;

#ログインチェック（モーダル画面）
Route::post('loginCheck', [LoginController::class,'DoLoginCheck']);
#会員登録チェック（モーダル画面）
Route::post('userCheck', [UserCreateController::class,'DoUserCheck']);

Route::get('/', function () {return view('login');});

#ログイン画面表示
// Route::get('login', [LoginController::class,'showLogin'])->name('ShowLogin');

#ログイン操作
Route::post('home', [LoginController::class,'DoLogin'])->name('login');
#ログアウト操作
Route::get('logout', [LoginController::class,'DoLogout'])->name('logout');

#会員登録画面を表示
// Route::get('UserCreate', [UserCreateController::class,'showUserCreate'])->name('UserCreate');
#会員登録
Route::post('UserStore', [UserCreateController::class,'exeUserStore'])->name('UserStore');
#会員削除
Route::get('DeleteUser', [UserCreateController::class,'exeUserDelete'])->name('DeleteUser');

#ブログ一覧画面表示
Route::get('home', 'App\Http\Controllers\BlogController@showHome')->name('showHome');

#プログ検索
Route::post('BlogSearch', [SearchController::class,'exeBlogSearch'])->name('BlogSearch');
#プログ検索時の一覧画面表示
Route::get('BlogSearch', [SearchController::class,'showBlogSearch'])->name('showBlogSearch');

#ブログ詳細画面を表示
Route::get('showDetail/{blog_ID}', [BlogController::class,'showDetail']);
#ブログ編集画面を表示
Route::get('showEdit', [BlogController::class,'showEdit'])->name('showEdit');
#プログ更新 or 削除
Route::post('edit', [BlogController::class,'exeUpdateDelelte'])->name('BlogUpdateDelelte');

#ブログ新規登録画面を表示
Route::get('BlogCreate', [BlogController::class,'showBlogCreate'])->name('BlogCreate');
#ブログ新規登録
Route::post('store', [BlogController::class,'exeBlogStore'])->name('BlogStore');
