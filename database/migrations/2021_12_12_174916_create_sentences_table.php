<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentencesTable extends Migration
{

    public function up()
    {
        Schema::create('sentences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('library_id');
            $table->text('sentence');
            $table->text('translation');

            $table->foreign('library_id')
                ->references('id')
                ->on('libraries')
                ->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sentences');
    }
}
