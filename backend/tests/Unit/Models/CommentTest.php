<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;

class CommentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
	public function testUser() {
		$comments = new Comment();
		$response = $comments->belongsTo(User::class);
		$this->assertNotNull($response);
	}
}
