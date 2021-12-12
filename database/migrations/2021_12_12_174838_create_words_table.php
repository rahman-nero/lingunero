<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordsTable extends Migration
{
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('library_id');
            $table->text('word');
            $table->text('translation');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('library_id')
                ->references('id')
                ->on('libraries')
                ->onDelete('CASCADE');
        });
    }


    public function down()
    {
        Schema::dropIfExists('words');
    }
}
