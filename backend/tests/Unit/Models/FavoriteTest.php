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
    public function testExample()
    {
        $this->assertTrue(true);
    }

	// いいねしているかの判定
	public function testIsFavorite() {
		$favorite = (boolean) Favorite::where('user_id', 4)->where('tweet_id', 2)->first();
		$this->assertTrue($favorite);
	}
}
