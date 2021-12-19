<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned()->index('category_questions_category_id_foreign');
			$table->string('question')->nullable();
			$table->enum('answer_type', array('dateT','textBox','dropDown','mcq','rating','3Combo'))->comment('dateT - Date Time, textBox - text Type, dropDown - drop down Type , mcq - Multiple choice Question, 3Combo - combination of 2 dropbox and textbox');
			$table->string('narrative_output_p1', 300);
			$table->string('narrative_output_p2', 300);
			$table->text('comments', 65535)->nullable();
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
		Schema::drop('category_questions');
	}

}
