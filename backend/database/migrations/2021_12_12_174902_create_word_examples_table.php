<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordExamplesTable extends Migration
{
    public function up()
    {
        Schema::create('word_examples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id');
            $table->text('content');
            $table->unsignedBigInteger('sort')->default(0);
            $table->foreign('word_id')
                ->references('id')
                ->on('words')
                ->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('word_examples');
    }
}
