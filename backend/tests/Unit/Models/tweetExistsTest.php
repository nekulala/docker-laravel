<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class tweetExistsTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_つぶやきが存在しているか() {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		$result = Tweet::where('id', $login_user_tweet->id)->exists();

		$response = $this->assertDatabaseHas('tweets', [
			'id' => $login_user_tweet->id,
			]);
        $this->assertTrue($result);
    }
}
