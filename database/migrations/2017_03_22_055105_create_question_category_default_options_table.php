<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionCategoryDefaultOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_category_default_options', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('question_category_default_options_user_id_foreign');
			$table->integer('question_category_id')->unsigned()->index('question_category_default_options_question_category_id_foreign');
			$table->integer('question_id')->unsigned()->index('question_category_default_options_question_id_foreign');
			$table->integer('category_id')->unsigned()->index('question_category_default_options_category_id_foreign');
			$table->string('default_option')->nullable();
			$table->enum('option_status', array('1','2'));
			$table->char('active', 1)->default('Y');
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
		Schema::drop('question_category_default_options');
	}

}
