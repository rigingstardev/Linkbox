<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuestionReceipientsAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_recipients_answers', function(Blueprint $table)
		{
			$table->foreign('question_category_id')->references('id')->on('question_categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('question_id')->references('id')->on('questions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('question_recipient_id')->references('id')->on('question_recipients')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_recipients_answers', function(Blueprint $table)
		{
			$table->dropForeign('question_recipients_answers_question_category_id_foreign');
			$table->dropForeign('question_recipients_answers_question_id_foreign');
			$table->dropForeign('question_recipients_answers_question_recipient_id_foreign');
		});
	}

}
