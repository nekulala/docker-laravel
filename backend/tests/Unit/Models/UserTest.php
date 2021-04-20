<?php

namespace Tests\Unit\Models;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
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
	public function testFollows() {
		$user = new User();
		$response = $user->belongsToMany(User::class, 'followers', 'following_id', 'followed_id');
		$this->assertNotNull($response);
	}

	// フォローしているか
	public function testIsFollowing() {
		$user = new User();
		$follow_user = (boolean) $user->follows()->where('followed_id', 1)->first(['id']);
		$this->assertTrue($follow_user);
	}

	// ユーザーの名前を取得
	public function testGetUserName() {
		$user_name = User::select('name')->where('id', 1)->first();
		$this->assertSame($user_name->name, 'yui');
	}
}
