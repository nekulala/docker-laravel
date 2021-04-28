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
	public function favorite(Tweet $tweet, Favorite $favorite, $tweet_id) {
		// ツイートが存在するか（削除されていないか）の判定
		if ($tweet->tweetExists($tweet_id)) {
			// 存在している場合は該当ツイートを取得
			$tweet = Tweet::find($tweet_id);
			// 該当ツイートをしたユーザーをフォローしている or 該当ツイートをしたのがログインユーザーかの判定
			if (Auth::user()->isFollowing($tweet->user_id) || Auth::id() == $tweet->user_id) {
				// いいねしていなければいいね登録処理
				if (!$favorite->isFavorite(Auth::id(), $tweet_id)) {
					$favorite = new Favorite();
					$favorite->user_id = Auth::id();
					$favorite->tweet_id = $tweet_id;
					$favorite->save();
					return back();
				}
			}
		}
		return redirect('home')->with('ng', __('いいね登録に失敗しました'));
	}

	// いいね取消処理
	public function unfavorite(Tweet $tweet, Favorite $favorite, $tweet_id) {
		// ツイートが存在するか（削除されていないか）の判定
		if ($tweet->tweetExists($tweet_id)) {
			// 存在している場合は該当ツイートを取得
			$tweet = Tweet::find($tweet_id);
			// 該当ツイートをしたユーザーをフォローしているor該当ツイートをしたのがログインユーザーかの判定
			if (Auth::user()->isFollowing($tweet->user_id) || Auth::id() == $tweet->user_id) {
				// いいねしていればいいね解除処理
				if ($favorite->isFavorite(Auth::id(), $tweet_id)) {
					// favoritesテーブルからログインユーザーIDといいねされてるtweet_id両方合致するレコードを取得
					$favorite = Favorite::where('user_id', Auth::id())
						->where('tweet_id', $tweet_id)
						->first();
					$favorite->delete();
					return back();
				}
			}
		}
		return redirect('home')->with('ng', __('いいね取消に失敗しました'));
	}

	// いいねしているツイートの一覧
	public function favorites() {
		// ログインユーザーのいいねしたツイートおよびそのツイートをしたユーザーの名前を取得
		$favorite_tweets = Tweet::select('tweets.id', 'users.name', 'tweets.tweet')
				->join('favorites', 'tweets.id', '=', 'favorites.tweet_id')
				->join('users', 'users.id', '=', 'tweets.user_id')
				->where('favorites.user_id', Auth::id())
				->paginate(5);
		return view('favorites', compact('favorite_tweets'));
	}
}
