<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $table = 'tr_tweets';

    protected $fillable = [
        'user_id',
        'content',
        'image_path',
        'parent_id',
    ];

    // ユーザーとの関係（1つのツイートは1人のユーザーが持つ）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ↓ リプライ（親ツイート）
    public function parent()
    {
        return $this->belongsTo(Tweet::class, 'parent_id');
    }

    // ↓ リプライ（子ツイート）
    public function replies()
    {
        return $this->hasMany(Tweet::class, 'parent_id');
    }

    // ↓ いいね（中間テーブル）
    // public function likes()
    // {
    //     return $this->hasMany(Like::class);
    // }

    // // ↓ タグ（多対多）
    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class, 'tweet_tag');
    // }

}
