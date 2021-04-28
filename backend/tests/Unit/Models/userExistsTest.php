<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class userExistsTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_ユーザーが存在しているか() {
		$login_user = factory(User::class)->create();
		$result = User::where('id', $login_user->id)->exists();

		$response = $this->assertDatabaseHas('users', [
			'id' => $login_user->id,
			]);
        $this->assertTrue($result);
    }
}
