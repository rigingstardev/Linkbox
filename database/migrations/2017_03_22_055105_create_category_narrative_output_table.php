<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryNarrativeOutputTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_narrative_output', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('question_id');
			$table->string('narrative_output_p1', 300);
			$table->string('narrative_output_p2', 300);
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
		Schema::drop('category_narrative_output');
	}

}
