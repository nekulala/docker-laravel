<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class GetEditTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_既存ツイート編集ページの表示() {
		$login_user = factory(User::class)->create();
		$login_user_tweet = factory(Tweet::class)->create([
			'user_id' => $login_user->id
		]);
		/** テストコード */
		$response = $this->actingAs($login_user)->get('/edit/'. $login_user_tweet->id);
		$response->assertStatus(200)
				->assertViewIs('edit')
				->assertSee($login_user->name)
				->assertSee('編集');
    }
}
