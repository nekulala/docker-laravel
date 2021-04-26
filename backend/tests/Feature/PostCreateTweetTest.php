<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Favorite;

class PostCreateTweetTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

	public function test_新規ツイート登録処理() {

		/** ログインユーザーのダミーデータ作成 */
		$login_user = factory(User::class)->create();
		$new_tweet = 'This is a unit test tweet';

		/** テストコード */
		$response = $this->actingAs($login_user)->post('/create_tweet', ['tweet' => $new_tweet]);
		$response->assertStatus(302)
				->assertRedirect('home');
				$this->actingAs($login_user)->get('home')
				->assertSee('つぶやきを登録しました。');
		$response = $this->assertDatabaseHas('tweets', [
					'user_id' => $login_user->id,
					'tweet' => $new_tweet
					]);
	}
}
