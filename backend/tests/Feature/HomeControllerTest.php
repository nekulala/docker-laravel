<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200)
	// 	->assertViewIs('welcome')
    //     ->assertSee('Laravel');
    // }

	// public function test_index() {
	// 	$array = new Tweet();
	// 	$response = $this->get('home', compact('array'));
    //     $response->assertStatus(200);

	// }

	// 新規ツイート登録ページ表示
	public function testTweetView() {
		$user = User::find(5);
		$response = $this->actingAs($user)->get('/tweet');
		$response->assertStatus(200)->assertViewIs('tweet');
	}
	
	// 新規ツイート登録処理
	public function testCreateTweet() {
		$user = User::find(5);
		$tweet = new Tweet();
		$tweet->user_id = 2;
		$tweet->tweet = 'feature_test testCreateTweet2';
		$response = $tweet->save();
		$this->assertTrue($response);
	}

	// 既存ツイート編集ページ表示
	public function testEdit() {
		$user = User::find(5);
		$tweet = Tweet::findOrFail(21);
		$response = $this->actingAs($user)->get('/edit/21');
		$response->assertStatus(200);
	}

	// // 既存ツイート編集処理
	public function testEditTweet() {
		$user = User::find(5);
		$response = Tweet::findOrFail(21);
		$response->tweet = '修正テスと';
		// $edit_tweet = $response->save();
		$this->assertTrue($edit_tweet);
		// $response = $this->actingAs($user)->get('home');
		// $response->assertStatus(200);
	}

	// 既存ツイート削除処理
	public function testDeleteTweet() {
		$user = User::find(5);
		$tweet = Tweet::findOrFail(23);
		$delete_tweet = $tweet->delete();
		$this->assertTrue($delete_tweet);
		$response = $this->actingAs($user)->get('home');
		$response->assertStatus(200);
	}
}
