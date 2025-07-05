<?php

namespace App\Jobs;

use App\Models\Tweet;
use App\Models\TweetTranslation;
use App\Services\LibreTranslateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Tweet $tweet;
    protected string $targetLang;

    public function __construct(Tweet $tweet, string $targetLang)
    {
        $this->tweet = $tweet;
        $this->targetLang = $targetLang;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LibreTranslateService $translator)
    {
        $translated = $translator->translate($this->tweet, $this->targetLang);

        if($translated) {
            TweetTranslation::updateOrCreate(
                [
                    'tweet_id' => $this->tweet->id,
                    'language_code' => $this->targetLang,
                ],
                [
                    'translated_content' => $translated,
                ]
            );
        }
    }
}
