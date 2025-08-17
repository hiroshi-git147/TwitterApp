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
        Schema::create('tr_tweets', function (Blueprint $table) {
            $table->id(); // id BIGINT AUTO_INCREMENT
            $table->foreignId('user_id')->constrained('mt_users')->onDelete('cascade'); // ユーザーID、外部キー制約
            $table->text('content'); // ツイート内容
            $table->string('image_path')->nullable(); // 画像パス
            $table->foreignId('parent_id')->nullable()->constrained('tr_tweets'); // リプライ元ID
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_tweets');
    }
};
