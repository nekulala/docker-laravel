<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Favorite;

class isFavoriteTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

	// いいねしているかの判定
	public function test_いいねしているか() {
		/** ログインユーザーのダミーデータ作成 */
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		$login_user_favorite = factory(Favorite::class)->create([
			'user_id' => $login_user->id,
			'tweet_id' => $login_user_tweet->id
		]);

		$favorite = (boolean) Favorite::where('user_id', $login_user->id)->where('tweet_id', $login_user_tweet->id)->first();
		$response = $this->assertDatabaseHas('favorites', [
			'user_id' => $login_user->id,
			'tweet_id' => $login_user_tweet->id,
			]);
		$this->assertTrue($favorite);
	}
}
