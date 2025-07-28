<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\View\View;

class TweetController extends Controller {

    public function index(): View
    {
        return view('tweets.index');
    }

    public function show(Tweet $tweet): View
    {
        $this->authorize('view', $tweet);
        return view('tweets.edit', compact('tweet'));
    }

    public function create(): View
    {
        $this->authorize('create', Tweet::class);
        return view('tweets.create');
    }

    public function edit(Tweet $tweet): View
    {
        $this->authorize('update', $tweet);
        return view('tweets.edit', compact('tweet'));
    }
}
