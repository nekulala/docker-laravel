<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class PostEditTweetTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_既存ツイート編集処理() {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		$edit_tweet = 'edit tweet test';

		/** テストコード */
		$response = $this->actingAs($login_user)->post('/edit_tweet/'.$login_user_tweet->id , ['tweet' => $edit_tweet]);
		$response->assertStatus(302)
				->assertRedirect('home');
				$this->actingAs($login_user)->get('home')
				->assertSee('つぶやきを更新しました。');
		$response = $this->assertDatabaseHas('tweets', [
					'id' => $login_user_tweet->id
					]);
    }
}
