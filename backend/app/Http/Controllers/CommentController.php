<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
	// コメント登録ページの表示
	public function comment(Request $request, $tweet_id) {
		return view('comment', compact('tweet_id'));
	}

	// コメント登録処理
	public function createComment(Request $request, $tweet_id) {
		$comment = new Comment();
		$comment->user_id = Auth::id();
		$comment->tweet_id = $tweet_id;
		$comment->comment = $request->comment;
		$comment->save();
		return redirect('home');
	}
}
