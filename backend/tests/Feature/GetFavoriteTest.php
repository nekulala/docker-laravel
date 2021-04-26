<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class GetFavoriteTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいね登録処理() {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('/favorite/' . $login_user_tweet->id);
		$response->assertStatus(302)
				->assertRedirect('home');
		$response = $this->assertDatabaseHas('favorites', [
					'user_id' => $login_user->id,
					'tweet_id' => $login_user_tweet->id,
					]);
    }
}
