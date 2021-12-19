<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuestionCategoryNarrativeOutputTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_category_narrative_output', function(Blueprint $table)
		{
			$table->foreign('question_category_id')->references('id')->on('question_categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_category_narrative_output', function(Blueprint $table)
		{
			$table->dropForeign('question_category_narrative_output_question_category_id_foreign');
		});
	}

}
