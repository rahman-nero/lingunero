<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordsPracticeStatictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words_practice_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('library_id');
            $table->integer('count_words');
            $table->integer('count_wrong');
            $table->integer('count_true');
            $table->timestamps();

            $table->foreign('library_id')
                ->references('id')
                ->on('libraries')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('words_practice_staticts');
    }
}
