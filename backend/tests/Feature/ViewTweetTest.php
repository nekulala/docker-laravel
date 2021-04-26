<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ViewTweetTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

	public function test_新規ツイート登録ページ表示() {
		/**  ログインユーザーのダミーデータ作成 */
		$login_user = factory(User::class)->create();

		/** テストコード */
		$response = $this->actingAs($login_user)->get('/tweet');
		$response->assertStatus(200)
				->assertViewIs('tweet')
				->assertSee($login_user->name)
				->assertSee('新しいつぶやき')
				->assertSee('つぶやく');
	}
}
