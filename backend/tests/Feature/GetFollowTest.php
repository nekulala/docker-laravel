<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class GetFollowTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ユーザーをフォローする処理()
    {
		$login_user = factory(User::class)->create();
		$guest_user = factory(User::class)->create();

		/** テストコード */
		$response = $this->actingAs($login_user)->get('/follow/'.$guest_user->id);
		$response->assertStatus(302)
				->assertRedirect('users');
		$response = $this->assertDatabaseHas('followers', [
					'following_id' => $login_user->id,
					'followed_id' => $guest_user->id,
					]);
    }
}
