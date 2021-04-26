<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class GetDeleteTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_既存ツイート削除処理() {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('/delete/'.$login_user_tweet->id);
		$response->assertStatus(302)
				->assertRedirect('home');
				$this->actingAs($login_user)->get('home')
				->assertSee('つぶやきを削除しました。');
		$response = $this->assertSoftDeleted('tweets', [
					'id' => $login_user_tweet->id
					]);
    }
}
