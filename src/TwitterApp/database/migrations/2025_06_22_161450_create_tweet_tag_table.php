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
        Schema::create('tweet_tag', function (Blueprint $table) {
            $table->id();
            // ツイートID
            $table->foreignId('tweet_id')->constrained()->onDelete('cascade');

            // タグID
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // 重複登録を防ぐ
            $table->unique(['tweet_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweet_tag');
    }
};
