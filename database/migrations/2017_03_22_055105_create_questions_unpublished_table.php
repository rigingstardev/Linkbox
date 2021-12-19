<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsUnpublishedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions_unpublished', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->integer('question_id');
			// $table->char('created_by', 1)->default(1)->comment('1 - Admin');
			$table->text('reason', 65535)->nullable();
			$table->enum('active', array('Y','N'))->default('Y');
			$table->auditable();
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
		Schema::drop('questions_unpublished');
	}

}
