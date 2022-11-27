<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentencesPracticesTable extends Migration
{

	public function up()
	{
		Schema::create('sentences_practices_statistics', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('library_id');
			$table->integer('count_sentences');
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
		Schema::dropIfExists('sentences_practices');
	}
}
