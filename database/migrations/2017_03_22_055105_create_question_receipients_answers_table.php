<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionReceipientsAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_recipients_answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_recipient_id')->unsigned()->index('question_recipients_answers_question_recipient_id_foreign');
			$table->integer('question_id')->unsigned()->index('question_recipients_answers_question_id_foreign');
			$table->integer('question_category_id')->unsigned()->index('question_recipients_answers_question_category_id_foreign');
			$table->string('description',200)->nullable();
			$table->string('answer');
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
		Schema::drop('question_recipients_answers');
	}

}
