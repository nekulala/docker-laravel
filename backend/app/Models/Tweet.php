<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Tweet extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'tweet'
    ];

	public function user() {
		return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

	// つぶやきが削除されたとき紐づくコメントといいねも削除(SoftDeletes対策)
	protected static function boot() {
		parent::boot();
		self::deleting(function ($tweet) {
		$tweet->comments()->delete();
		$tweet->favorites()->delete();
		});
	}
}
