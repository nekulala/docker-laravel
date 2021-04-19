<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Follower;

class UserController extends Controller
{
	// ユーザーの一覧表示
    public function index() {
		$users = User::all();
		return view('users', compact('users'));
	}

	// ユーザーをフォローする処理
	public function follow(Request $request, $user_id) {
		$login_user = Auth::user();
		if ($login_user->id == $user_id || $login_user->isFollowing($user_id)) {
			return redirect('home');
		}
		$login_user->follows()->attach($user_id);
		return redirect('users');
	}

	// ユーザーをフォロー解除する処理
	public function unfollow(Request $request, $user_id) {
		$login_user = Auth::user();
		if ($login_user->id == $user_id || !$login_user->isFollowing($user_id)) {
			return redirect('home');
		}
		$login_user->follows()->detach($user_id);
		return redirect('users');
	}

	// フォローしているユーザー一覧の表示
	public function followers() {
		$users = User::all();
		return view('followers', compact('users'));
	}
}