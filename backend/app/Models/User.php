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

	// public function follows() {
    //     return $this->hasManyThrough(self::class, Follower::class, 'following_id', 'id', 'id', 'followed_id');
    // }

	// 対象ユーザーをフォローしているかの判定
	public function isFollowing($user_id) {
		return (boolean) $this->follows()->where('followed_id', $user_id)->first();
	}

	// 存在しているつぶやきかの判定
	public function userExists($user_id) {
		return $this->where('id', $user_id)->exists();
	}
}
