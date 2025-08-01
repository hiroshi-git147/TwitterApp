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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            // ブロックした人
            $table->foreignId('blocker_id')
            ->constrained('users')
            ->onDelete('cascade');

            // ブロックされた人
            $table->foreignId('blocked_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();

            // 同じ組み合わせは禁止
            $table->unique(['blocker_id', 'blocked_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks');
    }
};
