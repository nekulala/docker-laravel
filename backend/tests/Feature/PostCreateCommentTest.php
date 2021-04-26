<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class PostCreateCommentTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_コメント登録処理()
    {
		/** ログインユーザーのダミーデータ作成 */
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		$new_comment = 'This is a new comment';

		/** テストコード */
		$response = $this->actingAs($login_user)->post('/create_comment/' . $login_user_tweet->id, ['comment' => $new_comment]);
		$response->assertStatus(302)
				->assertRedirect('home');
				$this->actingAs($login_user)->get('home')
				->assertSee('コメントを追加しました。');
		$response = $this->assertDatabaseHas('comments', [
					'user_id' => $login_user->id,
					'tweet_id' => $login_user_tweet->id,
					'comment' => $new_comment
					]);
    }
}
