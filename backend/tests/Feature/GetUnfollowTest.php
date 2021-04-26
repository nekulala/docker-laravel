<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Follower;

class GetUnfollowTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ユーザーをフォロー解除する処理()
    {
		$login_user = factory(User::class)->create();
		$guest_user = factory(User::class)->create();
		$login_user_following = factory(Follower::class)->create([
			'following_id' => $login_user->id,
			'followed_id' => $guest_user->id
		]);

		/** テストコード */
		$response = $this->actingAs($login_user)->get('/unfollow/'.$guest_user->id);
		$response->assertStatus(302)
				->assertRedirect('users');
		$response = $this->assertDatabaseMissing('followers', [
					'following_id' => $login_user->id,
					'followed_id' => $guest_user->id,
					]);
    }
}
