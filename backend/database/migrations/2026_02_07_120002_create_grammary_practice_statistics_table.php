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
        Schema::create('grammary_practice_statistics', function (Blueprint $table) {
            $table->comment("User statistics for grammar practice");

            $table->id();
            $table->foreignId(column: 'grammary_id')->comment('Grammar topic ID')->constrained('grammary')->cascadeOnDelete();
            $table->foreignId('user_id')->comment('User ID')->constrained()->cascadeOnDelete();
            $table->json('statistic')->nullable()->comment('Practice statistic data');
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
        Schema::dropIfExists('grammary_practice_statistics');
    }
};
