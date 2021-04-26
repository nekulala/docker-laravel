<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Favorite;

class getFavoritesTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねしているツイートの一覧()
    {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		$login_user_favorite = factory(Favorite::class)->create([
			'user_id' => $login_user->id,
			'tweet_id' => $login_user_tweet->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('/favorites');
		$response->assertStatus(200)
				->assertViewIs('favorites')
				->assertViewHas('favorites')
				->assertSee('いいねつぶやき一覧')
				->assertSee($login_user->name)
				->assertSee($login_user_tweet->tweet);
    }
}
