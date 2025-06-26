<?php

namespace App\Services;

use App\Models\Tweet;
use App\Services\Interfaces\TweetServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;


class TweetService implements TweetServiceInterface
{
    public function getTweets()
    {
        return Tweet::with('user')->latest()->get();
    }

    public function createTweet(array $data)
    {
        return DB::transaction(function () use ($data) {
            try {
                $imagePath = null;

                if (!empty($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $data['image']->store('images', 'public');
                }

                // parent_idの存在確認（リプライ機能）
                if (!empty($data['parent_id'])) {
                    Tweet::findOrFail($data['parent_id']);
                }

                return Tweet::create([
                    'user_id' => Auth::id(),
                    'content' => $data['content'],
                    'image_path' => $imagePath,
                    'parent_id' => $data['parent_id'] ?? null,
                ]);
            } catch (Exception $e) {
                Log::error('ツイート投稿失敗: ' . $e->getMessage());
                throw $e;
            }
        });
    }

    public function getTweetById(int $id)
    {
        return Tweet::with('user')->findOrFail($id);
    }

    public function updateTweet(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tweet = Tweet::findOrFail($id);

            // 自分のツイート以外は更新できない（保険）
            if ($tweet->user_id !== Auth::id()) {
                throw new Exception('このツイートを編集する権限がありません');
            }

            try {
                if (!empty($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    if ($tweet->image_path) {
                        Storage::disk('public')->delete($tweet->image_path);
                    }
                    $data['image_path'] = $data['image']->store('images', 'public');
                }

                // parent_idが渡されたら存在チェック（リプライ編集時）
                if (!empty($data['parent_id'])) {
                    Tweet::findOrFail($data['parent_id']);
                }

                $tweet->update([
                    'content' => $data['content'],
                    'image_path' => $data['image_path'] ?? $tweet->image_path,
                    'parent_id' => $data['parent_id'] ?? $tweet->parent_id,
                ]);

                return $tweet;
            } catch (Exception $e) {
                Log::error('ツイート更新失敗: ' . $e->getMessage());
                throw $e;
            }
        });
    }

    public function deleteTweet(int $id)
    {
        return DB::transaction(function () use ($id) {
            $tweet = Tweet::findOrFail($id);

            if ($tweet->user_id !== Auth::id()) {
                throw new Exception('このツイートを削除する権限がありません');
            }

            try {
                if ($tweet->image_path) {
                    Storage::disk('public')->delete($tweet->image_path);
                }

                return $tweet->delete();
            } catch (Exception $e) {
                Log::error('ツイート削除失敗: ' . $e->getMessage());
                throw $e;
            }
        });

    }

}
