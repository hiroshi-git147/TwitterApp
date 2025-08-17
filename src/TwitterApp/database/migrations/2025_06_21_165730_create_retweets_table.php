<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rt_retweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('mt_users')->onDelete('cascade');
            $table->foreignId('tweet_id')->constrained('tr_tweets')->onDelete('cascade');
            $table->timestamps();
        
            // 同じ組み合わせは禁止
            $table->unique(['user_id', 'tweet_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rt_retweets');
    }
};
