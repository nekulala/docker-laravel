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

class GetHomeTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

	public function test_ログインユーザーのつぶやき1件未いいね() {
		/** ログインユーザーのダミーデータ作成 */
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('home');
		$response->assertStatus(200)
				->assertViewIs('home')
				->assertViewHas('tweets')
				->assertSee('つぶやく')
				->assertSee('ユーザー一覧')
				->assertSee($login_user->name)
				->assertSee($login_user_tweet->tweet)
				->assertSee('編集')
				->assertSee('削除')
				->assertSee('いいね')
				->assertSee('コメント');
	}

	public function test_ログインユーザーのつぶやき1件いいね済() {
		/** ログインユーザーのダミーデータ作成 */
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		$login_user_favorite = factory(Favorite::class)->create([
			'user_id' => $login_user->id,
			'tweet_id' => $login_user_tweet->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('home');
		$response->assertStatus(200)
				->assertViewIs('home')
				->assertViewHas('tweets')
				->assertSee($login_user->name)
				->assertSee($login_user_tweet->tweet)
				->assertSee('編集')
				->assertSee('削除')
				->assertSee('いいね取消')
				->assertSee('コメント');
	}

	public function test_ログインユーザーのつぶやき1件別ユーザーのコメントあり() {
		/**  ログインユーザーのダミーデータ作成 */
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
			]);
		$guest_user = factory(User::class)->create();
		$guest_user_comment = factory(Comment::class)->create([
			'user_id' => $guest_user->id,
			'tweet_id' => $login_user_tweet->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('home');
		$response->assertStatus(200)
				->assertViewIs('home')
				->assertViewHas('tweets')
				->assertSee($login_user->name)
				->assertSee($login_user_tweet->tweet)
				->assertSee('編集')
				->assertSee('削除')
				->assertSee('いいね')
				->assertSee('コメント')
				->assertSee($guest_user->name)
				->assertSee($guest_user_comment->comment);
	}

	public function test_未ログインユーザーのつぶやき1件() {
		$login_user = factory(User::class)->create();
		$guest_user = factory(User::class)->create();
		$guest_user_tweet = factory(Tweet::class)->create([
			'user_id' => $guest_user->id
			]);
		$login_user_following = factory(Follower::class)->create([
			'following_id' => $login_user->id,
			'followed_id' => $guest_user->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('home');
		$response->assertStatus(200)
				->assertViewIs('home')
				->assertViewHas('tweets')
				->assertSee($login_user->name)
				->assertSee($guest_user->name)
				->assertSee($guest_user_tweet->tweet)
				->assertDontSee('編集')
				->assertDontSee('削除')
				->assertSee('いいね')
				->assertSee('コメント');
	}
}