<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('llm_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_room_id')->constrained('llm_chat_rooms');
            $table->text('message')->comment('Сообщение от пользователя');
            $table->text('reply')->nullable()->comment('Ответ от LLM');
            $table->dateTime('reply_given_at')->nullable()->comment('Дата время ответа от LLM');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llm_chat_messages');
    }
};
