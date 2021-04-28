<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;
use App\Models\Favorite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

	// ツイートの一覧表示（ログイン後のトップページ）
    public function index() {
		$tweets = Tweet::with(['user', 'comments'])
						->select('tweets.*')
						->join('users', 'tweets.user_id', '=', 'users.id')
						->leftjoin('followers', function($query) {
							// ユーザーidとフォローされているユーザーidでテーブルをつなぐ
							$query->on('users.id', '=', 'followers.followed_id')
							// フォローしているユーザーとログインユーザーが同じであること
							->where('followers.following_id', Auth::id());
						})
						// ①フォローしているユーザーidがnullでない(フォローしているユーザー = ログインユーザー)
						->orWhere('followers.following_id', '!=', null)
						->orWhere(function($query) {
						// ②フォローしているユーザーidがnull(user.id = ログインユーザー)
							$query->where('followers.following_id', '=', null)
							->where('users.id', '=', Auth::id());
						})
						->paginate(5);
        return view('home', compact('tweets'));
    }
}
