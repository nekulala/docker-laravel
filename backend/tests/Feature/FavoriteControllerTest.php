<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Favorite;

class FavoriteControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }


	// いいね登録処理
	public function testFavorite() {
		$login_user = User::find(5);
		$tweet_id = 28;
		// ツイートが存在するか（削除されていないか）の判定
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			// 存在している場合は該当ツイートを取得
			$tweet = Tweet::find($tweet_id);
			// 該当ツイートをしたユーザーをフォローしているor該当ツイートをしたのがログインユーザーかの判定
			if ($login_user->isFollowing($tweet->user_id) || $login_user->id == $tweet->user_id) {
				// いいねしているかの判定
				$is_favorite = Favorite::isFavorite($login_user->id, $tweet_id);
				// いいねしていなければいいね登録処理
				if (!$is_favorite) {
					$favorite = new Favorite();
					$favorite->user_id = $login_user->id;
					$favorite->tweet_id = $tweet_id;
					$response1 = $favorite->save();
					$this->assertTrue($response1);
					$response2 = $this->actingAs($login_user)->get('home');
					$response2->assertStatus(200);
				}
			}
		}
	}

	// いいね解除
	public function testUnfavorite() {
		$login_user = User::find(5);
		$tweet_id = 28;
		// ツイートが存在するか（削除されていないか）の判定
		if ($tweet = Tweet::where('id', $tweet_id)->exists()) {
			// 存在している場合は該当ツイートを取得
			$tweet = Tweet::find($tweet_id);
			// 該当ツイートをしたユーザーをフォローしているor該当ツイートをしたのがログインユーザーかの判定
			if ($login_user->isFollowing($tweet->user_id) || $login_user->id == $tweet->user_id) {
				// いいねしているかの判定
				$is_favorite = Favorite::isFavorite($login_user->id, $tweet_id);
				// いいねしていなければいいね解除処理
				if ($is_favorite) {
					// favoritesテーブルからログインユーザーIDといいねされてるtweet_id両方合致するレコードを取得
					$favorite = Favorite::where('user_id', $login_user->id)
						->where('tweet_id', $tweet_id)
						->first();
					$response1 = $favorite->delete();
					$this->assertTrue($response1);
					$response2 = $this->actingAs($login_user)->get('home');
					$response2->assertStatus(200);
				}
			}
		}
	}

	// いいねしているツイートの一覧
	public function testFavorites() {
		$user = User::find(5);
		// ログインユーザーのいいねしたツイートおよびそのツイートをしたユーザーの名前を取得
		$favorites = Tweet::select('users.name', 'tweets.tweet')
				->join('favorites', 'tweets.id', '=', 'favorites.tweet_id')
				->join('users', 'users.id', '=', 'tweets.user_id')
				->where('favorites.user_id', $user->id)
				->get();
		$this->assertNotNull($favorites);
		$response = $this->actingAs($user)->get('/favorites');
		$response->assertStatus(200);
	}
}
