<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Favorite;

class FavoriteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

	// いいねしているかの判定
	public function test_いいねしているか() {
		$favorite = (boolean) Favorite::where('user_id', 4)->where('tweet_id', 2)->first();
		$this->assertTrue($favorite);
	}
}
