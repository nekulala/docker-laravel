<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;

class CommentControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

	// コメント登録ページの表示
	public function testComment() {
		$user = User::find(5);
		$response = $this->actingAs($user)->get('/comment/2');
		$response->assertStatus(200);
	}

	// コメント登録処理
	public function testCreateComment() {
		$user = User::find(5);
		$comment = new Comment();
		$comment->user_id = 2;
		$comment->tweet_id = 2;
		$comment->comment = 'create_comment_test2';
		$save_comment = $comment->save();
		$this->assertTrue($save_comment);
		$response = $this->actingAs($user)->get('home');
		$response->assertStatus(200);
	}
}
