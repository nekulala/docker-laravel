<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // いいね登録処理
	public function favorite(Favorite $favorite, $tweet_id) {
		// ツイートが存在するか（削除されていないか）の判定
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			// 存在している場合は該当ツイートを取得
			$tweet = Tweet::find($tweet_id);
			// 該当ツイートをしたユーザーをフォローしているor該当ツイートをしたのがログインユーザーかの判定
			if (Auth::user()->isFollowing($tweet->user_id) || Auth::id() == $tweet->user_id) {
				// いいねしているかの判定
				$is_favorite = $favorite->isFavorite(Auth::id(), $tweet_id);
				// いいねしていなければいいね登録処理
				if (!$is_favorite) {
					$favorite = new Favorite();
					$favorite->user_id = Auth::id();
					$favorite->tweet_id = $tweet_id;
					$favorite->save();
				}
			}
		}
		return redirect('home');
	}

	// いいね解除
	public function unfavorite(Favorite $favorite, $tweet_id) {
		// ツイートが存在するか（削除されていないか）の判定
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			// 存在している場合は該当ツイートを取得
			$tweet = Tweet::find($tweet_id);
			// 該当ツイートをしたユーザーをフォローしているor該当ツイートをしたのがログインユーザーかの判定
			if (Auth::user()->isFollowing($tweet->user_id) || Auth::id() == $tweet->user_id) {
				// いいねしているかの判定
				$is_favorite = $favorite->isFavorite(Auth::id(), $tweet_id);
				// いいねしていなければいいね解除処理
				if ($is_favorite) {
					// favoritesテーブルからログインユーザーIDといいねされてるtweet_id両方合致するレコードを取得
					$favorite = Favorite::where('user_id', Auth::id())
						->where('tweet_id', $tweet_id)
						->first();
					$favorite->delete();
				}
			}
		}
		return redirect('home');
	}

	public function favorites() {
		// ログインユーザーのいいねしたツイートを取得
		$favorites = Favorite::where('user_id', Auth::id())->get();
		return view('favorites', compact('favorites'));
	}
}
