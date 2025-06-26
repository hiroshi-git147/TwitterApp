<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Services\TweetService;
use App\Http\Requests\TweetRequest;
use Illuminate\View\View;

class TweetController extends Controller {

    private $tweetService;

    public function __construct(TweetService $tweetService) {
        $this->tweetService = $tweetService;
    }

    public function index(): View
    {
        $tweets = $this->tweetService->getTweets();
        return view('tweets.index', compact('tweets'));
    }

    public function show(Tweet $tweet): View
    {
        return view('tweets.tweet', compact('tweet'));
    }

    public function create(): View
    {
        return view('tweets.create');
    }

    public function store(TweetRequest $request): RedirectResponse
    {
        $this->tweetService->createTweet($request->validated());

        return redirect()->route('tweets.index')->with('success', '投稿しました！');
    }
    public function edit(Tweet $tweet): View
    {
        $this->authorize('update', $tweet);
        return view('tweets.edit', compact('tweet'));
    }

    public function update(TweetRequest $request, Tweet $tweet): RedirectResponse
    {
        $this->authorize('update', $tweet);
        $this->tweetService->updateTweet($tweet->id, $request->validated());

        return redirect()->route('tweets.index')->with('success', '更新しました！');
    }

    public function destroy(Tweet $tweet): RedirectResponse
    {
        $this->authorize('destroy', $tweet);
        $this->tweetService->deleteTweet($tweet->id);
        return redirect()->route('tweets.index')->with('success', '削除しました！');
    }

    // 投稿の検索処理
    public function search(Request $request)
    {
        // 検索条件に応じた投稿を取得
    }
}
