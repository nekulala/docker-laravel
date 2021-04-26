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

	// フォローしているか
	public function test_フォローしているか() {
		$user = new User();
		$follow_user = (boolean) $user->follows()->where('followed_id', 1)->first(['id']);
		$this->assertTrue($follow_user);
	}
}
