<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// トップページ
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ログイン後トップページ
Route::get('/home', 'HomeController@index')->name('home');

// 以下ログインしている場合にアクセス可能なルート
Route::group(['middleware' => 'auth'], function () {
    // 新規ツイート登録ページ
	Route::view('/tweet', 'tweet');

	// 新規ツイート登録処理
	Route::post('/create_tweet', 'HomeController@createTweet');

	// 既存ツイート編集ページ
	Route::get('/edit/{tweet_id}', 'HomeController@edit');

	// 既存ツイート編集処理
	Route::post('/edit_tweet/{tweet_id}', 'HomeController@editTweet');

	// 既存ツイート削除処理
	Route::get('/delete/{tweet_id}', 'HomeController@deleteTweet');

	// ユーザー一覧ページの表示
	Route::get('/users', 'UserController@index')->name('users');

	// ユーザーをフォローする処理
	Route::get('/follow/{user_id}', 'UserController@follow');

	// ユーザーをフォロー解除する処理
	Route::get('/unfollow/{user_id}', 'UserController@unfollow');

	// フォローしているユーザーの一覧
	Route::get('/followers', 'UserController@followers');

	// コメント登録ページ
	Route::get('/comment/{tweet_id}', 'CommentController@comment');

	// コメント登録処理
	Route::post('/create_comment/{tweet_id}', 'CommentController@createComment');

	// いいね登録処理
	Route::get('/favorite/{tweet_id}', 'FavoriteController@favorite');

	// いいね取消処理
	Route::get('/unfavorite/{tweet_id}', 'FavoriteController@unfavorite');

	// いいねしているツイートの一覧
	Route::get('/favorites', 'FavoriteController@favorites');
});
