<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionReceipientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_recipients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('physician_id');
			$table->integer('patient_id')->unsigned()->nullable()->index('question_recipients_patient_id_foreign');
			$table->integer('question_id')->unsigned()->index('question_recipients_question_id_foreign');
			$table->string('uuid')->nullable();
			$table->enum('status', array('completed','pending','cancelled','responded'));
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
		Schema::drop('question_recipients');
	}

}
