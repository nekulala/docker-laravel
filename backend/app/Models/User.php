<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function follows() {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }

    public function followers() {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }

	// フォローしているか
	public function isFollowing(Int $user_id) {
		return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
	}

	// ユーザーの名前を取得
	public static function getUserName($user_id) {
		$comment_user = self::select('name')->where('id', $user_id)->first();
		return $comment_user;
	}
}
