<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Follower;


class GetFollowersTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_フォローしているユーザーの一覧()
    {
		$login_user = factory(User::class)->create();
		$guest_user = factory(User::class)->create();
		$login_user_following = factory(Follower::class)->create([
			'following_id' => $login_user->id,
			'followed_id' => $guest_user->id
		]);
		/** テストコード */
		$response = $this->actingAs($login_user)->get('/followers');
		$response->assertStatus(200)
				->assertViewIs('followers')
				->assertViewHas('following_users')
				->assertSee('フォローユーザー一覧')
				->assertSee($login_user->name)
				->assertSee($guest_user->name);
    }
}
