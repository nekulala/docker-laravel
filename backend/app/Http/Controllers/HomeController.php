<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;

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
}
