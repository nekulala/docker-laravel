<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

	// いいねしているかの判定
	public static function isFavorite($user_id, $tweet_id) {
		return (boolean) self::where('user_id', $user_id)->where('tweet_id', $tweet_id)->first();
	}

	// いいねしているツイートの取得
	public static function favoriteTweet($tweet_id) {
		return \App\Models\Tweet::where('id', $tweet_id)->first();
	}
}
