<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Follower;
use App\Models\Favorite;
use App\Models\Comment;

class UserController extends Controller
{
	// ユーザーの一覧表示
    public function index() {
		$users = User::all();
		return view('users', compact('users'));
	}

	// ユーザーをフォローする処理
	public function follow($user_id) {
		// 該当のユーザーが存在しているかを確認
		if (User::where('id', $user_id)->exists()) {
			// ログインしているユーザーのデータを取得
			$login_user = Auth::user();
			dd($login_user->follows());
			// ①フォロー対象のユーザーがログインユーザーではない
			// ②ログインユーザーがフォロー対象のユーザーを未フォローか確認
			if ($login_user->id != $user_id && !$login_user->isFollowing($user_id)) {
				$login_user->follows()->attach($user_id);
				return redirect('users');
			}
		}
		return redirect('users')->with('ng', __('フォローに失敗しました。'));
	}

	// ユーザーをフォロー解除する処理
	public function unfollow($user_id) {
		// 該当のユーザーが存在しているかを確認
		if (User::where('id', $user_id)->exists()) {
			// ログインしているユーザーのデータを取得
			$login_user = Auth::user();
			dd($login_user->isFollowing($user_id));
			// ①フォロー解除対象のユーザーがログインユーザーではない
			// ②ログインユーザーがフォロー解除対象のユーザーをフォロー済か確認
			if ($login_user->id != $user_id && $login_user->isFollowing($user_id)) {
				// フォロー解除対象ユーザーのつぶやきに対するいいねも削除
				$favorites = Favorite::join('tweets', 'tweets.id', '=', 'favorites.tweet_id')
						->where('favorites.user_id', Auth::id())
						->where('tweets.user_id', $user_id)
						->delete();
				// フォロー解除対象ユーザーのつぶやきに対するコメントも削除
				$comments = Comment::join('tweets', 'tweets.id', '=', 'comments.tweet_id')
						->where('comments.user_id', Auth::id())
						->where('tweets.user_id', $user_id)
						->delete();
				// フォロー解除処理
				$login_user->follows()->detach($user_id);
				return redirect('users');
			}
		}
		return redirect('users')->with('ng', __('フォロー解除に失敗しました。'));
	}

	// フォローしているユーザー一覧の表示
	public function followers() {
		$following_users = User::select('users.*')
				->join('followers', 'users.id', '=', 'followers.followed_id')
				->where('followers.following_id', Auth::id())
				->get();
		return view('followers', compact('following_users'));
	}
}