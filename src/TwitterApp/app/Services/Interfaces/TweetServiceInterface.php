<?php

namespace App\Services\Interfaces;

interface TweetServiceInterface
{
    public function getTweets();
    public function createTweet(array $data);
    public function getTweetById(int $id);
    public function updateTweet(int $id, array $data);
    public function deleteTweet(int $id);
}
