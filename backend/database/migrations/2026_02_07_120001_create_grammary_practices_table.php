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
        Schema::create('grammary_practices', function (Blueprint $table) {
            $table->comment("Grammar practice questions");

            $table->id();
            $table->foreignId(column: 'grammary_id')->comment('Grammar topic ID')->constrained('grammary')->cascadeOnDelete();
            $table->uuid('union_id')->comment('Questions grouping ID');
            $table->string('title', 255)->nullable()->comment('Description of how to solve questions');
            $table->string('type', 255)->nullable()->comment('Type of practice');
            $table->string('question', 1024)->nullable()->comment('Question text');
            $table->json('answers')->nullable()->comment('Correct answers (array, may contain more than one)');
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
        Schema::dropIfExists('grammary_practices');
    }
};
