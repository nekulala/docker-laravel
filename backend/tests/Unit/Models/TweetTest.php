<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Comment;

class TweetTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
	public function testUser() {
		$tweets = new Tweet();
		$response = $tweets->belongsTo(User::class);
		$this->assertNotNull($response);
	}

	public function testComment() {
		$tweets = new Tweet();
		$response = $tweets->hasMany(Comment::class);
		$this->assertNotNull($response);
	}
}
