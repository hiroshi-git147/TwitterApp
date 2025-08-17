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
        Schema::create('tr_messages', function (Blueprint $table) {
            $table->id();
            // 送信者ID
            $table->foreignId('sender_id')->constrained('mt_users')->onDelete('cascade');

            // 受信者ID
            $table->foreignId('receiver_id')->constrained('mt_users')->onDelete('cascade');

            // メッセージ内容
            $table->text('content');
            // 作成日時のみ（更新は不要なので updated_at はいらない）
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_messages');
    }
};
