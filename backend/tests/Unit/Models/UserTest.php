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
	// public function test_follows() {
	// 	// $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
	// 	$this->assertTrue(User::belongsToMany(self::class, 'followers', 'following_id', 'followed_id'));
	// }

	// // フォローしているか
	// public function testIsFollowing() {
	// 	$user = new User();
	// 	$follow_user = (boolean) $user->follows()->where('followed_id', 1)->first();
	// 	$this->assertTrue($follow_user);
	// }

	// ユーザーの名前を取得
	public function testGetUserName() {
		$user_name = User::select('name')->where('id', 1)->first();
		$this->assertSame($user_name->name, 'yui');
	}
}
