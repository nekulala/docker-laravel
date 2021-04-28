<?php

namespace Tests\Unit\Models;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Follower;

class isFollowingTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

	    /**
     * @test
     * @group User
     */

	// フォローしているか
	public function test_フォローしているか() {
		$login_user = factory(User::class)->create();
		$guest_user = factory(User::class)->create();
		$login_user_following = factory(Follower::class)->create([
			'following_id' => $login_user->id,
			'followed_id' => $guest_user->id
		]);

		$follow_user = (boolean) $login_user->follows()->where('followed_id', $guest_user->id)->first();
		$response = $this->assertDatabaseHas('followers', [
			'following_id' => $login_user->id,
			'followed_id' => $guest_user->id
			]);
		$this->assertTrue($follow_user);
	}
}
