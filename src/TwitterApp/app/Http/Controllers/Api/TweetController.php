<?php

namespace App\Http\Controllers\Api;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Interfaces\TweetServiceInterface;
use App\Http\Requests\TweetRequest;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TweetController extends Controller {

    private $tweetService;

    /**
     * コンストラクタ
     * 
     * @param TweetServiceInterface $tweetService ツイートサービスのインターフェース
     * @return void
     */
    public function __construct(TweetServiceInterface $tweetService) {
        $this->tweetService = $tweetService;
    }

    /**
     * 投稿一覧をJSONで返す
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $tweets = $this->tweetService->getTweets();
            return response()->json([
                'message' => 'ツイート一覧取得成功',
                'tweets' => $tweets
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'エラーが発生しました',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 投稿詳細をJSONで返す
     * 
     * @param Tweet $tweet 投稿
     * @return JsonResponse
     */
    public function show(Tweet $tweet): JsonResponse
    {
        try {
            $this->authorize('view', $tweet);
            $tweet->load('user');
            return response()->json([
                'message' => 'ツイート取得成功',
                'tweet' => $tweet,
            ], 200);
        } catch (AuthenticationException $e) {
            return response()->json([
                'message' => '認証されたユーザーではないためツイートを見る権限がありません。',
            ], 401);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'このツイートを見る権限がありません。',
            ], 403);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'ツイートが見つかりませんでした。',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'サーバーエラーが発生しました',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 新しい投稿を作成する
     * 
     * @param TweetRequest $request 投稿リクエスト
     * @return JsonResponse
    */
    public function store(TweetRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', Tweet::class);
            $tweet = $this->tweetService->createTweet($request->validated());
            return response()->json([
                'message' => 'ツイート成功',
                'tweet' => $tweet,
            ], 201);
        } catch (AuthenticationException $e) {
            return response()->json([
                'message' => '認証されたユーザーではないためツイートを作成する権限がありません。',
            ], 401);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'このツイートを作成する権限がありません。',
            ], 403);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'サーバーエラーが発生しました',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 投稿を更新する
     * 
     * @param TweetRequest $request 投稿リクエスト
     * @param Tweet $tweet 投稿
     * @return JsonResponse
     */
    public function update(TweetRequest $request, Tweet $tweet): JsonResponse
    {
        try {
            $this->authorize('update', $tweet);
            $updateTweet = $this->tweetService->updateTweet($tweet->id, $request->validated());
    
            return response()->json([
                'message' => 'ツイート成功',
                'updateTweet' => $updateTweet,
            ], 200);
        } catch (AuthenticationException $e) {
            return response()->json([
                'message' => '認証されたユーザーではないためツイートを更新する権限がありません。',
            ], 401);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'このツイートを更新する権限がありません。',
            ], 403);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'サーバーエラーが発生しました',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

    /**
     * 投稿を削除する
     * 
     * @param Tweet $tweet 投稿
     * @return JsonResponse
     */
    public function destroy(Tweet $tweet): JsonResponse
    {
        try {
            $this->authorize('destroy', $tweet);
            $this->tweetService->deleteTweet($tweet->id);
            return response()->json([
                'message' => 'ツイート削除成功',
            ], 204);
        } catch (AuthenticationException $e) {
            return response()->json([
                'message' => '認証されたユーザーではないためツイートを削除する権限がありません。',
            ], 401);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'このツイートを削除する権限がありません。',
            ], 403);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'サーバーエラーが発生しました',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // 投稿の検索処理
    public function search(Request $request)
    {
        // 検索条件に応じた投稿を取得
    }
}
