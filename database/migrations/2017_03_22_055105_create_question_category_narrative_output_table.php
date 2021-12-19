<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionCategoryNarrativeOutputTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_category_narrative_output', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_category_id')->unsigned()->index('question_category_narrative_output_question_category_id_foreign')->comment('primary key of question_categories');
			$table->string('narrative_output');
			$table->enum('active', array('Y','N'))->default('Y')->comment('Y - active, N - Inactive');
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
		Schema::drop('question_category_narrative_output');
	}

}
