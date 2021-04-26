<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Favorite;


class GetUnfavoriteTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいね解除処理() {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		$login_user_favorite = factory(Favorite::class)->create([
			'user_id' => $login_user->id,
			'tweet_id' => $login_user_tweet->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('/unfavorite/' . $login_user_tweet->id);
		$response->assertStatus(302)
				->assertRedirect('home');
		$response = $this->assertDeleted('favorites', [
					'user_id' => $login_user_favorite->user_id,
					'tweet_id' => $login_user_favorite->tweet_id,
					]);
    }
}
