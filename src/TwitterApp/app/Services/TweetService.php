<?php

namespace App\Services;

use App\Models\Tweet;
use App\Services\Interfaces\TweetServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Jobs\TranslateTweet;
use \Illuminate\Support\Collection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TweetService implements TweetServiceInterface
{
    // エラーログ共通化
    protected function logError(string $message, array $context = []): void
    {
        $context['user_id'] = Auth::id();
        Log::error($message, $context);
    }

    // 自分の投稿か確認
    protected function authorizeUserTweet(Tweet $tweet): void
    {
        if ($tweet->user_id !== Auth::id()) {
            throw new AuthorizationException('権限がありません');
        }
    }

    public function getTweets(): Collection
    {
        try {
            return Tweet::with('user')->latest()->get();
        } catch (\Throwable $e) {
            $this->logError('ツイート一覧取得失敗: ', ['error' => $e]);
            throw $e;
        }
    }

    public function createTweet(array $data)
    {
        return DB::transaction(function () use ($data) {
            try {
                $imagePath = null;

                if (!empty($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $data['image']->store('images', 'public');
                }

                if (!empty($data['parent_id'])) {
                    Tweet::findOrFail($data['parent_id']);
                }

                $tweet = Tweet::create([
                    'user_id' => Auth::id(),
                    'content' => $data['content'],
                    'image_path' => $imagePath,
                    'parent_id' => $data['parent_id'] ?? null,
                ]);
                
                $this->dispatchTranslationJobs($tweet);

                return $tweet->load('user');
            } catch (\Throwable $e) {
                $this->logError('ツイート投稿失敗: ', ['error' => $e]);
                throw $e;
            }
        });
    }

    public function getTweetById(int $id): Tweet
    {
        try {
            return Tweet::with('user')->findOrFail($id);
        } catch (\Throwable $e) {
            $this->logError("ツイート取得失敗（ID: {$id}）: ", ['error' => $e]);
            throw $e;
        }
    }

    public function updateTweet(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tweet = Tweet::find($id);

            if (!$tweet) {
                throw new ModelNotFoundException('ツイートが見つかりません');
            }

            $this->authorizeUserTweet($tweet);

            try {
                $imagePath = $tweet->image_path;

                if (!empty($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    if ($imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                    $imagePath = $data['image']->store('images', 'public');
                }

                if (!empty($data['parent_id'])) {
                    Tweet::findOrFail($data['parent_id']);
                }

                $tweet->update([
                    'content' => $data['content'],
                    'image_path' => $imagePath,
                    'parent_id' => $data['parent_id'] ?? $tweet->parent_id,
                ]);

                return $tweet->load('user');
            } catch (\Throwable $e) {
                $this->logError("ツイート更新失敗（ID: {$id}）", [
                    'error' => $e,
                    'input' => $data,
                ]);
                throw $e;
            }
        });
    }

    public function deleteTweet(int $id)
    {
        return DB::transaction(function () use ($id) {
            $tweet = Tweet::find($id);

            if (!$tweet) {
                throw new ModelNotFoundException('ツイートが見つかりません');
            }

            $this->authorizeUserTweet($tweet);

            try {
                if ($tweet->image_path) {
                    Storage::disk('public')->delete($tweet->image_path);
                }

                return $tweet->delete();
            } catch (\Throwable $e) {
                $this->logError("ツイート削除失敗（ID: {$id}）", [
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }
        });
    }

    protected function dispatchTranslationJobs(Tweet $tweet): void
    {
        $langs = ['en', 'zh', 'es', 'de'];

        foreach ($langs as $lang) {
            TranslateTweet::dispatch($tweet, $lang);
        }
    }
}
