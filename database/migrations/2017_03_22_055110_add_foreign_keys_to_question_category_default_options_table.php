<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuestionCategoryDefaultOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_category_default_options', function(Blueprint $table)
		{
			$table->foreign('category_id')->references('id')->on('categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('question_category_id')->references('id')->on('question_categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('question_id')->references('id')->on('questions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_category_default_options', function(Blueprint $table)
		{
			$table->dropForeign('question_category_default_options_category_id_foreign');
			$table->dropForeign('question_category_default_options_question_category_id_foreign');
			$table->dropForeign('question_category_default_options_question_id_foreign');
			$table->dropForeign('question_category_default_options_user_id_foreign');
		});
	}

}
