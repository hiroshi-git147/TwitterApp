<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\View\View;

class TweetController extends Controller {

    /**
     * 投稿一覧を表示する
     * 
     * @return View
     */
    public function index(): View
    {
        return view('tweets.index');
    }

    /**
     * 投稿詳細を表示する
     * 
     * @param Tweet $tweet 投稿
     * @return View
     */
    public function show(Tweet $tweet): View
    {
        $this->authorize('view', $tweet);
        return view('tweets.show', compact('tweet'));
    }

    /**
     * 投稿を作成する
     * 
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create', Tweet::class);
        return view('tweets.create');
    }

    /**
     * 投稿を更新する
     * 
     * @param Tweet $tweet 投稿
     * @return View
     */
    public function edit(Tweet $tweet): View
    {
        $this->authorize('update', $tweet);
        return view('tweets.edit', compact('tweet'));
    }
}
