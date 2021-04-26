<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;
use App\Models\User;
use App\Models\Follower;

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
		$tweets = Tweet::with(['user', 'comments'])
						->select('tweets.*')
						->join('users', 'tweets.user_id', '=', 'users.id')
						->leftjoin('followers', function($query) {
							$query->on('users.id', '=', 'followers.followed_id')
							->where('followers.following_id',  Auth::id());
						})
						->orWhere('followers.following_id', '!=', null)
						->orWhere(function($query) {
							$query->where('followers.following_id', '=', null)
							->where('users.id', '=', Auth::id());
						})
						->get();
        return view('home', compact('tweets'));
    }

	// 新規ツイート登録処理
	public function createTweet(Request $request) {
		$request->validate([
            'tweet' => [
				'required',
				'max:20'
				]
        ]);
		$tweet = new Tweet();
		$tweet->user_id = Auth::id();
		$tweet->tweet = $request->tweet;
		$tweet->save();
		return redirect('home')->with('ok', __('つぶやきを登録しました。'));
    }

	// 既存ツイート編集ページ表示
	public function edit($tweet_id) {
		// 該当のつぶやきが存在しているかを確認
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			$tweet = Tweet::find($tweet_id);
			// 該当のつぶやきがログインユーザーのものか確認
			if (Auth::id() === $tweet->user_id) {
				return view('edit', compact('tweet_id'));
			}
		}
		return redirect('home');
	}

	// 既存ツイート編集処理
	public function editTweet(Request $request, $tweet_id) {
		$request->validate([
            'tweet' => [
				'required',
				'max:20'
				]
        ]);
		// 該当のつぶやきが存在しているかを確認
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			$tweet = Tweet::find($tweet_id);
			// 該当のつぶやきがログインユーザーのものか確認
			if (Auth::id() === $tweet->user_id) {
				$tweet->tweet = $request->tweet;
				$tweet->save();
				return redirect('home')->with('ok', __('つぶやきを更新しました。'));
			}
		}
		return redirect('home')->with('ng', __('つぶやきの更新に失敗しました。'));
	}

	// 既存ツイート削除処理
	public function deleteTweet($tweet_id) {
		// 該当のつぶやきが存在しているかを確認
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			$tweet = Tweet::find($tweet_id);
			// 該当のつぶやきがログインユーザーのものか確認
			if (Auth::id() === $tweet->user_id) {
				$tweet->delete();
				return redirect('home')->with('ok', __('つぶやきを削除しました。'));
			}
		}
		return redirect('home')->with('ng', __('つぶやきを削除できませんでした。'));
	}
}
