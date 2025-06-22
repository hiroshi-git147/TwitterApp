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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            // フォローする人
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');

            // フォローされる人
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();

            // 同じ組み合わせは禁止
            $table->unique(['follower_id', 'followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
};
