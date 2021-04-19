<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
use App\Models\Tweet;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

	// ツイートの一覧表示（トップページ）
    public function index() {
		$tweets = Tweet::with(['user', 'comments'])->get();
        return view('home', compact('tweets'));
    }

	// 新規ツイート登録処理
	public function createTweet(Request $request) {
		$tweet = new Tweet();
		$tweet->user_id = Auth::id();
		$tweet->tweet = $request->tweet;
		$tweet->save();
		return redirect('home');
    }

	// 既存ツイート編集ページ表示
	public function edit(Request $request, $tweet_id) {
		$tweet = Tweet::findOrFail($tweet_id);
		if (Auth::id() === $tweet->user_id) {
			return view('edit', compact('tweet_id'));
		} else {
			return redirect('home');
		}
	}

	// 既存ツイート編集処理
	public function editTweet(Request $request, $tweet_id) {
		$tweet = Tweet::findOrFail($tweet_id);
		$tweet->tweet = $request->tweet;
		$tweet->save();
		return redirect('home');
	}

	// 既存ツイート削除処理
	public function deleteTweet(Request $request, $tweet_id) {
		$tweet = Tweet::findOrFail($tweet_id);
		$tweet->delete();
		return redirect('home');
	}
}
