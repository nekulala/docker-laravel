<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;


class GetCommentTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_コメント登録ページ() {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		/** テストコード */
		$response = $this->actingAs($login_user)->get('/comment/'. $login_user_tweet->id);
		$response->assertStatus(200)
				->assertViewIs('comment')
				->assertViewHas('tweet_id')
				->assertSee($login_user->name)
				->assertSee('コメント');
    }
}
