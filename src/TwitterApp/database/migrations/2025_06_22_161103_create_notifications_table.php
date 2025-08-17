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
        Schema::create('tr_notifications', function (Blueprint $table) {
            $table->id();
            // 通知を受け取るユーザー
            $table->foreignId('user_id')->constrained('mt_users')->onDelete('cascade');

            // 通知の種類
            $table->string('type');

            // JSONデータ
            $table->json('data');

            // 既読フラグ（false: 未読, true: 既読）
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_notifications');
    }
};
