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
        Schema::create('grammary', function (Blueprint $table) {
            $table->comment("Grammar topics");
            
            $table->id();
            $table->string('name', 255)->comment('Title of the topic');
            $table->text('content')->nullable()->comment('Content of the topic');
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
        Schema::dropIfExists('grammary');
    }
};
