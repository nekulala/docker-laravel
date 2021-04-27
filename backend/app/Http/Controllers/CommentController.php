<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;

class CommentController extends Controller
{
	// コメント登録ページの表示
	public function showEditCommentPage($tweet_id) {
		// 該当のつぶやきが存在しているかを確認
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			$tweet = Tweet::find($tweet_id);
			// 該当つぶやきがログインユーザーのものであるor該当つぶやきのユーザーをフォローしているか確認
			if(Auth::id() === $tweet->user->id || Auth::user()->isFollowing($tweet->user->id)) {
				return view('comment', compact('tweet'));
			}
		}
		return redirect('home')->with('ng', __('コメント追加ページを表示できません。'));
	}

	// コメント登録処理
	public function createComment(Request $request, $tweet_id) {
		$request->validate([
            'comment' => [
				'required',
				'max:20'
				]
        ]);
		$comment = new Comment();
		$comment->user_id = Auth::id();
		$comment->tweet_id = $tweet_id;
		$comment->comment = $request->comment;
		$comment->save();
		return redirect('home')->with('ok', __('コメントを追加しました。'));
	}
}
