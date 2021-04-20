<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Favorite;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

	// ユーザーの一覧表示
	public function testIndex() {
		$user = User::find(5);
		$users = User::all();
		$this->assertNotNull($users);
		$response = $this->actingAs($user)->get('users');
		$response->assertStatus(200);
	}

	// ユーザーをフォローする処理
	public function testFollow() {
		$user = User::find(5);
		if ($user->id == 3 || $user->isFollowing(3)) {
			$response = $this->actingAs($user)->get('home');
			$response->assertStatus(200);
		} else {
			$user->follows()->attach(3);
			$response = $this->actingAs($user)->get('home');
			$response->assertStatus(200);
		}
	}

	// ユーザーをフォロー解除する処理
	public function testUnfollow() {
		// ログインしているユーザーのデータを取得
		$login_user = User::find(5);
		// フォロー解除対象のユーザーidがログインユーザーと同じorログインユーザーがフォロー解除対象のユーザーをフォローしていない場合トップページへリダイレクトする
		if ($login_user->id == 3 || !$login_user->isFollowing(3)) {
			$response = $this->actingAs($login_user)->get('home');
			$response->assertStatus(200);
		} else {
			// フォロー解除対象ユーザーのつぶやきのいいねも削除
			$favorites = Favorite::join('tweets', 'tweets.id', '=', 'favorites.tweet_id')
					->where('favorites.user_id', $login_user->id)
					->where('tweets.user_id', 3)
					->delete();
	
			// フォロー解除処理
			$login_user->follows()->detach(3);
			$response = $this->actingAs($login_user)->get('home');
			$response->assertStatus(200);
		}
	}

	// フォローしているユーザー一覧の表示
	public function testFollowers() {
		$user = User::find(5);
		$users = User::all();
		$this->assertNotNull($users);
		$response = $this->actingAs($user)->get('/followers');
		$response->assertStatus(200);
	}
}
