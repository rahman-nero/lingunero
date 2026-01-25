<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterWordsPracticeStatisticTableAddContentRow extends Migration
{
    public function up()
    {
        Schema::table('words_practice_statistics', function (Blueprint $table) {
            $table->json('result')
                ->nullable()
                ->after('count_true');
        });
    }

    public function down()
    {
    }
}
